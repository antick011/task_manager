@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Comments for: {{ $task->title }}</h2>
    <a href="{{ route('tasks.index') }}" class="btn btn-primary">Back to Tasks</a>

    <!-- Comments List -->
    <ul class="list-group mt-3">
        @foreach($comments as $comment)
            <li class="list-group-item">
                <strong>{{ $comment->user->name ?? 'Anonymous' }}:</strong> 
                {{ $comment->content }} 
                <small class="text-muted"> - {{ $comment->created_at->diffForHumans() }}</small>
            </li>
        @endforeach
    </ul>

    <!-- Add Comment Form -->
    <div class="mt-4">
        <h4>Add a Comment</h4>
        <form action="{{ route('tasks.comments.store', $task->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <textarea name="content" class="form-control" rows="3" placeholder="Write your comment..." required></textarea>
    </div>
    <button type="submit" class="btn btn-success">Submit Comment</button>
</form>

    </div>
</div>
@endsection
