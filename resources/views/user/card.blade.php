<div class="card">
    @if ($task->image)
        <img src="{{ asset('storage/' . $task->image) }}" class="card-img-top " style=" height: 255px; " alt="image" />
    @else
        <img src="{{ asset('images/default-task.png') }}" class="card-img-top" alt="Default Image" />
    @endif
    <div class="card-body">
        <h5 class="card-title" style=" height: 50px "> {{ $task->title }} </h5>
        <p class="card-text">
            {{ $task->description }}
        </p>
        <p class="text-body-secondary">Last updated
            {{ \Carbon\Carbon::parse($task->updated_at)->timezone('Asia/Ho_Chi_Minh')->format('m/d/Y H:i:s') }}
        </p>
    </div>
    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-between ">
            <div class=" ">
                @if (!$task->isCompleted())
                    <form action={{ route('task.complete', $task->id) }} method="POST">
                        @csrf
                        <button class="btn btn-warning btn-block " input="submit">Complete</button>
                    </form>
                @else
                    <form action={{ route('task.delete', $task->id) }} method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger btn-block" input="submit">Delete</button>
                    </form>
                @endif
            </div>
            <div class="">
                <a href={{ route('task.edit', $task->id) }} class="btn btn-primary">
                    Edit
                </a>
            </div>
        </div>
    </div>
</div>
