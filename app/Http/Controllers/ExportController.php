<?php

namespace App\Http\Controllers;

use App\Exports\StrategicPlanExport;
use App\Models\Goal;
use App\Models\Indicator;
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

//    public function getAllSPAndFY()
//    {
//        $strategicPlans = StrategicPlan::all();
//        $indicators = Indicator::select('i_FY')->distinct()->get();
//
//        return view('reportes.index', compact('strategicPlans', 'indicators'));
//    }

    public function getFYsForSP($sp_id)
    {
        $fys = Indicator::whereIn('o_id', function ($query) use ($sp_id) {
            $query->select('o_id')
                ->from('objectives')
                ->whereIn('g_id', function ($query2) use ($sp_id) {
                    $query2->select('g_id')
                        ->from('goals')
                        ->whereIn('t_id', function ($query3) use ($sp_id) {
                            $query3->select('t_id')
                                ->from('topics')
                                ->where('sp_id', $sp_id);
                        });
                });
        })
            ->select('i_FY')
            ->distinct()
            ->orderBy('i_FY')
            ->pluck('i_FY');

        return response()->json($fys);
    }



//    public function getAllFY()
//    {
//        $indicators = Indicator::all(); // Fetch all plans from the database
//        return view('reportes.index', compact('indicators'));
//    }

//    public function getAllFY()
//    {
//        $indicators = Indicator::select('i_FY')->distinct()->get(); // Fetch distinct FY values
//        return view('reportes.index', compact('indicators'));
//    }


//    public function getTopicsForSP($sp_id)
//    {
//        $topics = Topic::where('sp_id', $sp_id)
//            ->orderBy('t_num', 'asc')
//            ->get();
//
//        return response()->json($topics);
//    }

    public function getTopicsForSPandFY($sp_id, $fy)
    {
        $topics = Topic::where('sp_id', $sp_id)
            ->whereIn('t_id', function ($query) use ($fy) {
                $query->select('t_id')
                    ->from('goals')
                    ->whereIn('g_id', function ($query2) use ($fy) {
                        $query2->select('g_id')
                            ->from('objectives')
                            ->whereIn('o_id', function ($query3) use ($fy) {
                                $query3->select('o_id')
                                    ->from('indicators')
                                    ->where('i_FY', $fy);
                            });
                    });
            })
            ->orderBy('t_num', 'asc')
            ->get();

        return response()->json($topics);
    }


//    public function getGoalsForTopic($topic_id)
//    {
//        $goals = \App\Models\Goal::where('t_id', $topic_id)
//            ->orderBy('g_num', 'asc')
//            ->get();
//
//        return response()->json($goals);
//    }
    public function getGoalsForTopicAndFY($topic_id, $fy)
    {
        $goals = \App\Models\Goal::where('t_id', $topic_id)
            ->whereIn('g_id', function ($query) use ($fy) {
                $query->select('g_id')
                    ->from('objectives')
                    ->whereIn('o_id', function ($sub) use ($fy) {
                        $sub->select('o_id')
                            ->from('indicators')
                            ->where('i_FY', $fy);
                    });
            })
            ->orderBy('g_num', 'asc')
            ->get();

        return response()->json($goals);
    }


//    public function getObjectivesForGoal($goal_id)
//    {
//        $objectives = \App\Models\Objective::where('g_id', $goal_id)
//            ->orderBy('o_num', 'asc')
//            ->get()
//            ->map(function ($objective) {
//                return [
//                    'o_id' => $objective->o_id,
//                    'o_num' => $objective->o_num,
//                    'g_num' => optional($objective->goal)->g_num,
//                    't_num' => optional(optional($objective->goal)->topic)->t_num,
//                ];
//            });
//
//        return response()->json($objectives);
//    }
    public function getObjectivesForGoalAndFY($goal_id, $fy)
    {
        $objectives = \App\Models\Objective::where('g_id', $goal_id)
            ->whereIn('o_id', function ($query) use ($fy) {
                $query->select('o_id')
                    ->from('indicators')
                    ->where('i_FY', $fy);
            })
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
//    public function export(Request $request)
//    {
//        $sp_id = $request->input('sp_id');
//        $topicIds = $request->input('topics', []);
//        $goalIds = $request->input('goals', []);
//        $objectiveIds = $request->input('objectives', []);
//
//        return Excel::download(
//            new StrategicPlanExport($sp_id, $topicIds, $goalIds, $objectiveIds),
//            'strategic_plan_export.xlsx'
//        );
//    }

    public function export(Request $request)
    {
        $sp_id = $request->input('sp_id');
        $fy = $request->input('i_FY');
        $topicIds = $request->input('topics', []);
        $goalIds = $request->input('goals', []);
        $objectiveIds = $request->input('objectives', []);

        return Excel::download(
            new StrategicPlanExport($sp_id, $fy, $topicIds, $goalIds, $objectiveIds),
            'strategic_plan_export.xlsx'
        );
    }

}

