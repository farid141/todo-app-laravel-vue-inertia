<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * create resource page.
     */
    public function create(Request $request)
    {
        $users = User::all();
        $tags = Tag::all()->transform(fn($tag) => ['id' => $tag->id, 'name' => $tag->name]);
        return Inertia::render('Task/Create', compact('users', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'description' => ['nullable'],
            'tags' => ['nullable', 'exists:tags,id', 'array'],

            'users' => ['nullable', 'array'],
            'users.*.user' => ['required', 'exists:users,id'],
            'users.*.role' => ['required'],

            'subtasks' => ['nullable', 'array'],
            'subtasks.*.title' => ['required'],
            'subtasks.*.tags' => ['nullable', 'exists:tags,id', 'array'],
        ]);

        DB::beginTransaction();
        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'is_complete' => false,
        ]);

        $task->tags()->sync($validated['tags']);

        // Prepare user-role data for syncing
        $syncData = [];
        foreach ($validated['users'] as $userRole) {
            $syncData[$userRole['user']] = ['role' => $userRole['role']];
        }
        $task->users()->sync($syncData);

        // Process subtasks
        foreach ($validated['subtasks'] as $subtaskData) {
            $subtask = $task->subtasks()->create([
                'title' => $subtaskData['title'],
            ]);

            // Attach tags to the subtask
            if (!empty($subtaskData['tags'])) {
                $subtask->tags()->sync($subtaskData['tags']);
            }
        }

        DB::commit();

        return redirect(to: route('dashboard'))->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
