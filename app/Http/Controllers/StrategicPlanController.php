<?php

namespace App\Http\Controllers;

use App\Models\StrategicPlan;
use Illuminate\Http\Request;

class StrategicPlanController extends Controller
{
    public function index()
    {
        $strategicplans = StrategicPlan::latest()->simplePaginate(5);
        return view('strategicplans.index', ['strategicplans' => $strategicplans]);
    }

    public function create()
    {
        return view('strategicplans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules
        ]);

        StrategicPlan::create($validated);

        return redirect()->route('strategicplans.index');
    }

    public function show(StrategicPlan $strategicplan)
    {
        return view('strategicplans.show', compact('strategicplan'));
    }

    public function edit(StrategicPlan $strategicplan)
    {
        return view('strategicplans.edit', compact('strategicplan'));
    }

    public function update(Request $request, StrategicPlan $strategicplan)
    {
        $validated = $request->validate([
            // TODO: add validation rules
        ]);

        $strategicplan->update($validated);

        return redirect()->route('strategicplans.index');
    }

    public function destroy(StrategicPlan $strategicplan)
    {
        $strategicplan->delete();
        return redirect()->route('strategicplans.index');
    }
}
