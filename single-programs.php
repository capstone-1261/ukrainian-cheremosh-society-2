<?php
/**
 * Single Program template
 *
 * WordPress uses this file automatically for any post in the "programs"
 * post type (single-{post_type}.php), e.g. Junior Dance or Mini Moshers.
 *
 * Shows: program name, description, schedule (days, time, season, ages),
 * the instructors who teach it, a Register button and a link back to
 * Dance with Us.
 * Structure only: styling comes later.
 */

get_header(); // Loads header.php (skip link, announcement bar, logo, main menu).
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<?php
	// The Loop: on a single page this runs once, for the program being viewed.
	while ( have_posts() ) :
		the_post();
		?>

		<article <?php post_class(); ?>>

			<!-- Program name (post title). Only H1 on the page. -->
			<h1><?php the_title(); ?></h1>

			<?php
			// The program description typed into the block editor.
			the_content();
			?>

			<?php
			// Everything below uses ACF fields (Sam's setup in inc/content-types.php).
			// function_exists() stops the page from crashing if ACF is ever turned off.
			if ( function_exists( 'get_field' ) ) :

				// Schedule fields.
				$days         = get_field( 'day_of_the_week' );      // Checkbox list, e.g. Monday, Wednesday.
				$start_time   = get_field( 'start_time' );           // e.g. 6:00 pm
				$end_time     = get_field( 'end_time' );             // e.g. 7:30 pm
				$season_start = get_field( 'date_of_season_start' ); // e.g. September 8, 2026
				$season_end   = get_field( 'date_of_season_end' );   // e.g. June 1, 2027

				// Instructors who teach this program.
				// This relationship is two-way: picking a program on an instructor's
				// post also adds that instructor here automatically (and vice versa).
				$instructors = get_field( 'related_instructor' );

				// The "age_range" taxonomy (e.g. 6-8 years) as a comma-separated list of links.
				$age_range = get_the_term_list( get_the_ID(), 'age_range', '', ', ' );
				?>

				<!-- Schedule. aria-labelledby ties the section to its heading for screen readers. -->
				<section class="program-schedule" aria-labelledby="program-schedule-heading">
					<h2 id="program-schedule-heading">Schedule</h2>

					<!-- A description list (dl): each dt is a label, each dd is its value. -->
					<dl>
						<?php if ( $days ) : ?>
							<dt>Days</dt>
							<!-- implode() joins the list of days with commas. -->
							<dd><?php echo esc_html( implode( ', ', $days ) ); ?></dd>
						<?php endif; ?>

						<?php
						// Only show the time if both start and end are filled in.
						if ( $start_time && $end_time ) :
							?>
							<dt>Time</dt>
							<dd><?php echo esc_html( $start_time . ' - ' . $end_time ); ?></dd>
						<?php endif; ?>

						<?php
						// Only show the season if both dates are filled in.
						if ( $season_start && $season_end ) :
							?>
							<dt>Season</dt>
							<dd><?php echo esc_html( $season_start . ' to ' . $season_end ); ?></dd>
						<?php endif; ?>

						<?php if ( $age_range && ! is_wp_error( $age_range ) ) : ?>
							<dt>Ages</dt>
							<!-- wp_kses_post() keeps the age range links but strips anything unsafe. -->
							<dd><?php echo wp_kses_post( $age_range ); ?></dd>
						<?php endif; ?>
					</dl>
				</section>

				<?php if ( $instructors ) : ?>
					<!-- Instructors who teach this program, linked to their own pages. -->
					<section class="program-instructors" aria-labelledby="program-instructors-heading">
						<h2 id="program-instructors-heading">Instructors</h2>
						<ul>
							<?php foreach ( $instructors as $instructor ) : ?>
								<li>
									<a href="<?php echo esc_url( get_permalink( $instructor ) ); ?>">
										<?php echo esc_html( get_the_title( $instructor ) ); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</section>
				<?php endif; ?>

			<?php endif; // End ACF check. ?>

			<!-- Register button. aria-label tells screen readers which program it's for.
			     This links to /register/ for now; it may change once the board
			     picks a registration system. -->
			<a class="button" href="<?php echo esc_url( home_url( '/register/' ) ); ?>" aria-label="Register for <?php the_title_attribute(); ?>">Register</a>

			<!-- Back link so visitors aren't stuck on a dead end. -->
			<p class="back-link">
				<a href="<?php echo esc_url( home_url( '/dance-with-us/' ) ); ?>">&larr; Back to Dance with Us</a>
			</p>

		</article>

	<?php endwhile; ?>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright, wp_footer()).