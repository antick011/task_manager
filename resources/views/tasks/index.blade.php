@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Tasks</h2>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Add New Task</a>

    @if($tasks->isEmpty())
        <p class="text-muted">No tasks available.</p>
    @else
        <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Priority</th>
                <th>Progress</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>
                        @php
                            $priorityColors = [
                                'high' => 'danger',
                                'medium' => 'warning',
                                'low' => 'success'
                            ];
                        @endphp
                        <span class="badge bg-{{ $priorityColors[strtolower($task->priority)] ?? 'secondary' }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </td>

                    <td>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" 
                                style="width: {{ (int) $task->progress }}%;" 
                                aria-valuenow="{{ (int) $task->progress }}" 
                                aria-valuemin="0" aria-valuemax="100">
                                {{ (int) $task->progress }}%
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-info">{{ ucfirst($task->status) }}</span>
                    </td>
                    <td>
                        {{ optional($task->assignedTo)->email ?? 'Not Assigned' }}
                    </td>
                    <td>
                        {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d M Y') : 'No Deadline' }}
                    </td>
                    <td>
                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-sm">View</a>

                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this task?')">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Comment Section for Each Task -->
                <tr>
                    <td colspan="7">
                        <h5>Comments:</h5>
                        @if($task->comments->isEmpty())
                            <p class="text-muted">No comments yet.</p>
                        @else
                            <ul class="list-group">
                                @foreach($task->comments as $comment)
                                    <li class="list-group-item">
                                        {{ $comment->content }} 
                                        <small class="text-muted">- {{ $comment->user->name }} ({{ $comment->created_at->diffForHumans() }})</small>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <!-- Add Comment Form -->
                        <form action="{{ route('tasks.comments.store', $task->id) }}" method="POST" class="mt-2">
                            @csrf
                            <div class="mb-2">
                                <textarea name="content" class="form-control" rows="2" placeholder="Write a comment..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm">Add Comment</button>
                        </form>
                    </td>
                </tr>

            @endforeach
        </tbody>
        </table>
    @endif
</div>
@endsection
