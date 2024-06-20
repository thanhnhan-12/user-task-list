@extends('layout.layout')
@section('content')
    <h1 class="mb-3">New Task</h1>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action={{ route('task.create') }} method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Task title</label>
            <input type="text" class="form-control" name="title" id="title" required />
        </div>

        <div class="form-group my-3">
            <label for="description">Task description</label>
            <textarea class="form-control" name="description" id="description" required></textarea>
        </div>

        <div class="form-group my-3">
            <label for="image">Task image</label>
            <input type="file" class="form-control" name="image" id="image" required accept="image/*" />
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Create Task</button>
            <button type="button" class="btn btn-danger" id="cancel-button">Cancel</button>
        </div>
    </form>

    <script>
        document.getElementById('cancel-button').addEventListener('click', function() {
            if (confirm('Are you sure you want to cancel the update? Any unsaved changes will be lost.')) {
                window.location.href = '{{ route('home') }}';
            }
        });
    </script>
@endsection
