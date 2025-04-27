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
            'i_num' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('indicators')->where(function ($query) use ($request) {
                    return $query->where('o_id', $request->o_id);
                }),
            ],
            'i_text' => 'required|string',
            'i_type' => 'required|in:string,integer,document',
            'o_id' => 'required|exists:objectives,o_id',
        ], [
            'i_num.unique' => 'Ya existe un indicador con ese número en este objetivo.',
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
        $validated = $request->validate([
            'i_num' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('indicators')->where(function ($query) use ($indicator) {
                    return $query->where('o_id', $indicator->o_id);
                })->ignore($indicator->i_id, 'i_id'),
            ],
            'i_text' => 'required|string|max:255',
            'i_type' => 'required|in:string,integer,document',
        ], [
            'i_num.unique' => 'Ya existe un indicador con ese número en este objetivo.',
        ]);

        $indicator->update($validated);

        return redirect()->route('objectives.indicators', ['objective' => $indicator->o_id])
            ->with('success', 'Indicador actualizado correctamente.');
    }

    public function updateValue(Request $request, Indicator $indicator)
    {
        if ($indicator->i_type === 'document') {
            $request->validate([
                'i_value' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx',
            ]);

            if ($request->hasFile('i_value')) {
                // Save the file with the original name
                $originalName = $request->file('i_value')->getClientOriginalName();
                $path = $request->file('i_value')->storeAs('documents', $originalName, 'public');

                // Concatenate the new document name
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

        return redirect()->back()->with('success', 'Valor del indicador actualizado.');
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
        return view('indicators.index', compact('indicators', 'objective'));
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

}
