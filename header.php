<?php
/**
 * Site header
 *
 * Loaded on every page by get_header().
 * Contains: <head>, skip link, site logo/name, main navigation, and Register button.
 * Structure only: no styling yet.
 */
?>
<!DOCTYPE html>
<!-- language_attributes() adds lang="en-CA" (or whatever WordPress is set to) for screen readers. -->
<html <?php language_attributes(); ?>>

<head>
	<!-- Character set from WordPress settings (UTF-8). -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<!-- Makes the site scale properly on phones. -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- wp_head() lets WordPress and plugins add the page title, styles, scripts, and SEO tags. Required. -->
	<?php wp_head(); ?>
</head>

<!-- body_class() adds helpful classes (page name, logged-in, etc.) we can target with CSS later. -->
<body <?php body_class(); ?>>
	<?php
	// wp_body_open() lets plugins add things right after <body> opens (e.g. tracking). Required by WordPress.
	wp_body_open();
	?>

	<!-- Skip link: first thing a keyboard user reaches. Jumps past the menu to <main id="main-content">.
	     Accessibility requirement. Will be visually hidden until focused once we style it. -->
	<a class="skip-link" href="#main-content">Skip to content</a>

	<!-- <header> is a landmark: screen readers can jump straight to it. -->
	<header class="site-header">

		<!-- Site branding: logo if one is uploaded, otherwise the site name as text. -->
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php
				// Outputs the logo (Appearance > Customize > Site Identity) already linked to the homepage.
				the_custom_logo();
				?>
			<?php else : ?>
				<!-- No logo yet: show the site name linked to the homepage. -->
				<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
			<?php endif; ?>
		</div>

		<!-- Main navigation. aria-label names it "Main" so screen readers can tell it apart from the footer menu. -->
		<nav class="main-navigation" aria-label="Main">
			<?php
			// Outputs the menu assigned to this location (Appearance > Menus > Manage Locations).
			// Child pages (Cheremosh Company, School of Dance) come out as a nested <ul class="sub-menu">,
			// which we will turn into dropdowns when we style.
			wp_nav_menu(
				array(
					'theme_location' => 'primary',   // Matches 'primary' in inc/setup.php.
					'menu_id'        => 'main-menu', // id on the <ul>, for CSS/JS later.
					'container'      => false,       // No extra <div> around the <ul>; the <nav> is enough.
					'fallback_cb'    => false,       // If no menu is assigned, show nothing (no messy page list).
				)
			);
			?>
		</nav>

		<!-- Main call to action, always visible in the header (Bohdan wants Register easy to find). -->
		<a class="button header-cta" href="<?php echo esc_url( home_url( '/register/' ) ); ?>">Register</a>

	</header>