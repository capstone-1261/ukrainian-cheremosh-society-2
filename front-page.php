<?php
/**
 * Homepage template
 *
 * WordPress always uses front-page.php for the homepage.
 *
 * The hero banner is built in the block editor (patterns/hero.php), so the
 * client can swap its photo or video. It prints through the_content() below.
 * Every section after the hero is built here in code.
 *
 * All the text, links and photos below can be changed by the client on the
 * Home page edit screen ("Homepage content" box, set up in
 * inc/homepage-fields.php). The words written in this file are only the
 * fallback, used when a field is empty. An empty fallback means that piece
 * is hidden, so no placeholder text ever shows on the live site.
 *
 * Sections so far:
 *   1. Hero (from the editor)
 *   2. About (two cards: the Company and the School)
 *   3. Program Registration (red band with a short list)
 *   4. Dance Festival (red box with four links and a photo)
 *   5. Events (the next three upcoming events)
 *   6. Rent Our Space (three columns and a photo)
 *   7. Shop slider (the newest products, with arrows and dots)
 */

get_header(); // Loads header.php (skip link, announcement bar, logo, main menu).

// Folder where the starter photos live. They show until the client uploads their own.
$home_images = get_theme_file_uri( 'assets/images/home/' );

/**
 * Works out the alt text (the description screen readers read) for a photo.
 * Our starter photos get the description written here. A photo the client
 * uploads uses the description they typed in the Media Library (or none).
 */
if ( ! function_exists( 'cheremosh_home_alt' ) ) {
	function cheremosh_home_alt( $image_url, $starter_url, $starter_alt ) {
		if ( $image_url === $starter_url ) {
			return $starter_alt;
		}
		$attachment_id = attachment_url_to_postid( $image_url );
		return $attachment_id ? (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) : '';
	}
}

// ---- Section 2: the two About cards ----
// Each card: field names start with "company_" or "school_".
$home_cards = array(
	array(
		'prefix'     => 'company',
		'starter'    => $home_images . 'company.jpg',
		'alt'        => 'Three Cheremosh dancers in red embroidered costumes mid-kick on stage.',
		'tagline'    => 'The Company',
		'title'      => 'Boisterous, Bold, and Proudly Ukrainian',
		'text'       => 'Founded by Chester and Luba Kuc and named after the Cheremosh River in Ukraine, the company brings the river’s energy and spirit to every performance.',
		'btn_label'  => 'Meet the company',
		'btn_url'    => home_url( '/dance-company/' ),
	),
	array(
		'prefix'     => 'school',
		'starter'    => $home_images . 'school.png',
		'alt'        => 'Two young dancers in floral wreaths performing with arms outstretched.',
		'tagline'    => 'School of Dance',
		'title'      => 'Where Every Dancer Starts',
		'text'       => 'Ukrainian dance instruction for children, youth, and adults, offered in two streams at our North Beverly and South Edmonton studios.',
		'btn_label'  => 'Explore classes',
		'btn_url'    => home_url( '/dance-with-us/' ),
	),
);

// ---- Section 3: the registration points (empty = hidden) ----
$register_points = array_filter(
	array(
		cheremosh_home( 'register_point_1' ),
		cheremosh_home( 'register_point_2' ),
		cheremosh_home( 'register_point_3' ),
	)
);
$register_intro = cheremosh_home( 'register_intro' );

// ---- Section 4: the four Festival blocks ----
// A block with no text is hidden (Support the Dance waits for the client's wording).
$festival_blocks = array(
	array(
		'n'         => 1,
		'title'     => 'Join the Lineup',
		'text'      => 'Hundreds of dancers perform and learn here in a professional setting.',
		'btn_label' => 'Festival sign up',
		'btn_url'   => home_url( '/dance-festival/' ),
		'btn_class' => 'home-button-filled', // The first button is the solid one.
	),
	array(
		'n'         => 2,
		'title'     => 'Our Story',
		'text'      => 'One of the largest and longest-running Ukrainian dance festivals in North America.',
		'btn_label' => 'Learn more about us',
		'btn_url'   => home_url( '/dance-festival/' ),
		'btn_class' => 'home-button-outline',
	),
	array(
		'n'         => 3,
		'title'     => 'Support the Dance',
		'text'      => '',
		'btn_label' => 'Festival donation',
		'btn_url'   => home_url( '/festival-donation/' ),
		'btn_class' => 'home-button-outline',
	),
	array(
		'n'         => 4,
		'title'     => 'Get in Touch',
		'text'      => 'Questions about the Festival? Email cheremoshfestival@cheremosh.ca.',
		'btn_label' => 'Contact us',
		'btn_url'   => home_url( '/contact/' ),
		'btn_class' => 'home-button-outline',
	),
);
$festival_image = cheremosh_home( 'festival_image', $home_images . 'festival.jpg' );


