<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GoalController extends Controller
{
    /**
     * Displays a list of all goals under a specific topic.
     *
     * The goals are ordered by their number for structured display.
     */
    public function index(Topic $topic)
    {
        $goals = Goal::where('t_id', $topic->t_id)
            ->orderBy('g_num', 'asc')
            ->get();

        return view('goals.index', compact('goals', 'topic'));
    }

    /**
     * Shows the form to create a new goal for the given topic.
     */
    public function create(Topic $topic)
    {
        return view('goals.create', compact('topic'));
    }

    /**
     * Stores a newly created goal in the database.
     *
     * Validates that the goal number is unique within its topic,
     * then saves the new goal and redirects to the topic's goals page.
     */
    public function store(Request $request, Topic $topic)
    {
        $validated = $request->validate([
            'g_num' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('goals')->where(function ($query) use ($request) {
                    return $query->where('t_id', $request->t_id);
                }),
            ],
            'g_text' => 'required|string',
            't_id' => 'required|exists:topics,t_id',
        ], [
            'g_num.unique' => 'Ya existe una meta con ese número en este asunto.',
        ]);

        $goal = new Goal([
            'g_num' => $validated['g_num'],
            'g_text' => $validated['g_text'],
            't_id' => $validated['t_id'],
        ]);

        $goal->save();

        return redirect()->route('topics.goals', $topic->t_id)
            ->with('success', 'Meta creada correctamente.');
    }

    /**
     * Displays the details of a specific goal.
     */
    public function show(Goal $goal)
    {
        return view('goals.show', compact('goal'));
    }

    /**
     * Shows the form to edit an existing goal.
     *
     * Loads the goal and its related topic for context in the form.
     */
    public function edit($id)
    {
        $goal = Goal::findOrFail($id);
        $topic = Topic::findOrFail($goal->t_id);

        return view('goals.edit', compact('goal', 'topic'));
    }

    /**
     * Updates an existing goal with new values.
     *
     * Ensures the new goal number is still unique within the topic,
     * then applies updates and redirects to the topic’s goal list.
     */
    public function update(Request $request, Goal $goal)
    {
        $validated = $request->validate([
            'g_num' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('goals')->where(function ($query) use ($goal) {
                    return $query->where('t_id', $goal->t_id);
                })->ignore($goal->g_id, 'g_id'),
            ],
            'g_text' => 'required|string',
        ], [
            'g_num.unique' => 'Ya existe una meta con ese número en este asunto.',
        ]);

        $goal->update($validated);

        return redirect()->route('topics.goals', ['topic' => $goal->t_id])
            ->with('success', 'Meta actualizada correctamente.');
    }

    /**
     * Deletes a specific goal from the database.
     */
    public function destroy(Goal $goal)
    {
        $goal->delete();
        return redirect()->route('goals.index');
    }

    /**
     * Displays a list of goals associated with a specific topic.
     *
     * Used to fetch goals dynamically when navigating via topic context.
     */
    public function showGoals(Topic $topic)
    {
        $goals = $topic->goals()->get();

        return view('goals.index', [
            'goals' => $goals,
            'topic' => $topic,
        ]);
    }

    /**
     * Handles bulk deletion of multiple selected goals.
     *
     * Validates that goals are selected, then deletes them in one query.
     */
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
