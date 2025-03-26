<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Objective;
use App\Models\User;

class AssignObjectiveFactory extends Factory
{
    public function definition(): array
    {
        return [
            'o_id' => Objective::factory(),
            'user_id' => User::factory(),
        ];
    }
}
