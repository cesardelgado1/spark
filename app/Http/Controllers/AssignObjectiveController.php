<?php

namespace App\Http\Controllers;

use App\Models\AssignObjectives;
use App\Models\Objective;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignObjectiveController extends Controller
{
    /**
     * Handles assignment of an objective to one or more users.
     *
     * Validates the request and creates assignment records for each selected user.
     * Existing assignments will not be duplicated.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'objective_id' => 'required|exists:objectives,o_id',
            'user_ids'     => 'required|array',
            'user_ids.*'   => 'exists:users,id',
        ]);

        $objectiveId = $validated['objective_id'];
        $userIds = $validated['user_ids'];
        $assignedBy = Auth::id(); // who is assigning

        foreach ($userIds as $userId) {
            AssignObjectives::firstOrCreate([
                'ao_ObjToFill'    => $objectiveId,
                'ao_assigned_to'  => $userId,
                'ao_assigned_by'  => $assignedBy,
            ]);
        }

        return redirect()->back()->with('success', 'Objetivo asignado correctamente.')->with('selected_objective', $objectiveId);
    }

    /**
     * Removes a specific objective assignment.
     *
     * Deletes the assignment record and returns a JSON response
     * including the user ID that was unassigned.
     */
    public function destroy(AssignObjectives $assignment)
    {
        $userId = $assignment->ao_assigned_to; // capture BEFORE delete
        $assignment->delete();

        return response()->json(['success' => true, 'user_id' => $userId]);
    }

    /**
     * Displays the form for assigning an objective to users.
     *
     * Loads available assignees and their current assignment status
     * for a given objective, then passes the data to the view.
     */
    public function showAssigneeForm(Objective $objective)
    {
        $assignees = User::where('u_type', 'Assignee')->get();

        $assignedRecords = AssignObjectives::where('ao_ObjToFill', $objective->o_id)
            ->get(['ao_id', 'ao_assigned_to']); // get both ao_id and user_id

        // Build the assignedMap
        $assignedMap = [
            $objective->o_id => $assignedRecords->map(function($record) {
                return [
                    'user_id' => $record->ao_assigned_to,
                    'ao_id' => $record->ao_id,
                ];
            })->toArray(),
        ];

        return view('indicators.assign', compact('objective', 'assignees', 'assignedMap'));
    }

    /**
     * Creates or updates assignments of a specific objective to selected users.
     *
     * Ensures the objective is assigned to all specified users, updating the
     * 'assigned by' value if the assignment already exists.
     */
    public function assignToAssignee(Request $request, Objective $objective)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        foreach ($request->user_ids as $assigneeId) {
            AssignObjectives::updateOrCreate([
                'ao_ObjToFill' => $objective->o_id,
                'ao_assigned_to' => $assigneeId,
            ], [
                'ao_assigned_by' => auth()->id(),
            ]);
        }

        return redirect()->back()->with('success', 'Objetivo asignado correctamente.')->with('selected_objective', $objective->o_id);
    }
}
