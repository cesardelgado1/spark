<?php

namespace App\Http\Controllers;

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
            'i_prompt' => 'required|string|max:255',
            'o_id'   => 'required|exists:objectives,o_id',
        ]);

        // Crear el indicador vinculado al objetivo
        Indicator::create([
            'i_num' => $validated['i_num'],
            'i_prompt' => $validated['i_prompt'],
            'o_id' => $validated['o_id'],
        ]);

        return redirect()->route('objectives.indicators', ['objective' => $objective->o_id])
            ->with('success', 'Indicador creado correctamente.');
    }

    public function show(Indicator $indicator)
    {
        return view('indicators.show', compact('indicator'));
    }

    public function edit(Indicator $indicator)
    {
        return view('indicators.edit', compact('indicator'));
    }

    public function update(Request $request, Indicator $indicator)
    {
        $validated = $request->validate([
            'i_num' => 'required|integer|min:1',
            'i_prompt' => 'required|string|max:255',
        ]);

        $indicator->update($validated);

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
}
