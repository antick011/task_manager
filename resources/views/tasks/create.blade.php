@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create a New Task</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Priority:</label>
            <select name="priority" id="priority" class="form-control" required>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="progress" class="form-label">Progress (%):</label>
            <input type="number" name="progress" id="progress" class="form-control" min="0" max="100">
        </div>

        <div class="mb-3">
            <label for="deadline" class="form-label">Deadline:</label>
            <input type="date" name="deadline" id="deadline" class="form-control">
        </div>

        <div class="form-group">
    <label for="assigned_email">Assign To (Email)</label>
    <input type="email" name="assigned_email" id="assigned_email" class="form-control" placeholder="Enter email">
</div>


        <button type="submit" class="btn btn-primary">Create Task</button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let userSearch = document.getElementById('userSearch');
    let userList = document.getElementById('userList');
    let assignedUserId = document.getElementById('assignedUserId');

    userSearch.addEventListener('input', function () {
        let query = this.value;
        if (query.length < 3) {
            userList.style.display = 'none';
            return;
        }
        fetch('/tasks/search-user?email=' + query)
            .then(response => response.json())
            .then(data => {
                userList.innerHTML = '';
                if (data.length > 0) {
                    userList.style.display = 'block';
                    data.forEach(user => {
                        let item = document.createElement('div');
                        item.classList.add('dropdown-item');
                        item.textContent = user.email;
                        item.dataset.userId = user.id;
                        item.addEventListener('click', function () {
                            userSearch.value = user.email;
                            assignedUserId.value = user.id;
                            userList.style.display = 'none';
                        });
                        userList.appendChild(item);
                    });
                } else {
                    userList.style.display = 'none';
                }
            });
    });
});
</script>
@endsection
