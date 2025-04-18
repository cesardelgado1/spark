<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class AuditLogsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'al_IPAddress' => $this->faker->ipv4,
            'al_action' => $this->faker->word,
            'al_action_par' => $this->faker->sentence,
            'user_id' => User::factory(),
        ];
    }
}
