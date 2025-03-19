<?php

namespace Database\Factories;

use App\Models\AuditLogs;
use App\Models\Goal;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditLogsFactory extends Factory {
    protected $model = AuditLogs::class;

    public function definition(): array {
        return [
            'al_timestamp' => $this->faker->dateTime(),
            'al_IPAddress' => $this->faker->ipv4(),
            'al_action' => $this->faker->sentence(),
            'al_action_par' => $this->faker->sentence(),
            'id' => User::factory(),
        ];
    }
}
