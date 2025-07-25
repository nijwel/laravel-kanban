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
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
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

<div class="container">

    <h1 class="mb-4">{{ $board->name }}</h1>

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

    <!-- Columns -->
    <div id="board-columns" class="board-container" data-board="{{ $board->id }}">
        @foreach ($board->columns as $column)
        <div class="column bg-white p-3 rounded shadow-sm flex-shrink-0" style="width: 300px;" data-id="{{ $column->id }}">
            <h5 class="mb-3">{{ $column->name }}</h5>

            <!-- Task List -->
            <div class="task-list" id="column-{{ $column->id }}" data-column="{{ $column->id }}">
                @foreach ($column->tasks->sortBy('order') as $task)
                <div class="task mb-3 task-card card" data-id="{{ $task->id }}">
                    @if ($task->image)
                    <img src="{{ asset('storage/' . $task->image) }}" class="card-img-top" alt="Task Image">
                    @endif
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <h6 class="card-title mb-2">{{ $task->title }}</h6>
                            <span class="badge
                                {{ $task->status === 'Done' ? 'bg-success' :
                                   ($task->status === 'In Progress' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                {{ $task->status }}
                            </span>
                        </div>

                        <p class="card-text text-muted small">{{ $task->description }}</p>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                <i class="bi bi-calendar-event"></i>
                                {{ optional($task->due_date)->format('M d, Y') }}
                            </small>
                            @if ($task->assignee)
                                <img src="{{ $task->assignee->avatar_url }}" alt="User" class="rounded-circle" width="28" height="28">
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-success w-100 mt-3 add-task" data-id="{{ $column->id }}"  data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add Task</button>
            
        </div>
        @endforeach
    </div>

    <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <!-- Add Task -->
            <form action="{{ route('tasks.store', $column) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                <input name="title" placeholder="Task title" class="form-control mb-2">
                <textarea name="description" placeholder="Description" class="form-control mb-2"></textarea>
                <input type="file" name="image" class="form-control mb-2">
                <input type="date" name="due_date" class="form-control mb-2">
                <input type="hidden" name="column_id" class="form-control mb-2 column_id">
                {{-- <select name="column_id" class="form-select mb-2">
                    <option value="To Do">To Do</option>
                    @foreach ($board->columns as $column)
                        <option value="{{ $column->id }}">{{ $column->name }}</option>
                    @endforeach
                </select> --}}

                <div class="mt-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">submit</button>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>
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
            onEnd: function (evt) {
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
        onEnd: function (evt) {
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
