<?php

namespace App\Http\Controllers;

use App\Models\StrategicPlan;
use Illuminate\Http\Request;

class StrategicPlanController extends Controller
{
    /**
     * Displays a paginated list of strategic plans.
     *
     * Can be filtered by institution via a query parameter.
     */
    public function index(Request $request)
    {
        $query = StrategicPlan::query();
        $institution = null;

        if ($request->has('institution')) {
            $query->where('sp_institution', $request->input('institution'));
            $institution = $request->input('institution');
        }

        $strategicplans = $query->latest()->simplePaginate(10);

        return view('strategicplans.index', compact('strategicplans', 'institution'));
    }

    /**
     * Shows the form to create a new strategic plan.
     *
     * Pre-fills the institution field if it's passed via URL query.
     */
    public function create(Request $request)
    {
        $institution = $request->query('institution');

        return view('strategicplans.create', compact('institution'));
    }

    /**
     * Validates and stores a new strategic plan.
     *
     * Ensures there are no duplicates for the same institution and year range.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sp_institution' => 'required|string|max:255',
            'start_year' => 'required|integer|digits:4',
            'end_year' => 'required|integer|digits:4|gt:start_year',
        ], [
            'end_year.gt' => 'El año final debe ser mayor que el año inicial.',
        ]);

        $sp_years = $validated['start_year'] . '-' . $validated['end_year'];

        $exists = StrategicPlan::where('sp_institution', $validated['sp_institution'])
            ->where('sp_years', $sp_years)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withErrors(['sp_years' => 'Ya existe un plan estratégico para ese rango de años en esta institución.'])
                ->withInput();
        }

        StrategicPlan::create([
            'sp_institution' => $validated['sp_institution'],
            'sp_years' => $sp_years,
        ]);

        return redirect()->route('strategicplans.index', ['institution' => $validated['sp_institution']])
            ->with('success', 'Plan Estratégico creado correctamente.');
    }

    /**
     * Displays details of a specific strategic plan.
     */
    public function show(StrategicPlan $strategicplan)
    {
        return view('strategicplans.show', compact('strategicplan'));
    }

    /**
     * Shows the form to edit an existing strategic plan.
     */
    public function edit(StrategicPlan $strategicplan)
    {
        return view('strategicplans.edit', compact('strategicplan'));
    }

    /**
     * Updates an existing strategic plan with validated input.
     *
     * Catches potential database errors during the update process.
     */
    public function update(Request $request, StrategicPlan $strategicplan)
    {
        $validated = $request->validate([
            'sp_years' => 'required|string|regex:/^\d{4}-\d{4}$/',
            'sp_institution' => 'required|string|max:255',
        ]);

        try {
            $strategicplan->update($validated);

            return redirect()
                ->route('strategicplans.index', ['institution' => $validated['sp_institution']])
                ->with('success', 'Plan Estratégico actualizado correctamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Ocurrió un error al guardar los cambios.');
        }
    }

    /**
     * Deletes a specific strategic plan from the system.
     */
    public function destroy(StrategicPlan $strategicplan)
    {
        $strategicplan->delete();
        return redirect()->route('strategicplans.index');
    }

    /**
     * Deletes multiple strategic plans at once.
     *
     * Redirects back with a success or error message depending on input.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('strategicplans');
        $institution = $request->query('institution');

        if (!$ids || !is_array($ids)) {
            return redirect()->route('strategicplans.index')->with('error', 'No se seleccionó ningún plan para eliminar.');
        }

        StrategicPlan::whereIn('sp_id', $ids)->delete();

        return redirect()->route('strategicplans.index', ['institution' => $institution])
            ->with('success', 'Planes estratégicos eliminados correctamente.');
    }
}
