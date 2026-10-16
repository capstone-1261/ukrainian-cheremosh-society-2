<?php
/**
 * Main template file. Fallback for every page that doesn't have its own template.
 */
get_header();
?>

<main id="main-content">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class(); ?>>
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</article>
			<?php
		endwhile;
	else :
		?>
		<p>No content found.</p>
	<?php endif; ?>
</main>

<?php
get_footer();