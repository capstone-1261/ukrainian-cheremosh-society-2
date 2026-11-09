<?php
/**
 * Site footer
 *
 * Loaded on every page by get_footer().
 * Layout (from Daina's design):
 *   Left:   Website Map (Footer Menu)
 *   Middle: Society name + logo (newsletter goes under it later)
 *   Right:  Contact details + Follow (social links)
 *   Bottom: Legal Menu (Privacy, Terms, Cookies, Refunds) + copyright
 *
 * Contact details and social links come from Appearance > Customize >
 * "Footer: contact and social" (inc/customizer.php), so the client can
 * change them without code.
 */

// Path to our icon files, used a few times below.
// get_template_directory_uri() = the URL of this theme's folder.
$icons = get_template_directory_uri() . '/assets/icons/';

// Contact details from the Customizer. get_theme_mod( 'name' ) reads a saved setting.
$address = get_theme_mod( 'cheremosh_contact_address', '4005 - 115 Avenue, Edmonton AB' );
$phone   = get_theme_mod( 'cheremosh_contact_phone', '780-466-0089' );
$email   = get_theme_mod( 'cheremosh_contact_email', 'contact@cheremosh.ca' );

// Social links: slug => name shown to screen readers.
// The slug matches both the Customizer setting (cheremosh_social_{slug})
// and the icon file name (assets/icons/{slug}.svg).
$social_networks = array(
	'facebook'  => 'Facebook',
	'instagram' => 'Instagram',
	'linkedin'  => 'LinkedIn',
	'x'         => 'X (Twitter)',
	'youtube'   => 'YouTube',
);

// Keep only the networks the client has added a URL for.
$social_links = array();
foreach ( $social_networks as $slug => $name ) {
	$url = get_theme_mod( 'cheremosh_social_' . $slug );
	if ( $url ) {
		$social_links[ $slug ] = array(
			'name' => $name,
			'url'  => $url,
		);
	}
}
?>

	<!-- <footer> is a landmark: screen readers can jump straight to it. -->
	<footer class="site-footer">

		<!-- The three columns. CSS will place them side by side (stacked on phones). -->
		<div class="footer-columns">

			<!-- LEFT: Website Map.
			     aria-labelledby ties the nav to its visible heading, so screen readers
			     announce "Website Map navigation" (different from the main menu). -->
			<nav class="footer-sitemap" aria-labelledby="footer-sitemap-heading">
				<h2 id="footer-sitemap-heading" class="footer-heading">Website Map</h2>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',      // Matches 'footer' in inc/setup.php.
						'menu_id'        => 'footer-menu', // id on the <ul>, for CSS.
						'container'      => false,         // No extra <div>; the <nav> is enough.
						'fallback_cb'    => false,         // Show nothing if no menu is assigned.
						'depth'          => 1,             // Top-level links only, no dropdowns.
					)
				);
				?>
			</nav>

			<!-- MIDDLE: Society name and logo. -->
			<div class="footer-brand">
				<!-- Plain text, not a heading: it's a name, not the start of a section. -->
				<p class="footer-name">Ukrainian Cheremosh Society</p>

				<!-- Logo links home. alt is empty because the name is already
				     right above it; the aria-label says where the link goes. -->
				<a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Cheremosh home">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.svg' ); ?>" alt="" width="160" loading="lazy">
				</a>

				<?php
				// NEWSLETTER: goes here once the team picks how sign-ups are handled
				// (likely a Fluent Forms form, added with do_shortcode()).
				?>
			</div>

			<!-- RIGHT: Contact and Follow. -->
			<div class="footer-connect">

				<section class="footer-contact" aria-labelledby="footer-contact-heading">
					<h2 id="footer-contact-heading" class="footer-heading">Contact</h2>

					<!-- <address> is the HTML tag for contact info about the site owner. -->
					<address>
						<ul class="contact-list">

							<?php if ( $address ) : ?>
								<li>
									<!-- Decorative icon: alt="" so screen readers skip it. -->
									<img class="contact-icon" src="<?php echo esc_url( $icons . 'location.svg' ); ?>" alt="" width="24" height="24">
									<span><?php echo esc_html( $address ); ?></span>
								</li>
							<?php endif; ?>

							<?php if ( $phone ) : ?>
								<li>
									<img class="contact-icon" src="<?php echo esc_url( $icons . 'phone.svg' ); ?>" alt="" width="24" height="24">
									<!-- tel: link lets phones call with one tap.
									     preg_replace() strips spaces and dashes for the link (7804660089),
									     while the visible text keeps the nice format. -->
									<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
								</li>
							<?php endif; ?>

							<?php if ( $email ) : ?>
								<li>
									<img class="contact-icon" src="<?php echo esc_url( $icons . 'email.svg' ); ?>" alt="" width="24" height="24">
									<!-- mailto: opens the visitor's email app.
									     antispambot() scrambles the address in the code so
									     spam bots can't easily read it; people still see it normally. -->
									<a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a>
								</li>
							<?php endif; ?>

						</ul>
					</address>
				</section>

				<?php
				// Only show Follow if at least one social link is filled in.
				if ( $social_links ) :
					?>
					<section class="footer-social" aria-labelledby="footer-social-heading">
						<h2 id="footer-social-heading" class="footer-heading">Follow</h2>
						<ul class="social-list">
							<?php foreach ( $social_links as $slug => $link ) : ?>
								<li>
									<!-- The icon is the only thing in the link, so the aria-label
									     gives it a name for screen readers ("Cheremosh on Facebook").
									     target="_blank" opens a new tab; rel="noopener" is a security
									     best practice for links that do that. -->
									<a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener" aria-label="Cheremosh on <?php echo esc_attr( $link['name'] ); ?> (opens in a new tab)">
										<img src="<?php echo esc_url( $icons . $slug . '.svg' ); ?>" alt="" width="32" height="32">
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</section>
				<?php endif; ?>

			</div>
		</div>

		<!-- BOTTOM: legal links and copyright. -->
		<div class="footer-bottom">
			<nav class="footer-legal" aria-label="Legal">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'legal',      // Matches 'legal' in inc/setup.php.
						'menu_id'        => 'legal-menu',
						'container'      => false,
						'fallback_cb'    => false,
						'depth'          => 1,
					)
				);
				?>
			</nav>

			<!-- Copyright. date( 'Y' ) keeps the year current automatically. -->
			<p class="site-info">
				&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.
			</p>
		</div>

	</footer>

	<?php
	// wp_footer() lets WordPress and plugins load scripts at the end of the page
	// (also draws the admin bar when logged in). Required.
	wp_footer();
	?>
</body>
</html>