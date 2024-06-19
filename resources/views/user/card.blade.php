<div class="card ">
    @if ($task->image)
        <img src="{{ asset('storage/' . $task->image) }}" class="card-img-top" alt="image" />
    @else
        <img src="{{ asset('images/default-task.png') }}" class="card-img-top" alt="Default Image" />
    @endif
    <div class="card-body">
        <h5 class="card-title">{{ $task->title }}</h5>
        <p class="card-text">
            {{ $task->description }}
        </p>
        <div class="card-footer">
            <div class="d-flex align-items-center justify-content-between ">
                <div class=" ">
                    @if (!$task->isCompleted())
                        <form action="/task/{{ $task->id }}" method="POST">
                            @method('PATCH')
                            @csrf
                            <button class="btn btn-warning btn-block " input="submit">Complete</button>
                        </form>
                    @else
                        <form action="/task/{{ $task->id }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger btn-block" input="submit">Delete</button>
                        </form>
                    @endif
                </div>
                <div class="">
                    <a href={{ route('task.edit', $task->id) }} class="btn btn-primary ">Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>
