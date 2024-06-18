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

    <form action={{ route('task.create') }} method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Task title</label>
            <input type="text" class="form-control" name="title" />
        </div>

        <div class="form-group my-3">
            <label for="description">Task description</label>
            <textarea class="form-control" name="description" id="description"></textarea>
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Create Task</button>
        </div>
    </form>
@endsection
