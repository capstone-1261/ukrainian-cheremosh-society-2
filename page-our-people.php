<?php
/**
 * Our People page template
 *
 * WordPress uses this file for the page with the slug "our-people"
 * (page-{slug}.php). It shows the page's own content, then three sections:
 * Artistic Director, Instructors and Board.
 *
 * Each card shows: photo, name, a short bio preview and a Learn More button.
 * Structure only: no styling yet.
 */

get_header(); // Loads header.php (skip link, site name, main menu).
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<?php
	// The page's own content (the intro text typed into the editor).
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class(); ?>>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</article>
	<?php endwhile; ?>

	<?php
	// The three sections, in the order they appear on the page.
	// 'role' is the slug from People → Roles. Instructors don't use a role.
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
		// Build the query for this section: all posts of this type, A to Z.
		$args = array(
			'post_type'      => $section['post_type'],
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		);

		// Only show people with this role (e.g. just the Board).
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

		<?php
		// Skip the whole section (heading too) if nobody is in it yet.
		if ( $people->have_posts() ) :
			?>
			<section class="people-section">
				<h2><?php echo esc_html( $section['heading'] ); ?></h2>
				<ul>
					<?php
					while ( $people->have_posts() ) :
						$people->the_post();

						// ACF fields from Sam's "Info" group (photo URL and bio text).
						$photo = function_exists( 'get_field' ) ? get_field( 'photo' ) : '';
						$bio   = function_exists( 'get_field' ) ? get_field( 'bio' ) : '';
						?>
						<li>
							<?php
							// Photo: ACF photo first, featured image as a fallback.
							if ( $photo ) :
								?>
								<img src="<?php echo esc_url( $photo ); ?>" alt="<?php the_title_attribute(); ?>">
							<?php elseif ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium' ); ?>
							<?php endif; ?>

							<!-- Name as plain text (the Learn More button is the link). -->
							<h3><?php the_title(); ?></h3>

							<?php
							// Short preview: first 25 words of the Bio field.
							// If there's no bio yet, use the normal excerpt instead.
							if ( $bio ) :
								?>
								<p><?php echo esc_html( wp_trim_words( $bio, 25 ) ); ?></p>
							<?php else : ?>
								<?php the_excerpt(); ?>
							<?php endif; ?>

							<!-- aria-label tells screen readers whose page this goes to. -->
							<a class="button" href="<?php the_permalink(); ?>" aria-label="Learn more about <?php the_title_attribute(); ?>">Learn More</a>
						</li>
					<?php endwhile; ?>
				</ul>
			</section>
			<?php
			// Reset so WordPress goes back to the main page after our custom query.
			wp_reset_postdata();
			?>
		<?php endif; ?>
	<?php endforeach; ?>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, copyright, wp_footer()).