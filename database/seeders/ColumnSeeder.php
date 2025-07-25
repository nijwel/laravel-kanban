<?php

namespace Database\Seeders;

use App\Models\Column;
use Illuminate\Database\Seeder;

class ColumnSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Column::insert( [
            [
                'board_id'   => 1,
                'name'       => 'To Do',
                'slug'       => 'to-do',
                'user_id'    => 1,
                'order'      => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'board_id'   => 1,
                'name'       => 'In Progress',
                'slug'       => 'in-progress',
                'user_id'    => 1,
                'order'      => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'board_id'   => 1,
                'name'       => 'Done',
                'slug'       => 'done',
                'user_id'    => 1,
                'order'      => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ] );
    }
}
