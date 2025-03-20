<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Topic;
use App\Models\Goal;
use App\Models\Objective;
use App\Models\Indicator;
use App\Models\Task;
use App\Models\AuditLogs;
use App\Models\StrategicPlan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users
        User::factory()->count(5)->create();

        // Create topics and related data
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
