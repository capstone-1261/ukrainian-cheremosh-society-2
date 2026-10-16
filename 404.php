<?php
/**
 * Page not found (404) template.
 */
get_header();
?>

<main id="main-content">
	<h1>Page not found</h1>
	<p>Sorry, we couldn't find that page. It may have moved or no longer exists.</p>
	<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Go back to the homepage</a></p>
</main>

<?php
get_footer();