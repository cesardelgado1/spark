<?php

namespace App\Http\Controllers;

use App\Models\AuditLogs;
use App\Models\Indicator;
use App\Models\Objective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class IndicatorController extends Controller
{
    /**
     * Shows all indicators for an objective, grouped by fiscal year.
     *
     * Used to display indicators in a tabbed layout by year.
     */
    public function index(Objective $objective)
    {
        $fiscalYears = Indicator::where('o_id', $objective->o_id)
            ->select('i_FY')
            ->distinct()
            ->orderBy('i_FY', 'asc')
            ->pluck('i_FY');

        $indicators = Indicator::where('o_id', $objective->o_id)
            ->orderBy('i_num', 'asc')
            ->get()
            ->groupBy('i_FY');

        return view('indicators.index', compact('fiscalYears', 'indicators', 'objective'));
    }

    /**
     * Shows the form to create a new indicator under an objective.
     */
    public function create(Objective $objective)
    {
        return view('indicators.create', compact('objective'));
    }

    /**
     * Stores a new indicator with validation and fiscal year constraints.
     *
     * Includes logic to verify valid fiscal year ranges, uniqueness,
     * and compliance with the parent strategic plan.
     */
    public function store(Request $request, Objective $objective)
    {
        $validated = $request->validate([
            'i_num' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('indicators')->where(function ($query) use ($request) {
                    return $query->where('o_id', $request->o_id)
                        ->where('i_FY', $request->fy_start . '-' . $request->fy_end);
                }),
            ],
            'i_text' => 'required|string',
            'i_type' => 'required|in:string,integer,document',
            'o_id' => 'required|exists:objectives,o_id',
            'fy_start' => 'required|integer',
            'fy_end' => 'required|integer|gt:fy_start',
        ], [
            'i_num.unique' => 'Ya existe un indicador con ese número en este objetivo y año fiscal.',
            'fy_end.gt' => 'El año fiscal de fin debe ser mayor que el año de inicio.',
        ]);

        $strategicPlan = $objective->goal->topic->strategicPlan;
        $fy_range = $request->fy_start . '-' . $request->fy_end;

        if ($request->fy_end != $request->fy_start + 1) {
            return back()->withErrors(['fy_start' => 'Los años fiscales deben ser consecutivos (ej. 2025-2026).'])
                ->withInput();
        }

        if ($strategicPlan->sp_institution === 'UPRM') {
            [$startYear, $endYear] = explode('-', $strategicPlan->sp_years);
            $validFiscalYears = [];
            for ($year = (int)$startYear; $year < (int)$endYear; $year++) {
                $validFiscalYears[] = "$year-" . ($year + 1);
            }

            if (!in_array($fy_range, $validFiscalYears)) {
                return back()->withErrors(['fy_start' => "En UPRM, el año fiscal debe estar dentro del rango del plan estratégico ($strategicPlan->sp_years)."])
                    ->withInput();
            }
        }

        Indicator::create([
            'i_num' => $validated['i_num'],
            'i_text' => $validated['i_text'],
            'i_type' => $validated['i_type'],
            'o_id' => $validated['o_id'],
            'i_FY' => $fy_range,
        ]);

        return redirect()->route('objectives.indicators', ['objective' => $objective->o_id])
            ->with('success', 'Indicador creado correctamente.');
    }

    /**
     * Displays the detail view of a specific indicator.
     */
    public function show(Indicator $indicator)
    {
        return view('indicators.show', compact('indicator'));
    }

    /**
     * Shows the form to edit an indicator.
     */
    public function edit($id)
    {
        $indicator = Indicator::findOrFail($id);
        $objective = Objective::findOrFail($indicator->o_id);

        return view('indicators.edit', compact('indicator', 'objective'));
    }

    /**
     * Updates an existing indicator, validating fiscal year and uniqueness constraints.
     */
    public function update(Request $request, Indicator $indicator)
    {
        $validated = $request->validate([
            'i_num' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('indicators', 'i_num')->where(function ($query) use ($indicator, $request) {
                    return $query->where('o_id', $indicator->o_id)
                        ->where('i_FY', $request->fy_start . '-' . $request->fy_end);
                })->ignore($indicator->i_id, 'i_id'),
            ],
            'i_text' => 'required|string',
            'i_type' => 'required|in:string,integer,document',
            'fy_start' => 'required|integer',
            'fy_end' => 'required|integer|gt:fy_start',
        ], [
            'i_num.unique' => 'Ya existe un indicador con ese número en este objetivo y año fiscal.',
            'fy_end.gt' => 'El año fiscal de fin debe ser mayor que el año de inicio.',
        ]);

        $objective = $indicator->objective;
        $strategicPlan = $objective->goal->topic->strategicPlan;
        $fy_range = $request->fy_start . '-' . $request->fy_end;

        if ($request->fy_end != $request->fy_start + 1) {
            return back()->withErrors(['fy_start' => 'Los años fiscales deben ser consecutivos (ej. 2025-2026).'])
                ->withInput();
        }

        if ($strategicPlan->sp_institution === 'UPRM') {
            [$startYear, $endYear] = explode('-', $strategicPlan->sp_years);
            $validFiscalYears = [];
            for ($year = (int)$startYear; $year < (int)$endYear; $year++) {
                $validFiscalYears[] = "$year-" . ($year + 1);
            }

            if (!in_array($fy_range, $validFiscalYears)) {
                return back()->withErrors(['fy_start' => "En UPRM, el año fiscal debe estar dentro del rango del plan estratégico ($strategicPlan->sp_years)."])
                    ->withInput();
            }
        }

        $indicator->update([
            'i_num' => $validated['i_num'],
            'i_text' => $validated['i_text'],
            'i_type' => $validated['i_type'],
            'i_FY' => $fy_range,
        ]);

        return redirect()->route('objectives.indicators', ['objective' => $indicator->o_id])
            ->with('success', 'Valor del indicador actualizado.')
            ->with('active_fy', $indicator->i_FY);
    }

    /**
     * Updates the value of an indicator, including document uploads.
     */
    public function updateValue(Request $request, Indicator $indicator)
    {
        if ($indicator->i_type === 'document') {
            $request->validate([
                'i_value' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx',
            ]);

            if ($request->hasFile('i_value')) {
                $originalName = $request->file('i_value')->getClientOriginalName();
                $path = $request->file('i_value')->storeAs('documents', $originalName, 'public');

                if (!empty($indicator->i_value)) {
                    $indicator->i_value .= ', ' . $originalName;
                } else {
                    $indicator->i_value = $originalName;
                }
            }
        } else {
            $request->validate([
                'i_value' => 'nullable|string',
            ]);
            $indicator->i_value = $request->i_value;
        }

        $indicator->save();

        return redirect()->route('objectives.indicators', ['objective' => $indicator->o_id])
            ->with('success', 'Valor del indicador actualizado.')
            ->with('active_fy', $indicator->i_FY);
    }

    /**
     * Deletes an indicator from the database.
     */
    public function destroy(Indicator $indicator)
    {
        $indicator->delete();
        return redirect()->route('objectives.indicators', ['objective' => $indicator->o_id])
            ->with('success', 'Indicador eliminado correctamente.')
            ->with('active_fy', $indicator->i_FY);
    }

    /**
     * Displays a basic list of indicators tied to a specific objective.
     */
    public function showIndicators(Objective $objective)
    {
        $indicators = $objective->indicators;
        return view('indicators.index', compact('indicators', 'objective'));
    }

    /**
     * Deletes multiple indicators in a batch and logs the action.
     */
    public function bulkDelete(Request $request)
    {
        $indicatorIds = $request->input('indicators');

        if (!$indicatorIds || count($indicatorIds) === 0) {
            return redirect()->back()->with('error', 'No seleccionaste ningún indicador para eliminar.');
        }

        AuditLogs::log('Deleted Indicators: ', implode(',', $indicatorIds));
        Indicator::whereIn('i_id', $indicatorIds)->delete();
        return redirect()->back()->with('success', 'Indicadores eliminados correctamente.');
    }

    /**
     * Removes a specific document from an indicator's value field.
     */
    public function removeDocument(Request $request)
    {
        $request->validate([
            'indicator_id' => 'required|exists:indicators,i_id',
            'document_name' => 'required|string',
        ]);

        $indicator = Indicator::findOrFail($request->indicator_id);

        if ($indicator->i_type === 'document') {
            $documents = array_map('trim', explode(',', $indicator->i_value));
            $documents = array_filter($documents, fn($doc) => $doc !== $request->document_name);

            $indicator->i_value = implode(', ', $documents);
            $indicator->save();
        }

        return redirect()->back()->with('success', 'Documento eliminado correctamente.');
    }

    /**
     * Duplicates all indicators from one fiscal year to the next for a given objective.
     *
     * Prevents copying if indicators already exist for the target year.
     */
    public function copyFiscalYear(Request $request, Objective $objective)
    {
        $request->validate([
            'current_fy' => 'required|string',
        ]);

        $currentFiscalYear = $request->input('current_fy');
        $nextFiscalYear = $this->generateNextFiscalYear($currentFiscalYear);

        $exists = Indicator::where('o_id', $objective->o_id)
            ->where('i_FY', $nextFiscalYear)
            ->exists();

        if ($exists) {
            return redirect()->route('objectives.indicators', ['objective' => $objective->o_id])
                ->with('error', "Ya existen indicadores para el año fiscal $nextFiscalYear. No se puede copiar.");
        }

        $indicators = Indicator::where('o_id', $objective->o_id)
            ->where('i_FY', $currentFiscalYear)
            ->get();

        foreach ($indicators as $indicator) {
            Indicator::create([
                'i_num' => $indicator->i_num,
                'i_text' => $indicator->i_text,
                'i_type' => $indicator->i_type,
                'o_id' => $objective->o_id,
                'i_FY' => $nextFiscalYear,
                'i_value' => null,
            ]);
        }

        return redirect()->route('objectives.indicators', ['objective' => $objective->o_id])
            ->with('success', "Indicadores copiados para el año fiscal $nextFiscalYear.");
    }

    /**
     * Generates the next fiscal year string based on the current one.
     */
    private function generateNextFiscalYear($currentFiscalYear)
    {
        [$start, $end] = explode('-', $currentFiscalYear);
        $newStart = (int) $start + 1;
        $newEnd = (int) $end + 1;
        return "$newStart-$newEnd";
    }

    /**
     * Toggles the locked/unlocked state of an indicator.
     */
    public function toggleLock(Indicator $indicator)
    {
        $indicator->i_locked = !$indicator->i_locked;
        $indicator->save();

        return back()->with('success', 'El estado de edición del indicador ha sido actualizado.');
    }
}
