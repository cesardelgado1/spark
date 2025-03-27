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
        return view('topics.index', ['topics' => $topics, 'strategicplan' => $strategicplan]);
    }

    public function create()
    {
        return view('topics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules
        ]);

        Topic::create($validated);

        return redirect()->route('topics.index');
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
