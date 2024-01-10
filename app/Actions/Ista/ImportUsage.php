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

readonly class ImportUsage implements Action
{
    public function __construct(private string $jwtToken)
    {
    }

    public function handle(): void
    {
        $data = Cache::get(
            'ista-' . CarbonImmutable::now()->format('d-m-Y'),
            function (): array {
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
            });

        foreach ($data['Cus'] as $customer) {
            //dd($customer);
            foreach ($customer['curConsumption']['ServicesComp'] as $service) {
                /** @var Usage $usage */
                $usage = Usage::query()->updateOrCreate([
                    'ista_id' => $customer['Cuid'],
                    'date' => CarbonImmutable::now()->startOfDay(),
                    'period_start' => CarbonImmutable::createFromFormat('d-m-Y', $customer['curConsumption']['CurStart']),
                    'period_end' => CarbonImmutable::createFromFormat('d-m-Y', $customer['curConsumption']['CurEnd']),
                ], [
                    'usage' => $service['TotalNow'],
                ]);

                foreach ($service['CurMeters'] as $reading) {
                    Reading::query()->updateOrCreate([
                        'usage_id' => $usage->id,
                        'ista_meter_id' => $reading['MeterId'],
                    ], [
                        'name' => $reading['Position'],
                        'date' => CarbonImmutable::now()->startOfDay(),
                        'usage' => $reading['CCDValue'],
                    ]);
                }
            }
        }
    }
}
