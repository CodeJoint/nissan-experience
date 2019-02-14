<?php
/**
 * Created by PhpStorm.
 * User: johnfalcon
 * Date: 2/4/19
 * Time: 10:24 PM
 */

function set_active( $path = '', $query_string = NULL, $class = 'active' ){
    
    $possible_get_param = strpos( request()->fullUrl(), '=' );
    if( $query_string ){
        $get_values = array_values($_GET);
        $found = in_array( $query_string, $get_values );
        return $found != FALSE ? $class : '';
    }
    return (  request()->is($path) AND $possible_get_param === FALSE ) ? $class : '';
}