<!DOCTYPE html>
<html>
<head>
    <title>{{ $board->name }} - Kanban</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
</head>
<body class="p-6 bg-gray-100">

    <h1 class="text-2xl font-bold mb-6">{{ $board->name }}</h1>

    <!-- Add Column Form -->
    <form action="{{ route('columns.store', $board) }}" method="POST" class="mb-6 flex gap-3">
        @csrf
        <input name="name" placeholder="New column name" class="border px-3 py-2 rounded">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Add Column</button>
    </form>

    <div id="board-columns" class="flex gap-6 overflow-x-auto" data-board="{{ $board->id }}">
        @foreach ($board->columns as $column)
        <div class="column w-72 bg-white p-4 rounded shadow flex-shrink-0" data-id="{{ $column->id }}">

                <h2 class="text-lg font-semibold mb-4">{{ $column->name }}</h2>

                <!-- Task List -->
                <div class="task-list min-h-10" id="column-{{ $column->id }}" data-column="{{ $column->id }}">
                    @foreach ($column->tasks->sortBy('order') as $task)
                        <div class="task bg-gray-100 p-2 mb-2 rounded shadow-sm" data-id="{{ $task->id }}">
                            {{ $task->title }}
                        </div>
                    @endforeach
                </div>

                <!-- Add Task -->
                <form action="{{ route('tasks.store', $column) }}" method="POST" class="mb-4">
                    @csrf
                    <input name="title" placeholder="Task title" class="w-full border px-2 py-1 rounded mb-2">
                    <button class="w-full bg-green-500 text-white py-1 rounded">Add Task</button>
                </form>
            </div>
        @endforeach
    </div>

    <script>
        // document.querySelectorAll('.task-list').forEach(el => {
        //     new Sortable(el, {
        //         group: 'shared',
        //         animation: 150,
        //         onAdd: function (evt) {
        //             const taskId = evt.item.dataset.id;
        //             const newColumnId = evt.to.dataset.column;

        //             fetch(`/tasks/${taskId}/move`, {
        //                 method: 'POST',
        //                 headers: {
        //                     'Content-Type': 'application/json',
        //                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //                 },
        //                 body: JSON.stringify({ column_id: newColumnId })
        //             }).then(res => {
        //                 if (!res.ok) alert('Failed to move task');
        //             });
        //         }
        //     });
        // });

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


    </script>
    <script>
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


</body>
</html>
