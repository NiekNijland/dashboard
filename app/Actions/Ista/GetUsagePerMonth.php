<?php

declare(strict_types=1);

namespace App\Actions\Ista;

use App\Actions\Action;
use App\Models\Ista\Usage;
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

    public function handle(): DataCollection
    {
        /** @var Collection $data */
        $data = Usage::raw(function (Collection $collection): Iterator&CursorInterface {
            return $collection->aggregate([
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
                    '$limit' => $this->months,
                ],
            ]);
        });

        $result = [];

        foreach ($data as $usage) {
            $result[] = new \App\Data\Ista\Usage(
                year: $usage['_id']['year'],
                month: $usage['_id']['month'],
                usage: $usage['usage'],
                usage_previous_year: $usage['usage_previous_year'],
                building_average_usage: $usage['building_average_usage'],
            );
        }

        return new DataCollection(\App\Data\Ista\Usage::class, $result);
    }
}
