<?php
/**
 * Our People page: page content, then Artistic Director, Instructors and Board sections.
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
	// Each section: heading, post type, and (optional) role slug.
	$sections = array(
		array(
			'heading'   => 'Artistic Director',
			'post_type' => 'people',
			'role'      => 'artistic-director',
		),
		array(
			'heading'   => 'Instructors',
			'post_type' => 'instructors',
			'role'      => '',
		),
		array(
			'heading'   => 'Board',
			'post_type' => 'people',
			'role'      => 'board',
		),
	);
	?>

	<?php foreach ( $sections as $section ) : ?>
		<?php
		$args = array(
			'post_type'      => $section['post_type'],
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		);

		if ( $section['role'] ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'role',
					'field'    => 'slug',
					'terms'    => $section['role'],
				),
			);
		}

		$people = new WP_Query( $args );
		?>

		<?php if ( $people->have_posts() ) : ?>
			<section class="people-section">
				<h2><?php echo esc_html( $section['heading'] ); ?></h2>
				<ul>
					<?php while ( $people->have_posts() ) : $people->the_post(); ?>
						<?php $photo = function_exists( 'get_field' ) ? get_field( 'photo' ) : ''; ?>
						<li>
							<?php if ( $photo ) : ?>
								<img src="<?php echo esc_url( $photo ); ?>" alt="<?php the_title_attribute(); ?>">
							<?php elseif ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium' ); ?>
							<?php endif; ?>

							<h3><?php the_title(); ?></h3>

							<?php the_excerpt(); ?>

							<a class="button" href="<?php the_permalink(); ?>" aria-label="Learn more about <?php the_title_attribute(); ?>">Learn More</a>
						</li>
					<?php endwhile; ?>
				</ul>
			</section>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	<?php endforeach; ?>
</main>

<?php
get_footer();