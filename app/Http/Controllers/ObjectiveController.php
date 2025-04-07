<?php

namespace App\Http\Controllers;

use App\Models\AssignObjectives;
use App\Models\Goal;
use App\Models\Objective;
use App\Models\User;
use Illuminate\Http\Request;

class ObjectiveController extends Controller
{
    public function index(Goal $goal)
    {
        $objectives = Objective::where('g_id', $goal->g_id)
            ->orderBy('o_num', 'asc')
            ->get();

        return view('objectives.index', compact('objectives', 'goal'));
    }

    public function create(Goal $goal)
    {
        return view('objectives.create', compact('goal'));
    }

    public function store(Request $request, Goal $goal)
    {
        $validated = $request->validate([
            'o_num' => 'required|integer|min:1',
            'o_text' => 'required|string|max:255',
            'g_id'   => 'required|exists:goals,g_id',
        ]);

        // Crear el objetivo vinculado a la meta
        Objective::create([
            'o_num' => $validated['o_num'],
            'o_text' => $validated['o_text'],
            'g_id' => $validated['g_id'],
        ]);

        return redirect()->route('goals.objectives', ['goal' => $goal->g_id])
            ->with('success', 'Objetivo creado correctamente.');
    }

    public function show(Objective $objective)
    {
        return view('objectives.show', compact('objective'));
    }

    public function edit($id)
    {
        $objective = Objective::findOrFail($id);

        $goal = Goal::findOrFail($objective->g_id);

        return view('objectives.edit', compact('objective', 'goal'));
    }

    public function update(Request $request, Objective $objective)
    {
        $request ->validate([
            'o_num' => 'required|string|max:255',
            'o_text' => 'required|string',
        ]);

        $objective->o_num = $request->o_num;
        $objective->o_text = $request->o_text;
        $objective->save();

        return redirect()->route('goals.objectives', ['goal' => $objective->g_id])
            ->with('success', 'Objetivo actualizado correctamente.');
    }

    public function destroy(Objective $objective)
    {
        $objective->delete();
        return redirect()->route('objectives.index');
    }

    public function showObjectives(Goal $goal)
    {
        $objectives = $goal->objectives()->get();

        return view('objectives.index', compact('objectives', 'goal'));
    }

    public function bulkDelete(Request $request)
    {
        $objectiveIds = $request->input('objectives', []);

        if (count($objectiveIds) > 0) {
            Objective::whereIn('o_id', $objectiveIds)->delete();
            return redirect()->back()->with('success', 'Objetivos eliminados correctamente.');
        } else {
            return redirect()->back()->with('error', 'No se seleccionaron objetivos para eliminar.');
        }
    }
    public function showAssignForm(Goal $goal)
    {
        $objectives = $goal->objectives;

        // Get ALL contributors
        $contributors = User::where('u_type', 'Contributor')->get();

        // Get the objectives' IDs under this Goal
        $objectiveIds = $objectives->pluck('o_id');

        // Get all roles for these objectives
        $assignments = AssignObjectives::whereIn('ao_ObjToFill', $objectiveIds)->get();

        // Build a map: objective_id => array of assigned user IDs
        $assignedMap = [];

        foreach ($assignments as $assignment) {
            $assignedMap[$assignment->ao_ObjToFill][] = [
                'user_id' => $assignment->ao_assigned_to,
                'ao_id' => $assignment->ao_id,
            ];
        }

        return view('objectives.assign', compact('goal', 'objectives', 'contributors', 'assignedMap'));
    }
    public function getAssignedContributors($objectiveId)
    {
        $assignedRecords = AssignObjectives::where('ao_ObjToFill', $objectiveId)
            ->get(['ao_id', 'ao_assigned_to']); // Important: get ao_id and user_id

        return response()->json($assignedRecords);
    }





}
