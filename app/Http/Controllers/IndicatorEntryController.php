<?php

namespace App\Http\Controllers;

use App\Models\AssignObjectives;
use App\Models\Objective;
use App\Models\Indicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndicatorEntryController extends Controller
{
    public function showForEntry(Objective $objective)
    {
        $userId = Auth::id();

        $isAssigned = AssignObjectives::where('ao_ObjToFill', $objective->o_id)
            ->where('ao_assigned_to', $userId)
            ->exists();

        if (! $isAssigned) {
            abort(403, 'No estás asignado a este objetivo.');
        }

        $indicators = $objective->indicators;

        return view('indicators.fill', compact('objective', 'indicators'));
    }
    public function updateValues(Request $request)
    {
        foreach ($request->indicators as $id => $value) {
            Indicator::where('i_id', $id)->update(['i_value' => $value]);
        }

        return redirect()->route('tasks.index')->with('success', 'Indicadores actualizados correctamente.');
    }

}
