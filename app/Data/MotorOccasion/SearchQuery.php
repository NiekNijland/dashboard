<?php

declare(strict_types=1);

namespace App\Data\MotorOccasion;

use Spatie\LaravelData\Data;

class SearchQuery extends Data
{
    public function __construct(
        public Brand $brand,
        public Type $type,
    ) {
    }
}
