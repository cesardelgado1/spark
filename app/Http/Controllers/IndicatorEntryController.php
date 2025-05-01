<?php

namespace App\Http\Controllers;

use App\Models\AssignObjectives;
use App\Models\Objective;
use App\Models\Indicator;
use App\Models\IndicatorValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IndicatorEntryController extends Controller
{
    /**
     * Displays the indicator entry form for the current user on a given objective.
     *
     * Ensures the user is assigned to the objective and only shows indicators
     * for the current fiscal year. Also loads any previously entered values.
     */
    public function showForEntry(Objective $objective)
    {
        $userId = Auth::id();

        $isAssigned = AssignObjectives::where('ao_ObjToFill', $objective->o_id)
            ->where('ao_assigned_to', $userId)
            ->exists();

        if (! $isAssigned) {
            abort(403, 'No estás asignado a este objetivo.');
        }

        // Calculate the current Fiscal Year
        $year = date('Y');
        $month = date('n');

        if ($month >= 7) {
            $fyStart = $year;
            $fyEnd = $year + 1;
        } else {
            $fyStart = $year - 1;
            $fyEnd = $year;
        }

        $currentFiscalYear = "$fyStart-$fyEnd";

        // Get only indicators for the current Fiscal Year
        $indicators = $objective->indicators()
            ->where('i_FY', $currentFiscalYear)
            ->get();

        // Get the current user's values for those indicators
        $userIndicatorValues = IndicatorValues::where('iv_u_id', $userId)
            ->whereIn('iv_ind_id', $indicators->pluck('i_id'))
            ->pluck('iv_value', 'iv_ind_id'); // Key: indicator ID, Value: user’s value

        // Attach the user's value to each indicator object
        foreach ($indicators as $indicator) {
            $indicator->user_value = $userIndicatorValues[$indicator->i_id] ?? null;
        }

        return view('indicators.fill', compact('objective', 'indicators'));
    }

    /**
     * Updates the user's values for one or more indicators.
     *
     * Saves each entry per user and recalculates the final `i_value` for each indicator
     * (sum for integers, concatenation for strings/documents), unless the indicator is locked.
     */
    public function updateValues(Request $request)
    {
        $userId = Auth::id();

        foreach ($request->indicators as $id => $value) {
            $indicator = Indicator::findOrFail($id);

            // Skip if the indicator is locked
            if ($indicator->i_locked) {
                continue;
            }

            if ($indicator->i_type === 'document') {
                if (is_object($value) && $value->isValid()) {
                    $originalName = $value->getClientOriginalName();
                    $path = $value->storeAs('documents', $originalName, 'public');
                    $iv_value = $originalName;
                } else {
                    continue;
                }
            } else {
                $iv_value = $value;
            }

            IndicatorValues::updateOrCreate(
                ['iv_u_id' => $userId, 'iv_ind_id' => $id],
                ['iv_value' => $iv_value]
            );
        }

        // Recalculate overall indicator value per type
        $indicatorIds = array_keys($request->indicators);

        foreach ($indicatorIds as $indicatorId) {
            $indicator = Indicator::findOrFail($indicatorId);

            if ($indicator->i_locked) {
                continue;
            }

            if ($indicator->i_type === 'integer') {
                $result = IndicatorValues::where('iv_ind_id', $indicatorId)->sum('iv_value');
            } elseif ($indicator->i_type === 'string' || $indicator->i_type === 'document') {
                $result = IndicatorValues::where('iv_ind_id', $indicatorId)
                    ->pluck('iv_value')
                    ->filter()
                    ->implode(', ');
            } else {
                $result = null;
            }

            Indicator::where('i_id', $indicatorId)->update(['i_value' => $result]);
        }

        return redirect()->route('tasks.index')->with('success', 'Indicadores actualizados correctamente.');
    }
}
