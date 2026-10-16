<?php
/**
 * Homepage template. Content is built in the block editor using our patterns.
 */
get_header();
?>

<main id="main-content">
	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>
</main>

<?php
get_footer();