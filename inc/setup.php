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

	/*
	 * Load our own stylesheet inside the block editor as well.
	 *
	 * Without this, the editor only knows about theme.json, so anything styled
	 * in main.css (the hero, for example) looks wrong while you're editing even
	 * though it's correct on the real page. These two lines make the editor
	 * preview match what visitors actually see.
	 *
	 * 'editor-styles' switches the feature on; add_editor_style() says which
	 * file to load, relative to the theme folder.
	 */
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/main.css' );

	// Menu locations the client can manage in Appearance > Menus.
	// Left side = slug used in code (header.php / footer.php). Right side = name shown in the dashboard.
	register_nav_menus(
		array(
			'primary' => 'Main Menu',   // Used in header.php.
			'footer'  => 'Footer Menu', // Used in footer.php: the "Website Map" column.
			'legal'   => 'Legal Menu',  // Used in footer.php: the small links at the very bottom (Privacy, Terms, Cookies).
		)
	);
}
add_action( 'after_setup_theme', 'cheremosh_setup' );