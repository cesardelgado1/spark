<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StrategicPlan;
use App\Models\Topic;
use App\Models\Goal;
use App\Models\Objective;
use App\Models\Indicator;
use App\Models\Task;
use App\Models\AuditLogs;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Strategic Plan
        $strategicPlan = StrategicPlan::factory()->create();

        // 2. Create Users
        $users = User::factory()->count(5)->create();

        // 3. Create Topics with nested Goals, Objectives, and Indicators
        Topic::factory()
            ->count(3)
            ->create(['sp_id' => $strategicPlan->sp_id])
            ->each(function ($topic) {
                Goal::factory()
                    ->count(2)
                    ->create(['t_id' => $topic->t_id])
                    ->each(function ($goal) {
                        Objective::factory()
                            ->count(2)
                            ->create(['g_id' => $goal->g_id])
                            ->each(function ($objective) {
                                Indicator::factory()->count(3)->create([
                                    'o_id' => $objective->o_id,
                                    'i_FY' => now()->year,
                                ]);
                            });
                    });
            });

        // 4. Create Tasks between users
        Task::factory()->count(10)->create([
            'assigned_by' => $users[0]->id,
            'assigned_to' => $users[1]->id,
        ]);

        // 5. Create Audit Logs for seeded indicators
        $indicators = Indicator::all();
        $logUser = $users->first();

        $indicators->each(function ($indicator) use ($logUser) {
            AuditLogs::factory()->create([
                'user_id' => $logUser->id,
                'al_action' => 'Seeded indicator',
                'al_action_par' => json_encode(['indicator_id' => $indicator->i_id]),
                'al_IPAddress' => ip2long('127.0.0.1'),
            ]);
        });
    }
}
