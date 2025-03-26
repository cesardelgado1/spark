<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Topic;

class GoalFactory extends Factory
{
    public function definition(): array
    {
        return [
            'g_num' => $this->faker->numberBetween(1, 10),
            'g_text' => $this->faker->sentence,
            't_id' => Topic::factory(),
        ];
    }
}
