<?php

declare(strict_types=1);

namespace App\Actions\MotorOccasion;

use App\Actions\Action;
use App\Data\MotorOccasion\Result;
use App\Data\MotorOccasion\Seller;
use DOMDocument;
use DOMElement;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use RuntimeException;

readonly class GetResults implements Action
{
    public function __construct(private string $sessionId)
    {
    }

    /**
     * @return Collection<int, Result>
     */
    public function handle(): Collection
    {
        $html = $this->getHtml();

        $nodes = $this->filterTableNodes($html);

        $results = new Collection();

        foreach ($nodes as $node) {
            $results->push($this->parseNodeToDto($node));
        }

        return $results;
    }

    private function getHtml(): string
    {
        $response = Http::withCookies(['PHPSESSID' => $this->sessionId], 'www.motoroccasion.nl')
            ->get('https://www.motoroccasion.nl/motoren');

        if (! $response->ok()) {
            throw new RuntimeException('Could not get results');
        }

        return $response->body();
    }

    /**
     * @return Collection<int, DOMElement>
     */
    private function filterTableNodes(string $html): Collection
    {
        $doc = new DOMDocument(encoding: 'UTF-8');

        @$doc->loadHTML($html);

        /** @var ?DOMElement $motorsWrapper */
        $motorsWrapper = $doc->getElementById('motors-wrapper');

        if ($motorsWrapper === null) {
            throw new RuntimeException();
        }

        $nodes = [];

        /** @var DOMElement $child */
        foreach ($motorsWrapper->childNodes as $child) {
            if ($child->getAttribute('class') !== 'table line-tile') {
                continue;
            }

            $nodes[] = $child;
        }

        return new Collection($nodes);
    }

    private function parseNodeToDto(DOMElement $node): Result
    {
        /** @var DOMElement $detailsElement */
        $detailsElement = $node->childNodes->item(0)?->childNodes->item(0)?->childNodes->item(0);

        /** @var DOMElement $sellerElement */
        $sellerElement = $node->childNodes->item(1)?->childNodes->item(0)?->childNodes->item(0)?->childNodes->item(2);

        // GET IMAGE

        /** @var DOMElement $imageElement */
        $imageElement = $detailsElement->childNodes->item(0);

        /** @var DOMElement $link */
        $link = $imageElement->childNodes->item(0);

        /** @var DOMElement $img */
        $img = $link->childNodes->item(0);

        // GET DETAILS

        /** @var DOMElement $textElement */
        $textElement = $detailsElement->childNodes->item(1)?->childNodes->item(0);

        /** @var DOMElement $titleElement */
        $titleElement = $textElement->childNodes->item(1);

        /** @var DOMElement $priceElement */
        $priceElement = $textElement->childNodes->item(2);

        /** @var DOMElement $yearAndOdometerElement */
        $yearAndOdometerElement = $textElement->childNodes->item(3);

        $yearAndOdometerDebris = explode(', ', $yearAndOdometerElement->childNodes->item(0)?->nodeValue ?? '');

        $year = (int) $yearAndOdometerDebris[0];

        $odometerDebris = explode(' ', $yearAndOdometerDebris[1]);

        $odometerReading = (int) $odometerDebris[0];
        $odometerReadingUnit = strtoupper($odometerDebris[1]);

        // GET SELLER

        /** @var DOMElement $sellerLink */
        $sellerLink = $sellerElement->firstChild;

        /** @var DOMElement $sellerProvince */
        $sellerProvince = $sellerElement->lastChild;

        return new Result(
            brand: html_entity_decode(str_replace('&nbsp;', '', htmlentities($titleElement->childNodes->item(0)?->nodeValue ?? ''))),
            model: $titleElement->childNodes->item(1)?->nodeValue ?? '',
            price: (static function (string $price): float {
                $decodedPrice = html_entity_decode(str_replace('&nbsp;', '', htmlentities($price)));
                $decodedPrice = mb_substr(mb_substr($decodedPrice, 1), 0, -2);

                return (float) $decodedPrice;
            })($priceElement->childNodes->item(0)?->nodeValue ?? ''),
            year: $year,
            odometerReading: $odometerReading,
            odometerReadingUnit: $odometerReadingUnit,
            image: $img->getAttribute('src'),
            url: $link->getAttribute('href'),
            seller: new Seller(
                name: $sellerLink->nodeValue ?? '',
                province: substr($sellerProvince->nodeValue ?? '', -2),
                website: $sellerLink->getAttribute('href')
            ),
        );
    }
}
