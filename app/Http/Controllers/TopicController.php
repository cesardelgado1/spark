<?php

namespace App\Http\Controllers;

use App\Models\StrategicPlan;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index(StrategicPlan $strategicplan)
    {
        $topics = Topic::where('sp_id', $strategicplan->sp_id)->get();
        return view('topics.index', compact('topics', 'strategicplan'));
    }

    public function create(StrategicPlan $strategicplan)
    {
        return view('topics.create', compact('strategicplan'));
    }


    public function store(Request $request, StrategicPlan $strategicplan)
    {
//        // Verifica que los datos lleguen correctamente
//        dd($request->all());

        $validated = $request->validate([
            't_num' => 'required|integer|min:1',
            't_text' => 'required|string|max:255',
            'sp_id'  => 'required|exists:strategic_plans,sp_id',
        ]);

        // Crear el asunto vinculado al plan estratégico
        $topic = new Topic([
            't_num' => $validated['t_num'],
            't_text' => $validated['t_text'],
            'sp_id' => $validated['sp_id'],
        ]);

        $topic->save();


        return redirect()->route('strategicplans.topics', ['strategicplan' => $strategicplan->sp_id])
            ->with('success', 'Asunto creado correctamente.');
    }



    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

    public function edit(Topic $topic)
    {
        return view('topics.edit', compact('topic'));
    }

    public function update(Request $request, Topic $topic)
    {
        $validated = $request->validate([
            // TODO: add validation rules
        ]);

        $topic->update($validated);

        return redirect()->route('topics.index');
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();
        return redirect()->route('topics.index');
    }
}
