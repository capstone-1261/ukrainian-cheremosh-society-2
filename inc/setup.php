<?php
/**
 * Theme setup: turns on WordPress features and registers menu locations.
 */

function cheremosh_setup() {
	// Let WordPress manage the <title> tag.
	add_theme_support( 'title-tag' );

	// Featured images on posts, pages, programs and people.
	add_theme_support( 'post-thumbnails' );

	// Clean HTML5 markup for forms, galleries and captions.
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'gallery', 'caption', 'style', 'script' ) );

	// Block editor support for full and wide width blocks.
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );

	// Menu locations the client can manage in Appearance > Menus.
	register_nav_menus(
		array(
			'primary' => 'Main Menu',
			'footer'  => 'Footer Menu',
		)
	);
}
add_action( 'after_setup_theme', 'cheremosh_setup' );