<?php
/**
 * Created by PhpStorm.
 * User: johnfalcon
 * Date: 2/4/19
 * Time: 10:24 PM
 */

function set_active( $path = '', $query_string = NULL, $class = 'active' ){
    
    $possible_get_param = strpos( Request::fullUrl(), '=' );
    if( $query_string ){
        $exploded = explode('=', $query_string );
        if(!empty($exploded))
            return in_array( $query_string, array_values($_GET) ) ? $class : '';
    }
    return ( Request::is($path) AND $possible_get_param === FALSE ) ? $class : '';
}