<?php

namespace App\Http\Controllers;

use App\Models\StrategicPlan;
use Illuminate\Http\Request;

class StrategicPlanController extends Controller
{
    public function index(Request $request)
    {
        $query = StrategicPlan::query();
        $institution = null;
        // Check if the request has a filter for institution
        if ($request->has('institution')) {
            $query->where('sp_institution', $request->input('institution'));
            $institution = $request->input('institution');
        }

        // Paginate the filtered (or unfiltered) list
        $strategicplans = $query->latest()->simplePaginate(10);

        return view('strategicplans.index', compact('strategicplans','institution'));
    }
    public function create(Request $request)
    {
        $institution = $request->query('institution'); // Capture it from URL query

        return view('strategicplans.create', compact('institution'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'sp_institution' => 'required|string|max:255',
            'start_year' => 'required|integer|digits:4',
            'end_year' => 'required|integer|digits:4|gt:start_year',
        ], [
            'end_year.gt' => 'El año final debe ser mayor que el año inicial.',
        ]);

        // Check if the span is exactly 5 years
        if (($validated['end_year'] - $validated['start_year']) !== 5) {
            return redirect()->back()
                ->withErrors(['end_year' => 'El plan estratégico debe durar exactamente 5 años.'])
                ->withInput();
        }

        // Concatenate into 2025-2030
        $sp_years = $validated['start_year'] . '-' . $validated['end_year'];

        StrategicPlan::create([
            'sp_institution' => $validated['sp_institution'],
            'sp_years' => $sp_years,
        ]);

        return redirect()->route('strategicplans.index', ['institution' => $validated['sp_institution']])
            ->with('success', 'Plan Estratégico creado correctamente.');
    }


    public function show(StrategicPlan $strategicplan)
    {
        return view('strategicplans.show', compact('strategicplan'));
    }

    public function edit(StrategicPlan $strategicplan)
    {
        return view('strategicplans.edit', compact('strategicplan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'start_year' => 'required|integer|digits:4',
            'end_year' => 'required|integer|digits:4|gt:start_year',
        ], [
            'end_year.gt' => 'El año final debe ser mayor que el año inicial.',
        ]);

        if (($validated['end_year'] - $validated['start_year']) !== 5) {
            return redirect()->back()
                ->withErrors(['end_year' => 'El plan estratégico debe durar exactamente 5 años.'])
                ->withInput();
        }

        $strategicplan = StrategicPlan::findOrFail($id);
        $strategicplan->sp_years = $validated['start_year'] . '-' . $validated['end_year'];
        $strategicplan->save();

        return redirect()->route('strategicplans.index', ['institution' => $strategicplan->sp_institution])
            ->with('success', 'Plan Estratégico actualizado correctamente.');
    }


    public function destroy(StrategicPlan $strategicplan)
    {
        $strategicplan->delete();
        return redirect()->route('strategicplans.index');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('strategicplans');
        $institution = $request->query('institution');
        if (!$ids || !is_array($ids)) {
            return redirect()->route('strategicplans.index')->with('error', 'No se seleccionó ningún plan para eliminar.');
        }

        StrategicPlan::whereIn('sp_id', $ids)->delete();

        return redirect()->route('strategicplans.index',['institution' => $institution])->with('success', 'Planes estratégicos eliminados correctamente.');
    }

}
