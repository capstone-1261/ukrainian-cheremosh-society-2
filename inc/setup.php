<?php
/**
 * Theme setup: turns on WordPress features and registers menu locations.
 *
 * Runs on the after_setup_theme hook, which fires once when the theme loads,
 * before any page is built.
 */

function cheremosh_setup() {
	// Let WordPress manage the <title> tag (outputs it inside wp_head() in header.php).
	add_theme_support( 'title-tag' );

	// Featured images on posts, pages, programs and people.
	add_theme_support( 'post-thumbnails' );

	// Logo upload in Appearance > Customize > Site Identity.
	// header.php shows the logo if one is uploaded, otherwise the site name.
	// flex-width/flex-height let the client upload any size without forced cropping.
	add_theme_support(
		'custom-logo',
		array(
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Clean HTML5 markup for forms, galleries and captions.
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'gallery', 'caption', 'style', 'script' ) );

	// Block editor support for full and wide width blocks.
	add_theme_support( 'align-wide' );

	// Videos (YouTube, etc.) keep their shape and resize on smaller screens.
	add_theme_support( 'responsive-embeds' );

	// Menu locations the client can manage in Appearance > Menus.
	// Left side = slug used in code (header.php / footer.php). Right side = name shown in the dashboard.
	register_nav_menus(
		array(
			'primary' => 'Main Menu',   // Used in header.php.
			'footer'  => 'Footer Menu', // Used in footer.php.
		)
	);
}
add_action( 'after_setup_theme', 'cheremosh_setup' );