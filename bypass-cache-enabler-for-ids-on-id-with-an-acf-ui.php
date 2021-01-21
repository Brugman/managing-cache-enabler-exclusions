<?php

/**
 * Bypass Cache Enabler for IDs on ID with an ACF UI.
 *
 * Do yourself:
 * Create an options page.
 * Create a relationship field named "ce_exclude_by_id" that returns ids.
 */

add_filter( 'cache_enabler_bypass_cache', function () {

    // get excluded ids
    $excluded_ids = get_field( 'ce_exclude_by_id', 'options' );
    // no exclusions no bypass
    if ( empty( $excluded_ids ) )
        return false;
    // get current id
    $current_id = url_to_postid( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) );
    // bypass cache
    return in_array( $current_id, $excluded_ids );
});

