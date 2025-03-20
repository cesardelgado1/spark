<?php

namespace Database\Factories;

use App\Models\Indicator;
use App\Models\Objective;
use Illuminate\Database\Eloquent\Factories\Factory;

class IndicatorFactory extends Factory {
    protected $model = Indicator::class;

    public function definition(): array {
        return [
            'i_num' => $this->faker->unique()->randomNumber(),
            'i_prompt' => $this->faker->sentence(),
            'i_resp_num' => $this->faker->optional()->randomNumber(),
            'i_resp_text' => $this->faker->optional()->sentence(),
            'i_resp_file' => $this->faker->optional()->word() . '.pdf',
            'i_FY' => $this->faker->optional()->year(),
            'o_id' => Objective::factory(),
        ];
    }
}
