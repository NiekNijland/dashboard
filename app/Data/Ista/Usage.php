<?php

declare(strict_types=1);

namespace App\Data\Ista;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

abstract class Usage extends Data
{
    public float $buildingDifferencePercentage;

    public float $previousYearDifferencePercentage;

    public function __construct(
        public CarbonImmutable $date,
        public int $usage,
        public int $usage_previous_year,
        public int $building_average_usage,
    ) {
        $this->buildingDifferencePercentage = round(
            abs(($this->usage - $this->building_average_usage) / $this->building_average_usage) * 100,
            2
        );

        $this->previousYearDifferencePercentage = round(
            abs(($this->usage_previous_year - $this->usage) / $this->usage) * 100,
            2
        );
    }

    abstract public function title(): string;
}
