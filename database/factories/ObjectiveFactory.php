<?php

namespace Database\Factories;

use App\Models\Objective;
use App\Models\Goal;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObjectiveFactory extends Factory {
    protected $model = Objective::class;

    public function definition(): array {
        return [
            'o_num' => $this->faker->numberBetween(1, 9999),
            'o_text' => $this->faker->sentence(),
            'g_id' => Goal::factory(),
        ];
    }
}
