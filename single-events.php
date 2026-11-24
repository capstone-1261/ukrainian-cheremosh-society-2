<?php
/**
 * Single Event template
 *
 * WordPress uses this file by itself for any post in the "events" post
 * type (single-{post_type}.php). It's the page the "Event Details" and
 * "View Event" buttons on the Events page go to.
 *
 * Two sections: a photo hero (title, date, category, countdown, buttons)
 * and an About band (photo, description, details, buttons).
 */

get_header();

// Where the RSVP button goes. Logged out = our Log In page (looked up by
// slug, same as the header button). Logged in = down to the details for
// now, until we know how tickets/RSVP will work.
$event_login_page = get_page_by_path( 'log-in' );
$event_login_url  = $event_login_page ? get_permalink( $event_login_page ) : home_url( '/' );
$event_rsvp_url   = is_user_logged_in() ? '#event-details' : $event_login_url;
?>

<main id="main-content">

	<?php
	// The Loop. On a single page it runs once, for this event.
	while ( have_posts() ) :
		the_post();

		// ---- Event info (ACF fields from inc/content-types.php) ----
		$event_date_raw  = function_exists( 'get_field' ) ? get_field( 'event_date' ) : '';        // saved as Y-m-d, e.g. 2027-01-23
		$event_start     = function_exists( 'get_field' ) ? get_field( 'event_start_time' ) : '';  // e.g. 7:00 PM
		$event_end       = function_exists( 'get_field' ) ? get_field( 'event_end_time' ) : '';    // e.g. 10:00 PM
		$event_location  = function_exists( 'get_field' ) ? get_field( 'event_location' ) : '';
		$event_featuring = function_exists( 'get_field' ) ? get_field( 'event_featuring' ) : '';

		// Turn the saved date into a date object so we can format it ("Sat Jan 23 2027").
		$event_dt = $event_date_raw ? DateTime::createFromFormat( 'Y-m-d', $event_date_raw, wp_timezone() ) : false;

		// The moment the event starts (date + start time). The countdown counts down to this.
		$event_start_dt = false;
		if ( $event_dt ) {
			$event_start_dt = clone $event_dt;
			$event_start_dt->setTime( 0, 0 ); // Midnight if there's no start time.
			if ( $event_start ) {
				$parsed = date_parse( $event_start );
				if ( false !== $parsed['hour'] ) {
					$event_start_dt->setTime( (int) $parsed['hour'], (int) $parsed['minute'] );
				}
			}
		}

		// Time text like "7:00 PM - 10:00 PM".
		$event_time_text = '';
		if ( $event_start && $event_end ) {
			$event_time_text = $event_start . ' - ' . $event_end;
		} elseif ( $event_start ) {
			$event_time_text = $event_start;
		}

		// First category name, shown in the blue tag.
		$event_cats = get_the_terms( get_the_ID(), 'event_category' );
		$event_cat  = ( $event_cats && ! is_wp_error( $event_cats ) ) ? $event_cats[0]->name : '';

		// Google Calendar link for "Add to Calendar", built from the event info.
		$event_cal_url = '';
		if ( $event_start_dt ) {
			$cal_end = clone $event_start_dt;
			$cal_end->modify( '+2 hours' ); // Used if there's no end time.
			if ( $event_end ) {
				$parsed_end = date_parse( $event_end );
				if ( false !== $parsed_end['hour'] ) {
					$cal_end = clone $event_start_dt;
					$cal_end->setTime( (int) $parsed_end['hour'], (int) $parsed_end['minute'] );
				}
			}
			$event_cal_url = add_query_arg(
				array(
					'action'   => 'TEMPLATE',
					'text'     => get_the_title(),
					'dates'    => $event_start_dt->format( 'Ymd\THis' ) . '/' . $cal_end->format( 'Ymd\THis' ),
					'ctz'      => wp_timezone_string(),
					'location' => $event_location,
				),
				'https://calendar.google.com/calendar/render'
			);
		}
		?>

		<article <?php post_class( 'event-single' ); ?>>

			<!-- ===== HERO: photo, title, date, countdown, buttons ===== -->
			<section class="event-hero">
				<?php if ( has_post_thumbnail() ) : ?>
					<!-- The event photo (Featured Image) fills the hero. Decorative, so empty alt. -->
					<?php the_post_thumbnail( 'full', array( 'class' => 'event-hero-image', 'alt' => '' ) ); ?>
				<?php endif; ?>

				<!-- Dark blurred band that holds the text -->
				<div class="event-hero-panel">
					<div class="event-hero-content">
						<p class="about-label">Event</p>
						<!-- The only H1 on the page -->
						<h1 class="event-hero-title"><?php the_title(); ?></h1>

						<?php if ( has_excerpt() ) : ?>
							<p class="event-hero-text"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<?php endif; ?>

						<?php if ( $event_dt ) : ?>
							<p class="event-hero-date"><?php echo esc_html( $event_dt->format( 'D M j Y' ) ); ?></p>
						<?php endif; ?>

						<?php if ( $event_cat ) : ?>
							<span class="event-tag"><?php echo esc_html( $event_cat ); ?></span>
						<?php endif; ?>

						<?php if ( $event_start_dt ) : ?>
							<!-- Countdown. A small script (step 3) reads data-start and fills in the numbers. -->
							<div class="event-countdown" data-start="<?php echo esc_attr( $event_start_dt->format( 'c' ) ); ?>" role="timer" aria-label="Time until the event starts">
								<div class="event-countdown-item"><span class="event-countdown-number" data-unit="days">0</span><span class="event-countdown-label">Days</span></div>
								<div class="event-countdown-item"><span class="event-countdown-number" data-unit="hours">0</span><span class="event-countdown-label">Hours</span></div>
								<div class="event-countdown-item"><span class="event-countdown-number" data-unit="minutes">0</span><span class="event-countdown-label">Min</span></div>
								<div class="event-countdown-item"><span class="event-countdown-number" data-unit="seconds">0</span><span class="event-countdown-label">Secs</span></div>
							</div>
						<?php endif; ?>

						<div class="event-hero-actions">
							<a class="button event-rsvp" href="<?php echo esc_url( $event_rsvp_url ); ?>">RSVP Now</a>
							<a class="button" href="<?php echo esc_url( home_url( '/events/' ) ); ?>">Back to Events</a>
						</div>
					</div>
				</div>
			</section>

			<!-- ===== ABOUT: photo, description, details ===== -->
			<section class="event-about" id="event-details">
				<div class="event-about-inner">

					<div class="event-about-media">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'large', array( 'class' => 'event-about-image', 'alt' => '' ) ); ?>
						<?php endif; ?>
					</div>

					<div class="event-about-body">
						<p class="about-label">About</p>
						<h2 class="event-about-title"><?php the_title(); ?></h2>
						<span class="about-rule" aria-hidden="true"></span>

						<!-- The description typed into the main editor box -->
						<div class="event-about-text">
							<?php the_content(); ?>
						</div>

						<?php if ( $event_featuring ) : ?>
							<p class="event-about-featuring"><strong>Featuring:</strong> <?php echo esc_html( $event_featuring ); ?></p>
						<?php endif; ?>

						<!-- Date, place and time. A row only shows if it has info. -->
						<ul class="event-about-list">
							<?php if ( $event_dt ) : ?>
								<li><span class="event-about-icon" aria-hidden="true"></span><?php echo esc_html( $event_dt->format( 'D M j Y' ) ); ?></li>
							<?php endif; ?>
							<?php if ( $event_location ) : ?>
								<li><span class="event-about-icon" aria-hidden="true"></span><?php echo esc_html( $event_location ); ?></li>
							<?php endif; ?>
							<?php if ( $event_time_text ) : ?>
								<li><span class="event-about-icon" aria-hidden="true"></span><?php echo esc_html( $event_time_text ); ?></li>
							<?php endif; ?>
						</ul>

						<div class="event-about-actions">
							<a class="button event-rsvp" href="<?php echo esc_url( $event_rsvp_url ); ?>">RSVP Now</a>
							<?php if ( $event_cal_url ) : ?>
								<a class="button" href="<?php echo esc_url( $event_cal_url ); ?>" target="_blank" rel="noopener">Add to Calendar</a>
							<?php endif; ?>
						</div>
					</div>

				</div>
			</section>

		</article>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>