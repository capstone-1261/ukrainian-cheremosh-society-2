<?php
/**
 * Festival Donation page template
 *
 * WordPress uses this file for the page whose slug is "festival-donation"
 * (the page-{slug}.php naming rule). Create the page in wp-admin as a child
 * of Dance Festival with that slug.
 *
 * Layout (from Daina's design): the same red-to-grey band as the About page's
 * Hire Us section. Left: label, heading, text, the video and contact details.
 * Right: a dark card. Daina's design reused the performance inquiry form here,
 * but a donation needs an amount and a payment, so the card has a Donate
 * button instead (see $donate_url below).
 *
 * Wording comes from the client's copy document (section 5, Festival
 * Subpages): "Online donations ($10 minimum via Stripe or PayPal) directly
 * support youth scholarships, adjudication, and venue staging."
 *
 * Most of the styling is reused from the About page (.about-hire, .about-reel,
 * .about-inquiry). Only the card text and button are new (.festival-donation-*).
 *
 * @package cheremosh-theme
 */

// Where the Donate button goes. Leave it empty until the client confirms
// the donation link (Stripe or PayPal). While it is empty, the button
// opens an email to the festival team instead of going nowhere.
$donate_url = '';

// Festival contact details, shown under the video (from the live Dance Festival page).
$festival_email = 'cheremoshfestival@cheremosh.ca';

// The video links to the company's YouTube channel (set in the Customizer),
// same as the About page, until the client sends a festival video.
$donation_video_url = get_theme_mod( 'cheremosh_social_youtube', '' );

get_header(); // Loads header.php (skip link, announcement bar, logo, main menu).
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<section class="about-hire festival-donation">
		<div class="about-hire-inner">

			<!-- LEFT COLUMN: label, heading, text, video, contact. -->
			<div class="about-hire-main">
				<p class="about-label">Donation</p>
				<h1 class="about-hire-title">Festival Donation</h1>
				<span class="about-rule" aria-hidden="true"></span>

				<p>Your donation directly supports youth scholarships, adjudication, and venue staging at the Cheremosh Ukrainian Dance Festival.</p>

				<!-- The video: a photo with a round play button. It is a link, so it has an aria-label. -->
				<a class="about-reel" href="<?php echo esc_url( $donation_video_url ? $donation_video_url : '#' ); ?>" aria-label="Watch a Cheremosh festival video">
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
					<a href="<?php echo esc_url( 'mailto:' . $festival_email ); ?>"><?php echo esc_html( $festival_email ); ?></a>
					·
					<a href="tel:+17804660089">780-466-0089</a>
				</div>
			</div>

			<!-- RIGHT COLUMN: the donation card. -->
			<div class="about-hire-side">
				<div class="about-inquiry festival-donation-card">
					<h2 class="about-inquiry-title">Make a Donation</h2>
					<p>Online donations start at $10 and can be made with Stripe or PayPal.</p>

					<?php if ( $donate_url ) : ?>
						<!-- The link is ready: go straight to it. -->
						<a class="button festival-donation-button" href="<?php echo esc_url( $donate_url ); ?>">Donate Now</a>
					<?php else : ?>
						<!-- No link yet: an email to the festival team, with the subject filled in. -->
						<a class="button festival-donation-button" href="<?php echo esc_url( 'mailto:' . $festival_email . '?subject=' . rawurlencode( 'Festival donation' ) ); ?>">Email Us to Donate</a>
					<?php endif; ?>
				</div>
			</div>

		</div>
	</section>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright).