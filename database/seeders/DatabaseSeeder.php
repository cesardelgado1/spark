<?php

namespace Database\Seeders;
use App\Models\Goal;
use App\Models\Indicator;
use App\Models\Objective;
use App\Models\Task;
use App\Models\Topic;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Create users
        Usuario::factory()->count(5)->create();

        // Create topics and their related data
        Topic::factory()->count(3)->create()->each(function ($topic) {
            $goals = Goal::factory()->count(2)->create(['t_id' => $topic->t_id]);

            $goals->each(function ($goal) {
                $objectives = Objective::factory()->count(2)->create(['g_id' => $goal->g_id]);

                $objectives->each(function ($objective) {
                    Indicator::factory()->count(3)->create(['o_id' => $objective->o_id]);
                });
            });
        });

        // Create tasks
        Task::factory()->count(10)->create();
    }
}
