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
    /**
     * Shows a view with all strategic plans available for export.
     *
     * Retrieves all plans from the database and passes them to the export view.
     */
    public function getAllSP()
    {
        $strategicPlans = StrategicPlan::all(); // Fetch all plans from the database
        return view('reportes.index', compact('strategicPlans'));
    }

    /**
     * Retrieves all distinct fiscal years for a given strategic plan.
     *
     * Builds a nested query to fetch fiscal years from indicators
     * linked to the strategic plan's structure.
     */
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

    /**
     * Gets all topics from a specific strategic plan that contain indicators for a given fiscal year.
     *
     * This helps dynamically populate topic filters in the export view.
     */
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

    /**
     * Gets all goals under a topic that are active for a given fiscal year.
     *
     * This is used to populate goal filters based on selected topic and fiscal year.
     */
    public function getGoalsForTopicAndFY($topic_id, $fy)
    {
        $goals = Goal::where('t_id', $topic_id)
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

    /**
     * Gets all objectives under a goal that are active for a given fiscal year.
     *
     * Returns a formatted list including goal and topic numbers to support export UI.
     */
    public function getObjectivesForGoalAndFY($goal_id, $fy)
    {
        $objectives = Objective::where('g_id', $goal_id)
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

    /**
     * Exports the filtered strategic plan data to an Excel file.
     *
     * Builds the filename dynamically based on plan, year, and department,
     * then uses the StrategicPlanExport class to generate the spreadsheet.
     */
    public function export(Request $request)
    {
        $sp_id = $request->input('sp_id');
        $fy = $request->input('i_FY');
        $department = $request->input('department');
        $topicIds = $request->input('topics', []);
        $goalIds = $request->input('goals', []);
        $objectiveIds = $request->input('objectives', []);

        $strategicPlan = \App\Models\StrategicPlan::find($sp_id);

        if (!$strategicPlan) {
            return back()->with('error', 'Strategic Plan not found.');
        }

        if ($department === "Todos") {
            $filename = 'Plan Estrategico ' . $strategicPlan->sp_institution
                . ' (' . $strategicPlan->sp_years . ') - [Año Fiscal ' . $fy . '].xlsx';
        } else {
            $filename = 'Plan Estrategico ' . $strategicPlan->sp_institution
                . ' (' . $strategicPlan->sp_years . ') - [' . $department . ', Año Fiscal ' . $fy . '].xlsx';
        }

        return Excel::download(
            new StrategicPlanExport($sp_id, $fy, $department, $topicIds, $goalIds, $objectiveIds),
            $filename
        );
    }
}
