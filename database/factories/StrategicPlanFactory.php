<?php

namespace Database\Factories;

use App\Models\AuditLogs;
use App\Models\Goal;
use App\Models\StrategicPlan;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StrategicPlanFactory extends Factory {
    protected $model = StrategicPlan::class;

    public function definition(): array {
        return [
            'sp_institution' => $this->faker->randomElement(['UPRM', 'UPR']),
        ];
    }
}
