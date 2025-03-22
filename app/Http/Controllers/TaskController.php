<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TaskController extends Controller
{
    // Show all tasks
    public function index()
    {
        $tasks = Task::with('assignedTo')
          ->where('user_id', Auth::id())
          ->orWhere('assigned_email', Auth::user()->email)
          ->get();

        return view('tasks.index', compact('tasks'));

        
    }

    // Show form to create a task
    public function create()
    {
        return view('tasks.create');
    }

    // Store a new task
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'progress' => 'nullable|integer|min:0|max:100',
            'deadline' => 'nullable|date',
            'assigned_email' => 'nullable|email|exists:users,email',
        ]);

        $task = Task::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'progress' => $request->progress ?? 0,
            'deadline' => $request->deadline,
            'assigned_email' => $request->assigned_email,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    // Search users by email for task assignment (AJAX)
    public function searchUser(Request $request)
    {
        $users = User::where('email', 'like', '%' . $request->email . '%')->get(['email']);
        return response()->json($users);
    }
    public function assignedTo()
{
    return $this->belongsTo(User::class, 'assigned_email', 'email');
}

    // Show a single task
    public function show(Task $task)
    {
            return view('tasks.show', compact('task'));
    }

    // Edit a task
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // Update a task
    public function update(Request $request, Task $task)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|string|in:pending,completed',
        'progress' => 'required|integer|min:0|max:100',
    ]);

    $task->update([
        'title' => $request->title,
        'description' => $request->description,
        'status' => $request->status,
        'progress' => $request->progress,
    ]);

    return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
}


    // Delete a task
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    

}
