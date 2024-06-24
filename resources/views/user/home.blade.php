@extends('layout.layout')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show mt-4">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-4">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex align-items-center justify-content-between">
        <h1>Home</h1>
        <a href={{ route('task.new') }} class="btn btn-info my-4">New Task</a>
    </div>
    <hr>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($tasks as $task)
            <div class="col">
                @include('user.card')
            </div>
        @endforeach
    </div>

    <div class="" style="margin-top: 20px;"> {{ $tasks->links() }} </div>
@endsection