// ---- Section 5: the next three upcoming events ----
// This function formats the stored date (Y-m-d). The Events page defines the
// same one, so we only add it if it isn't there already.
if ( ! function_exists( 'cheremosh_event_date' ) ) {
	function cheremosh_event_date( $ymd ) {
		$date = DateTime::createFromFormat( 'Y-m-d', (string) $ymd );
		return $date ? $date : null;
	}
}

// Events that haven't happened yet, soonest first. Only three for the homepage.
$home_events = new WP_Query(
	array(
		'post_type'      => 'events',
		'posts_per_page' => 3,
		'meta_key'       => 'event_date',
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'meta_query'     => array(
			array(
				'key'     => 'event_date',
				'value'   => current_time( 'Y-m-d' ),
				'compare' => '>=',
				'type'    => 'DATE',
			),
		),
	)
);

// Intro text next to the Events heading (empty = hidden).
$events_intro = cheremosh_home( 'events_intro' );


// ---- Section 6: Rent our space (wording from the client's Studio Space copy) ----
$rent_image   = cheremosh_home( 'rent_image', $home_images . 'rent-space.jpg' );
$rent_columns = array(
	array(
		'n'     => 1,
		'title' => 'Availability',
		'text'  => 'September to May: Monday to Friday 8 a.m. to 5 p.m., Saturday 2 p.m. to 10 p.m., Sunday 8 a.m. to 3:30 p.m. Contact us for summer hours.',
	),
	array(
		'n'     => 2,
		'title' => 'Studio Space',
		'text'  => 'Our main studio has a 37 by 75 foot sprung floor, wall mirrors, barres and a sound system. $50 per hour. The boardroom is $30 per hour.',
	),
	array(
		'n'     => 3,
		'title' => 'Rentals',
		'text'  => 'Local arts groups, instructors and community organizations are welcome to rent our rehearsal hall and boardroom at the Beverly Studio.',
	),
);


// ---- Section 7: the newest products from WooCommerce ----
// If WooCommerce is off, or there are no products, this stays empty and the
// whole section is left out of the page.
$shop_products = function_exists( 'wc_get_products' )
	? wc_get_products(
		array(
			'status'  => 'publish',
			'limit'   => 8,
			'orderby' => 'date',
			'order'   => 'DESC',
		)
	)
	: array();



// ---- Section 8: FAQ ----
// Up to 5 questions. The first three use real wording from the client's copy
// (Recreational Program FAQ) until the client types their own on the Home page.
// A question with no text is skipped, so nothing empty shows.
$faq_fallbacks = array(
	1 => array(
		'q' => 'Do dancers need to audition for any Recreational Program?',
		'a' => 'No audition is required. Simply register online through our registration portal.',
	),
	2 => array(
		'q' => 'What should dancers wear to rehearsal?',
		'a' => 'Option A: black bodysuit, black tights or fitted dance leggings, black ballet skirt (optional), and red ballet slippers, with long hair secured away from the face. Option B: fitted white t-shirt, black athletic shorts or dance pants, and black ballet slippers.',
	),
	3 => array(
		'q' => 'Where can we buy dance shoes and rehearsal attire in Edmonton?',
		'a' => 'Adajio Dance & Skate Apparel (Castle Downs), All 4 Dance (West Edmonton), On Stage Dancewear (Whyte Avenue), Karries Kostumes & Dance Supplies (St. Albert), or And All That Jazz (Sherwood Park).',
	),
);

