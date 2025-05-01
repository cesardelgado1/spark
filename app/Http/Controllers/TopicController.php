<?php

namespace App\Http\Controllers;

use App\Models\AuditLogs;
use App\Models\StrategicPlan;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TopicController extends Controller
{
    /**
     * Displays a list of topics for a given strategic plan.
     *
     * Topics are ordered by number within the plan.
     */
    public function index(StrategicPlan $strategicplan)
    {
        $topics = Topic::where('sp_id', $strategicplan->sp_id)
            ->orderBy('t_num', 'asc')
            ->get();

        return view('topics.index', compact('topics', 'strategicplan'));
    }

    /**
     * Shows the form to create a new topic under the given strategic plan.
     */
    public function create(StrategicPlan $strategicplan)
    {
        return view('topics.create', compact('strategicplan'));
    }

    /**
     * Stores a new topic with validation to ensure uniqueness within its plan.
     */
    public function store(Request $request, StrategicPlan $strategicplan)
    {
        $validated = $request->validate([
            't_num' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('topics')->where(function ($query) use ($request) {
                    return $query->where('sp_id', $request->sp_id);
                }),
            ],
            't_text' => 'required|string',
            'sp_id'  => 'required|exists:strategic_plans,sp_id',
        ], [
            't_num.unique' => 'Ya existe un asunto con ese número dentro de este plan estratégico.',
        ]);

        $topic = new Topic([
            't_num' => $validated['t_num'],
            't_text' => $validated['t_text'],
            'sp_id' => $validated['sp_id'],
        ]);

        $topic->save();

        return redirect()->route('strategicplans.topics', $strategicplan->sp_id)
            ->with('success', 'Asunto creado correctamente.');
    }

    /**
     * Displays the details of a single topic.
     */
    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

    /**
     * Shows the form to edit a topic.
     */
    public function edit($id)
    {
        $topic = Topic::findOrFail($id);
        $strategicplan = StrategicPlan::findOrFail($topic->sp_id);

        return view('topics.edit', compact('topic', 'strategicplan'));
    }

    /**
     * Updates a topic after validating uniqueness within the same strategic plan.
     */
    public function update(Request $request, Topic $topic)
    {
        $validated = $request->validate([
            't_num' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('topics')->where(function ($query) use ($topic) {
                    return $query->where('sp_id', $topic->sp_id);
                })->ignore($topic->t_id, 't_id'),
            ],
            't_text' => 'required|string',
        ], [
            't_num.unique' => 'Ya existe un asunto con ese número dentro de este plan estratégico.',
        ]);

        $topic->update([
            't_num' => $validated['t_num'],
            't_text' => $validated['t_text'],
        ]);

        return redirect()->route('topics.index', ['strategicplan' => $topic->sp_id])
            ->with('success', 'Asunto actualizado correctamente.');
    }

    /**
     * Deletes a single topic from the system.
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();
        return redirect()->route('strategicplans.topics', ['strategicplan' => $topic->sp_id])
            ->with('success', 'Asunto eliminado correctamente.');
    }

    /**
     * Displays all topics tied to a given strategic plan.
     */
    public function showTopics(StrategicPlan $strategicplan)
    {
        $topics = $strategicplan->topics()->get();

        return view('topics.index', compact('topics', 'strategicplan'));
    }

    /**
     * Deletes multiple topics in one request and logs the action.
     */
    public function bulkDelete(Request $request)
    {
        $topicIds = $request->input('topics');

        if (!$topicIds || count($topicIds) === 0) {
            return redirect()->back()->with('error', 'No seleccionaste ningún asunto para eliminar.');
        }

        AuditLogs::log('Deleted Topics: ', implode(',', $topicIds));
        Topic::whereIn('t_id', $topicIds)->delete();

        return redirect()->back()->with('success', 'Asuntos eliminados correctamente.');
    }
}
