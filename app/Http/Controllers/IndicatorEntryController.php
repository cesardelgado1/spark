<?php

namespace App\Http\Controllers;

use App\Models\AssignObjectives;
use App\Models\Objective;
use App\Models\Indicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $indicator = Indicator::findOrFail($id);

        if ($indicator->i_type === 'document') {
            if (is_object($value) && $value->isValid()) {
                // Delete the old document if it exists
                if ($indicator->i_value && Storage::disk('public')->exists($indicator->i_value)) {
                    Storage::disk('public')->delete($indicator->i_value);
                }

                // Store the new document
                $path = $value->store('indicators/documents', 'public');
                $indicator->i_value = $path;
            }
        } else {
            $indicator->i_value = $value;
        }

        $indicator->save();
    }

    return redirect()->route('tasks.index')->with('success', 'Indicadores actualizados correctamente.');
}

}
