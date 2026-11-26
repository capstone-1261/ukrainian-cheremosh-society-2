<?php
/**
 * Events page template
 *
 * WordPress uses this file for the page with the slug "events"
 * (page-{slug}.php). It shows:
 *   1. A banner (same layout as the About page banner).
 *   2. One big "featured" event card.
 *   3. A grid of the other upcoming events.
 * Events come from the Events post type (inc/content-types.php).
 */

get_header(); // Loads header.php (skip link, announcement bar, logo, main menu).

/**
 * Prints one date as the parts the design uses.
 *
 * Event dates are stored as Y-m-d (e.g. 2027-01-23). DateTime turns that
 * into whatever format a card needs ("Sat", "23", "Jan 2027", ...).
 *
 * @param string $ymd The stored date.
 * @return DateTime|null Null if the event has no valid date.
 */
function cheremosh_event_date( $ymd ) {
	$date = DateTime::createFromFormat( 'Y-m-d', (string) $ymd );
	return $date ? $date : null;
}

// Today's date in the same Y-m-d format, so we can hide events that are over.
$events_today = current_time( 'Y-m-d' );

// The "RSVP Now" button: logged-in people go to the event page, everyone else
// goes to the Login page first (the design shows RSVP only needing a login).
$events_login_url = home_url( '/log-in/' );?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<!--
		1. BANNER
		Reuses the .about-hero classes. The photo is this page's Featured
		image, set in the page editor. The description is placeholder text
		from the design until the client sends real copy.
	-->
	<section class="about-hero">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'full', array( 'class' => 'about-hero-image', 'alt' => '' ) ); ?>
		<?php endif; ?>

		<div class="about-hero-text">
			<p class="about-hero-tagline">Events</p>
			<h1 class="about-hero-title about-hero-title--wide">Events</h1>
			<div class="about-hero-bottom">
				<p class="about-hero-description">Lorem ipsum dolor sit amet consectetur. Lectus eget quam lobortis tincidunt scelerisque egestas sit. Tellus tempor amet mus donec enim ipsum mi ut. Eget morbi consequat tincidunt in integer arcu.</p>
			</div>
		</div>
	</section>

	<?php
	/*
	 * 2. THE FEATURED EVENT
	 * The soonest upcoming event that has "Featured Event" ticked.
	 * meta_query = only events that are ticked AND not in the past.
	 * orderby meta_value + meta_key = sort by the event date, soonest first.
	 */
	$featured_query = new WP_Query( array(
		'post_type'      => 'events',
		'posts_per_page' => 1,
		'meta_key'       => 'event_date',
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'meta_query'     => array(
			'relation' => 'AND',
			array(
				'key'   => 'event_featured',
				'value' => '1',
			),
			array(
				'key'     => 'event_date',
				'value'   => $events_today,
				'compare' => '>=',
				'type'    => 'DATE',
			),
		),
	) );

	// Remember its ID so the grid below doesn't show it twice.
	$featured_id = 0;
	?>

	<section class="events-list" aria-label="Upcoming events">
		<div class="events-list-inner">

			<?php if ( $featured_query->have_posts() ) : ?>
				<?php while ( $featured_query->have_posts() ) : $featured_query->the_post(); ?>
					<?php
					$featured_id = get_the_ID();
					$ev_date     = cheremosh_event_date( get_field( 'event_date' ) );
					$ev_start    = get_field( 'event_start_time' );
					$ev_end      = get_field( 'event_end_time' );
					$ev_place    = get_field( 'event_location' );
					$ev_feature  = get_field( 'event_featuring' );
					$ev_terms    = get_the_terms( get_the_ID(), 'event_category' );
					$ev_category = ( $ev_terms && ! is_wp_error( $ev_terms ) ) ? $ev_terms[0]->name : '';
					?>
					<article class="event-feature">

						<!-- Left half: the photo with the date badge on top. -->
						<div class="event-feature-media">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'large', array( 'class' => 'event-feature-image', 'alt' => '' ) ); ?>
							<?php endif; ?>
							<?php if ( $ev_date ) : ?>
								<div class="event-badge" aria-hidden="true">
									<span class="event-badge-day"><?php echo esc_html( $ev_date->format( 'D' ) ); ?></span>
									<span class="event-badge-number"><?php echo esc_html( $ev_date->format( 'j' ) ); ?></span>
									<span class="event-badge-month"><?php echo esc_html( $ev_date->format( 'M Y' ) ); ?></span>
								</div>
							<?php endif; ?>
						</div>

						<!-- Right half: all the details. -->
						<div class="event-feature-body">
							<div class="event-eyebrow">
								<span class="event-tag-featured">Featured</span>
								<?php if ( $ev_category ) : ?>
									<span class="event-eyebrow-category"><?php echo esc_html( $ev_category ); ?></span>
								<?php endif; ?>
							</div>

							<h2 class="event-feature-title"><?php the_title(); ?></h2>
							<span class="about-rule" aria-hidden="true"></span>

							<ul class="event-details">
								<?php if ( $ev_date ) : ?>
									<li><?php echo esc_html( $ev_date->format( 'l, F j, Y' ) ); ?></li>
								<?php endif; ?>
								<?php if ( $ev_start ) : ?>
									<li><?php echo esc_html( $ev_start ); ?><?php echo $ev_end ? ' – ' . esc_html( $ev_end ) : ''; ?></li>
								<?php endif; ?>
								<?php if ( $ev_place ) : ?>
									<li><?php echo esc_html( $ev_place ); ?></li>
								<?php endif; ?>
							</ul>

							<?php if ( $ev_feature ) : ?>
								<p class="event-featuring"><strong>Featuring</strong> <?php echo esc_html( $ev_feature ); ?></p>
							<?php endif; ?>

							<?php if ( has_excerpt() ) : ?>
								<p class="event-feature-text"><?php echo esc_html( get_the_excerpt() ); ?></p>
							<?php endif; ?>

							<div class="event-actions">
								<a class="button event-rsvp" href="<?php echo esc_url( is_user_logged_in() ? get_permalink() : $events_login_url ); ?>">RSVP Now</a>
								<a class="button" href="<?php the_permalink(); ?>">Event Details</a>
							</div>
						</div>
					</article>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); // Hands the page back to WordPress. ?>
			<?php endif; ?>

			<?php
			/*
			 * 3. THE OTHER UPCOMING EVENTS
			 * Every upcoming event except the featured one (post__not_in),
			 * soonest first. Six per page for now.
			 */
			$grid_query = new WP_Query( array(
				'post_type'      => 'events',
				'posts_per_page' => 6,
				'post__not_in'   => array( $featured_id ),
				'meta_key'       => 'event_date',
				'orderby'        => 'meta_value',
				'order'          => 'ASC',
				'meta_query'     => array(
					array(
						'key'     => 'event_date',
						'value'   => $events_today,
						'compare' => '>=',
						'type'    => 'DATE',
					),
				),
			) );
			?>

			<?php if ( $grid_query->have_posts() ) : ?>
				<div class="events-grid-wrap">
					<h2 class="events-grid-heading">Upcoming Events</h2>

					<div class="events-grid">
						<?php while ( $grid_query->have_posts() ) : $grid_query->the_post(); ?>
							<?php
							$ev_date     = cheremosh_event_date( get_field( 'event_date' ) );
							$ev_place    = get_field( 'event_location' );
							$ev_terms    = get_the_terms( get_the_ID(), 'event_category' );
							$ev_category = ( $ev_terms && ! is_wp_error( $ev_terms ) ) ? $ev_terms[0]->name : '';
							?>
							<article class="event-card">
								<div class="event-card-media">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'medium_large', array( 'class' => 'event-card-image', 'alt' => '' ) ); ?>
									<?php endif; ?>
									<?php if ( $ev_category ) : ?>
										<span class="event-card-tag"><?php echo esc_html( $ev_category ); ?></span>
									<?php endif; ?>
								</div>

								<div class="event-card-body">
									<p class="event-card-meta">
										<?php if ( $ev_date ) : ?>
											<span><?php echo esc_html( $ev_date->format( 'D d M Y' ) ); ?></span>
										<?php endif; ?>
										<?php if ( $ev_place ) : ?>
											<span><?php echo esc_html( $ev_place ); ?></span>
										<?php endif; ?>
									</p>
									<h3 class="event-card-title"><?php the_title(); ?></h3>
									<?php if ( has_excerpt() ) : ?>
										<p class="event-card-text"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
									<?php endif; ?>
									<!-- aria-label tells screen readers which event the button is for. -->
									<a class="button" href="<?php the_permalink(); ?>" aria-label="View event: <?php the_title_attribute(); ?>">View Event</a>
								</div>
							</article>
						<?php endwhile; ?>
					</div>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>

			<?php if ( ! $featured_id && ! $grid_query->have_posts() ) : ?>
				<!-- Shown when there are no upcoming events at all. -->
				<p class="events-empty">There are no upcoming events right now. Please check back soon.</p>
			<?php endif; ?>

		</div>
	</section>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright, wp_footer()).