<?php

/**
 * Site header
 *
 * Loaded on every page by get_header().
 * Contains: <head>, skip link, announcement bar, site logo,
 * the mobile menu button, main navigation, and the header button.
 */
?>
<!DOCTYPE html>
<!-- language_attributes() adds lang="en-CA" (or whatever WordPress is set to) for screen readers. -->
<html <?php language_attributes(); ?>>

<head>
	<!-- Character set from WordPress settings (UTF-8). -->
	<meta charset="<?php bloginfo('charset'); ?>">
	<!-- Makes the site scale properly on phones. -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- wp_head() lets WordPress and plugins add the page title, styles, scripts, and SEO tags. Required. -->
	<?php wp_head(); ?>
</head>

<!-- body_class() adds helpful classes (page name, logged-in, etc.) we can target with CSS. -->

<body <?php body_class(); ?>>
	<?php
	// wp_body_open() lets plugins add things right after <body> opens (e.g. tracking). Required by WordPress.
	wp_body_open();
	?>

	<!-- Skip link: first thing a keyboard user reaches. Jumps past the menu to <main id="main-content">.
	     Hidden until focused (see main.css). -->
	<a class="skip-link" href="#main-content">Skip to content</a>

	<?php
	// Announcement bar (yellow). Settings live in Appearance > Customize > Announcement bar (inc/customizer.php).
	// get_theme_mod() reads a saved Customizer setting; the second value is the default if nothing is saved.
	$cheremosh_show_bar  = get_theme_mod('cheremosh_announcement_show', false);
	$cheremosh_bar_text  = get_theme_mod('cheremosh_announcement_text', 'The Cheremosh Ukrainian Dance Festival is Coming');
	$cheremosh_bar_link  = get_theme_mod('cheremosh_announcement_link_text', 'Explore the Festival');
	$cheremosh_bar_url   = get_theme_mod('cheremosh_announcement_link_url', '/dance-festival/');

	// Only print the bar if it's switched on and has a message.
	if ($cheremosh_show_bar && $cheremosh_bar_text) :
	?>
		<!-- role="region" + aria-label lets screen readers find and announce it as "Announcement". -->
		<div class="announcement-bar" role="region" aria-label="Announcement">
			<p>
				<?php echo esc_html($cheremosh_bar_text); ?>

				<?php if ($cheremosh_bar_link && $cheremosh_bar_url) : ?>
					<!-- Underlined link so it isn't shown by colour alone (Daina's note). -->
					<a href="<?php echo esc_url($cheremosh_bar_url); ?>"><?php echo esc_html($cheremosh_bar_link); ?></a>
				<?php endif; ?>
			</p>
		</div>
	<?php endif; ?>

	<!-- <header> is a landmark: screen readers can jump straight to it. -->
	<header class="site-header">

		<!-- Site branding: the logo, linked to the homepage. -->
		<div class="site-branding">
			<?php if (has_custom_logo()) : ?>
				<?php
				// If the client uploads a logo in Appearance > Customize > Site Identity, use theirs.
				the_custom_logo();
				?>
			<?php else : ?>
				<!-- Default: the logo file that ships with the theme (assets/images/logo.svg).
				     Alt text from Daina's accessibility note: it says where the link goes ("home"). -->
				<a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
					<img
						src="<?php echo esc_url(get_theme_file_uri('assets/images/logo.svg')); ?>"
						alt="Cheremosh Ukrainian Dance Society — home">
				</a>
			<?php endif; ?>
		</div>

		<?php
		/*
		 * Mobile menu button.
		 *
		 * Hidden on desktop by CSS; only appears on narrow screens.
		 *
		 * A real <button> so it works with keyboard and screen readers for free.
		 * type="button" stops it submitting anything if it ever sits inside a form.
		 *
		 * aria-controls="main-menu" points at the <ul> that wp_nav_menu() prints
		 * below, so assistive tech knows which thing this button opens.
		 *
		 * aria-expanded="false" is the state. assets/js/mobile-menu.js flips it to
		 * "true" when the menu opens, and screen readers announce the change.
		 * It starts as "false" in the HTML so the markup is correct even before
		 * the JavaScript loads.
		 *
		 * The bars are drawn in CSS. aria-hidden="true" hides that decorative span
		 * from screen readers, and the screen-reader-text span gives the button a
		 * proper name ("Menu") that's invisible on screen.
		 */
		?>
		<button class="menu-toggle" type="button" aria-controls="main-menu" aria-expanded="false">
			<span class="menu-toggle-bars" aria-hidden="true"></span>
			<span class="screen-reader-text">Menu</span>
		</button>

		<!-- Main navigation. aria-label names it "Main" so screen readers can tell it apart from the footer menu. -->
		<nav class="main-navigation" aria-label="Main">
			<?php
			// Outputs the menu assigned to this location (Appearance > Menus > Manage Locations).
			// Child pages come out as a nested <ul class="sub-menu"> (the dropdown, styled in main.css).
			wp_nav_menu(
				array(
					'theme_location' => 'primary',   // Matches 'primary' in inc/setup.php.
					'menu_id'        => 'main-menu', // id on the <ul>, for CSS/JS.
					'container'      => false,       // No extra <div> around the <ul>; the <nav> is enough.
					'fallback_cb'    => false,       // If no menu is assigned, show nothing.
				)
			);
			?>
			<?php
			/*
			 * Header button.
			 *
			 * Logged out: "Login", pointing at the Log In page.
			 * Logged in:  "My Account", pointing at the account page.
			 *
			 * The Log In page is looked up by slug. The account page is found by
			 * its template (see cheremosh_get_account_page() in functions.php), so
			 * WooCommerce's own "my-account" page can't clash with ours. Each falls
			 * back to the home page rather than printing a dead link if the page
			 * doesn't exist yet.
			 */
			if ( is_user_logged_in() ) {
				$cheremosh_cta_page  = cheremosh_get_account_page();
				$cheremosh_cta_label = 'My Account';
			} else {
				$cheremosh_cta_page  = get_page_by_path( 'log-in' );
				$cheremosh_cta_label = 'Login';
			}

			$cheremosh_cta_url = $cheremosh_cta_page
				? get_permalink( $cheremosh_cta_page )
				: home_url( '/' );
			?>
			<a class="header-cta" href="<?php echo esc_url( $cheremosh_cta_url ); ?>">
				<?php echo esc_html( $cheremosh_cta_label ); ?>
			</a>
		</nav>

	</header>