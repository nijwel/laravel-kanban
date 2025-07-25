<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Assuming you have a Task model and the necessary columns
        Task::insert( [
            [
                'column_id'   => 1,
                'title'       => 'Task 1',
                'slug'        => 'task-1',
                'description' => 'Description for Task 1',
                'due_date'    => now()->addDays( 7 ),
                'user_id'     => 1,
                'order'       => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'column_id'   => 2,
                'title'       => 'Task 2',
                'slug'        => 'task-2',
                'description' => 'Description for Task 2',
                'due_date'    => now()->addDays( 14 ),
                'user_id'     => 1,
                'order'       => 2,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'column_id'   => 3,
                'title'       => 'Task 3',
                'slug'        => 'task-3',
                'description' => 'Description for Task 3',
                'due_date'    => now()->addDays( 21 ),
                'user_id'     => 1,
                'order'       => 3,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ] );
    }
}