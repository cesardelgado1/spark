<?php

namespace App\Http\Controllers;

use App\Models\AssignObjectives;
use App\Models\Objective;
use App\Models\User;
use Illuminate\Http\Request;

class AssignObjectiveController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'objective_id' => 'required|exists:objectives,o_id',
            'user_id' => 'required|exists:users,id',
        ]);

        AssignObjectives::create($validated);

        return back()->with('success', 'AssignObjective created successfully.');
    }

    public function destroy(AssignObjectives $assignment)
    {
        $assignment->delete();
        return back()->with('success', 'AssignObjective removed successfully.');
    }
}
