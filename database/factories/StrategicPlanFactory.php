<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StrategicPlanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sp_institution' => $this->faker->company,
        ];
    }
}
