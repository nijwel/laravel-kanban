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
        //
    }
}