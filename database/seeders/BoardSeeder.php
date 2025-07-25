<?php

namespace Database\Seeders;

use App\Models\Board;
use Illuminate\Database\Seeder;

class BoardSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Board::create( [
            'user_id' => 1,
            'name'    => 'Sample Board',
            'slug'    => 'sample-board',
        ] );
    }
}