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
            'user_ids'     => 'required|array',
            'user_ids.*'   => 'exists:users,id',
        ]);

        $objectiveId = $validated['objective_id'];
        $userIds = $validated['user_ids'];

        foreach ($userIds as $userId) {
            AssignObjectives::firstOrCreate([
                'o_id'    => $objectiveId,
                'user_id' => $userId,
            ]);
        }

        return redirect()->back()->with('success', 'Objetivo asignado correctamente.');
    }

    public function destroy(AssignObjectives $assignment)
    {
        $assignment->delete();
        return back()->with('success', 'AssignObjective removed successfully.');
    }
}
