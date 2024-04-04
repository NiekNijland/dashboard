<?php

declare(strict_types=1);

namespace App\Data\MotorOccasion;

use Spatie\LaravelData\Data;

class Seller extends Data
{
    public function __construct(
        public string $name,
        public string $province,
        public string $website,
    ) {
    }
}
