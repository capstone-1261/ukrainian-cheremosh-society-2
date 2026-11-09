<?php
/**
 * Default page template
 *
 * WordPress uses this file for any regular page that doesn't have its
 * own template (e.g. About, FAQ, Contact, Privacy Policy).
 * Pages with their own file (page-our-people.php, page-dance-with-us.php)
 * or the homepage (front-page.php) skip this one.
 *
 * Shows: the page title and whatever is built in the block editor.
 * Structure only: styling comes later.
 */

get_header(); // Loads header.php (skip link, announcement bar, logo, main menu).
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<?php
	// The Loop: on a single page this runs once, for the page being viewed.
	while ( have_posts() ) :
		the_post();
		?>

		<!-- post_class() adds helpful classes (e.g. page, page-id-12) for CSS later. -->
		<article <?php post_class(); ?>>

			<!-- Page title. Only H1 on the page. -->
			<h1><?php the_title(); ?></h1>

			<?php
			// Everything built in the block editor for this page.
			the_content();
			?>

		</article>

	<?php endwhile; ?>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright, wp_footer()).