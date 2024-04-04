<?php

declare(strict_types=1);

namespace App\Data\MotorOccasion;

use Spatie\LaravelData\Data;

class Result extends Data
{
    public function __construct(
        public string $brand,
        public string $model,
        public float $price,
        public int $year,
        public int $odometerReading,
        public string $odometerReadingUnit,
        public string $image,
        public string $url,
        public Seller $seller,
    ) {
    }
}
