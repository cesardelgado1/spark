<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory {
    protected $model = Usuario::class;

    public function definition(): array {
        return [
            'u_fname' => $this->faker->firstName(),
            'u_lname' => $this->faker->lastName(),
            'u_email' => $this->faker->unique()->safeEmail(),
            'u_signup_date' => now(),
            'u_type' => $this->faker->randomElement(['Admin', 'Planner', 'Assignee', 'Contributor']),
        ];
    }
}
