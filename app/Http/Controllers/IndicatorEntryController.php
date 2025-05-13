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
    public function showForEntry(Request $request, Objective $objective)
    {
        $userId = Auth::id();

        $isAssigned = AssignObjectives::where('ao_ObjToFill', $objective->o_id)
            ->where('ao_assigned_to', $userId)
            ->exists();

        if (! $isAssigned) {
            abort(403, 'No estás asignado a este objetivo.');
        }

        $fiscalYear = $request->has('fy') ? $request->query('fy') : null;

        $indicators = $objective->indicators()
            ->when($fiscalYear, fn($query) => $query->where('i_FY', $fiscalYear))
            ->get();

        $userIndicatorValues = IndicatorValues::where('iv_u_id', $userId)
            ->whereIn('iv_ind_id', $indicators->pluck('i_id'))
            ->pluck('iv_value', 'iv_ind_id');

        foreach ($indicators as $indicator) {
            $indicator->user_value = $userIndicatorValues[$indicator->i_id] ?? null;
        }

        return view('indicators.fill', compact('objective', 'indicators', 'fiscalYear'));
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
                if ($indicator->i_type === 'integer') {
                    if (!is_numeric($value) || $value < 0) {
                        return back()->withErrors([
                            "indicators.$id" => "El valor debe ser un número entero positivo."
                        ])->withInput();
                    }
                }
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

        $fiscalYear = $request->input('fiscal_year');
        $planId = $request->input('sp_id');

        $redirect = redirect()->route('tasks.index')->with('success', 'Indicadores actualizados correctamente.');

        if ($request->has('fiscal_year') && $request->has('sp_id')) {
            $params = [];
            if ($fiscalYear) $params['fy'] = $fiscalYear;
            if ($planId) $params['sp_id'] = $planId;

            $redirect = redirect()->route('tasks.index', $params)->with('success', 'Indicadores actualizados correctamente.');
        }

        return $redirect;

    }
}
