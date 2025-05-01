<?php

namespace App\Http\Controllers;

use App\Models\AssignObjectives;
use App\Models\Objective;
use App\Models\StrategicPlan;
use App\Models\User;
use App\Models\IndicatorValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Displays the Tareas (Tasks) view for the current user.
     *
     * Loads assigned objectives, optionally filtered by strategic plan.
     * Also calculates indicator completion status for each assignee tied to an objective.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Get all strategic plans that the user has assignments under
        $strategicPlans = StrategicPlan::whereHas('topics.goals.objectives.assignments', function ($q) use ($userId) {
            $q->where('ao_assigned_to', $userId);
        })->get();

        $planId = $request->input('sp_id');

        // Load objectives assigned to the current user
        $assignedObjectivesQuery = AssignObjectives::with([
            'objective.indicators',
            'objective.goal.topic.strategicplan',
            'objective.assignments.assignedTo',
            'assignedBy'
        ])->where('ao_assigned_to', $userId);

        // If a plan is selected, filter objectives by that plan
        if ($planId) {
            $assignedObjectivesQuery->whereHas('objective.goal.topic', function ($q) use ($planId) {
                $q->where('sp_id', $planId);
            });
        }

        $assignedObjectives = $assignedObjectivesQuery->get()->unique('ao_ObjToFill')->values();

        // Track which assignees have completed their indicator entries
        $assigneeCompletion = [];

        foreach ($assignedObjectives as $assignment) {
            $objective = $assignment->objective;
            $indicators = $objective->indicators;

            foreach ($objective->assignments as $assigneeAssignment) {
                $assignee = $assigneeAssignment->assignedTo;

                if (!$assignee || $assignee->u_type !== 'Assignee') continue;

                $completed = $indicators->every(function ($indicator) use ($assignee) {
                    return IndicatorValues::where('iv_ind_id', $indicator->i_id)
                        ->where('iv_u_id', $assignee->id)
                        ->whereNotNull('iv_value')
                        ->where('iv_value', '!=', '')
                        ->exists();
                });

                $assigneeCompletion[$objective->o_id][] = [
                    'assignee' => $assignee,
                    'completed' => $completed
                ];
            }
        }

        return view('tasks.index', compact('assignedObjectives', 'strategicPlans', 'planId', 'assigneeCompletion'));
    }
}
