<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\TaskController;
use App\Models\Board;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get( '/', function () {

    $boards = Board::all();
    return view( 'welcome', compact( 'boards' ) );
} );

Auth::routes();
Route::get( '/home', [App\Http\Controllers\HomeController::class, 'index'] )->name( 'home' );

Route::prefix( 'boards' )->group( function () {
    Route::post( '/store', [BoardController::class, 'store'] )->name( 'boards.store' );
    Route::get( '/{board}', [BoardController::class, 'show'] )->name( 'boards.show' );
    Route::post( '/{board}/columns', [ColumnController::class, 'store'] )->name( 'columns.store' );
    Route::post( '/{board}/reorder-columns', [ColumnController::class, 'reorder'] )->name( 'columns.reorder' );
} );

Route::post( '/columns/{column}/tasks', [TaskController::class, 'store'] )->name( 'tasks.store' );
Route::post( '/tasks/{task}/move', [TaskController::class, 'move'] )->name( 'tasks.move' );

Route::delete( 'board/delete/{id}', [BoardController::class, 'destroy'] )->name( 'boards.destroy' );
Route::delete( 'column/delete/{id}', [ColumnController::class, 'destroy'] )->name( 'delete.column' );