<?php
/**
 * Dance Company page template
 *
 * WordPress uses this file for the page with the slug "dance-company"
 * (page-{slug}.php). It is the public page for the Cheremosh Ukrainian
 * Dance Company: a banner, the Artistic Director, three press quotes,
 * and a card for auditions.
 *
 * Most of the layout reuses the About page's classes (.about-hero,
 * .about-leadership, .about-card), so only the quotes band is new CSS.
 * Wording comes from the client's copy document (section 3.1).
 */

get_header(); // Loads header.php (skip link, announcement bar, logo, main menu).
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<!--
		1. HERO BANNER
		Same layout as the About page banner. The photo is this page's
		Featured image, set in the page editor.
	-->
	<section class="about-hero">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'full', array( 'class' => 'about-hero-image', 'alt' => '' ) ); ?>
		<?php endif; ?>

		<div class="about-hero-text">
			<p class="about-hero-tagline">Cheremosh | Edmonton since 1969</p>
			<h1 class="about-hero-title about-hero-title--wide">Cheremosh Ukrainian Dance Company</h1>
			<div class="about-hero-bottom">
				<p class="about-hero-description">For more than five decades, the Cheremosh Ukrainian Dance Company has set the standard for Ukrainian stage dance in Canada. Directed by Ballet Master Mykola Kanevets, the Company blends soaring acrobatics, rapid-fire precision, symphonic orchestration, and authentic regional costuming into an unforgettable theatrical experience.</p>

				<div class="about-hero-actions">
					<a class="button" href="<?php echo esc_url( home_url( '/about/#hire-us' ) ); ?>">Book a Performance</a>
				</div>
			</div>
		</div>
	</section>

	<!--
		2. ARTISTIC DIRECTOR
		Mykola's photo and name come from his People entry (the same one the
		About and Our People pages use). Reuses the About page's dark band.
	-->
	<section class="about-leadership">
		<div class="about-leadership-inner">

			<?php
			// Find the person with the "artistic-director" role.
			$company_director = new WP_Query( array(
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

			<?php while ( $company_director->have_posts() ) : $company_director->the_post(); ?>
				<?php
				// Photo: the ACF "photo" field (a URL) first, then the featured image.
				$company_photo = function_exists( 'get_field' ) ? get_field( 'photo' ) : '';
				?>
				<article class="about-director">

					<?php if ( $company_photo ) : ?>
						<img class="about-director-photo" src="<?php echo esc_url( $company_photo ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy">
					<?php elseif ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'class' => 'about-director-photo', 'loading' => 'lazy' ) ); ?>
					<?php endif; ?>

					<div class="about-director-text">
						<p class="about-label">Artistic Director</p>
						<h2 class="about-leadership-name"><?php the_title(); ?></h2>
						<span class="about-rule" aria-hidden="true"></span>

						<p>The first Artistic Director outside Ukraine inducted into the prestigious Order of Pavlo Virsky, Mykola Kanevets has choreographed and staged every work in Cheremosh’s modern repertoire since 1991.</p>

						<!-- Links to his own People page. -->
						<a class="button" href="<?php echo esc_url( get_permalink() ); ?>">Read Mykola Kanevets’s Bio</a>
					</div>

				</article>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); // Hands the page back to WordPress. ?>

		</div>
	</section>

	<!--
		3. PRAISE FOR CHEREMOSH
		Three quotes side by side (stacked on phones). Each one is a
		<blockquote> with a <cite> for who said it.
	-->
	<section class="company-quotes" aria-labelledby="company-quotes-heading">
		<div class="company-quotes-inner">

			<p class="about-label">Press</p>
			<h2 id="company-quotes-heading" class="company-quotes-title">Praise for Cheremosh</h2>
			<span class="about-rule" aria-hidden="true"></span>

			<div class="company-quotes-grid">

				<blockquote class="company-quote">
					<p>“Kanevets’s choreography is so eloquent that 55 dancers at a time — sometimes carrying swords or spears — were able to jump over, under, and around each other in patterns as intricate as the best Ukrainian embroidery.”</p>
					<cite>Ann Alexander, Staff Writer</cite>
				</blockquote>

				<blockquote class="company-quote">
					<p>“Cheremosh combines the symmetry and poetry of motion of the Ukrainian form with the energy and vitality of the Canadian, to create a truly exquisite hybrid.”</p>
					<cite>Marco Levytsky, Ukrainian News</cite>
				</blockquote>

				<blockquote class="company-quote">
					<p>“A great satisfaction comes from knowing that what I have done will be continued. The interest is still there and will continue to be there.”</p>
					<cite>Chester Kuc, Co-Founder of Cheremosh</cite>
				</blockquote>

			</div>
		</div>
	</section>

	<!--
		4. AUDITIONS
		One card, reusing the About page's Join the Company card styles.
	-->
	<section class="about-join-press company-auditions">
		<div class="about-join-press-inner">
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
					<h2 class="about-card-title">Audition for the Company</h2>
					<p>Company auditions take place each June and September at the Mykola Kanevets Rehearsal Hall (Beverly Studio, 4005 115 Avenue NW, Edmonton).</p>
					<!-- TODO: point this at the real Auditions page once the client says where it lives. -->
					<a class="button about-card-button about-card-button--filled" href="#">View Audition Dates &amp; Register</a>
				</div>
			</article>
		</div>
	</section>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright).