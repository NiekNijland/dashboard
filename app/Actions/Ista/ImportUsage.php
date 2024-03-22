<?php

declare(strict_types=1);

namespace App\Actions\Ista;

use App\Actions\Action;
use App\Exceptions\Ista\ApiException;
use App\Models\Ista\Reading;
use App\Models\Ista\Usage;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use MongoDB\BSON\UTCDateTime;

readonly class ImportUsage implements Action
{
    public function __construct(private string $jwtToken)
    {
    }

    public function handle(): void
    {
        $usageData = Cache::remember(
            'ista-usage-data-' . CarbonImmutable::now()->format('d-m-Y'),
            24 * 60 * 60,
            fn (): array => $this->getUsage());

        $buildingAverage = Cache::remember(
            'ista-building-average-' . CarbonImmutable::now()->format('d-m-Y'),
            24 * 60 * 60,
            fn (): int => $this->getBuildingAverage(
                customerId: $usageData['Cus'][0]['Cuid'],
                periodStart: CarbonImmutable::createFromFormat('d-m-Y', $usageData['Cus'][0]['curConsumption']['CurStart']),
                periodEnd: CarbonImmutable::createFromFormat('d-m-Y', $usageData['Cus'][0]['curConsumption']['CurEnd']),
            ));

        $this->importData($usageData, $buildingAverage);

        Cache::forget('ista-week-usages');
        Cache::forget('ista-month-usages');
    }

    /**
     * @throws ApiException
     */
    private function getUsage(): array
    {
        $response = Http::withHeaders([
            'authority' => 'mijn.ista.nl',
            'accept' => 'application/json, text/javascript, */*; q=0.01',
            'content-type' => 'application/json',
        ])
            ->post('https://mijn.ista.nl/api/Values/UserValues', [
                'JWT' => $this->jwtToken,
            ]);

        $data = $response->json();

        if (! is_array($data)) {
            throw new ApiException('API did not return valid response');
        }

        return $data;
    }

    /**
     * @throws ApiException
     */
    private function getBuildingAverage(string $customerId, CarbonImmutable $periodStart, CarbonImmutable $periodEnd): int
    {
        $response = Http::withHeaders([
            'authority' => 'mijn.ista.nl',
            'accept' => 'application/json, text/javascript, */*; q=0.01',
            'content-type' => 'application/json',
        ])
            ->post('https://mijn.ista.nl/api/Values/ConsumptionAverages', [
                'JWT' => $this->jwtToken,
                'Cuid' => $customerId,
                'PAR' => [
                    'start' => $periodStart->format('Y-m-d'),
                    'end' => $periodEnd->format('Y-m-d'),
                ],
            ]);

        $data = $response->json();

        if (! is_array($data)) {
            throw new ApiException('API did not return valid response');
        }

        return $data['Averages'][1]['NormalizedValue'];
    }

    private function importData(array $usageData, int $buildingAverage): void
    {
        foreach ($usageData['Cus'][0]['curConsumption']['ServicesComp'] as $service) {
            /** @var Usage $usage */
            $usage = Usage::query()->updateOrCreate([
                'ista_id' => $usageData['Cus'][0]['Cuid'],
                'date' => new UTCDateTime(CarbonImmutable::now()->startOfDay()),
            ], [
                'building_average_usage' => $buildingAverage,
                'usage' => $service['TotalNow'],
                'usage_previous_year' => $service['TotalPrevious'],
                'period_start' => CarbonImmutable::createFromFormat('d-m-Y', $usageData['Cus'][0]['curConsumption']['CurStart']),
                'period_end' => CarbonImmutable::createFromFormat('d-m-Y', $usageData['Cus'][0]['curConsumption']['CurEnd']),
            ]);

            foreach ($service['CurMeters'] as $i => $reading) {
                Reading::query()->updateOrCreate([
                    'usage_id' => $usage->id,
                    'ista_meter_id' => $reading['MeterId'],
                ], [
                    'name' => $reading['Position'],
                    'date' => CarbonImmutable::now()->startOfDay(),
                    'usage' => $reading['CCDValue'],
                    'usage_previous_year' => $service['CompMeters'][$i]['CCDValue'],
                ]);
            }
        }
    }
}
