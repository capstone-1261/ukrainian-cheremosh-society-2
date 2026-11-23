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

	<!--
		1. HERO BANNER
		Same layout as the About page banner, so it reuses the .about-hero
		classes (no new CSS). The photo is this page's Featured image, set in
		the editor. The H1 is hard-coded because the design's heading,
		"School of Dance", is different from the page title "Dance with Us".
	-->
	<section class="about-hero">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'full', array( 'class' => 'about-hero-image', 'alt' => '' ) ); ?>
		<?php endif; ?>

		<div class="about-hero-text">
			<p class="about-hero-tagline">Cheremosh | Edmonton since 1969</p>
			<h1 class="about-hero-title about-hero-title--wide">School of Dance</h1>
			<div class="about-hero-bottom">
				<p class="about-hero-description">The Cheremosh School of Dance has provided youth and children with the HIGHEST caliber of Ukrainian dance instruction since 1976.</p>

				<div class="about-hero-actions">
					<?php
					// "Book a Performance" goes to the Hire Us section on the About page.
					// "Watch Us Dance" goes to the YouTube link set in Customizer > Social
					// (the same link the About page reel uses), or the Hire Us section if none.
					$dance_youtube = get_theme_mod( 'cheremosh_social_youtube' );
					?>
					<a class="button" href="<?php echo esc_url( home_url( '/about/#hire-us' ) ); ?>">Book a Performance</a>
					<a class="button" href="<?php echo esc_url( $dance_youtube ? $dance_youtube : home_url( '/about/#hire-us' ) ); ?>">Watch Us Dance</a>
				</div>
			</div>
		</div>
	</section>
	<?php /* ============================================================
	       2. PROGRAM OVERVIEW

	       Heading on the left, intro text on the right, then a row of
	       program cards (one per Program entry, A to Z). The row scrolls
	       sideways; the arrows and dots come in a later step.
	       ============================================================ */ ?>

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

	<section class="dance-programs" aria-labelledby="dance-programs-heading">
		<div class="dance-programs-inner">

			<div class="dance-programs-header">
				<div>
					<p class="about-label">About</p>
					<h2 id="dance-programs-heading" class="dance-programs-title">Program Overview</h2>
					<span class="about-rule" aria-hidden="true"></span>
				</div>

				<!-- Wording from the design. -->
				<p class="dance-programs-intro">Our School gives Dancers the Essentials to Pursue Dancing with the Cheremosh Ukrainian Dance Company or simply to Experience Dance Recreationally. The Balance of Fitness, Art, and Culture is Irresistible !</p>
			</div>

			<?php if ( $programs->have_posts() ) : ?>
				<ul class="dance-programs-track">
					<?php
					while ( $programs->have_posts() ) :
						$programs->the_post();

						// Ages: the "age_range" taxonomy names (e.g. 8-17), joined with commas, no links.
						$age_terms = get_the_terms( get_the_ID(), 'age_range' );
						$ages      = ( $age_terms && ! is_wp_error( $age_terms ) ) ? implode( ', ', wp_list_pluck( $age_terms, 'name' ) ) : '';

						// Instructors: the ACF "related_instructor" relationship (a list of posts).
						$instructors      = function_exists( 'get_field' ) ? get_field( 'related_instructor' ) : array();
						$instructor_names = $instructors ? implode( ', ', array_map( 'get_the_title', $instructors ) ) : '';
						?>
						<li class="dance-program-card">

							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'large', array( 'class' => 'dance-program-photo', 'alt' => '', 'loading' => 'lazy' ) ); ?>
							<?php else : ?>
								<!-- No photo yet: a dark block keeps every card the same height. -->
								<div class="dance-program-photo dance-program-photo--empty" aria-hidden="true"></div>
							<?php endif; ?>

							<div class="dance-program-body">
								<?php if ( $instructor_names || $ages ) : ?>
									<p class="dance-program-tags">
										<?php if ( $instructor_names ) : ?>
											<span class="dance-program-tag">Instructor: <?php echo esc_html( $instructor_names ); ?></span>
										<?php endif; ?>
										<?php if ( $ages ) : ?>
											<span class="dance-program-tag">Ages: <?php echo esc_html( $ages ); ?></span>
										<?php endif; ?>
									</p>
								<?php endif; ?>

								<h3 class="dance-program-name"><?php the_title(); ?></h3>

								<?php
								// Short description: the program's excerpt
								// (or the first part of its content if no excerpt is set).
								// Cut to about 22 words so every card stays the same height as the design.
								echo '<p>' . esc_html( wp_trim_words( get_the_excerpt(), 22 ) ) . '</p>';								?>

								<!-- aria-label tells screen readers which program the button is for. -->
								<a class="button" href="<?php the_permalink(); ?>" aria-label="Learn more about <?php the_title_attribute(); ?>">Learn More</a>
							</div>

						</li>
					<?php endwhile; ?>
				</ul>
				<?php wp_reset_postdata(); // Hands the page back to WordPress. ?>

				<!-- Carousel controls: dots on the left, arrows on the right.
				     The dots are built by assets/js/dance-programs.js (one per card).
				     Arrows are real buttons so keyboard and screen reader users can use them. -->
				<div class="dance-programs-controls">
					<div class="dance-programs-dots" aria-label="Choose a program"></div>

					<div class="dance-programs-arrows">
						<button class="dance-programs-arrow" type="button" data-direction="-1" aria-label="Previous programs">
							<svg viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20z" fill="currentColor"/></svg>
						</button>
						<button class="dance-programs-arrow" type="button" data-direction="1" aria-label="Next programs">
							<svg viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" fill="currentColor"/></svg>
						</button>
					</div>
				</div>
			<?php endif; ?>

		</div>
	</section>
		<!-- ===== WHY DANCE WITH CHEREMOSH (benefits grid) ===== -->
	<section class="dance-why" aria-labelledby="dance-why-heading">
		<div class="dance-why-inner">

			<div class="dance-why-header">
				<p class="about-label">Program Benefits</p>
				<h2 class="dance-why-title" id="dance-why-heading">Why dance with Cheremosh</h2>
				<div class="about-rule"></div>
				<p class="dance-why-intro">Since 1976, the Cheremosh School of Dance has given children and youth the highest calibre of Ukrainian dance instruction — in two program streams, at two Edmonton studios.</p>
			</div>

			<!-- 3-column grid. "--wide" cards span two columns. -->
			<div class="dance-why-grid">

				<article class="dance-benefit dance-benefit--wide dance-benefit--feature">
					<p class="dance-benefit-kicker">Artistic direction</p>
					<h3 class="dance-benefit-title dance-benefit-title--large">Led by Mykola Kanevets</h3>
					<p>The School of Dance is guided by Cheremosh’s internationally acclaimed Artistic Director and Ballet Master — who still coaches Academy students himself.</p>
					<a class="button" href="<?php echo esc_url( home_url( '/about/#leadership' ) ); ?>">Meet Mykola</a>
				</article>

				<article class="dance-benefit">
					<p class="dance-benefit-kicker">All ages welcome</p>
					<h3 class="dance-benefit-title dance-benefit-title--large dance-benefit-title--red">All ages</h3>
					<p>Academy programs from age 8, plus recreational classes for every age — from Mini Moshers to Chayka adult classes.</p>
				</article>

				<article class="dance-benefit">
					<p class="dance-benefit-kicker">Affordability</p>
					<h3 class="dance-benefit-title">No costumes to buy</h3>
					<p>Costumes are provided, and there’s just one fundraising volunteer commitment per dancer.</p>
				</article>

				<article class="dance-benefit">
					<p class="dance-benefit-kicker">Close to home</p>
					<h3 class="dance-benefit-title">Two Edmonton studios</h3>
					<p>The Cheremosh Studio in north Edmonton and a satellite studio in south Edmonton keep class close at hand.</p>
					<!-- #dance-locations is the Locations section we build later. -->
					<a class="button" href="#dance-locations">Where to find us</a>
				</article>

				<article class="dance-benefit">
					<p class="dance-benefit-kicker">Trained instructors</p>
					<h3 class="dance-benefit-title">Taught by the best</h3>
					<p>Every instructor is trained in ballet and traditional Ukrainian dance — including former Virsky dancers Kostiantyn Frolov and Anna Frolova — backed by an executive team dedicated to families.</p>
					<a class="button" href="<?php echo esc_url( home_url( '/our-people/' ) ); ?>">Instructors</a>
				</article>

				<article class="dance-benefit dance-benefit--wide">
					<p class="dance-benefit-kicker">Custom Ukrainian wardrobe</p>
					<h3 class="dance-benefit-title">Costumes made in Ukraine</h3>
					<p>An unparalleled costume wardrobe, 100% owned by the Cheremosh Society. Academy costumes are custom-designed and sewn by designers and seamstresses in Ukraine.</p>
					<!-- Embroidery strip from Figma goes here once we have the image. -->
				</article>

				<article class="dance-benefit">
					<p class="dance-benefit-kicker">Travel opportunities</p>
					<h3 class="dance-benefit-title">See the world on stage</h3>
					<p>Jr. Ensemble tours have taken dancers to:</p>
					<ul class="dance-benefit-chips">
						<li>Banff, AB</li>
						<li>Penticton, BC</li>
						<li>Winnipeg, MB</li>
						<li>Rochester, NY</li>
						<li>Aberdeen, Scotland</li>
					</ul>
				</article>

			</div>

			<div class="dance-why-actions">
				<!-- Register Now is a placeholder (#) until we know where registration lives. -->
				<a class="button" href="#">Register Now</a>
				<a class="button" href="#dance-programs">Explore Programs</a>
			</div>

		</div>
	</section>

		<!-- ===== MEET OUR INSTRUCTORS ===== -->
	<section class="dance-instructors" aria-labelledby="dance-instructors-heading">
		<div class="dance-instructors-inner">

			<!-- Left: tagline, heading, rule. Right: intro text + button. -->
			<div class="dance-instructors-header">
				<div>
					<p class="about-label">Instructors</p>
					<h2 class="dance-instructors-title" id="dance-instructors-heading">Meet our instructors</h2>
					<div class="about-rule"></div>
				</div>
				<div class="dance-instructors-intro">
					<p>The Cheremosh School of Dance has provided youth and children with the HIGHEST caliber of Ukrainian dance instruction since 1976. The programs are separated into TWO different streams across the Edmonton North Beverly Studio, and South Edmonton Studio.</p>
					<a class="button" href="<?php echo esc_url( home_url( '/sod-instructors/' ) ); ?>">Learn More</a>
				</div>
			</div>

			<?php
			// The first three instructors A-Z. Change posts_per_page to show more or fewer.
			$dance_instructors = new WP_Query( array(
				'post_type'      => 'instructors',
				'posts_per_page' => 3,
				'orderby'        => 'title',
				'order'          => 'ASC',
			) );
			?>

			<?php if ( $dance_instructors->have_posts() ) : ?>
				<ul class="dance-instructors-list">
					<?php while ( $dance_instructors->have_posts() ) : $dance_instructors->the_post(); ?>
						<?php
						// Photo: the ACF "photo" field first, then the Featured image.
						$dance_photo = function_exists( 'get_field' ) ? get_field( 'photo' ) : '';
						?>
						<li class="dance-instructor">
							<!-- The whole card is one link to the instructor's page. -->
							<a href="<?php the_permalink(); ?>">
								<?php if ( $dance_photo ) : ?>
									<img class="dance-instructor-photo" src="<?php echo esc_url( $dance_photo ); ?>" alt="" loading="lazy">
								<?php elseif ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'large', array( 'class' => 'dance-instructor-photo', 'alt' => '', 'loading' => 'lazy' ) ); ?>
								<?php else : ?>
									<span class="dance-instructor-photo dance-instructor-photo--empty"></span>
								<?php endif; ?>
								<span class="dance-instructor-name"><?php the_title(); ?></span>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
				<?php wp_reset_postdata(); // Hands the page back to WordPress. ?>
			<?php endif; ?>

		</div>
	</section>
	<!-- ===== LOCATIONS ===== -->
	<section class="dance-locations" id="dance-locations" aria-labelledby="dance-locations-heading">
		<div class="dance-locations-inner">

			<div class="dance-locations-header">
				<p class="about-label">Locations</p>
				<h2 class="dance-locations-title" id="dance-locations-heading">Where to find us</h2>
				<div class="about-rule"></div>
				<p class="dance-locations-intro">The programs are separated into TWO Different Streams across the Edmonton NORTH Beverly Studio, and Edmonton SOUTH Studio.</p>
			</div>

			<div class="dance-locations-grid">

				<article class="dance-location">
					<!-- Live Google map (no API key needed). "q=" is the address. -->
					<iframe class="dance-location-map" title="Map of the North Beverly Studio" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=4005+115+Ave+NW+Edmonton+AB+T5W+0V5&amp;z=13&amp;output=embed"></iframe>
					<h3 class="dance-location-name">North Beverly Studio</h3>
					<address class="dance-location-address">4005 115 Ave NW<br>Edmonton, AB<br>T5W 0V5</address>
					<a class="button" href="https://www.google.com/maps?q=4005+115+Ave+NW+Edmonton+AB+T5W+0V5" target="_blank" rel="noopener">View Map</a>
				</article>

				<article class="dance-location">
					<iframe class="dance-location-map" title="Map of the South Studio" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=11230+43+Ave+NW+Edmonton+AB+T6J+0X8&amp;z=13&amp;output=embed"></iframe>
					<h3 class="dance-location-name">South Studio</h3>
					<address class="dance-location-address">11230 43 Ave NW<br>Edmonton, AB T6J 0X8</address>
					<a class="button" href="https://www.google.com/maps?q=11230+43+Ave+NW+Edmonton+AB+T6J+0X8" target="_blank" rel="noopener">View Map</a>
				</article>

			</div>
		</div>
	</section>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright, wp_footer()).