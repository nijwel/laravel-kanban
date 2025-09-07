@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container mt-5">
        <div class="card mb-4">
            <div class="card-header">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-sm btn-primary float-end" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    New Column
                </button>
                <h3 class="mb-4">{{ $board->name }}</h3>
            </div>
            <div class="">
                <!-- Columns -->
                <div class="kanban-board shadow p-3 mb-5 bg-body-tertiary rounded" id="board-columns"
                    data-board="{{ $board->id }}">
                    @forelse ($board->columns as $column)
                        <div class="kanban-column shadow p-3 mb-5 bg-body-tertiary rounded" data-id="{{ $column->id }}">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-3">{{ $column->name }} <span class="btn btn-sm add-task"
                                        data-id="{{ $column->id }}" data-column="{{ $column->name }}"
                                        data-bs-toggle="modal" data-bs-target="#staticBackdrop"><img
                                            src="{{ asset('images/plus.png') }}" width="20px" alt="add"></span></h5>

                                <form action="{{ route('delete.column', $column->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this column?')">
                                        <img src="{{ asset('images/delete.png') }}" width="20px" alt="remove">
                                    </button>
                                </form>

                            </div>
                            <hr>
                            <div class="task-list shadow-sm" id="column-{{ $column->id }}"
                                data-column-name="{{ $column->name }}" data-column="{{ $column->id }}">
                                @foreach ($column->tasks->sortBy('order') as $task)
                                    <div class="kanban-card task" data-id="{{ $task->id }}">
                                        @if ($task->image)
                                            @php
                                                $extension = pathinfo($task->image, PATHINFO_EXTENSION);
                                            @endphp

                                            @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                {{-- Show Image --}}
                                                <img src="{{ asset('storage/' . $task->image) }}" class="card-img-top"
                                                    alt="Task Image" style="width: 100%; height: 150px; object-fit: cover;">
                                            @elseif (in_array(strtolower($extension), ['mp4', 'webm', 'ogg', '3gp', 'wav', 'flv']))
                                                {{-- Show Video --}}
                                                <video class="card-img-top"
                                                    style="width: 100%; height: 150px; object-fit: cover;" controls>
                                                    <source src="{{ asset('storage/' . $task->image) }}"
                                                        type="video/{{ $extension }}">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @endif
                                        @endif

                                        <div class="d-flex justify-content-between align-items-start mb-2 mt-2">
                                            <div>
                                                <div class=" d-flex align-items-center">
                                                    {{-- @if ($task->starred) --}}
                                                    <i class="bi bi-star-fill text-warning me-1"></i>
                                                    {{-- @endif --}}
                                                    {{ $task->title }}
                                                </div>
                                                <div class="card-subtitle">
                                                    ({{ ucfirst($task->created_at->diffForHumans()) }})
                                                </div>
                                            </div>
                                            <div class="fw-bold">
                                                ${{ number_format($task->amount, 0, '.', ',') }}
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div class="dot-group mb-2">
                                                @php
                                                    $dots = $task->dots ?? 4;
                                                @endphp
                                                @for ($i = 0; $i < $dots; $i++)
                                                    <span class="bg-primary"></span>
                                                @endfor
                                            </div>

                                            <div class="avatar-group d-flex mb-2">
                                                {{-- @foreach ($task->avatars as $avatar) --}}
                                                @if (auth()->user()->avatar)
                                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                                        alt="avatar" class="rounded-circle">
                                                @else
                                                    <img src="{{ asset('images/avatar.png') }}" width="20px"
                                                        alt="remove">
                                                @endif
                                                {{-- @endforeach --}}
                                            </div>
                                        </div>

                                        @if ($task->due_date)
                                            <div class="tag-badge bg-info text-white">
                                                Create Date: {{ custom_date_format($task->created_at) }}
                                            </div>
                                            <div class="tag-badge bg-warning text-dark">
                                                Due Date: {{ custom_date_format($task->due_date) }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-success w-100 mt-3 add-task"
                                data-id="{{ $column->id }}" data-column="{{ $column->name }}" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                Add Task
                            </button>
                        </div>
                    @empty
                        <div class=" text-center">
                            <h5>No columns found</h5>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create New Column</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('columns.store', $board) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Column Name</label>
                                <input name="name" placeholder="New column name" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @isset($column)
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Add Task -->
                                    <form action="{{ route('tasks.store', $column) }}" method="POST"
                                        enctype="multipart/form-data" class="mt-4">
                                        @csrf
                                        <div class="form-group">
                                            <input name="title" placeholder="Task title" class="form-control mb-2">
                                            <input type="file" name="image" class="form-control mb-2">
                                            <input type="date" name="due_date" class="form-control mb-2">
                                            <textarea name="description" placeholder="Description" class="form-control mb-2"></textarea>
                                            <input type="hidden" name="column_id" class="form-control mb-2 column_id">
                                            <input type="hidden" name="status" class="form-control mb-2 status">
                                        </div>
                                        {{-- <select name="column_id" class="form-select mb-2">
                            <option value="To Do">To Do</option>
                            @foreach ($board->columns as $column)
                                <option value="{{ $column->id }}">{{ $column->name }}</option>
                            @endforeach
                        </select> --}}

                                        <div class="mt-3">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endisset

    </div>

    <!-- Drag & Drop Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(".add-task").on('click', function() {
            var columnId = $(this).data('id');
            var columnName = $(this).data('column');
            $(".column_id").val(columnId.toString().toLowerCase());
            $(".status").val(columnName.toString().toLowerCase());
        });

        document.querySelectorAll('.task-list').forEach(el => {
            new Sortable(el, {
                group: 'shared',
                animation: 150,
                onEnd: function(evt) {
                    const column = evt.to;
                    const taskIds = Array.from(column.children).map(task => task.dataset.id);
                    const columnId = column.dataset.column;
                    const columnName = column.dataset.columnName;
                    fetch(`/tasks/${evt.item.dataset.id}/move`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            column_id: columnId,
                            order: taskIds,
                            status: columnName
                        })
                    }).then(res => {
                        if (!res.ok) alert('Failed to move task');
                    });
                }
            });
        });

        new Sortable(document.getElementById('board-columns'), {
            animation: 150,
            direction: 'horizontal',
            onEnd: function(evt) {
                const board = document.getElementById('board-columns');
                const boardId = board.dataset.board;
                const columnIds = Array.from(board.children).map(col => col.dataset.id);

                fetch(`/boards/${boardId}/reorder-columns`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        order: columnIds
                    })
                }).then(res => {
                    if (!res.ok) alert('Failed to reorder columns');
                });
            }
        });
    </script>

@endsection
