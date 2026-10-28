<?php
/**
 * Site footer
 *
 * Loaded on every page by get_footer().
 * Contains: footer navigation, social links, copyright, and wp_footer().
 * Structure only: no styling yet.
 * Social links are placeholders until Bohdan confirms them.
 */
?>

	<!-- <footer> is a landmark: screen readers can jump straight to it. -->
	<footer class="site-footer">

		<!-- Footer navigation (FAQ, Studio Space & Rental, About, Contact).
		     aria-label "Footer" so screen readers can tell it apart from the main menu. -->
		<nav class="footer-navigation" aria-label="Footer">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',      // Matches 'footer' in inc/setup.php.
					'menu_id'        => 'footer-menu', // id on the <ul>, for CSS later.
					'container'      => false,         // No extra <div>; the <nav> is enough.
					'fallback_cb'    => false,         // Show nothing if no menu is assigned.
					'depth'          => 1,             // Top-level links only, no dropdowns in the footer.
				)
			);
			?>
		</nav>

		<!-- Social links. The aria-label says where each link goes, for screen readers.
		     href="#" is a placeholder until we get the real URLs. -->
		<section class="footer-social" aria-labelledby="footer-social-heading">
			<h2 id="footer-social-heading">Follow Us</h2>
			<ul>
				<li><a href="#" aria-label="Cheremosh on Facebook">Facebook</a></li>
				<li><a href="#" aria-label="Cheremosh on Instagram">Instagram</a></li>
				<li><a href="#" aria-label="Cheremosh on YouTube">YouTube</a></li>
			</ul>
		</section>

		<!-- Copyright. date('Y') keeps the year current automatically. -->
		<p class="site-info">
			&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.
		</p>

	</footer>

	<?php
	// wp_footer() lets WordPress and plugins load scripts at the end of the page
	// (also draws the admin bar when logged in). Required.
	wp_footer();
	?>
</body>
</html>