@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ __('Dashboard') }}</h4>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="bi bi-plus-circle me-1"></i> Create New Board
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="row g-4">
                            @forelse($boards as $board)
                                @php
                                    $taskCount = $board->tasks->count();
                                    $completedTasks = $board->tasks->where('status', 'completed')->count();
                                    $progress = $taskCount > 0 ? round(($completedTasks / $taskCount) * 100) : 0;
                                    $columnCount = $board->columns->count();
                                @endphp

                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="card h-100 shadow border-0 hover-card">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="fw-bold text-primary text-center">{{ ucfirst($board->name) }}</h5>
                                            <hr>
                                            <p class="text-muted mb-1">
                                                <small><i class="bi bi-calendar"></i>
                                                    Created: {{ $board->created_at->format('M d, Y') }}</small>
                                            </p>

                                            <p class="mb-1">
                                                <small><i class="bi bi-columns-gap"></i> Columns:
                                                    {{ $columnCount }}</small>
                                            </p>

                                            <p class="mb-3">
                                                <small><i class="bi bi-list-task"></i> Tasks: {{ $taskCount }}</small>
                                            </p>

                                            <p class="mb-3">
                                            <div
                                                class="d-flex justify-content-between align-items-center border-top pt-2 mt-2">
                                                <!-- Completed Tasks -->
                                                <div class="d-flex align-items-center text-muted">
                                                    <i class="bi bi-check-circle-fill text-success me-1"></i>
                                                    <small><strong>{{ $completedTasks }}</strong> Completed</small>
                                                </div>

                                                <!-- Assignee Avatars -->
                                                <div class="d-flex flex-row-reverse">
                                                    @foreach (explode(',', $board->assign_to) as $index => $userId)
                                                        @php $user = \App\Models\User::find($userId); @endphp
                                                        <div class="avatar-wrapper" style="z-index: {{ 100 - $index }}">
                                                            <img src="{{ $user && $user->avatar ? asset('storage/' . $user->avatar) : asset('images/avatar.png') }}"
                                                                class="rounded-circle border" width="32" height="32"
                                                                alt="avatar">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            </p>

                                            <!-- Progress bar -->
                                            <div class="mb-3">
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: {{ $progress }}%;"
                                                        aria-valuenow="{{ $progress }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <small class="text-muted">{{ $progress }}% Completed</small>
                                            </div>

                                            <div class="mt-auto d-flex justify-content-between">
                                                <a href="{{ route('boards.show', $board->slug) }}" class="text-success"
                                                    title="Open Board">
                                                    <i class="bi bi-box-arrow-up-right fs-5"></i>
                                                </a>
                                                <form action="{{ route('boards.destroy', $board->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this board?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link p-0 text-danger"
                                                        title="Delete Board">
                                                        <i class="bi bi-trash fs-5"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5">
                                    <h5 class="text-muted">No boards found</h5>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                        class="btn btn-outline-primary mt-3">
                                        <i class="bi bi-plus-circle me-1"></i> Create New Board
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Board Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Board</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('boards.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Board Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Styling --}}
    <style>
        .hover-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-radius: 12px;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }
    </style>
@endsection
