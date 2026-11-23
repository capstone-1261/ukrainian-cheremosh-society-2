<?php
/**
 * Our People page template
 *
 * WordPress uses this file for the page with the slug "our-people"
 * (page-{slug}.php).
 *
 * The design gives each group its own layout, so this file renders them
 * separately rather than looping one card design:
 *
 *   Banner            — "Meet Our Team" / page title over the Featured image.
 *   Leadership band   — Artistic Director, Founders and Festival Director on a gradient.
 *   Instructors       — a row of landscape photos with a name bar under each.
 *   Board             — a grid of cards: photo, name, short bio.
 *   Hiring strip      — thin red bar at the bottom with an Open Positions button.
 *
 * Fields come from Sam's ACF "Info" group: photo (image URL), bio (text).
 * There is no job-title or social-link field yet, so real Board cards leave
 * those out for now (only the grey placeholder cards show them).
 *
 * @package cheremosh-theme
 */

get_header(); // Loads header.php (skip link, announcement bar, menu).

/**
 * Fetch people for a section.
 *
 * Wrapped in a function so the sections below each read as one line
 * instead of repeating the same twenty lines of WP_Query arguments.
 *
 * @param string $post_type 'people' or 'instructors'.
 * @param string $role      A slug from the People > Roles taxonomy, or ''.
 * @return WP_Query
 */
function cheremosh_get_people( $post_type, $role = '' ) {
	$args = array(
		'post_type'      => $post_type,
		'posts_per_page' => -1,   // No paging; these lists are small.
		'orderby'        => 'title',
		'order'          => 'ASC',
	);

	// Narrow to one role (e.g. just the Board) when a slug is given.
	if ( $role ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'role',
				'field'    => 'slug',
				'terms'    => $role,
			),
		);
	}

	return new WP_Query( $args );
}

/**
 * The photo for a person, as an <img> tag.
 *
 * Prefers the ACF photo field and falls back to the featured image, so a
 * person entered either way still shows a picture.
 *
 * @param string $class CSS class for the image.
 * @param int    $width Width attribute, in pixels.
 * @return string The <img> markup, or '' when there is no photo.
 */
