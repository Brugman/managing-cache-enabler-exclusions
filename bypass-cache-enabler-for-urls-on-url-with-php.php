<?php

/**
 * Bypass Cache Enabler for URLs on URL with PHP.
 */

add_filter( 'cache_enabler_bypass_cache', function () {

    // settings
    $excluded_paths = [
        '/members/',
        '/members/premier/',
        '/party-registration/',
    ];
    // no exclusions no bypass
    if ( empty( $excluded_paths ) )
        return false;
    // current path
    $current_path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
    // bypass cache
    return in_array( $current_path, $excluded_paths );
});

