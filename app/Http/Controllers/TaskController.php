<?php

namespace App\Http\Controllers;

use App\Models\AssignObjectives;
use App\Models\StrategicPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $strategicPlans = StrategicPlan::whereHas('topics.goals.objectives.assignments', function ($q) use ($userId) {
            $q->where('ao_assigned_to', $userId);
        })->get();


        $planId = $request->input('sp_id');

        $assignedObjectivesQuery = AssignObjectives::with([
            'objective.indicators', // <-- add this
            'objective.goal.topic.strategicplan',
            'assignedBy'
        ])
            ->where('ao_assigned_to', $userId);


        if ($planId) {
            $assignedObjectivesQuery->whereHas('objective.goal.topic', function ($q) use ($planId) {
                $q->where('sp_id', $planId);
            });
        }
        $assignedObjectives = $assignedObjectivesQuery->get();

        #dd($strategicPlans);
        return view('tasks.index', compact('assignedObjectives', 'strategicPlans', 'planId'));
    }
}
