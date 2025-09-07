<?php

if ( !function_exists( 'custom_date_format' ) ) {
    function custom_date_format( $value ) {
        return Carbon\Carbon::parse( $value )->format( 'M d, Y' );
    }
}

if ( !function_exists( 'task_count' ) ) {
    function task_count( $board ) {
        return $board->tasks->count();
    }
}

if ( !function_exists( 'completed_task' ) ) {
    function completed_task( $board ) {
        return $board->tasks->where( 'status', 'completed' )->count();
    }
}

if ( !function_exists( 'column_count' ) ) {
    function column_count( $board ) {
        return $board->columns->count();
    }
}

if ( !function_exists( 'progress' ) ) {
    function progress( $board ) {
        $taskCount      = $board->tasks->count();
        $completedTasks = $board->tasks->where( 'status', 'completed' )->count();
        $progress       = $taskCount > 0 ? round( ( $completedTasks / $taskCount ) * 100 ) : 0;
        return $progress;
    }
}