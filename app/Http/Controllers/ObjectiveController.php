<?php

namespace App\Http\Controllers;

use App\Models\AssignObjectives;
use App\Models\Goal;
use App\Models\Objective;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ObjectiveController extends Controller
{
    /**
     * Displays a list of objectives for a specific goal, ordered by number.
     */
    public function index(Goal $goal)
    {
        $objectives = Objective::where('g_id', $goal->g_id)
            ->orderBy('o_num', 'asc')
            ->get();

        return view('objectives.index', compact('objectives', 'goal'));
    }

    /**
     * Shows the form to create a new objective under a given goal.
     */
    public function create(Goal $goal)
    {
        return view('objectives.create', compact('goal'));
    }

    /**
     * Stores a newly created objective in the database after validation.
     *
     * Ensures the number is unique within the goal before saving.
     */
    public function store(Request $request, Goal $goal)
    {
        $validated = $request->validate([
            'o_num' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('objectives')->where(function ($query) use ($request) {
                    return $query->where('g_id', $request->g_id);
                }),
            ],
            'o_text' => 'required|string',
            'g_id'   => 'required|exists:goals,g_id',
        ], [
            'o_num.unique' => 'Ya existe un objetivo con ese número en esta meta.',
        ]);

        Objective::create([
            'o_num' => $validated['o_num'],
            'o_text' => $validated['o_text'],
            'g_id' => $validated['g_id'],
        ]);

        return redirect()->route('goals.objectives', ['goal' => $goal->g_id])
            ->with('success', 'Objetivo creado correctamente.');
    }

    /**
     * Displays the details of a specific objective.
     */
    public function show(Objective $objective)
    {
        return view('objectives.show', compact('objective'));
    }

    /**
     * Shows the form to edit a specific objective.
     */
    public function edit($id)
    {
        $objective = Objective::findOrFail($id);
        $goal = Goal::findOrFail($objective->g_id);

        return view('objectives.edit', compact('objective', 'goal'));
    }

    /**
     * Updates an existing objective after validating uniqueness and input.
     */
    public function update(Request $request, Objective $objective)
    {
        $validated = $request->validate([
            'o_num' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('objectives')->where(function ($query) use ($objective) {
                    return $query->where('g_id', $objective->g_id);
                })->ignore($objective->o_id, 'o_id'),
            ],
            'o_text' => 'required|string',
        ], [
            'o_num.unique' => 'Ya existe un objetivo con ese número en esta meta.',
        ]);

        $objective->update($validated);

        return redirect()->route('goals.objectives', ['goal' => $objective->g_id])
            ->with('success', 'Objetivo actualizado correctamente.');
    }

    /**
     * Deletes an objective from the database.
     */
    public function destroy(Objective $objective)
    {
        $objective->delete();
        return redirect()->route('objectives.index');
    }

    /**
     * Displays all objectives associated with a given goal.
     */
    public function showObjectives(Goal $goal)
    {
        $objectives = $goal->objectives()->get();

        return view('objectives.index', compact('objectives', 'goal'));
    }

    /**
     * Deletes multiple selected objectives in a single request.
     */
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

    /**
     * Displays the assignment interface to assign objectives to contributors.
     *
     * Loads all contributors and currently assigned users per objective.
     */
    public function showAssignForm(Goal $goal)
    {
        $objectives = $goal->objectives;
        $contributors = User::where('u_type', 'Contributor')->get();

        $objectiveIds = $objectives->pluck('o_id');
        $assignments = AssignObjectives::whereIn('ao_ObjToFill', $objectiveIds)->get();

        $assignedMap = [];

        foreach ($assignments as $assignment) {
            $assignedMap[$assignment->ao_ObjToFill][] = [
                'user_id' => $assignment->ao_assigned_to,
                'ao_id' => $assignment->ao_id,
            ];
        }

        return view('objectives.assign', compact('goal', 'objectives', 'contributors', 'assignedMap'));
    }

    /**
     * Returns all users assigned to a specific objective as JSON.
     */
    public function getAssignedContributors($objectiveId)
    {
        $assignedRecords = AssignObjectives::where('ao_ObjToFill', $objectiveId)
            ->get(['ao_id', 'ao_assigned_to']);

        return response()->json($assignedRecords);
    }
}
