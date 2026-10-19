<?php
/**
 * Dance With Us page: page content, then a list of all programs.
 */

get_header();
?>

<main id="main-content">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?>>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</article>
	<?php endwhile; ?>

	<?php
	$programs = new WP_Query(
		array(
			'post_type'      => 'programs',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);
	?>

	<?php if ( $programs->have_posts() ) : ?>
		<section class="programs-list">
			<h2>Our Programs</h2>
			<ul>
				<?php while ( $programs->have_posts() ) : $programs->the_post(); ?>
					<?php $age_range = get_the_term_list( get_the_ID(), 'age_range', '', ', ' ); ?>
					<li>
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

						<?php if ( $age_range && ! is_wp_error( $age_range ) ) : ?>
							<p>Ages: <?php echo wp_kses_post( $age_range ); ?></p>
						<?php endif; ?>

						<?php the_excerpt(); ?>
					</li>
				<?php endwhile; ?>
			</ul>
		</section>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>
</main>

<?php
get_footer();