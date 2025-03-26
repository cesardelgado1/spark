<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StrategicPlan;

class TopicFactory extends Factory
{
    public function definition(): array
    {
        return [
            't_num' => $this->faker->numberBetween(1, 10),
            't_text' => $this->faker->sentence,
            'sp_id' => StrategicPlan::factory(),
        ];
    }
}
