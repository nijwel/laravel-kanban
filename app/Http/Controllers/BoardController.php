<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BoardController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Request $request ) {
        $request->validate( [
            'name' => 'required|string|max:255',
        ] );

        $board = Board::create( [
            'name'    => $request->name,
            'slug'    => Str::slug( $request->name ) . '-' . Str::random( 5 ),
            'user_id' => auth()->id(), // optional if boards are user-owned
        ] );

        $board->columns()->createMany( [
            [
                'name'    => 'To Do',
                'slug'    => Str::slug( 'to do' ) . '-column-' . $board->slug,
                'user_id' => auth()->id(),
                'status'  => 'todo',
                'order'   => 0,
            ],
            [
                'name'    => 'In Progress',
                'slug'    => Str::slug( 'In Progress' ) . '-column-' . $board->slug,
                'user_id' => auth()->id(),
                'status'  => 'inprogress',
                'order'   => 1,
            ],
            [
                'name'    => 'Completed',
                'slug'    => Str::slug( 'completed' ) . '-column-' . $board->slug,
                'user_id' => auth()->id(),
                'status'  => 'completed',
                'order'   => 2,
            ],
        ] );

        return redirect()->back()->with( 'success', 'Board created successfully!' );
    }

    /**
     * Display the specified resource.
     */
    public function show( $slug ) {
        $board = Board::where( 'slug', $slug )->with( 'columns.tasks' )->first();
        return view( 'board.board2', compact( 'board' ) );

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( string $id ) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {
        $board = Board::findOrFail( $id );
        $board->delete();
        return redirect()->back()->with( 'success', 'Board deleted successfully.' );
    }
}