function cheremosh_person_photo( $class, $width ) {
	$photo = function_exists( 'get_field' ) ? get_field( 'photo' ) : '';

	if ( $photo ) {
		return sprintf(
			'<img class="%1$s" src="%2$s" alt="%3$s" width="%4$d" loading="lazy">',
			esc_attr( $class ),
			esc_url( $photo ),
			esc_attr( get_the_title() ),
			absint( $width )
		);
	}

	if ( has_post_thumbnail() ) {
		return get_the_post_thumbnail(
			get_the_ID(),
			'medium',
			array(
				'class'   => $class,
				'loading' => 'lazy',
			)
		);
	}

	return ''; // No photo: the layouts below cope with it being absent.
}
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<?php
	/*
	 * BANNER
	 * Same look as the Faculty page banner, so it reuses those classes
	 * (.instructors-hero...). The photo is this page's Featured image, set
	 * in the editor. The page title is the only H1 on the page.
	 */
	while ( have_posts() ) :
		the_post();
		?>
		<section class="instructors-hero">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'large', array( 'class' => 'instructors-hero-image', 'alt' => '' ) ); ?>
			<?php endif; ?>

			<div class="instructors-hero-text">
				<p class="instructors-hero-tagline">Meet Our Team</p>
				<h1 class="instructors-hero-title"><?php the_title(); ?></h1>
			</div>
		</section>
	<?php endwhile; ?>


	<?php /* ============================================================
	       LEADERSHIP BAND

	       One band with the dark-to-maroon gradient from the design.
	       Inside it: the Artistic Director card, the Founders card and
	       the Festival Director.
	       The cards reuse the About page's classes (.about-director...).
	       ============================================================ */ ?>

	<section class="people-leadership">
		<div class="people-leadership-inner">

			<?php $director = cheremosh_get_people( 'people', 'artistic-director' ); ?>

			<?php while ( $director->have_posts() ) : $director->the_post(); ?>
				<?php
				// Photo: the ACF "photo" field (a URL) first, then the featured image.
				$people_photo = function_exists( 'get_field' ) ? get_field( 'photo' ) : '';
				?>
				<article class="about-director">

					<?php if ( $people_photo ) : ?>
						<img class="about-director-photo" src="<?php echo esc_url( $people_photo ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy">
					<?php elseif ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'class' => 'about-director-photo', 'loading' => 'lazy' ) ); ?>
					<?php endif; ?>

					<div class="about-director-text">
						<p class="about-label">Artistic Director</p>
						<h2 class="about-leadership-name"><?php the_title(); ?></h2>
						<span class="about-rule" aria-hidden="true"></span>

						<!-- Wording from the design (same as the About page). -->
						<p>The first Artistic Director outside of Ukraine to be inducted into the Order of Pavlo Virsky, and named one of the Top 25 Most Influential Artists in Alberta by the Alberta Foundation for the Arts.</p>

						<blockquote class="about-pullquote">
							<p>“Patterns as intricate as the best Ukrainian embroidery.”</p>
							<cite>Ann Alexander, on Kanevets’ choreography</cite>
						</blockquote>

						<a class="button" href="<?php the_permalink(); ?>">Meet Mykola</a>
					</div>

				</article>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); // Hands the page back to WordPress. ?>

			<!-- OUR FOUNDERS: text on the left, photo on the right. Reuses the
			     About page's founders classes. Wording is from the design. -->
			<article class="about-founders">
				<div class="about-founders-text">
					<p class="about-label">Our Founders</p>
					<h2 class="about-leadership-name">Chester &amp; Luba Kuc</h2>
					<span class="about-rule" aria-hidden="true"></span>
					<p>As Cheremosh’s first Artistic Director, Chester Kuc set out to modernize Ukrainian folk dance — bringing its stories to the stage in ways that were dramatic and effective, and helping Ukrainian culture flourish in Canada. Together with Luba, he built the company that still carries their vision forward.</p>
				</div>

				<img
					class="about-founders-photo"
					src="<?php echo esc_url( get_theme_file_uri( 'assets/images/about-founders.png' ) ); ?>"
					alt="Chester and Luba Kuc, founders of Cheremosh"
					width="960"
					height="920"
					loading="lazy"
				>
			</article>

			<!-- FESTIVAL DIRECTOR: portrait on the left, role and name on the right.
			     Hard-coded for now (there's no People entry for her yet). -->
			<article class="people-festival">
				<img
					class="people-festival-photo"
					src="<?php echo esc_url( get_theme_file_uri( 'assets/images/people-festival-director.jpg' ) ); ?>"
					alt="Samantha Aloisio, Festival Director"
					width="686"
					height="1120"
					loading="lazy"
				>

				<div class="people-festival-text">
					<p class="about-label">Festival Director</p>
					<h2 class="about-leadership-name">Samantha Aloisio</h2>
					<span class="about-rule" aria-hidden="true"></span>
				</div>
			</article>

		</div>
	</section>


	<?php /* ============================================================
	       INSTRUCTORS

	       A deep-red band: heading on the left, a short intro on the
	       right, then a row of photo cards (one per Instructor entry).
	       The whole card is the link. "Instructors" button goes to the
	       Faculty & Instructors page.
	       ============================================================ */ ?>

	<section class="people-band">
		<div class="people-band-inner">

			<div class="people-band-header">
				<div>
					<p class="about-label">Instructors</p>
					<h2 class="people-band-title">Meet Our Instructors</h2>
					<span class="about-rule" aria-hidden="true"></span>
				</div>

				<!-- Wording from the design. -->
				<p class="people-band-intro">The Cheremosh School of Dance has provided youth and children with the HIGHEST caliber of Ukrainian dance instruction since 1976. The programs are separated into TWO different streams across the Edmonton North Beverly Studio, and South Edmonton Studio.</p>
			</div>

			<?php $instructors = cheremosh_get_people( 'instructors' ); ?>

			<?php if ( $instructors->have_posts() ) : ?>
				<ul class="instructor-grid">
					<?php while ( $instructors->have_posts() ) : $instructors->the_post(); ?>
						<li class="instructor-tile">
							<?php
							/*
							 * The whole tile is one link wrapping photo and name,
							 * so there's a single large target rather than a small
							 * text link: easier to hit, and one stop for keyboard
							 * users instead of two.
							 */
							?>
							<a href="<?php the_permalink(); ?>">
								<?php echo cheremosh_person_photo( 'instructor-photo', 400 ); ?>
								<span class="instructor-name"><?php the_title(); ?></span>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>

			<div class="people-band-actions">
				<a class="button" href="<?php echo esc_url( home_url( '/sod-instructors/' ) ); ?>">Instructors</a>
			</div>

		</div>
	</section>


	<?php /* ============================================================
	       BOARD

	       Same deep-red band as the Instructors. A grid of cards: photo,
	       name, short bio.

	       PLACEHOLDERS: the design shows 8 cards. Until the real board
	       members are entered (People > Role: Board), grey placeholder
	       cards fill the grid up to 8, as in the design.
	       >>> BEFORE HANDOVER: set $board_show_placeholders to false. <<<
	       ============================================================ */ ?>

	<?php
	$board_show_placeholders = true; // <-- Set to false before handover.

	$board              = cheremosh_get_people( 'people', 'board' );
	$board_placeholders = $board_show_placeholders ? max( 0, 8 - $board->post_count ) : 0;
	$board_icons        = get_theme_file_uri( 'assets/icons/' );
	?>

	<?php if ( $board->have_posts() || $board_placeholders > 0 ) : ?>
		<section class="people-band people-band--board">
			<div class="people-band-inner">

				<div>
					<p class="about-label">Board</p>
					<h2 class="people-band-title">Our Board</h2>
					<span class="about-rule" aria-hidden="true"></span>
				</div>

				<ul class="board-grid">

					<?php // Real board members from the People entries. ?>
					<?php while ( $board->have_posts() ) : $board->the_post(); ?>
						<li class="board-card">
							<?php echo cheremosh_person_photo( 'board-photo', 300 ); ?>

							<h3 class="board-name"><?php the_title(); ?></h3>

							<?php $bio = function_exists( 'get_field' ) ? get_field( 'bio' ) : ''; ?>
							<?php if ( $bio ) : ?>
								<p class="board-bio"><?php echo esc_html( wp_trim_words( $bio, 25 ) ); ?></p>
							<?php endif; ?>

							<a class="board-link" href="<?php the_permalink(); ?>"
							   aria-label="Learn more about <?php the_title_attribute(); ?>">Learn More</a>
						</li>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>

					<?php // Grey placeholder cards, copied from the design. ?>
					<?php for ( $i = 0; $i < $board_placeholders; $i++ ) : ?>
						<li class="board-card board-card--placeholder">
							<div class="board-photo board-photo--placeholder" aria-hidden="true"></div>
							<h3 class="board-name">Full name</h3>
							<p class="board-job">Job title</p>
							<p class="board-bio">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.</p>
							<span class="board-social" aria-hidden="true">
								<img src="<?php echo esc_url( $board_icons . 'linkedin.svg' ); ?>" alt="" width="20" height="20">
								<img src="<?php echo esc_url( $board_icons . 'x.svg' ); ?>" alt="" width="20" height="20">
								<img src="<?php echo esc_url( $board_icons . 'website.svg' ); ?>" alt="" width="20" height="20">
							</span>
						</li>
					<?php endfor; ?>

				</ul>

			</div>
		</section>
	<?php endif; ?>


	<?php /* ============================================================
	       WE'RE HIRING STRIP

	       The thin red bar at the bottom, same look as the "Company
	       Dancer?" bar on the About page (it reuses those CSS classes).
	       The button goes to the Contact page for now, until we know
	       where open positions should link.
	       ============================================================ */ ?>

	<section class="about-dancer-strip">
		<div class="about-dancer-strip-inner">
			<div>
				<h2 class="about-dancer-title">We're Hiring!</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
			</div>
			<?php $hiring_page = get_page_by_path( 'contact' ); // Change this slug when the real positions page exists. ?>
			<a class="button about-dancer-button" href="<?php echo esc_url( $hiring_page ? get_permalink( $hiring_page ) : home_url( '/' ) ); ?>">Open Positions</a>
		</div>
	</section>

</main>

<?php
get_footer(); // Loads footer.php.