<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory {
    protected $model = User::class;

    public function definition(): array {
        return [
            'u_fname' => $this->faker->firstName(),
            'u_lname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'u_signup_date' => now(),
            'u_type' => $this->faker->randomElement(['Admin', 'Planner', 'Assignee', 'Contributor']),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
