<?php
//////
//////namespace App\Http\Controllers;
//////
//////use App\Models\AssignObjectives;
//////use App\Models\Objective;
//////use App\Models\StrategicPlan;
//////use App\Models\User;
//////use App\Models\IndicatorValues;
//////use Illuminate\Http\Request;
//////use Illuminate\Support\Facades\Auth;
//////
//////class TaskController extends Controller
//////{
//////    /**
//////     * Displays the Tareas (Tasks) view for the current user.
//////     *
//////     * Loads assigned objectives, optionally filtered by strategic plan.
//////     * Also calculates indicator completion status for each assignee tied to an objective.
//////     */
//////    public function index(Request $request)
//////    {
//////        $userId = Auth::id();
//////
//////        // Get all strategic plans that the user has assignments under
//////        $strategicPlans = StrategicPlan::whereHas('topics.goals.objectives.assignments', function ($q) use ($userId) {
//////            $q->where('ao_assigned_to', $userId);
//////        })->get();
//////
//////        $planId = $request->input('sp_id');
//////
//////        // Load objectives assigned to the current user
//////        $assignedObjectivesQuery = AssignObjectives::with([
//////            'objective.indicators',
//////            'objective.goal.topic.strategicplan',
//////            'objective.assignments.assignedTo',
//////            'assignedBy'
//////        ])->where('ao_assigned_to', $userId);
//////
//////        // If a plan is selected, filter objectives by that plan
//////        if ($planId) {
//////            $assignedObjectivesQuery->whereHas('objective.goal.topic', function ($q) use ($planId) {
//////                $q->where('sp_id', $planId);
//////            });
//////        }
//////
//////        $assignedObjectives = $assignedObjectivesQuery->get()->unique('ao_ObjToFill')->values();
//////
//////        // Track which assignees have completed their indicator entries
//////        $assigneeCompletion = [];
//////
//////        foreach ($assignedObjectives as $assignment) {
//////            $objective = $assignment->objective;
//////            $indicators = $objective->indicators;
//////
//////            foreach ($objective->assignments as $assigneeAssignment) {
//////                $assignee = $assigneeAssignment->assignedTo;
//////
//////                if (!$assignee || $assignee->u_type !== 'Assignee') continue;
//////
//////                $completed = $indicators->every(function ($indicator) use ($assignee) {
//////                    return IndicatorValues::where('iv_ind_id', $indicator->i_id)
//////                        ->where('iv_u_id', $assignee->id)
//////                        ->whereNotNull('iv_value')
//////                        ->where('iv_value', '!=', '')
//////                        ->exists();
//////                });
//////
//////                $assigneeCompletion[$objective->o_id][] = [
//////                    'assignee' => $assignee,
//////                    'completed' => $completed
//////                ];
//////            }
//////        }
//////
//////        return view('tasks.index', compact('assignedObjectives', 'strategicPlans', 'planId', 'assigneeCompletion'));
//////    }
//////}
////
////
////namespace App\Http\Controllers;
////
////use App\Models\AssignObjectives;
////use App\Models\Objective;
////use App\Models\StrategicPlan;
////use App\Models\User;
////use App\Models\Indicator;
////use App\Models\IndicatorValues;
////use Illuminate\Http\Request;
////use Illuminate\Support\Facades\Auth;
////
////class TaskController extends Controller
////{
////    /**
////     * Displays the Tareas (Tasks) view for the current user.
////     *
////     * Loads assigned objectives, optionally filtered by strategic plan and fiscal year.
////     * Also calculates indicator completion status for each assignee tied to an objective.
////     */
////    public function index(Request $request)
////    {
////        $userId = Auth::id();
////
////        // Get selected filters
////        $planId = $request->input('sp_id');
////        $selectedFY = $request->input('fy');
////
////        // Determine current FY if none selected
////        $year = date('Y');
////        $month = date('n');
////        $currentFY = ($month >= 7) ? "$year-" . ($year + 1) : ($year - 1) . "-$year";
////        $fy = $selectedFY ?: $currentFY;
////
////        // Get all strategic plans that the user has assignments under
////        $strategicPlans = StrategicPlan::whereHas('topics.goals.objectives.assignments', function ($q) use ($userId) {
////            $q->where('ao_assigned_to', $userId);
////        })->get();
////
////        // Get available FYs from indicators table
////        $availableFYs = Indicator::select('i_FY')->distinct()->pluck('i_FY')->sort();
////
////        // Load objectives assigned to the current user
////        $assignedObjectivesQuery = AssignObjectives::with([
////            'objective.indicators',
////            'objective.goal.topic.strategicplan',
////            'objective.assignments.assignedTo',
////            'assignedBy'
////        ])->where('ao_assigned_to', $userId);
////
////        // Filter by Strategic Plan if selected
////        if ($planId) {
////            $assignedObjectivesQuery->whereHas('objective.goal.topic', function ($q) use ($planId) {
////                $q->where('sp_id', $planId);
////            });
////        }
////
//////        $assignedObjectives = $assignedObjectivesQuery->get()->unique('ao_ObjToFill')->values();
////        $assignedObjectives = $assignedObjectivesQuery->get()
////            ->unique('ao_ObjToFill')
////            ->filter(function ($assignment) use ($fy) {
////                return $assignment->objective->indicators->contains('i_FY', $fy);
////            })
////            ->values();
////
////
////        // Track which assignees have completed their indicator entries (only for selected FY)
////        $assigneeCompletion = [];
////
////        foreach ($assignedObjectives as $assignment) {
////            $objective = $assignment->objective;
////            $indicators = $objective->indicators->where('i_FY', $fy);
////
////            foreach ($objective->assignments as $assigneeAssignment) {
////                $assignee = $assigneeAssignment->assignedTo;
////
////                if (!$assignee || $assignee->u_type !== 'Assignee') continue;
////
////                $completed = $indicators->every(function ($indicator) use ($assignee) {
////                    return IndicatorValues::where('iv_ind_id', $indicator->i_id)
////                        ->where('iv_u_id', $assignee->id)
////                        ->whereNotNull('iv_value')
////                        ->where('iv_value', '!=', '')
////                        ->exists();
////                });
////
////                $assigneeCompletion[$objective->o_id][] = [
////                    'assignee' => $assignee,
////                    'completed' => $completed
////                ];
////            }
////        }
////
////        return view('tasks.index', compact(
////            'assignedObjectives',
////            'strategicPlans',
////            'planId',
////            'assigneeCompletion',
////            'availableFYs',
////            'fy' // selected FY
////        ));
////    }
////}
//
//
//namespace App\Http\Controllers;
//
//use App\Models\AssignObjectives;
//use App\Models\Objective;
//use App\Models\StrategicPlan;
//use App\Models\User;
//use App\Models\Indicator;
//use App\Models\IndicatorValues;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//
//class TaskController extends Controller
//{
//    /**
//     * Displays the Tareas (Tasks) view for the current user.
//     *
//     * Loads assigned objectives, optionally filtered by strategic plan and fiscal year.
//     * Also calculates indicator completion status for each assignee tied to an objective.
//     */
//    public function index(Request $request)
//    {
//        $userId = Auth::id();
//
//        // Get selected filters (optional)
//        $planId = $request->input('sp_id');
//        $fy = $request->input('fy'); // If null, we show all FYs
//
//        // Get all strategic plans that the user has assignments under
//        $strategicPlans = StrategicPlan::whereHas('topics.goals.objectives.assignments', function ($q) use ($userId) {
//            $q->where('ao_assigned_to', $userId);
//        })->get();
//
//        // Get all available FYs from indicators table
//        $availableFYs = Indicator::select('i_FY')->distinct()->pluck('i_FY')->sort();
//
//        // Load objectives assigned to the current user
//        $assignedObjectivesQuery = AssignObjectives::with([
//            'objective.indicators',
//            'objective.goal.topic.strategicplan',
//            'objective.assignments.assignedTo',
//            'assignedBy'
//        ])->where('ao_assigned_to', $userId);
//
//        // Filter by Strategic Plan if selected
//        if ($planId) {
//            $assignedObjectivesQuery->whereHas('objective.goal.topic', function ($q) use ($planId) {
//                $q->where('sp_id', $planId);
//            });
//        }
//
//        $assignedObjectives = $assignedObjectivesQuery->get()
//            ->unique('ao_ObjToFill')
//            ->filter(function ($assignment) use ($fy) {
//                // If no FY filter, include all
//                if (!$fy) return true;
//
//                // Only include if objective has indicators for the selected FY
//                return $assignment->objective->indicators->contains('i_FY', $fy);
//            })
//            ->values();
//
//        // Track which assignees have completed their indicator entries (only for selected FY)
//        $assigneeCompletion = [];
//
//        foreach ($assignedObjectives as $assignment) {
//            $objective = $assignment->objective;
//            $indicators = $objective->indicators;
//            if ($fy) {
//                $indicators = $indicators->where('i_FY', $fy);
//            }
//
//            foreach ($objective->assignments as $assigneeAssignment) {
//                $assignee = $assigneeAssignment->assignedTo;
//
//                if (!$assignee || $assignee->u_type !== 'Assignee') continue;
//
//                $completed = $indicators->every(function ($indicator) use ($assignee) {
//                    return IndicatorValues::where('iv_ind_id', $indicator->i_id)
//                        ->where('iv_u_id', $assignee->id)
//                        ->whereNotNull('iv_value')
//                        ->where('iv_value', '!=', '')
//                        ->exists();
//                });
//
//                $assigneeCompletion[$objective->o_id][] = [
//                    'assignee' => $assignee,
//                    'completed' => $completed
//                ];
//            }
//        }
//
//        return view('tasks.index', compact(
//            'assignedObjectives',
//            'strategicPlans',
//            'planId',
//            'availableFYs',
//            'fy',
//            'assigneeCompletion'
//        ));
//    }
//}


