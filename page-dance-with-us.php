<?php
/**
 * Dance with Us page template
 *
 * WordPress uses this file for the page with the slug "dance-with-us"
 * (page-{slug}.php). It shows the page's own content, then a list of
 * every program (A to Z) with its age range, a short description and a
 * Learn More button.
 * Structure only: styling comes later.
 */

get_header(); // Loads header.php (skip link, announcement bar, logo, main menu).
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<?php
	// The page's own content (the intro text typed into the editor).
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class(); ?>>
			<!-- Page title. Only H1 on the page. -->
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</article>
	<?php endwhile; ?>

	<?php
	// Custom query: get every program, sorted A to Z.
	// posts_per_page -1 means "no limit, show them all".
	$programs = new WP_Query(
		array(
			'post_type'      => 'programs',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);
	?>

	<?php
	// Only show the section (heading too) if there's at least one program.
	if ( $programs->have_posts() ) :
		?>
		<!-- aria-labelledby ties the section to its heading for screen readers. -->
		<section class="programs-list" aria-labelledby="programs-list-heading">
			<h2 id="programs-list-heading">Our Programs</h2>
			<ul>
				<?php
				while ( $programs->have_posts() ) :
					$programs->the_post();

					// The "age_range" taxonomy (e.g. 6-8 years) as a comma-separated list of links.
					$age_range = get_the_term_list( get_the_ID(), 'age_range', '', ', ' );
					?>
					<li>
						<!-- Program name as plain text (the Learn More button is the link). -->
						<h3><?php the_title(); ?></h3>

						<?php if ( $age_range && ! is_wp_error( $age_range ) ) : ?>
							<!-- wp_kses_post() keeps the age range links but strips anything unsafe. -->
							<p class="program-ages">Ages: <?php echo wp_kses_post( $age_range ); ?></p>
						<?php endif; ?>

						<?php
						// Short description: the program's excerpt
						// (or the first part of its content if no excerpt is set).
						the_excerpt();
						?>

						<!-- aria-label tells screen readers which program the button is for,
						     instead of hearing "Learn More" over and over. -->
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

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright, wp_footer()).