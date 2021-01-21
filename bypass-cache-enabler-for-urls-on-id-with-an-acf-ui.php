<?php

/**
 * Bypass Cache Enabler for URLs on ID with an ACF UI.
 *
 * Do yourself:
 * Create an options page.
 * Create a textarea field named "ce_exclude_by_url".
 */

add_filter( 'cache_enabler_bypass_cache', function () {

    // get paths
    $excluded_paths = get_field( 'ce_exclude_by_url', 'options' );
    $excluded_paths = trim( $excluded_paths );
    // no exclusions no bypass
    if ( empty( $excluded_paths ) )
        return false;
    // convert to ids
    $excluded_paths = explode( "\n", $excluded_paths );
    $excluded_ids = array_map( function ( $path ) {
        return url_to_postid( $path );
    }, $excluded_paths );
    // get current id
    $current_id = url_to_postid( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) );
    // bypass cache
    return in_array( $current_id, $excluded_ids );
});

