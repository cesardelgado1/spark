<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Objective;
use Illuminate\Http\Request;

class ObjectiveController extends Controller
{
    public function index()
    {
        $objectives = Objective::latest()->simplePaginate(5);
        return view('objectives.index', compact('objectives'));
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

    public function edit(Objective $objective)
    {
        return view('objectives.edit', compact('objective'));
    }

    public function update(Request $request, Objective $objective)
    {
        $validated = $request->validate([
            // TODO: add validation rules
        ]);

        $objective->update($validated);

        return redirect()->route('objectives.index');
    }

    public function destroy(Objective $objective)
    {
        $objective->delete();
        return redirect()->route('objectives.index');
    }

    public function showObjectives(Goal $goal)
    {
        $objectives = $goal->objectives;
        return view('objectives.index', compact('objectives', 'goal'));
    }

}
