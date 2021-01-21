<?php

/**
 * Bypass Cache Enabler for IDs on ID with PHP.
 */

add_filter( 'cache_enabler_bypass_cache', function () {

    // settings
    $excluded_ids = [
        11,
        12,
        13,
    ];
    // no exclusions no bypass
    if ( empty( $excluded_ids ) )
        return false;
    // get current id
    $current_id = url_to_postid( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) );
    // bypass cache
    return in_array( $current_id, $excluded_ids );
});

