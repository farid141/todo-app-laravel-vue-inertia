<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // subtask by user (has many trough)
        $subtask_by_user = User::with('subtasks')->get();

        // tag count by task
        $tag_by_task = Tag::withCount('tasks')->get();

        // tag count by subtask
        $tag_by_subtask = Tag::withCount('subtasks')->get();

        // task data
        $tasks = Task::with(['tags', 'users'])->get()->transform(function ($task) {
            $task->tagList = $task->tags()->get()->map(fn($tag) => $tag->name);
            $task->usersString = $task->users()->get()->map(fn($user) => $user->name)->join(', ');
            return $task;
        });

        return Inertia::render('Dashboard', compact('tasks', 'subtask_by_user', 'tag_by_task', 'tag_by_subtask'));
    }
}
