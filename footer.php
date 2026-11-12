<?php
/**
 * Site footer
 *
 * Loaded on every page by get_footer().
 * Layout (from Daina's design):
 *   Left:   Website Map (Footer Menu)
 *   Middle: Society name + logo + newsletter signup
 *   Right:  Contact details + Follow (social links)
 *   Bottom: Legal Menu (Privacy, Terms, Cookies, Refunds) + copyright
 *
 * Contact details, social links and the newsletter address all come from
 * Appearance > Customize > "Footer: contact and social" (inc/customizer.php),
 * so the client can change them without code.
 */

// Path to our icon files, used a few times below.
// get_template_directory_uri() = the URL of this theme's folder.
$icons = get_template_directory_uri() . '/assets/icons/';

// Contact details from the Customizer. get_theme_mod( 'name' ) reads a saved setting.
$address = get_theme_mod( 'cheremosh_contact_address', '4005 115 Avenue NW, Edmonton, AB T5W 0V5' );
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

// The Mailchimp signup address. Empty = hide the whole newsletter section.
$newsletter_url = get_theme_mod( 'cheremosh_newsletter_url' );

/*
 * Mailchimp's bot trap ("honeypot").
 *
 * Mailchimp expects one extra text field, named b_{account}_{list}, that real
 * people never see. Bots fill in every field they find, so anything arriving
 * with that box filled in gets rejected as spam.
 *
 * Rather than hard-coding the name, we read the account (u) and list (id)
 * straight out of the signup address, so this keeps working if the client
 * ever pastes in a different Mailchimp form.
 */
$honeypot_name = '';
if ( $newsletter_url ) {
	$query_string = wp_parse_url( $newsletter_url, PHP_URL_QUERY ); // The part after the "?".
	$query_parts  = array();
	if ( $query_string ) {
		wp_parse_str( $query_string, $query_parts ); // Turns "u=123&id=456" into an array.
	}
	if ( ! empty( $query_parts['u'] ) && ! empty( $query_parts['id'] ) ) {
		$honeypot_name = 'b_' . $query_parts['u'] . '_' . $query_parts['id'];
	}
}
?>

	<!-- <footer> is a landmark: screen readers can jump straight to it. -->
	<footer class="site-footer">

		<!-- The three columns. CSS places them side by side (stacked on phones). -->
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

			<!-- MIDDLE: Society name, logo and newsletter signup. -->
			<div class="footer-brand">

				<!-- Plain text, not a heading: it's a name, not the start of a section. -->
				<p class="footer-name">Ukrainian Cheremosh Society</p>

				<!-- Logo links home. alt is empty because the name is already
				     right above it; the aria-label says where the link goes. -->
				<a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Cheremosh home">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.svg' ); ?>" alt="" width="260" loading="lazy">
				</a>

				<?php
				// Newsletter signup. Only shows once a Mailchimp address is saved.
				if ( $newsletter_url ) :
					?>
					<section class="footer-newsletter" aria-labelledby="footer-newsletter-heading">
						<h2 id="footer-newsletter-heading" class="footer-heading">Newsletter</h2>

						<p class="newsletter-intro">Get performance announcements, registration dates, and festival news delivered to your inbox.</p>

						<?php
						/*
						 * This form posts straight to Mailchimp, not to our website:
						 * - action  = Cheremosh's Mailchimp signup address.
						 * - method  = "post", which is how Mailchimp expects the data.
						 * - target  = "_blank" so Mailchimp's thank-you page opens in a new
						 *             tab and the visitor doesn't lose their place on our site.
						 * - novalidate lets us keep the browser's own error wording
						 *             consistent rather than mixing two styles of message.
						 *
						 * No sign-up data is stored on this website at all.
						 */
						?>
						<form class="newsletter-form" action="<?php echo esc_url( $newsletter_url ); ?>" method="post" target="_blank" rel="noopener">

							<?php
							// A real <label> for the email box. It's hidden on screen (the
							// placeholder does that job visually) but read out by screen
							// readers, because a placeholder alone isn't an accessible name.
							?>
							<label class="screen-reader-text" for="newsletter-email">Your email address</label>

							<?php
							/*
							 * name="EMAIL" is required: that's the field name Mailchimp looks for.
							 * type="email" makes phones show the @ keyboard and lets the browser
							 * check the address looks valid before sending.
							 */
							?>
							<input
								class="newsletter-email"
								id="newsletter-email"
								type="email"
								name="EMAIL"
								placeholder="Enter your email"
								autocomplete="email"
								required>

							<?php
							// The bot trap from the top of this file. It sits inside a container
							// pushed off-screen, and aria-hidden plus tabindex="-1" keep screen
							// readers and the Tab key away from it.
							if ( $honeypot_name ) :
								?>
								<div class="newsletter-honeypot" aria-hidden="true">
									<input type="text" name="<?php echo esc_attr( $honeypot_name ); ?>" tabindex="-1" value="" autocomplete="off">
								</div>
							<?php endif; ?>

							<button class="newsletter-submit" type="submit">Subscribe</button>
						</form>

						<!-- Consent line. The Privacy Policy link uses the page's slug so it
						     keeps working if the site ever moves to a different address. -->
						<p class="newsletter-consent">
							By subscribing you agree to our
							<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a>
							and consent to receive updates from the Ukrainian Cheremosh Society.
						</p>
					</section>
				<?php endif; ?>

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