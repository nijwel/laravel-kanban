<?php

if ( !function_exists( 'custom_date_format' ) ) {
    function custom_date_format( $value ) {
        return Carbon\Carbon::parse( $value )->format( 'M d, Y' );
    }
}