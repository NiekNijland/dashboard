<?php

namespace Database\Factories\MotorOccasion;

use App\Models\MotorOccassion\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => $this->faker->uuid(),
            'name' => $this->faker->company(),
        ];
    }
}
