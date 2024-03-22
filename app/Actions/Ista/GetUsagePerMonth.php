<?php

declare(strict_types=1);

namespace App\Actions\Ista;

use App\Actions\Action;
use App\Data\Ista\MonthUsage;
use App\Models\Ista\Usage;
use Carbon\CarbonImmutable;
use Iterator;
use MongoDB\Driver\CursorInterface;
use MongoDB\Laravel\Collection;
use Spatie\LaravelData\DataCollection;

readonly class GetUsagePerMonth implements Action
{
    public function __construct(
        private int $months = 12,
    ) {
    }

    /**
     * @return DataCollection<int, MonthUsage>
     */
    public function handle(): DataCollection
    {
        /** @var Collection $data */
        $data = Usage::raw(fn(Collection $collection): Iterator&CursorInterface => $collection->aggregate([
            [
                '$addFields' => [
                    'month' => [
                        '$month' => '$date',
                    ],
                    'year' => [
                        '$year' => '$date',
                    ],
                ],
            ],
            [
                '$sort' => [
                    'date' => -1,
                ],
            ],
            [
                '$group' => [
                    '_id' => [
                        'month' => '$month',
                        'year' => '$year',
                    ],
                    'usage' => [
                        '$first' => '$usage',
                    ],
                    'usage_previous_year' => [
                        '$first' => '$usage_previous_year',
                    ],
                    'building_average_usage' => [
                        '$first' => '$building_average_usage',
                    ],
                ],
            ],
            [
                '$sort' => [
                    '_id' => -1,
                ],
            ],
            [
                '$limit' => $this->months,
            ],
        ]));

        $result = [];

        foreach ($data as $usage) {
            $date = (new CarbonImmutable())
                ->setYear($usage['_id']['year'])
                ->setMonth($usage['_id']['month'])
                ->startOfMonth();

            $result[] = new MonthUsage(
                date: $date,
                usage: $usage['usage'],
                usage_previous_year: $usage['usage_previous_year'],
                building_average_usage: $usage['building_average_usage'],
            );
        }

        return new DataCollection(MonthUsage::class, $result);
    }
}
