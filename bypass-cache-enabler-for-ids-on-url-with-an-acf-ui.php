<?php

/**
 * Bypass Cache Enabler for IDs on URL with an ACF UI.
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
    // convert ids to paths
    $excluded_paths = [];
    foreach ( $excluded_ids as $post_id )
    {
        $post_slug = get_post_field( 'post_name', $post_id );
        if ( $post_slug )
            $excluded_paths[] = '/'.$post_slug.'/';
    }
    // current path
    $current_path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
    // bypass cache
    return in_array( $current_path, $excluded_paths );
});

