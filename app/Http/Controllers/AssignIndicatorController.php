<?php

namespace App\Http\Controllers;

use App\Models\AssignIndicators;
use App\Models\Indicator;
use App\Models\User;
use Illuminate\Http\Request;

class AssignIndicatorController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'indicator_id' => 'required|exists:indicators,i_id',
            'user_id' => 'required|exists:users,id',
        ]);

        AssignIndicators::create($validated);

        return back()->with('success', 'AssignIndicator created successfully.');
    }

    public function destroy(AssignIndicators $assignment)
    {
        $assignment->delete();
        return back()->with('success', 'AssignIndicator removed successfully.');
    }
}
