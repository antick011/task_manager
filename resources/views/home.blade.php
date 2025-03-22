@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Dashboard') }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                    </form>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <h3 class="mt-4">Task Management</h3>
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary">Add New Task</a>
                    <a href="{{ route('tasks.index') }}" class="btn btn-success">View All Tasks</a>

                    <hr>

                    <h4 class="mt-4">My Tasks</h4>
                    @if($tasks->isEmpty())
                        <p class="text-muted">No tasks assigned to you yet.</p>
                    @else
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Priority</th>
                                    <th>Progress</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>{{ $task->title }}</td>
                                        <td>
    <span class="badge bg-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'success') }}">
        {{ ucfirst($task->priority) }}
    </span>
</td>

                                        <td>
                                        <div class="progress">
    <div class="progress-bar" role="progressbar" 
         style="width: {{ intval($task->progress ?? 0) }}%;" 
         aria-valuenow="{{ intval($task->progress ?? 0) }}" 
         aria-valuemin="0" 
         aria-valuemax="100">
        {{ intval($task->progress ?? 0) }}%
    </div>
</div>

                                        </td>
                                        <td>
                                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-sm">View</a>
                                            <a href="{{ route('tasks.comments.index', $task->id) }}" class="btn btn-secondary btn-sm">Comments</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
