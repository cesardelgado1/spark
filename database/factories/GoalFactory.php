<?php

namespace Database\Factories;

use App\Models\Goal;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoalFactory extends Factory {
    protected $model = Goal::class;

    public function definition(): array {
        return [
            'g_num' => $this->faker->numberBetween(1, 9999),
            'g_text' => $this->faker->sentence(),
            't_id' => Topic::factory(),
        ];
    }
}
