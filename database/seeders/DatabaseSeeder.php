<?php

namespace Database\Seeders;

use App\Models\AssignIndicators;
use App\Models\AssignObjectives;
use App\Models\AuditLogs;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StrategicPlan;
use App\Models\Topic;
use App\Models\Goal;
use App\Models\Objective;
use App\Models\Indicator;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
// Create users
        $users = User::factory()->count(10)->create();

// Create strategic plan with nested data
        $strategicPlan = StrategicPlan::factory()->create();

        $usersByType = [
            'Planner' => $users->where('u_type', 'Planner'),
            'Contributor' => $users->where('u_type', 'Contributor'),
            'Assignee' => $users->where('u_type', 'Assignee'),
        ];

        Topic::factory()->count(rand(2, 4))->create(['sp_id' => $strategicPlan->sp_id])->each(function ($topic) use ($usersByType) {
            Goal::factory()->count(rand(2, 4))->create(['t_id' => $topic->t_id])->each(function ($goal) use ($usersByType) {
                Objective::factory()->count(rand(2, 4))->create(['g_id' => $goal->g_id])->each(function ($objective) use ($usersByType) {

// Assign objectives to Contributors
                    if ($usersByType['Contributor']->count() && $usersByType['Planner']->count()) {
                        AssignObjectives::create([
                            'ao_ObjToFill' => $objective->o_id,
                            'ao_assigned_to' => $usersByType['Contributor']->random()->id,
                            'ao_assigned_by' => $usersByType['Planner']->random()->id,
                        ]);
                    }

                    Indicator::factory()->count(rand(2, 3))->create(['o_id' => $objective->o_id])->each(function ($indicator) use ($usersByType) {
// Assign indicators to Assignees
                        if ($usersByType['Assignee']->count()) {
                            AssignIndicators::create([
                                'i_id' => $indicator->i_id,
                                'user_id' => $usersByType['Assignee']->random()->id,
                            ]);
                        }
                    });
                });
            });
        });
    }
}
