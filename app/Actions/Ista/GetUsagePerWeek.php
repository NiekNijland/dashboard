<?php

declare(strict_types=1);

namespace App\Actions\Ista;

use App\Actions\Action;
use App\Data\Ista\WeekUsage;
use App\Models\Ista\Usage;
use Carbon\CarbonImmutable;
use Iterator;
use MongoDB\Driver\CursorInterface;
use MongoDB\Laravel\Collection;
use Spatie\LaravelData\DataCollection;

readonly class GetUsagePerWeek implements Action
{
    public function __construct(
        private int $weeks = 12,
    ) {
    }

    /**
     * @return DataCollection<int, WeekUsage>
     */
    public function handle(): DataCollection
    {
        /** @var Collection $data */
        $data = Usage::raw(function (Collection $collection): Iterator&CursorInterface {
            return $collection->aggregate([
                [
                    '$addFields' => [
                        'week' => [
                            '$isoWeek' => '$date',
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
                            'week' => '$week',
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
                    '$limit' => $this->weeks,
                ],
            ]);
        });

        $result = [];

        foreach ($data as $usage) {
            $date = (new CarbonImmutable())
                ->setISODate($usage['_id']['year'], $usage['_id']['week'])
                ->startOfWeek();

            $result[] = new WeekUsage(
                date: $date,
                usage: $usage['usage'],
                usage_previous_year: $usage['usage_previous_year'],
                building_average_usage: $usage['building_average_usage'],
            );
        }

        return new DataCollection(WeekUsage::class, $result);
    }
}
