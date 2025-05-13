<?php

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
