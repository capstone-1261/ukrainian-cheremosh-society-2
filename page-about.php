<?php
/**
 * About page template
 *
 * WordPress uses this file automatically for the page whose slug is
 * "about" (the page-{slug}.php naming rule, same as page-our-people.php).
 *
 * Layout (from Daina's design):
 *   1. Hero banner      — "Boisterous by Nature" over the group photo.
 *   2. Our Story        — text, two buttons and a photo.
 *   3. Milestones       — red band with four stats.
 *   4. Leadership       — Artistic Director, Founders, timeline.
 *   5. Press quotes     — three quote cards.
 *   6. Hire Us          — text, reel and the inquiry form (form still to come).
 *   7. Join & Press     — Auditions card and Press Kit card.
 *   8. Company dancer   — thin red bar linking to member login.
 *
 * Styling lives in assets/css/main.css.
 *
 * @package cheremosh-theme
 */

get_header(); // Loads header.php (skip link, announcement bar, menu).
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<!--
		1. HERO BANNER
		The photo is the page's featured image, so the client can swap it in
		the editor without touching code. alt="" because the photo is
		decoration. The title is the only H1 on the page.
	-->
	<section class="about-hero">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'full', array( 'class' => 'about-hero-image', 'alt' => '' ) ); ?>
		<?php endif; ?>

		<div class="about-hero-text">
			<p class="about-hero-tagline">The Dance Company | Edmonton since 1969</p>
			<h1 class="about-hero-title">Boisterous by Nature</h1>

			<div class="about-hero-bottom">
				<p class="about-hero-description">Named for the Cheremosh River that divides Bukovyna and Halychyna in Ukraine — and every bit as boisterous. Edmonton’s semi-professional Ukrainian dance company has thrilled audiences around the world for more than five decades.</p>

				<div class="about-hero-actions">
					<!-- #hire-us is the Hire Us section further down this page. -->
					<a class="button" href="#hire-us">Book a Performance</a>
					<a class="button" href="#hire-us">Watch Us Dance</a>
				</div>
			</div>
		</div>
	</section>

	<!--
		2. OUR STORY
		Text on the left, photo on the right. The inner wrapper is the
		two-column grid (it stacks into one column on phones).
		The buttons are placeholders for now: Events and Leadership.
	-->
	<section class="about-story">
		<div class="about-story-inner">

			<div class="about-story-text">
				<p class="about-label">Our Story</p>
				<h2 class="about-story-title">A Leader in Ukrainian Dance Since 1969</h2>

				<!-- The short blue line under the heading. Pure decoration. -->
				<span class="about-rule" aria-hidden="true"></span>

				<p>Founded in Edmonton by Chester and Luba Kuc, Cheremosh has grown into one of Canada’s leading Ukrainian dance companies. Through discipline, determination and superb artistic direction, our semi-professional dancers have taken the stage across the world.</p>

				<p>Rich in intensity, energy and spirit, a Cheremosh performance is a colourful, exhilarating journey: intricate choreography, spectacular costumes and dynamic music. Men leap to breathtaking heights while women spin across the stage with beauty and grace.</p>

				<div class="about-story-actions">
					<a class="button" href="<?php echo esc_url( home_url( '/events/' ) ); ?>">Upcoming Performances</a>
					<a class="button" href="#leadership">Our Leadership</a>
				</div>
			</div>

			<!-- The photo lives in the theme (assets/images), like hero.jpg.
			     width/height stop the page jumping while the image loads. -->
			<figure class="about-story-photo">
				<img
					src="<?php echo esc_url( get_theme_file_uri( 'assets/images/about-story.jpg' ) ); ?>"
					alt="Three Cheremosh dancers in red and green costumes kicking in step on stage"
					width="1072"
					height="1200"
					loading="lazy"
				>
			</figure>

		</div>
	</section>

	<!--
		3. MILESTONES
		Red band with four stats. The list is a <ul> so screen readers
		announce "list of 4 items". Each item has a big number and a caption.
	-->
	<section class="about-milestones">
		<div class="about-milestones-inner">
			<p class="about-label">Milestones</p>
			<h2 class="about-milestones-title">More than five decades on stage</h2>

			<ul class="about-stats">
				<li class="about-stat">
					<span class="about-stat-number">1969</span>
					<span class="about-stat-label">Founded</span>
					<span class="about-stat-text">By Chester &amp; Luba Kuc in Edmonton, Alberta</span>
				</li>
				<li class="about-stat">
					<span class="about-stat-number">1976</span>
					<span class="about-stat-label">School of Dance</span>
					<span class="about-stat-text">Training Edmonton’s next generation of Ukrainian dancers</span>
				</li>
				<li class="about-stat">
					<span class="about-stat-number">1st</span>
					<span class="about-stat-label">Order of Virsky</span>
					<span class="about-stat-text">Mykola Kanevets is the first Artistic Director outside Ukraine to be inducted</span>
				</li>
				<li class="about-stat">
					<span class="about-stat-number">1,000s</span>
					<span class="about-stat-label">Festival Dancers</span>
					<span class="about-stat-text">Perform at one of North America’s largest Ukrainian dance festivals</span>
				</li>
			</ul>
		</div>
	</section>

	<!--
		4. LEADERSHIP
		Three pieces inside one dark band: the Artistic Director, the Founders
		and the "Leading the Company" timeline.
		Mykola's photo, name and role come from his People entry (the same one
		the Our People page uses). id="leadership" is where the "Our Leadership"
		button in Our Story jumps to.
	-->
	<section class="about-leadership" id="leadership">
		<div class="about-leadership-inner">

			<?php
			// Find the person with the "artistic-director" role.
			$about_director = new WP_Query( array(
				'post_type'      => 'people',
				'posts_per_page' => 1,
				'tax_query'      => array(
					array(
						'taxonomy' => 'role',
						'field'    => 'slug',
						'terms'    => 'artistic-director',
					),
				),
			) );
			?>

			<!-- PIECE 1: ARTISTIC DIRECTOR (portrait left, text right) -->
			<?php while ( $about_director->have_posts() ) : $about_director->the_post(); ?>
				<?php
				// Photo: the ACF "photo" field (a URL) first, then the featured image.
				$about_photo = function_exists( 'get_field' ) ? get_field( 'photo' ) : '';
				?>
				<article class="about-director">

					<?php if ( $about_photo ) : ?>
						<img class="about-director-photo" src="<?php echo esc_url( $about_photo ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy">
					<?php elseif ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'class' => 'about-director-photo', 'loading' => 'lazy' ) ); ?>
					<?php endif; ?>

					<div class="about-director-text">
						<p class="about-label">Artistic Director</p>
						<h3 class="about-leadership-name"><?php the_title(); ?></h3>
						<span class="about-rule" aria-hidden="true"></span>

						<p>The first Artistic Director outside of Ukraine to be inducted into the Order of Pavlo Virsky, and named one of the Top 25 Most Influential Artists in Alberta by the Alberta Foundation for the Arts.</p>

						<blockquote class="about-pullquote">
							<p>“Patterns as intricate as the best Ukrainian embroidery.”</p>
							<cite>Ann Alexander, on Kanevets’ choreography</cite>
						</blockquote>

						<a class="button" href="<?php echo esc_url( get_permalink() ); ?>">Meet Mykola</a>
					</div>

				</article>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); // Hands the page back to WordPress. ?>

			<!-- PIECE 2: FOUNDERS (text left, photo right) -->
			<article class="about-founders">
				<div class="about-founders-text">
					<p class="about-label">Our Founders</p>
					<h3 class="about-leadership-name">Chester &amp; Luba Kuc</h3>
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

			<!-- PIECE 3: TIMELINE. A list, because it is three items in order. -->
			<div class="about-timeline-wrap">
				<h3 class="about-timeline-title">Leading the Company</h3>

				<ol class="about-timeline">
					<li class="about-timeline-item">
						<span class="about-timeline-year">1969</span>
						<span class="about-timeline-name">Chester Kuc</span>
						<span class="about-timeline-role">Founding Artistic Director</span>
					</li>
					<li class="about-timeline-item">
						<span class="about-timeline-year">1982 – 1991</span>
						<span class="about-timeline-name">Richard Wacko, Ken Kachmar &amp; Greg Bayda</span>
						<span class="about-timeline-role">Carried the company through its second era</span>
					</li>
					<li class="about-timeline-item">
						<span class="about-timeline-year">Today</span>
						<span class="about-timeline-name">Mykola Kanevets</span>
						<span class="about-timeline-role">Artistic Director</span>
					</li>
				</ol>
			</div>

		</div>
	</section>

	<!--
		5. PRESS QUOTES
		"In Their Words": three quote cards. Each card is a <figure> with a
		<blockquote> (the quote) and a <figcaption> (who said it).
		Wording is from the client's approved copy doc (section 3.1).
	-->
	<section class="about-press">
		<div class="about-press-inner">

			<div class="about-press-heading">
				<p class="about-label">In Their Words</p>
				<h2 class="about-press-title">A Sight to Behold</h2>
			</div>

			<div class="about-quotes">

				<figure class="about-quote">
					<blockquote>
						<p>“Kanevets’s choreography is so eloquent that 55 dancers at a time — sometimes carrying swords or spears — were able to jump over, under, and around each other in patterns as intricate as the best Ukrainian embroidery.”</p>
					</blockquote>
					<figcaption>
						<span class="about-quote-name">Ann Alexander</span>
						<span class="about-quote-role">Staff Writer</span>
					</figcaption>
				</figure>

				<figure class="about-quote">
					<blockquote>
						<p>“Cheremosh combines the symmetry and poetry of motion of the Ukrainian form with the energy and vitality of the Canadian, to create a truly exquisite hybrid.”</p>
					</blockquote>
					<figcaption>
						<span class="about-quote-name">Marco Levytsky</span>
						<span class="about-quote-role">Ukrainian News</span>
					</figcaption>
				</figure>

				<figure class="about-quote">
					<blockquote>
						<p>“A great satisfaction comes from knowing that what I have done will be continued. The interest is still there and will continue to be there.”</p>
					</blockquote>
					<figcaption>
						<span class="about-quote-name">Chester Kuc</span>
						<span class="about-quote-role">Cheremosh Founder</span>
					</figcaption>
				</figure>

			</div>
		</div>
	</section>

	<!--
		6. HIRE US
		id="hire-us" is where the two banner buttons ("Book a Performance",
		"Watch Us Dance") jump to.
		Left: heading, text and the reel. Right: contact details and the
		Performance Inquiry form (the form is Abdale's; see the note below).
	-->
	<section class="about-hire" id="hire-us">
		<div class="about-hire-inner">

			<div class="about-hire-main">
				<p class="about-label">Hire Us</p>
				<h2 class="about-hire-title">Bring Cheremosh to Your Stage</h2>
				<span class="about-rule" aria-hidden="true"></span>

				<p>See it. Hear it. Feel it. From festival main stages to galas, corporate events and community celebrations, Cheremosh brings intricate choreography, spectacular costumes and dynamic music to audiences of every size.</p>

				<?php
				// The reel links to the company's YouTube channel (set in the
				// Customizer) until the client sends the link to the actual video.
				$about_reel_url = get_theme_mod( 'cheremosh_social_youtube', '' );
				?>
				<a class="about-reel" href="<?php echo esc_url( $about_reel_url ? $about_reel_url : '#hire-us' ); ?>" aria-label="Watch the Cheremosh performance reel">
					<img
						src="<?php echo esc_url( get_theme_file_uri( 'assets/images/about-reel.jpg' ) ); ?>"
						alt=""
						width="992"
						height="640"
						loading="lazy"
					>
					<!-- Round play button drawn in SVG, so it stays sharp at any size. -->
					<span class="about-reel-play" aria-hidden="true">
						<svg viewBox="0 0 24 24" width="28" height="28"><path d="M8 5v14l11-7z" fill="currentColor"></path></svg>
					</span>
				</a>
					<div class="about-hire-contact">
						<h5>Prefer email?</h5>
						<a href="mailto:performances@cheremosh.ca">performances@cheremosh.ca</a>
						·
						<a href="tel:+17804660089">780-466-0089</a>
                  </div>
			</div>

			<div class="about-hire-side">

				<div class="about-inquiry">
					<h3 class="about-inquiry-title">Performance Inquiry</h3>
						<?php
						echo do_shortcode( '[fluentform id="5"]' );
						?>
			</div>
			</div>

		</div>
	</section>

	<!--
		7. JOIN & PRESS
		Two cards side by side: auditions and the press kit. The buttons'
		links are placeholders until the client confirms where Auditions lives
		(see the notes next to each link).
	-->
	<section class="about-join-press">
		<div class="about-join-press-inner">

			<!-- Card 1: Join the Company -->
			<article class="about-card">
				<img
					class="about-card-photo"
					src="<?php echo esc_url( get_theme_file_uri( 'assets/images/about-join.jpg' ) ); ?>"
					alt="Two Cheremosh dancers in green and red costumes with their arms stretched wide"
					width="800"
					height="374"
					loading="lazy"
				>
				<div class="about-card-body">
					<p class="about-card-label">Join the Company</p>
					<h2 class="about-card-title">Auditions</h2>
					<p>Company auditions are held every spring and fall. If you’re ready to train with one of Canada’s leading Ukrainian dance companies, we want to see you dance.</p>
					<p class="about-card-small">Not ready yet? Join our newsletter to hear when the next auditions open.</p>
					<!-- TODO: point this at the real Auditions page once the client says where it lives. -->
					<a class="button about-card-button about-card-button--filled" href="/auditions/">Register for Auditions</a>
				</div>
			</article>

			<!-- Card 2: Press & Media -->
			<article class="about-card">
				<img
					class="about-card-photo"
					src="<?php echo esc_url( get_theme_file_uri( 'assets/images/about-press.jpg' ) ); ?>"
					alt="A smiling Cheremosh dancer in an embroidered headdress"
					width="800"
					height="374"
					loading="lazy"
				>
				<div class="about-card-body">
					<p class="about-card-label">Press &amp; Media</p>
					<h2 class="about-card-title">Press Kit</h2>
					<p>Everything you need to cover Cheremosh: company and artistic director bios, high-resolution photos, logos and a fact sheet.</p>
					<p class="about-card-small">Media inquiries: <a href="mailto:contact@cheremosh.ca">contact@cheremosh.ca</a></p>
					<!-- Goes to the Press Kit page (still to be built). -->
					<a class="button about-card-button" href="<?php echo esc_url( home_url( '/press-kit/' ) ); ?>">Download Press Kit</a>
				</div>
			</article>

		</div>
	</section>

	<!--
		8. COMPANY DANCER STRIP
		A thin red bar for current members, linking to the login page.
	-->
	<section class="about-dancer-strip">
		<div class="about-dancer-strip-inner">
			<div>
				<h2 class="about-dancer-title">Company Dancer?</h2>
				<p>Log in for rehearsal schedules, documents and member content.</p>
			</div>
			<?php $about_login_page = get_page_by_path( 'log-in' ); // Same page the header's Login button uses. ?>
			<a class="button about-dancer-button" href="<?php echo esc_url( $about_login_page ? get_permalink( $about_login_page ) : home_url( '/' ) ); ?>">Member Login</a>
		</div>
	</section>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright).