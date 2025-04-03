<?php

namespace App\Http\Controllers;

use App\Models\AuditLogs;
use App\Models\Indicator;
use App\Models\Objective;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{
    public function index(Objective $objective)
    {
        $indicators = Indicator::where('o_id', $objective->o_id)
            ->orderBy('i_num', 'asc')
            ->get();

        return view('indicators.index', compact('indicators', 'objective'));
    }

    public function create(Objective $objective)
    {
        return view('indicators.create', compact('objective'));
    }

    public function store(Request $request, Objective $objective)
    {
        $validated = $request->validate([
            'i_num' => 'required|integer|min:1',
            'i_text' => 'required|string',
            'i_type' => 'required|in:string,integer,document',
            'o_id'   => 'required|exists:objectives,o_id',
        ]);

        Indicator::create([
            'i_num' => $validated['i_num'],
            'i_text' => $validated['i_text'],
            'i_type' => $validated['i_type'],
            'o_id' => $validated['o_id'],
        ]);

        return redirect()->route('objectives.indicators', ['objective' => $objective->o_id])
            ->with('success', 'Indicador creado correctamente.');
    }

    public function show(Indicator $indicator)
    {
        return view('indicators.show', compact('indicator'));
    }

    public function edit($id)
    {
        $indicator = Indicator::findOrFail($id);
        $objective = Objective::findOrFail($indicator->o_id);

        return view('indicators.edit', compact('indicator', 'objective'));
    }

    public function update(Request $request, Indicator $indicator)
    {
        $request->validate([
            'i_num' => 'required|integer|min:1',
            'i_text' => 'required|string|max:255',
            'i_type' => 'required|in:string,integer,document',
        ]);

        $indicator->update([
            'i_num' => $request->i_num,
            'i_text' => $request->i_text,
            'i_type' => $request->i_type,
        ]);

        return redirect()->route('objectives.indicators', ['objective' => $indicator->o_id])
            ->with('success', 'Indicador actualizado correctamente.');
    }

    public function destroy(Indicator $indicator)
    {
        $indicator->delete();
        return redirect()->route('objectives.indicators', ['objective' => $indicator->o_id])
            ->with('success', 'Indicador eliminado correctamente.');
    }

    public function showIndicators(Objective $objective)
    {
        $indicators = $objective->indicators;
        return view('indicators.index', compact('indicators','objective'));
    }

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

}
