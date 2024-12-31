<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // tag count by task
        $tag_by_task = [];

        // tag count by subtask
        $tag_by_subtask = [];

        // task data
        $tasks = Task::with(['tags', 'users'])->get();
        return Inertia::render('Dashboard', compact('tasks', 'tag_by_task', 'tag_by_subtask'));
    }
}
