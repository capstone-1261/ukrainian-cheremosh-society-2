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
 * Work out a version number for one of our own CSS or JS files.
 *
 * Browsers cache these files hard. WordPress adds ?ver=... to the URL, and the
 * browser only fetches a fresh copy when that number changes.
 *
 * We used to pass the theme version from style.css, which never changes — so
 * every edit we made stayed invisible until someone hard-refreshed. (That's
 * exactly what bit us while building the cards.)
 *
 * filemtime() returns the moment the file was last saved, so the version
 * changes automatically whenever we edit it, and visitors always get the
 * current file without being told to clear anything.
 *
 * @param string $relative_path Path inside the theme, e.g. 'assets/css/main.css'.
 * @return string|int The file's last-modified time, or the theme version as a fallback.
 */
function cheremosh_asset_version( $relative_path ) {
	$file = get_theme_file_path( $relative_path );

	// file_exists() guards against a typo'd path returning false and breaking the URL.
	return file_exists( $file ) ? filemtime( $file ) : wp_get_theme()->get( 'Version' );
}

/**
 * Load front-end styles and scripts.
 *
 * get_theme_file_uri() builds the URL to a file in this theme.
 */
function cheremosh_enqueue_scripts() {
	// main.css: the theme's own styles (header, footer, hero, cards).
	// theme.json styles load first (WordPress does that automatically),
	// so this file can build on top of them.
	wp_enqueue_style(
		'cheremosh-main',                                   // A unique name for this stylesheet.
		get_theme_file_uri( 'assets/css/main.css' ),        // Where the file is.
		array(),                                            // Other stylesheets it needs first (none).
		cheremosh_asset_version( 'assets/css/main.css' )    // Changes whenever we save the file.
	);

	// hero-video.js: adds the Pause/Play button to background videos in Cover blocks.
	wp_enqueue_script(
		'cheremosh-hero-video',                              // A unique name for this script.
		get_theme_file_uri( 'assets/js/hero-video.js' ),     // Where the file is.
		array(),                                             // Other scripts it needs first (none).
		cheremosh_asset_version( 'assets/js/hero-video.js' ),
		array(
			'strategy'  => 'defer', // Download alongside the page, run after it's built.
			'in_footer' => true,    // Load at the bottom of the page.
		)
	);

	// mobile-menu.js: opens and closes the main menu on small screens.
	// Loaded on every page because the header is on every page.
	wp_enqueue_script(
		'cheremosh-mobile-menu',
		get_theme_file_uri( 'assets/js/mobile-menu.js' ),
		array(),
		cheremosh_asset_version( 'assets/js/mobile-menu.js' ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'cheremosh_enqueue_scripts' );