<?php

declare(strict_types=1);

namespace App\Integrations\MotorOccasion\Actions;

use App\Actions\Action;
use App\Data\MotorOccasion\Brand;
use DOMDocument;
use DOMElement;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use JsonException;
use RuntimeException;

readonly class GetBrands implements Action
{
    public function __construct(private string $sessionId)
    {
    }

    /**
     * @return Collection<int, Brand>
     * @throws JsonException
     */
    public function handle(): Collection
    {
        $html = $this->getHtml();

        $array = json_decode($html, true, 512, JSON_THROW_ON_ERROR);

        return $this->filterTableNodes($array['brands']);
    }

    private function getHtml(): string
    {
        $response = Http::withCookies(['PHPSESSID' => $this->sessionId], 'www.motoroccasion.nl')
            ->get('https://www.motoroccasion.nl/fs.php?s=mz');

        if (! $response->ok()) {
            throw new RuntimeException('Could not get results');
        }

        return $response->body();
    }

    /**
     * @return Collection<int, Brand>
     */
    private function filterTableNodes(string $html): Collection
    {
        $doc = new DOMDocument(encoding: 'UTF-8');

        @$doc->loadHTML('<html lang="en"><body><select id="select">' . $html . '</body></html>');

        /** @var DOMElement $select */
        $select = $doc->getElementById('select');

        $options = $select->getElementsByTagName('option');

        $brands = new Collection();

        /** @var DOMElement $option */
        foreach ($options as $option) {
            $value = $option->getAttribute('value');
            $name = $option->nodeValue;

            if ($value === '-1' || empty($name)) {
                continue;
            }

            $brands->push(new Brand(
                name: $name,
                value: $value,
            ));
        }

        return $brands;
    }
}