// Build the list the page will print.
$faq_items = array();
for ( $i = 1; $i <= 5; $i++ ) {
	$fallback = isset( $faq_fallbacks[ $i ] ) ? $faq_fallbacks[ $i ] : array( 'q' => '', 'a' => '' );
	$question = cheremosh_home( 'faq_' . $i . '_question', $fallback['q'] );
	$answer   = cheremosh_home( 'faq_' . $i . '_answer', $fallback['a'] );

	// Only keep a question that has both words and an answer.
	if ( $question && $answer ) {
		$faq_items[] = array(
			'question' => $question,
			'answer'   => $answer,
		);
	}
}

// ---- Section 9: Newsletter ----
// Posts to the same Mailchimp address as the footer form (set in the
// Customizer under Footer). If that address is empty, this whole section is hidden.
$home_newsletter_url = get_theme_mod( 'cheremosh_newsletter_url', 'https://cheremosh.us17.list-manage.com/subscribe/post?u=57c9c1368507b392b0108d7ff&id=f71b458757&f_id=00c9e7e3f0' );

// Mailchimp's bot trap field name is built from the u and id parts of that address
// (same idea as in footer.php).
$home_honeypot = '';
if ( $home_newsletter_url ) {
	$home_query_string = wp_parse_url( $home_newsletter_url, PHP_URL_QUERY );
	$home_query_parts  = array();
	if ( $home_query_string ) {
		wp_parse_str( $home_query_string, $home_query_parts );
	}
	if ( ! empty( $home_query_parts['u'] ) && ! empty( $home_query_parts['id'] ) ) {
		$home_honeypot = 'b_' . $home_query_parts['u'] . '_' . $home_query_parts['id'];
	}
}


// ---- Section 10: Supporters logo strip ----
// The four complete logos start here. The client can replace any of them, or fill
// slots 5 to 8, on the Home page edit screen. A slot with no photo is skipped.
// (The Alberta logo file is cut off, so it is not used until Daina sends the full one.)
$supporter_fallbacks = array(
	1 => array( 'image' => $home_images . 'sponsor-alberta-foundation-for-the-arts.png', 'name' => 'Alberta Foundation for the Arts' ),
	2 => array( 'image' => $home_images . 'sponsor-alberta-lottery-fund.png', 'name' => 'Alberta Lottery Fund' ),
	3 => array( 'image' => $home_images . 'sponsor-shevchenko-foundation.png', 'name' => 'Shevchenko Foundation' ),
	4 => array( 'image' => $home_images . 'sponsor-auda.png', 'name' => 'Alberta Ukrainian Dance Association' ),
);

// Build the list the page will print.
$supporters = array();
for ( $i = 1; $i <= 8; $i++ ) {
	$fallback = isset( $supporter_fallbacks[ $i ] ) ? $supporter_fallbacks[ $i ] : array( 'image' => '', 'name' => '' );
	$image    = cheremosh_home( 'supporter_' . $i . '_image', $fallback['image'] );
	$name     = cheremosh_home( 'supporter_' . $i . '_name', $fallback['name'] );

	// Only keep a slot that has a photo.
	if ( $image ) {
		$supporters[] = array(
			'image' => $image,
			'name'  => $name,
		);
	}
}

?>

