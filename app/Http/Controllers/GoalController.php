<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::latest()->simplePaginate(5);
        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        return view('goals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules
        ]);

        Goal::create($validated);

        return redirect()->route('goals.index');
    }

    public function show(Goal $goal)
    {
        return view('goals.show', compact('goal'));
    }

    public function edit(Goal $goal)
    {
        return view('goals.edit', compact('goal'));
    }

    public function update(Request $request, Goal $goal)
    {
        $validated = $request->validate([
            // TODO: add validation rules
        ]);

        $goal->update($validated);

        return redirect()->route('goals.index');
    }

    public function destroy(Goal $goal)
    {
        $goal->delete();
        return redirect()->route('goals.index');
    }
}
