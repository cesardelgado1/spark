<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Indicator;
use App\Models\User;

class AssignIndicatorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'i_id' => Indicator::factory(),
            'user_id' => User::factory(),
        ];
    }
}
