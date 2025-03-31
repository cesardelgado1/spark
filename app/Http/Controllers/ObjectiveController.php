<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Objective;
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

    public function create()
    {
        return view('objectives.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules
        ]);

        Objective::create($validated);

        return redirect()->route('objectives.index');
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


}
