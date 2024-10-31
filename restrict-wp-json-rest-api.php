<?php
/*

Plugin Name: Restrict Json Rest Api
Description: Plugin to restrict json rest api, which you want to restrict to use from outside
Version: 1.0
Author: Rajat Meshram
Author URI: https://rajatmeshram.in
License: GPLv2
Text Domain : restrict-json-rest-api
License: GPLv2 or later

*/
 if ( ! defined( 'ABSPATH' ) ) exit;
require_once(__DIR__.'/pages/admin-menu.php');
$all_api = sanitize_text_field(get_option( 'disable_all' ));
$list_endpoints = sanitize_text_field(get_option( 'endpoints_list' ));
if( $all_api == 'yes' ){
remove_action( 'init', 'rest_api_init' );
remove_action( 'rest_api_init', 'rest_api_default_filters', 10 );
remove_action( 'rest_api_init', 'register_initial_settings', 10 );
remove_action( 'rest_api_init', 'create_initial_rest_routes', 99 );
remove_action( 'parse_request', 'rest_api_loaded' );
}
else {
    if(!empty($list_endpoints)){
add_filter( 'rest_endpoints', 'rjrapi_disable_default_endpoints' );
    }
}
function rjrapi_disable_default_endpoints( $endpoints ) {
     $list_endpoints = sanitize_text_field(get_option( 'endpoints_list' ));
     $list = explode(",",$list_endpoints);
     $endpoints_to_remove = $list;
    if ( ! is_user_logged_in() ) {
        foreach ( $endpoints_to_remove as $rem_endpoint ) {
            // $base_endpoint = "/wp/v2/{$rem_endpoint}";
            foreach ( $endpoints as $maybe_endpoint => $object ) {
                if ( stripos( $maybe_endpoint, $rem_endpoint ) !== false ) {
                    unset( $endpoints[ $maybe_endpoint ] );
                }
            }
        }
    }
    return $endpoints;
}