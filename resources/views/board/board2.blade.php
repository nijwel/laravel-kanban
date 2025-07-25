<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $board->name }} - Kanban</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <style>
        .board-container {
            overflow-x: auto;
            display: flex;
            gap: 1rem;
        }

        .task-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
        }

        .kanban-board {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
        }

        .kanban-column {
            background: #fff;
            border-radius: 0.5rem;
            padding: 1rem;
            min-width: 300px;
            flex-shrink: 0;
            box-shadow: 0 0.2rem 0.5rem rgba(0, 0, 0, 0.05);
        }

        .kanban-card {
            border: 1px solid #eee;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #fff;
            transition: box-shadow 0.2s;
        }

        .kanban-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .card-header {
            font-weight: 600;
            font-size: 1rem;
        }

        .card-subtitle {
            font-size: 0.85rem;
            color: #888;
        }

        .avatar-group img {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: -8px;
            border: 2px solid white;
        }

        .dot-group span {
            width: 6px;
            height: 6px;
            background: #ccc;
            display: inline-block;
            border-radius: 50%;
            margin-right: 4px;
        }

        .tag-badge {
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 0.25rem;
            background-color: #eee;
            color: #444;
            display: inline-block;
            margin-top: 0.5rem;
        }
    </style>
</head>

<body class="bg-light py-4">
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

        <h1 class="mb-4">{{ $board->name }}</h1>

        <div class="card mb-4">
            <div class="card-header">
                Create New Column
            </div>
            <div class="card-body">
                <!-- Add Column -->
                <form action="{{ route('columns.store', $board) }}" method="POST" class="gap-2 mb-4">
                    @csrf
                    <div class="row">
                        <div class="col-lg-10 col-sm-8">
                            <input name="name" placeholder="New column name" class="form-control">
                        </div>
                        <div class="col-lg-2 col-sm-2">
                            <button class="btn btn-primary">Add Column</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                Kanban Board
            </div>
            <div class="card-body">
                <!-- Columns -->
                <div class="kanban-board shadow p-3 mb-5 bg-body-tertiary rounded" id="board-columns"
                    data-board="{{ $board->id }}">
                    @foreach ($board->columns as $column)
                        <div class="kanban-column shadow p-3 mb-5 bg-body-tertiary rounded"
                            data-id="{{ $column->id }}">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-3">{{ $column->name }} <span class="btn btn-sm add-task"
                                        data-id="{{ $column->id }}" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop"><img src="{{ asset('images/plus.png') }}"
                                            width="20px" alt="add"></span></h5>

                                <form action="{{ route('delete.column', $column->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this column?')">
                                        <img src="{{ asset('images/delete.png') }}" width="20px" alt="remove">
                                    </button>
                                </form>

                            </div>
                            <div class="task-list shadow-sm" id="column-{{ $column->id }}"
                                data-column="{{ $column->id }}">
                                @foreach ($column->tasks->sortBy('order') as $task)
                                    <div class="kanban-card task" data-id="{{ $task->id }}">
                                        @if ($task->image)
                                            <img src="{{ asset('storage/' . $task->image) }}" class="card-img-top"
                                                alt="Task Image"
                                                style="max-height: width: 100%; height: 150px; object-fit: cover;">
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
                                                @if ($task->image)
                                                    <img src="{{ asset('storage/' . $task->image) }}" alt="avatar">
                                                @else
                                                    <img src="{{ asset('images/photo.png') }}" width="20px"
                                                        alt="remove">
                                                @endif
                                                {{-- @endforeach --}}
                                            </div>
                                        </div>

                                        @if ($task->due_date)
                                            <div class="tag-badge bg-info text-white">
                                                Create Date: {{ $task->created_at->format('M d, Y') }}
                                            </div>
                                            <div class="tag-badge bg-warning text-dark">
                                                Due Date: {{ $task->due_date->format('M d, Y') }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-success w-100 mt-3 add-task"
                                data-id="{{ $column->id }}" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                Add Task
                            </button>
                        </div>
                    @endforeach
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
            $(".column_id").val(columnId);
        });

        document.querySelectorAll('.task-list').forEach(el => {
            new Sortable(el, {
                group: 'shared',
                animation: 150,
                onEnd: function(evt) {
                    const column = evt.to;
                    const taskIds = Array.from(column.children).map(task => task.dataset.id);
                    const columnId = column.dataset.column;

                    fetch(`/tasks/${evt.item.dataset.id}/move`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            column_id: columnId,
                            order: taskIds
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

    <!-- Optional Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>

</html>
