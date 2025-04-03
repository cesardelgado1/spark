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
            'ao_ObjToFill' => Objective::factory(),
            'ao_assigned_to' => User::factory(),
            'ao_assigned_by' => User::factory(),
        ];
    }
}
