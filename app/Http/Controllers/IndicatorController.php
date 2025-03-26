<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{
    public function index()
    {
        $indicators = Indicator::latest()->simplePaginate(5);
        return view('indicators.index', compact('indicators'));
    }

    public function create()
    {
        return view('indicators.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules
        ]);

        Indicator::create($validated);

        return redirect()->route('indicators.index');
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
            // TODO: add validation rules
        ]);

        $indicator->update($validated);

        return redirect()->route('indicators.index');
    }

    public function destroy(Indicator $indicator)
    {
        $indicator->delete();
        return redirect()->route('indicators.index');
    }
}
