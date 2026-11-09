<?php
/**
 * Homepage template
 *
 * WordPress always uses front-page.php for the homepage, whichever page
 * is set as the homepage in Settings → Reading.
 *
 * There's no <h1> here on purpose: the homepage is built in the block
 * editor using our patterns, and the hero pattern (patterns/hero.php)
 * supplies the page's only H1.
 * Structure only: styling comes later.
 */

get_header(); // Loads header.php (skip link, announcement bar, logo, main menu).
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<?php
	// The Loop: runs once for the homepage and prints everything built
	// in the block editor (hero, programs, festival sections, etc.).
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright, wp_footer()).