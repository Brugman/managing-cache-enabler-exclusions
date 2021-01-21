<?php

/**
 * Manage Cache Enabler settings with an ACF UI.
 *
 * We tell ACF to load from and save to CE's settings.
 *
 * Do yourself:
 * Create an options page.
 * Create a relationship field named "ce_exclude_by_id" that returns ids.
 * Create a textarea field named "ce_exclude_by_url".
 */

/**
 * Exclude by ID: Load.
 */

add_filter( 'acf/load_value/name=ce_exclude_by_id', function ( $value, $post_id, $field ) {

    $ce_settings = get_option( 'cache_enabler' );
    $ce_excluded_ids = explode( ',', $ce_settings['excluded_post_ids'] );

    return $ce_excluded_ids;
}, 10, 3 );

/**
 * Exclude by ID: Save.
 */

add_filter( 'acf/update_value/name=ce_exclude_by_id', function ( $value, $post_id, $field, $original ) {

    $ce_settings = get_option( 'cache_enabler' );
    $ce_settings['excluded_post_ids'] = implode( ',', $value );

    update_option( 'cache_enabler', $ce_settings );

    return $value;
}, 10, 4 );

/**
 * Exclude by URL: Load.
 */

function timbr_acfce_deregexify_paths( $regex )
{
    $string = $regex;
    $string = str_replace( ['/^(',')$/'], '', $string );
    $string = str_replace( '\/', '/', $string );
    $string = str_replace( '|', "\n", $string );

    return $string;
}

add_filter( 'acf/load_value/name=ce_exclude_by_url', function ( $value, $post_id, $field ) {

    $ce_settings = get_option( 'cache_enabler' );
    $string = timbr_acfce_deregexify_paths( $ce_settings['excluded_page_paths'] );

    return $string;
}, 10, 3 );

/**
 * Exclude by URL: Save.
 */

function timbr_acfce_regexify_paths( $string )
{
    $regex = '';

    $paths = trim( $string );

    if ( !empty( $paths ) )
    {
        $paths = explode( "\n", $paths );
        foreach ( $paths as &$path )
            $path = '/'.trim( trim( $path ), '/' ).'/';

        $regex = implode( '|', $paths );
        $regex = str_replace( '/', '\/', $regex );
        $regex = '/^('.$regex.')$/';
    }

    return $regex;
}

add_filter( 'acf/update_value/name=ce_exclude_by_url', function ( $value, $post_id, $field, $original ) {

    $ce_settings = get_option( 'cache_enabler' );
    $ce_settings['excluded_page_paths'] = timbr_acfce_regexify_paths( $value );

    update_option( 'cache_enabler', $ce_settings );

    return $value;
}, 10, 4 );

