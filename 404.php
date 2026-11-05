<?php
/**
 * 404 template (Page Not Found)
 *
 * WordPress uses this file automatically when someone visits a URL
 * that doesn't exist (a broken link, a typo, or an old page from the previous site).
 *
 * Shows: a clear message and links to the main pages so the visitor isn't stuck.
 * Structure only: no styling yet.
 */
get_header(); // Loads header.php (skip link, site name, main menu, Register button).
?>
<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<!-- Only H1 on the page. Plain language so everyone understands what happened. -->
	<h1>Page Not Found</h1>

	<p>Sorry, we couldn't find the page you were looking for. It may have moved, or the link may be broken.</p>

	<!-- Helpful links to the most visited pages.
	     home_url() builds the full link, so it works on local, dev, and live sites. -->
	<section aria-labelledby="popular-heading">
		<h2 id="popular-heading">Popular Pages</h2>
		<ul>
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
			<li><a href="<?php echo esc_url( home_url( '/dance-with-us/' ) ); ?>">Dance with Us</a></li>
			<li><a href="<?php echo esc_url( home_url( '/register/' ) ); ?>">Register</a></li>
			<li><a href="<?php echo esc_url( home_url( '/events/' ) ); ?>">Events</a></li>
			<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a></li>
		</ul>
	</section>

</main>
<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright, wp_footer()).