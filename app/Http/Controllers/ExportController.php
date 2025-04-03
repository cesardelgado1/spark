<?php

namespace App\Http\Controllers;

use App\Exports\StrategicPlanExport;
use App\Models\Goal;
use App\Models\Objective;
use App\Models\StrategicPlan;
use App\Models\Topic;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function getAllSP()
    {
        $strategicPlans = StrategicPlan::all(); // Fetch all plans from the database
        return view('reportes.index', compact('strategicPlans'));
    }

    public function getTopicsForSP($sp_id)
    {
        $topics = Topic::where('sp_id', $sp_id)
            ->orderBy('t_num', 'asc')
            ->get();

        return response()->json($topics);
    }

    public function getGoalsForTopic($topic_id)
    {
        $goals = \App\Models\Goal::where('t_id', $topic_id)
            ->orderBy('g_num', 'asc')
            ->get();

        return response()->json($goals);
    }

    public function getObjectivesForGoal($goal_id)
    {
        $objectives = \App\Models\Objective::where('g_id', $goal_id)
            ->orderBy('o_num', 'asc')
            ->get()
            ->map(function ($objective) {
                return [
                    'o_id' => $objective->o_id,
                    'o_num' => $objective->o_num,
                    'g_num' => optional($objective->goal)->g_num,
                    't_num' => optional(optional($objective->goal)->topic)->t_num,
                ];
            });

        return response()->json($objectives);
    }

//    public function export()
//    {
//        return Excel::download(new StrategicPlanExport, 'strategic_plans.xlsx');
//    }
    public function export(Request $request)
    {
        $sp_id = $request->input('sp_id');
        $topicIds = $request->input('topics', []);
        $goalIds = $request->input('goals', []);
        $objectiveIds = $request->input('objectives', []);

        return Excel::download(
            new StrategicPlanExport($sp_id, $topicIds, $goalIds, $objectiveIds),
            'strategic_plan_export.xlsx'
        );
    }
}

