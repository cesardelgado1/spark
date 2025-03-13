<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory {
    protected $model = Task::class;

    public function definition(): array {
        return [
            'assigned_by' => Usuario::factory(),
            'assigned_to' => Usuario::factory(),
            'assigned_on' => now(),
            'completed_on' => $this->faker->optional()->dateTime(),
        ];
    }
}
