<?php

declare(strict_types=1);

namespace App\Data\MotorOccasion;

use Spatie\LaravelData\Data;

class Brand extends Data
{
    public function __construct(
        public string $name,
        public string $value,
    ) {
    }

    public static function fromModel(\App\Models\MotorOccasion\Brand $brand): self
    {
        return new self(
            name: $brand->name,
            value: $brand->value,
        );
    }
}
