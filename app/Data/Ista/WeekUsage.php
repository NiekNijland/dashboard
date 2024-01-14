<?php

declare(strict_types=1);

namespace App\Data\Ista;

use Carbon\CarbonImmutable;

class WeekUsage extends Usage
{
    public function __construct(
        CarbonImmutable $date,
        int $usage,
        int $usage_previous_year,
        int $building_average_usage
    ) {
        parent::__construct($date, $usage, $usage_previous_year, $building_average_usage);
    }

    public function title(): string
    {
        return implode(' ', [
            $this->date->format('Y'),
            __('general.week'),
            $this->date->format('W'),
        ]);
    }
}
