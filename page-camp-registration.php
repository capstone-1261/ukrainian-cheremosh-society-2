<?php
/**
 * Camp Registration page template
 *
 * WordPress uses this file for the page whose slug is "camp-registration".
 * The form is the Fluent Forms form with ID 6. Fluent handles validation and
 * error messages. Styles: assets/css/main.css.
 *
 * @package cheremosh-theme
 */

get_header();
?>


<!-- Success pop-up. Opens after a good submit (see camp-registration-modal.js). -->
<div class="camp-modal" id="camp-modal" hidden>
	<div class="camp-modal-box" role="dialog" aria-modal="true" aria-labelledby="camp-modal-title">

		<div class="camp-modal-pattern" aria-hidden="true">
			<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/camps/vertical-pattern.png' ) ); ?>" alt="">
		</div>

		<button type="button" class="camp-modal-close" aria-label="Close">
			<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
		</button>

		<div class="camp-modal-content">
			<p class="camp-modal-tagline">Camp Registration confirmation</p>
			<h2 id="camp-modal-title" class="camp-modal-title">Camp Registration success</h2>
			<span class="camp-modal-line" aria-hidden="true"></span>
			<p class="camp-modal-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.</p>
			<a class="camp-modal-button" href="<?php echo esc_url( home_url( '/login/' ) ); ?>">Login</a>
		</div>

	</div>
</div>

<main class="camp-reg-page">
	<section class="camp-reg">

		<!-- Decorative ribbon behind the form. Never over text or buttons. -->
		<div class="camp-reg-ribbon" aria-hidden="true">
			<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/camps/registration-ribbon.svg' ) ); ?>" alt="">
		</div>

		<div class="camp-reg-inner">

			<div class="camp-reg-header">
				<p class="camp-reg-tagline">Register</p>
				<h1 class="camp-reg-title">Camp Registration</h1>
				<span class="camp-reg-line"></span>
				<p class="camp-reg-intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
			</div>

			<!-- Fluent Forms: form ID 6. -->
			<div class="camp-reg-form camp-reg-fluent">
				<?php echo do_shortcode( '[fluentform id="6"]' ); ?>
			</div>

			<a class="camp-reg-back" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to home</a>

		</div>
	</section>
</main>

<?php
get_footer();