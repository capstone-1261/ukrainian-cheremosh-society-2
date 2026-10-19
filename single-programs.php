<?php
/**
 * Single program: description, schedule, age range, and instructors.
 */

get_header();
?>

<main id="main-content">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?>>
			<h1><?php the_title(); ?></h1>

			<?php the_content(); ?>

			<?php if ( function_exists( 'get_field' ) ) : ?>
				<?php
				$days         = get_field( 'day_of_the_week' );
				$start_time   = get_field( 'start_time' );
				$end_time     = get_field( 'end_time' );
				$season_start = get_field( 'date_of_season_start' );
				$season_end   = get_field( 'date_of_season_end' );
				$instructors  = get_field( 'related_instructor' );
				$age_range    = get_the_term_list( get_the_ID(), 'age_range', '', ', ' );
				?>

				<section class="program-schedule">
					<h2>Schedule</h2>
					<dl>
						<?php if ( $days ) : ?>
							<dt>Days</dt>
							<dd><?php echo esc_html( implode( ', ', $days ) ); ?></dd>
						<?php endif; ?>

						<?php if ( $start_time && $end_time ) : ?>
							<dt>Time</dt>
							<dd><?php echo esc_html( $start_time . ' – ' . $end_time ); ?></dd>
						<?php endif; ?>

						<?php if ( $season_start && $season_end ) : ?>
							<dt>Season</dt>
							<dd><?php echo esc_html( $season_start . ' to ' . $season_end ); ?></dd>
						<?php endif; ?>

						<?php if ( $age_range && ! is_wp_error( $age_range ) ) : ?>
							<dt>Ages</dt>
							<dd><?php echo wp_kses_post( $age_range ); ?></dd>
						<?php endif; ?>
					</dl>
				</section>

				<?php if ( $instructors ) : ?>
					<section class="program-instructors">
						<h2>Instructors</h2>
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
			<?php endif; ?>
		</article>
	<?php endwhile; ?>
</main>

<?php
get_footer();