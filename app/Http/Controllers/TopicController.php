<?php

namespace App\Http\Controllers;

use App\Models\StrategicPlan;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index(StrategicPlan $strategicplan)
    {

        $topics = Topic::where('sp_id', $strategicplan->sp_id)
            ->orderBy('t_num', 'asc')
            ->get();

        // Para hacer lo de mostrar mas resultados
//        $topics = Topic::where('sp_id', $strategicplan->sp_id)
//            ->orderBy('t_num', 'asc')
//            ->paginate(4); // Cambiamos get() por paginate(4)

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

    public function edit($id)
    {
        $topic = Topic::findOrFail($id);
        $strategicplan = StrategicPlan::findOrFail($topic->sp_id);

        return view('topics.edit', compact('topic', 'strategicplan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            't_num' => 'required|string|max:255',
            't_text' => 'required|string',
        ]);

        $topic = Topic::findOrFail($id);
        $topic->t_num = $request->t_num;
        $topic->t_text = $request->t_text;
        $topic->save();

        // Asegúrate de redirigir correctamente pasando el strategicplan id
        return redirect()->route('topics.index', ['strategicplan' => $topic->sp_id])
            ->with('success', 'Asunto actualizado correctamente.');
    }



    // Este sirve para borrar solamente 1, si quiero que sea mas de 1, cree el de abajo, que coje muchos id de muchos topics :)
    public function destroy(Topic $topic)
    {
        $topic->delete();
        return redirect()->route('strategicplans.topics', ['strategicplan' => $topic->sp_id])
            ->with('success', 'Asunto eliminado correctamente.');
    }

    public function bulkDelete(Request $request)
    {
        $topicIds = $request->input('topics');

        if (!$topicIds || count($topicIds) === 0) {
            return redirect()->back()->with('error', 'No seleccionaste ningún asunto para eliminar.');
        }

        Topic::whereIn('t_id', $topicIds)->delete();

        return redirect()->back()->with('success', 'Asuntos eliminados correctamente.');
    }
}
