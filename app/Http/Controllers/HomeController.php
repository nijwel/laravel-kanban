<?php

namespace App\Http\Controllers;

use App\Models\Board;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware( 'auth' );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $boards = Board::whereRaw( 'FIND_IN_SET(?, assign_to)', [auth()->id()] )
            ->with( 'columns' )
            ->latest()
            ->get();
        return view( 'home', compact( 'boards' ) );
    }
}