<main id="main-content" class="home"> <!-- The skip link in header.php jumps here. -->

	<?php
	// 1. HERO: prints what is saved on the homepage in the block editor.
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>

	<!-- ===== 2. ABOUT (two cards) ===== -->
	<section class="home-about" aria-labelledby="home-about-label">

		<p class="home-label" id="home-about-label">About</p>

		<div class="home-cards">

			<?php foreach ( $home_cards as $card ) : ?>
				<?php
				// Ask for each piece by name; fall back to the starter wording.
				$card_image = cheremosh_home( $card['prefix'] . '_image', $card['starter'] );
				$card_label = cheremosh_home( $card['prefix'] . '_button_label', $card['btn_label'] );
				$card_url   = cheremosh_home( $card['prefix'] . '_button_url', $card['btn_url'] );
				?>
				<article class="home-card">
					<img
						class="home-card-image"
						src="<?php echo esc_url( $card_image ); ?>"
						alt="<?php echo esc_attr( cheremosh_home_alt( $card_image, $card['starter'], $card['alt'] ) ); ?>">
					<div class="home-card-body">
						<p class="home-card-tagline"><?php echo esc_html( cheremosh_home( $card['prefix'] . '_tagline', $card['tagline'] ) ); ?></p>
						<h2 class="home-card-title"><?php echo esc_html( cheremosh_home( $card['prefix'] . '_title', $card['title'] ) ); ?></h2>
						<p class="home-card-text"><?php echo esc_html( cheremosh_home( $card['prefix'] . '_text', $card['text'] ) ); ?></p>
					</div>
					<a class="home-button home-button-outline" href="<?php echo esc_url( $card_url ); ?>">
						<?php echo esc_html( $card_label ); ?>
					</a>
				</article>
			<?php endforeach; ?>

		</div>
	</section>

	<!-- ===== 3. PROGRAM REGISTRATION ===== -->
	<section class="home-register" aria-labelledby="home-register-title">

		<div class="home-register-inner">

			<!-- Left side: label, heading and the short blue line -->
			<div class="home-register-heading">
				<p class="home-label"><?php echo esc_html( cheremosh_home( 'register_label', 'Register' ) ); ?></p>
				<h2 id="home-register-title" class="home-register-title"><?php echo esc_html( cheremosh_home( 'register_title', 'Program Registration' ) ); ?></h2>
				<span class="home-rule" aria-hidden="true"></span>
			</div>

			<!-- Right side: intro text, points and the button. Empty pieces are left out. -->
			<div class="home-register-body">

				<?php if ( $register_intro ) : ?>
					<p class="home-register-intro"><?php echo esc_html( $register_intro ); ?></p>
				<?php endif; ?>

				<?php if ( $register_points ) : ?>
					<ul class="home-register-list">
						<?php foreach ( $register_points as $point ) : ?>
							<li><span class="home-list-icon" aria-hidden="true"></span><?php echo esc_html( $point ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<a class="home-button home-button-filled" href="<?php echo esc_url( cheremosh_home( 'register_button_url', home_url( '/register/' ) ) ); ?>">
					<?php echo esc_html( cheremosh_home( 'register_button_label', 'Register now' ) ); ?>
				</a>
			</div>

		</div>
	</section>

	<!-- ===== 4. DANCE FESTIVAL ===== -->
	<section class="home-festival" aria-labelledby="home-festival-title">

		<div class="home-festival-box">

			<!-- Left side: heading and the four small blocks -->
			<div class="home-festival-main">
				<p class="home-label"><?php echo esc_html( cheremosh_home( 'festival_label', 'Cheremosh Ukrainian Dance Festival' ) ); ?></p>
				<h2 id="home-festival-title" class="home-festival-title"><?php echo esc_html( cheremosh_home( 'festival_title', 'Where Dancers Take the Stage' ) ); ?></h2>
				<span class="home-rule" aria-hidden="true"></span>

				<div class="home-festival-links">
					<?php foreach ( $festival_blocks as $block ) : ?>
						<?php
						$block_text = cheremosh_home( 'festival_' . $block['n'] . '_text', $block['text'] );

						// No text yet = leave this block out of the page.
						if ( ! $block_text ) {
							continue;
						}
						?>
						<div class="home-festival-link">
							<h3><?php echo esc_html( cheremosh_home( 'festival_' . $block['n'] . '_title', $block['title'] ) ); ?></h3>
							<p><?php echo esc_html( $block_text ); ?></p>
							<a class="home-button <?php echo esc_attr( $block['btn_class'] ); ?>" href="<?php echo esc_url( cheremosh_home( 'festival_' . $block['n'] . '_button_url', $block['btn_url'] ) ); ?>">
								<?php echo esc_html( cheremosh_home( 'festival_' . $block['n'] . '_button_label', $block['btn_label'] ) ); ?>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Right side: the photo -->
			<img
				class="home-festival-image"
				src="<?php echo esc_url( $festival_image ); ?>"
				alt="<?php echo esc_attr( cheremosh_home_alt( $festival_image, $home_images . 'festival.jpg', 'Festival dancers in embroidered costumes linking hands on a red-lit stage.' ) ); ?>">

		</div>
	</section>


	<!-- ===== 5. EVENTS ===== -->
	<section class="home-events" aria-labelledby="home-events-title">

		<!-- Heading row: title on the left, intro text on the right (hidden if empty). -->
		<div class="home-events-top">
			<div class="home-events-heading">
				<p class="home-label"><?php echo esc_html( cheremosh_home( 'events_label', 'What’s on' ) ); ?></p>
				<h2 id="home-events-title" class="home-events-title"><?php echo esc_html( cheremosh_home( 'events_title', 'Events' ) ); ?></h2>
				<span class="home-rule" aria-hidden="true"></span>
			</div>

			<?php if ( $events_intro ) : ?>
				<p class="home-events-intro"><?php echo esc_html( $events_intro ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( $home_events->have_posts() ) : ?>

			<!-- The next upcoming events, same cards as the Events page. -->
			<div class="home-events-grid">
				<?php while ( $home_events->have_posts() ) : $home_events->the_post(); ?>
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
				<?php wp_reset_postdata(); // Hands the page back to WordPress. ?>
			</div>

			<a class="home-events-all" href="<?php echo esc_url( cheremosh_home( 'events_view_all_url', home_url( '/events/' ) ) ); ?>">
				<?php echo esc_html( cheremosh_home( 'events_view_all_label', 'View all' ) ); ?>
			</a>

		<?php else : ?>

			<!-- Shown when there are no upcoming events. -->
			<p class="home-events-empty">There are no upcoming events right now. Please check back soon.</p>

		<?php endif; ?>
	</section>


	<!-- ===== 6. RENT OUR SPACE ===== -->
	<section class="home-rent" aria-labelledby="home-rent-title">

		<div class="home-rent-box">

			<!-- Left side: heading and three short columns -->
			<div class="home-rent-main">
				<p class="home-label"><?php echo esc_html( cheremosh_home( 'rent_label', 'Studio space and rentals' ) ); ?></p>
				<h2 id="home-rent-title" class="home-rent-title"><?php echo esc_html( cheremosh_home( 'rent_title', 'Rent our space' ) ); ?></h2>
				<span class="home-rule" aria-hidden="true"></span>

				<div class="home-rent-columns">
					<?php foreach ( $rent_columns as $column ) : ?>
						<?php
						$column_text = cheremosh_home( 'rent_' . $column['n'] . '_text', $column['text'] );

						// No text = leave this column out.
						if ( ! $column_text ) {
							continue;
						}
						?>
						<div class="home-rent-column">
							<h3><?php echo esc_html( cheremosh_home( 'rent_' . $column['n'] . '_title', $column['title'] ) ); ?></h3>
							<p><?php echo esc_html( $column_text ); ?></p>
							<a class="home-button home-button-outline" href="<?php echo esc_url( cheremosh_home( 'rent_' . $column['n'] . '_button_url', home_url( '/studio-space/' ) ) ); ?>">
								<?php echo esc_html( cheremosh_home( 'rent_' . $column['n'] . '_button_label', 'Learn more' ) ); ?>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Right side: the photo -->
			<img
				class="home-rent-image"
				src="<?php echo esc_url( $rent_image ); ?>"
				alt="<?php echo esc_attr( cheremosh_home_alt( $rent_image, $home_images . 'rent-space.jpg', 'A smiling dancer in an embroidered costume holding flowers backstage.' ) ); ?>">

		</div>
	</section>


	<!-- ===== 7. SHOP SLIDER ===== -->
	<?php if ( $shop_products ) : ?>
		<section class="home-shop" aria-labelledby="home-shop-title">

			<!-- Heading on the left, "View all" link on the right. -->
			<div class="home-shop-top">
				<div class="home-shop-heading">
					<p class="home-label"><?php echo esc_html( cheremosh_home( 'shop_label', 'Shop' ) ); ?></p>
					<h2 id="home-shop-title" class="home-shop-title"><?php echo esc_html( cheremosh_home( 'shop_title', 'Shop our store' ) ); ?></h2>
					<span class="home-rule" aria-hidden="true"></span>
				</div>

				<a class="home-shop-all" href="<?php echo esc_url( cheremosh_home( 'shop_view_all_url', home_url( '/shop/' ) ) ); ?>">
					<?php echo esc_html( cheremosh_home( 'shop_view_all_label', 'View all products' ) ); ?>
				</a>
			</div>

			<!-- The row of product cards. assets/js/home-shop-slider.js makes the arrows and dots work. -->
			<div class="home-shop-slider" data-shop-slider>

				<ul class="home-shop-track" data-shop-track>
					<?php foreach ( $shop_products as $product ) : ?>
						<li class="home-shop-item">
							<article class="shop-card">
								<div class="shop-card-media">
									<?php echo wp_kses_post( $product->get_image( 'woocommerce_single' ) ); ?>
								</div>
								<div class="shop-card-body">
									<div class="shop-card-info">
										<h3 class="shop-card-title"><?php echo esc_html( $product->get_name() ); ?></h3>
										<p class="shop-card-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
									</div>
									<a class="button shop-card-button" href="<?php echo esc_url( $product->get_permalink() ); ?>" aria-label="<?php echo esc_attr( 'Details for ' . $product->get_name() ); ?>">Details</a>
								</div>
							</article>
						</li>
					<?php endforeach; ?>
				</ul>

				<!-- Dots on the left, arrows on the right. The script fills in the dots. -->
				<div class="home-shop-controls">
					<div class="home-shop-dots" data-shop-dots></div>
					<div class="home-shop-arrows">
						<button type="button" class="home-shop-arrow" data-shop-prev aria-label="Previous products">&larr;</button>
						<button type="button" class="home-shop-arrow" data-shop-next aria-label="Next products">&rarr;</button>
					</div>
				</div>

			</div>
		</section>
	<?php endif; ?>



	<!-- 8. FAQ: heading and contact box on the left, questions on the right.
	     Uses <details> so each question opens and closes with no JavaScript.
	     Hidden completely if there are no questions. -->
	<?php if ( $faq_items ) : ?>
		<section class="home-faq" aria-labelledby="home-faq-title">
			<div class="home-faq-inner">

				<!-- Left side -->
				<div class="home-faq-side">
					<p class="home-label"><?php echo esc_html( cheremosh_home( 'faq_label', 'FAQ' ) ); ?></p>
					<h2 id="home-faq-title" class="home-faq-title"><?php echo esc_html( cheremosh_home( 'faq_title', 'Frequently asked questions' ) ); ?></h2>
					<span class="home-rule" aria-hidden="true"></span>

					<?php $faq_intro = cheremosh_home( 'faq_intro', 'Answers to the questions we hear most about our programs and registration.' ); ?>
					<?php if ( $faq_intro ) : ?>
						<p class="home-faq-text"><?php echo esc_html( $faq_intro ); ?></p>
					<?php endif; ?>

					<h3 class="home-faq-more-title"><?php echo esc_html( cheremosh_home( 'faq_more_title', 'Still have questions?' ) ); ?></h3>

					<?php $faq_more_text = cheremosh_home( 'faq_more_text', 'Send us a message and we will get back to you.' ); ?>
					<?php if ( $faq_more_text ) : ?>
						<p class="home-faq-text"><?php echo esc_html( $faq_more_text ); ?></p>
					<?php endif; ?>

					<a class="home-button home-button-filled" href="<?php echo esc_url( cheremosh_home( 'faq_button_url', home_url( '/contact/' ) ) ); ?>">
						<?php echo esc_html( cheremosh_home( 'faq_button_label', 'Contact' ) ); ?>
					</a>
				</div>

				<!-- Right side: the questions -->
				<div class="home-faq-list">
					<?php foreach ( $faq_items as $faq ) : ?>
						<details class="home-faq-item">
							<summary class="home-faq-question">
								<span><?php echo esc_html( $faq['question'] ); ?></span>
								<span class="home-faq-chevron" aria-hidden="true"></span>
							</summary>
							<p class="home-faq-answer"><?php echo esc_html( $faq['answer'] ); ?></p>
						</details>
					<?php endforeach; ?>
				</div>

			</div>
		</section>
	<?php endif; ?>



	<!-- 9. NEWSLETTER: heading on the left, sign-up form on the right.
	     Posts straight to Mailchimp (same address as the footer form).
	     Hidden completely if no Mailchimp address is set. -->
	<?php if ( $home_newsletter_url ) : ?>
		<section class="home-newsletter" aria-labelledby="home-newsletter-title">
			<div class="home-newsletter-inner">

				<!-- Left side -->
				<div class="home-newsletter-side">
					<p class="home-label"><?php echo esc_html( cheremosh_home( 'newsletter_label', 'Stay connected' ) ); ?></p>
					<h2 id="home-newsletter-title" class="home-newsletter-title"><?php echo esc_html( cheremosh_home( 'newsletter_title', 'Newsletter sign up' ) ); ?></h2>
					<span class="home-rule" aria-hidden="true"></span>

					<?php $newsletter_text = cheremosh_home( 'newsletter_text', 'Get performance announcements, registration dates, and Festival news delivered to your inbox.' ); ?>
					<?php if ( $newsletter_text ) : ?>
						<p class="home-newsletter-text"><?php echo esc_html( $newsletter_text ); ?></p>
					<?php endif; ?>
				</div>

				<!-- Right side: the form. name="EMAIL" is the field name Mailchimp looks for. -->
				<form class="home-newsletter-form" action="<?php echo esc_url( $home_newsletter_url ); ?>" method="post" target="_blank" rel="noopener">
					<label class="home-newsletter-label" for="home-newsletter-email"><?php echo esc_html( cheremosh_home( 'newsletter_email_label', 'Email address' ) ); ?></label>

					<div class="home-newsletter-row">
						<input
							class="home-newsletter-email"
							id="home-newsletter-email"
							type="email"
							name="EMAIL"
							placeholder="<?php echo esc_attr( cheremosh_home( 'newsletter_placeholder', 'name@example.com' ) ); ?>"
							autocomplete="email"
							required>

						<?php
						// Mailchimp's bot trap. Hidden from people and screen readers.
						if ( $home_honeypot ) :
							?>
							<div class="newsletter-honeypot" aria-hidden="true">
								<input type="text" name="<?php echo esc_attr( $home_honeypot ); ?>" tabindex="-1" value="" autocomplete="off">
							</div>
						<?php endif; ?>

						<button class="home-button home-button-filled" type="submit"><?php echo esc_html( cheremosh_home( 'newsletter_button_label', 'Subscribe' ) ); ?></button>
					</div>

					<!-- Small print. The link only shows if the client adds a link address. -->
					<?php
					$newsletter_terms_url = cheremosh_home( 'newsletter_terms_url', '' );
					$newsletter_terms     = cheremosh_home( 'newsletter_terms_label', 'Terms and Conditions' );
					?>
					<p class="home-newsletter-small">
						<?php echo esc_html( cheremosh_home( 'newsletter_consent', 'By clicking Subscribe you agree to our' ) ); ?>
						<?php if ( $newsletter_terms_url ) : ?>
							<a href="<?php echo esc_url( $newsletter_terms_url ); ?>"><?php echo esc_html( $newsletter_terms ); ?></a>.
						<?php else : ?>
							<?php echo esc_html( $newsletter_terms ); ?>.
						<?php endif; ?>
					</p>
				</form>

			</div>
		</section>
	<?php endif; ?>



	<!-- 10. SUPPORTERS: a row of logos with arrows and dots.
	     assets/js/home-supporters-slider.js makes the arrows and dots work.
	     Hidden completely if there are no logos. -->
	<?php if ( $supporters ) : ?>
		<section class="home-supporters" aria-labelledby="home-supporters-title">
			<h2 id="home-supporters-title" class="home-supporters-title"><?php echo esc_html( cheremosh_home( 'supporters_title', 'Thank you to our supporters' ) ); ?></h2>

			<div class="home-supporters-slider" data-supporters-slider>

				<ul class="home-supporters-track" data-supporters-track>
					<?php foreach ( $supporters as $supporter ) : ?>
						<li class="home-supporters-item">
							<img src="<?php echo esc_url( $supporter['image'] ); ?>" alt="<?php echo esc_attr( $supporter['name'] ); ?>" loading="lazy">
						</li>
					<?php endforeach; ?>
				</ul>

				<div class="home-supporters-controls">
					<div class="home-supporters-dots" data-supporters-dots></div>
					<div class="home-supporters-arrows">
						<button type="button" class="home-supporters-arrow" data-supporters-prev aria-label="Previous logos">&larr;</button>
						<button type="button" class="home-supporters-arrow" data-supporters-next aria-label="Next logos">&rarr;</button>
					</div>
				</div>

			</div>
		</section>
	<?php endif; ?>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright, wp_footer()).