<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Goal;

class ObjectiveFactory extends Factory
{
    public function definition(): array
    {
        return [
            'o_num' => $this->faker->numberBetween(1, 10),
            'o_text' => $this->faker->sentence,
            'g_id' => Goal::factory(),
        ];
    }
}
