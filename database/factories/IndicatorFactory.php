<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Objective;

class IndicatorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'i_num' => $this->faker->numberBetween(1, 10),
            'i_text' => $this->faker->sentence,
            'i_type' => $this->faker->randomElement(['integer', 'string', 'document']),
            'i_doc_path' => $this->faker->optional()->filePath(),
            'i_value' => $this->faker->optional()->text,
            'o_id' => Objective::factory(),
        ];
    }
}