namespace App\Http\Controllers;

use App\Models\AssignObjectives;
use App\Models\StrategicPlan;
use App\Models\Indicator;
use App\Models\IndicatorValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Displays the Tareas (Tasks) view for the current user.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Filtros opcionales
        $planId = $request->input('sp_id');
        $fy = $request->input('fy');

        // Planes estratégicos disponibles para el usuario
        $strategicPlans = StrategicPlan::whereHas('topics.goals.objectives.assignments', function ($q) use ($userId) {
            $q->where('ao_assigned_to', $userId);
        })->get();

        // Años fiscales disponibles en la base de datos
        $availableFYs = Indicator::select('i_FY')->distinct()->pluck('i_FY')->sort();

        // Objetivos asignados al usuario actual
        $assignedObjectivesQuery = AssignObjectives::with([
            'objective.indicators',
            'objective.goal.topic.strategicplan',
            'objective.assignments.assignedTo',
            'assignedBy'
        ])->where('ao_assigned_to', $userId);

        // Filtro por plan estratégico si se selecciona
        if ($planId) {
            $assignedObjectivesQuery->whereHas('objective.goal.topic', function ($q) use ($planId) {
                $q->where('sp_id', $planId);
            });
        }

        // Obtener resultados y filtrar por FY si aplica
        $assignedObjectives = $assignedObjectivesQuery->get()
            ->unique('ao_ObjToFill')
            ->filter(function ($assignment) use ($fy) {
                if (!$fy) return true; // sin filtro: mostrar todo
                return $assignment->objective->indicators->contains('i_FY', $fy);
            })
            ->values();

        return view('tasks.index', compact(
            'assignedObjectives',
            'strategicPlans',
            'planId',
            'availableFYs',
            'fy'
        ));
    }
}
