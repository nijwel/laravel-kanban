<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ColumnController extends Controller {
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
    public function store( Request $request, Board $board ) {
        $request->validate( ['name' => 'required'] );
        $board->columns()->create( [
            'name'    => $request->name,
            'slug'    => Str::slug( $request->name ) . '-column-' . $board->slug,
            'user_id' => auth()->id(),
            'order'   => $board->columns()->count(),
        ] );
        return back();
    }

    public function reorder( Request $request, Board $board ) {
        $request->validate( [
            'order'   => 'required|array',
            'order.*' => 'integer',
        ] );

        foreach ( $request->order as $index => $columnId ) {
            Column::where( 'id', $columnId )->where( 'board_id', $board->id )->update( ['order' => $index] );
        }

        return response()->json( ['success' => true] );
    }

    /**
     * Display the specified resource.
     */
    public function show( string $id ) {
        //
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
        Column::findOrFail( $id )->delete();
        return redirect()->back()->with( 'success', 'Column deleted successfully.' );
    }
}
