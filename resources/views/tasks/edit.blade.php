@extends('layouts.app')

@section('content')
    <h2>Edit Task</h2>
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ $task->description }}</textarea>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <!-- Progress Input -->
        <div class="mb-3">
            <label class="form-label">Progress</label>
            <input type="range" name="progress" class="form-range" min="0" max="100" value="{{ $task->progress }}" oninput="progressValue.innerText = this.value + '%'">
            <p>Progress: <span id="progressValue">{{ $task->progress }}%</span></p>
        </div>

        <button type="submit" class="btn btn-primary">Update Task</button>
    </form>
@endsection
