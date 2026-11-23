<?php
/**
 * Faculty & Instructors page template
 *
 * WordPress uses this file automatically for the page whose slug is
 * "sod-instructors" (the page-{slug}.php naming rule, same as
 * page-our-people.php).
 *
 * Layout (from Daina's design):
 *   1. Hero banner   — "Meet Our Instructors" over a photo.
 *   2. One row per instructor — photo on one side, text on the other,
 *                       flipping sides on every second row.
 *   3. Call to action — "Ready to start dancing?" with a View Programs button.
 *
 * Instructors are the "instructors" post type (Sam's setup in
 * inc/content-types.php). Each one has a photo and a bio (ACF fields).
 * Styling lives in assets/css/main.css.
 *
 * @package cheremosh-theme
 */

get_header(); // Loads header.php (skip link, announcement bar, menu).
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<!--
		1. HERO BANNER
		The page title is the only H1 on the page. The photo is the page's
		featured image, so the client can swap it in the editor without
		touching code. If no featured image is set, the banner just shows
		the title.
	-->
	<section class="instructors-hero">
		<?php if ( has_post_thumbnail() ) : ?>
			<!-- alt="" because the photo is decoration; the title already says what the page is. -->
			<?php the_post_thumbnail( 'large', array( 'class' => 'instructors-hero-image', 'alt' => '' ) ); ?>
		<?php endif; ?>

		<!-- Tagline and title sit together in one wrapper so they stack on the left, like the design. -->
		<div class="instructors-hero-text">
			<p class="instructors-hero-tagline">Instructors</p>
			<h1 class="instructors-hero-title">Meet our Instructors</h1>
		</div>	</section>

	<?php
	// 2. THE INSTRUCTOR ROWS
	// A WP_Query is a way of asking WordPress for a list of posts.
	// Here: every post in the "instructors" post type, A to Z by title.
	$instructors = new WP_Query(
		array(
			'post_type'      => 'instructors',
			'posts_per_page' => -1,      // -1 means "all of them"; the list is small.
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);

	$row = 0; // Counts the rows so we can flip every second one.

	if ( $instructors->have_posts() ) :
		while ( $instructors->have_posts() ) :
			$instructors->the_post();

			// ACF fields from the "Info" group.
			$photo = function_exists( 'get_field' ) ? get_field( 'photo' ) : ''; // Image URL.
			$bio   = function_exists( 'get_field' ) ? get_field( 'bio' ) : '';   // Plain text.

			// The bio starts with a line like "Instructing: Chobitok, and Ballet",
			// then the real bio paragraphs. Split it so the two can be shown separately.
			$teaches = '';
			$summary = '';
			if ( $bio ) {
				// preg_split cuts the text wherever there's a blank line.
				$parts = preg_split( '/\R\s*\R/', trim( $bio ) );

				// If the first chunk starts with "Instructing:", pull it out.
				if ( 0 === strpos( $parts[0], 'Instructing:' ) ) {
					$teaches = array_shift( $parts );
				}

				// wp_trim_words() shortens the rest to about 45 words and adds "…".
				$summary = wp_trim_words( implode( ' ', $parts ), 45, '…' );
			}

			// The small label above the name. Uses the Role term (e.g. Instructor)
			// when one is set, and falls back to the word "Instructor".
			$terms = get_the_terms( get_the_ID(), 'role' );
			$label = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : 'Instructor';

			// Every second row gets an extra class so the CSS can flip it.
			// $row % 2 is the remainder after dividing by 2: 0, 1, 0, 1...
			$flip = ( 1 === $row % 2 ) ? ' is-reversed' : '';
			?>

			<article class="instructor-row<?php echo esc_attr( $flip ); ?>">

				<div class="instructor-row-text">
					<p class="instructor-row-label"><?php echo esc_html( $label ); ?></p>
					<h2 class="instructor-row-name"><?php the_title(); ?></h2>

					<?php if ( $teaches ) : ?>
						<p class="instructor-row-teaches"><?php echo esc_html( $teaches ); ?></p>
					<?php endif; ?>

					<?php if ( $summary ) : ?>
						<p class="instructor-row-bio"><?php echo esc_html( $summary ); ?></p>
					<?php endif; ?>

					<!-- Full bio lives on the instructor's own page. aria-label says whose. -->
					<a class="instructor-row-link" href="<?php the_permalink(); ?>" aria-label="Read more about <?php the_title_attribute(); ?>">Read more</a>
				</div>

				<?php if ( $photo ) : ?>
					<!-- Photo. loading="lazy" waits to load it until it's near the screen. -->
					<img class="instructor-row-photo" src="<?php echo esc_url( $photo ); ?>" alt="<?php the_title_attribute(); ?>" width="400" loading="lazy">
				<?php elseif ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'medium_large', array( 'class' => 'instructor-row-photo', 'loading' => 'lazy' ) ); ?>
				<?php endif; ?>

			</article>

			<?php
			$row++; // Next instructor is the next row.
		endwhile;

		// Puts WordPress back to the page itself after our custom query.
		wp_reset_postdata();
	endif;
	?>

	<!--
		3. CALL TO ACTION
		Links to Dance with Us, where all the programs are listed.
	-->
	<section class="instructors-cta">
		<p class="instructor-row-label">Programs</p>
		<h2 class="instructors-cta-title">Ready to start dancing?</h2>
		<a class="button" href="<?php echo esc_url( home_url( '/dance-with-us/' ) ); ?>">View Programs</a>
	</section>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright).