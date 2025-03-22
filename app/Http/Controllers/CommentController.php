<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Support\Facades\Auth; // Add this at the top

class CommentController extends Controller
{
    public function store(Request $request, $taskId)
{
    $request->validate([
        'content' => 'required|string|max:500',
    ]);

    // Fetch the task
    $task = Task::find($taskId);

    // Check if the task exists
    if (!$task) {
        return redirect()->back()->with('error', 'Task not found.');
    }

    // Create a new comment
    $comment = new Comment();
    $comment->task_id = $task->id; // Ensure task exists
    $comment->user_id = auth()->id(); // Ensure authenticated user
    $comment->content = $request->input('content'); // Ensure content exists
    $comment->save();

    return redirect()->route('tasks.comments.index', $taskId)->with('success', 'Comment added successfully.');
}

    
public function index($taskId)
{
    $task = Task::findOrFail($taskId);
    $comments = $task->comments; // Assuming Task has a `comments` relationship

    return view('comments.index', compact('task', 'comments'));
}

}