<?php

declare(strict_types=1);

namespace App\Data\MotorOccasion;

use Spatie\LaravelData\Data;

class Type extends Data
{
    public function __construct(
        public string $name,
        public string $value,
        public Brand $brand,
    ) {
    }

    public static function fromModel(\App\Models\MotorOccasion\Type $type): self
    {
        return new self(
            name: $type->name,
            value: $type->value,
            brand: Brand::fromModel($type->brand),
        );
    }
}
