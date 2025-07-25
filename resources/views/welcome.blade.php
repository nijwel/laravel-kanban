<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Kanban Board</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container mt-5">
        {{-- Create New Board Form --}}
        <div class="card mb-4">
            <div class="card-header">Create New Board</div>
            <div class="card-body">
                <form action="{{ route('boards.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Board Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Create Board</button>
                </form>
            </div>
        </div>

        {{-- Existing Boards --}}
        @foreach ($boards as $board)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">{{ $board->name }}</h5>
                        <a href="{{ route('boards.show', $board->slug) }}" class="btn btn-primary">Open Board</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</body>

</html>
