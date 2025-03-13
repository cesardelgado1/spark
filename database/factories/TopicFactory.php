<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopicFactory extends Factory {
    protected $model = Topic::class;

    public function definition(): array {
        return [
            't_num' => $this->faker->unique()->randomNumber(),
            't_text' => $this->faker->sentence(),
        ];
    }
}
