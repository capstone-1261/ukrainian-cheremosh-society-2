<?php
/**
 * Theme functions
 *
 * Loads the theme's setup, content types and Customizer settings,
 * adds WooCommerce support, and loads front-end styles and scripts.
 */

// Theme features and menu locations (title tag, thumbnails, logo, menus).
require get_template_directory() . '/inc/setup.php';

// Custom post types, taxonomies and ACF fields (programs, instructors, people).
require get_template_directory() . '/inc/content-types.php';

// Customizer settings (Appearance > Customize), e.g. the announcement bar.
require get_template_directory() . '/inc/customizer.php';

/**
 * Tell WooCommerce this theme supports it (Sam).
 */
function cheremosh_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'cheremosh_add_woocommerce_support' );

/**
 * Load front-end styles and scripts.
 *
 * - get_theme_file_uri() builds the URL to a file in this theme.
 * - wp_get_theme()->get( 'Version' ) uses the theme version from style.css so
 *   browsers load the new file after an update instead of an old cached copy.
 */
function cheremosh_enqueue_scripts() {
	// main.css: the theme's own styles (header, footer, templates).
	// theme.json styles load first (WordPress does that automatically),
	// so this file can build on top of them.
	wp_enqueue_style(
		'cheremosh-main',                              // A unique name for this stylesheet.
		get_theme_file_uri( 'assets/css/main.css' ),   // Where the file is.
		array(),                                       // Other stylesheets it needs first (none).
		wp_get_theme()->get( 'Version' )               // Version, for cache-busting.
	);

	// hero-video.js: adds the Pause/Play button to background videos in Cover blocks.
	wp_enqueue_script(
		'cheremosh-hero-video',                         // A unique name for this script.
		get_theme_file_uri( 'assets/js/hero-video.js' ), // Where the file is.
		array(),                                         // Other scripts it needs first (none).
		wp_get_theme()->get( 'Version' ),                // Version, for cache-busting.
		array(
			'strategy'  => 'defer', // Download alongside the page, run after it's built.
			'in_footer' => true,    // Load at the bottom of the page.
		)
	);
}
add_action( 'wp_enqueue_scripts', 'cheremosh_enqueue_scripts' );