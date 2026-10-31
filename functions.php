<?php 
/**
 * Theme functions
 * 
 * Loads the theme's setup and content types, adds WooCommerce support, and loads front-end scripts.
 */

// Theme feature and menu locations (title tag, thumbnails, logo, menus).
require get_template_directory() . '/inc/setup.php';

// Custom post types, taxonomies and ACF fields (programs, instructors, people).
require get_template_directory() . '/inc/content-types.php';

/**
 * Tell WooCommerce this theme supports it (Sam).
 */
function cheremosh_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'cheremosh_add_woocommerce_support' );

/**
 * Load front-end scripts.
 * 
 * hero-video.js adds the Pause/play button to background videos in the Cover blocks.
 * - get_theme_file_uri() builds the URL to the file in this theme.
 * -wp_get_theme()->get( 'Version' ) uses the theme version from style.css so browsers load the new file after an update instead of an old cashed copy. 
 * 'defer' + 'in_footer' load it without slowing down the page.
 */
function cheremosh_enqueue_scripts() {
    wp_enqueue_script(
        'cheremosh-hero-video',  // A unique name for this script.
    get_theme_file_uri( 'assets/js/hero-video.js' ), //Where the file is.
    array(),    // Other scripts it needs first (none).
    wp_get_theme()->get( 'Version' ),   // Version for cache-busting.
    array(
        'strategy' => 'defer', // Download alongside the page, run after it's built.
        'in_footer' => true, // Load at the bottom of the page.
        )
    );
}
add_action( 'wp_enqueue_scripts', 'cheremosh_enqueue_scripts' );