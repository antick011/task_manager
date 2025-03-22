@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $task->title }}</h2>
    <p><strong>Priority:</strong> {{ ucfirst($task->priority) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>
    <p><strong>Assigned To:</strong> {{ optional($task->assignedTo)->email ?? 'Not Assigned' }}</p>
    <p><strong>Due Date:</strong> {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d M Y') : 'No Deadline' }}</p>
    
    <h3>Comments</h3>
    <ul class="list-group">
        @foreach($task->comments as $comment)
            <li class="list-group-item">
                {{ $comment->content }} 
                <small class="text-muted">- {{ $comment->created_at->diffForHumans() }}</small>
            </li>
        @endforeach
    </ul>

    <!-- Add Comment Form -->
    <form action="{{ route('tasks.comments.store', $task->id) }}" method="POST" class="mt-3">
        @csrf
        <div class="mb-3">
            <textarea name="content" class="form-control" placeholder="Add a comment..." required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Post Comment</button>
    </form>

    <a href="{{ route('tasks.index') }}" class="btn btn-primary mt-3">Back to Tasks</a>
</div>
@endsection
