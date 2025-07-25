<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ColumnController;
use App\Models\Board;

Route::get('/', function () {

    $boards = Board::all();
    return view('welcome',compact('boards'));
});

Route::get('/boards/{board}', [BoardController::class, 'show'])->name('boards.show');
Route::post('/columns/{column}/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::post('/tasks/{task}/move', [TaskController::class, 'move'])->name('tasks.move');

Route::post('/boards/{board}/columns', [ColumnController::class, 'store'])->name('columns.store');
Route::post('/boards/{board}/reorder-columns', [ColumnController::class, 'reorder'])->name('columns.reorder');
Route::delete('column/delete/{id}',[ColumnController::class, 'destroy'])->name('delete.column');

