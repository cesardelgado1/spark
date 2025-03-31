<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Topic;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index(Topic $topic)
    {
        $goals = Goal::where('t_id', $topic->t_id)
            ->orderBy('g_num', 'asc')
            ->get();

        return view('goals.index', compact('goals', 'topic'));
    }


    public function create()
    {
        return view('goals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules
        ]);

        Goal::create($validated);

        return redirect()->route('goals.index');
    }

    public function show(Goal $goal)
    {
        return view('goals.show', compact('goal'));
    }

    public function edit($id)
    {
        // Obtener la meta por su ID
        $goal = Goal::findOrFail($id);

        $topic = Topic::findOrFail($goal->t_id);

        return view('goals.edit', compact('goal', 'topic'));
    }

    public function update(Request $request, Goal $goal)
    {
        $request->validate([
            'g_num' => 'required|string|max:255',
            'g_text' => 'required|string',
        ]);

        $goal->g_num = $request->g_num;
        $goal->g_text = $request->g_text;
        $goal->save();

        // Redirige correctamente a la página de metas del asunto
        return redirect()->route('topics.goals', ['topic' => $goal->t_id])
            ->with('success', 'Meta actualizada correctamente.');
    }


    public function destroy(Goal $goal)
    {
        $goal->delete();
        return redirect()->route('goals.index');
    }

    public function showGoals(Topic $topic)
    {
        $goals = $topic->goals()->get();

        return view('goals.index', [
            'goals' => $goals,
            'topic' => $topic,
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $goalIds = $request->input('goals', []);

        if (count($goalIds) > 0) {
            Goal::whereIn('g_id', $goalIds)->delete();
            return redirect()->back()->with('success', 'Metas eliminadas correctamente.');
        }

        return redirect()->back()->with('error', 'No se seleccionaron metas para eliminar.');
    }

}

