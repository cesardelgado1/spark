<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'u_fname' => $this->faker->firstName,
            'u_lname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'u_signup_date' => now(),
            'u_type' => $this->faker->randomElement(['Planner', 'Contributor', 'Assignee']),
            'password' => bcrypt('password'), // default password
            'remember_token' => Str::random(10),
        ];
    }
}
