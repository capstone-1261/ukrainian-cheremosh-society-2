<?php
/**
 * Sign-up handling.
 *
 * The form in page-signup.php posts to admin-post.php with
 * action="cheremosh_signup", which WordPress turns into the two hooks
 * below. This file validates what was sent, creates the user, signs them
 * in and sends them on.
 *
 * Everything here runs on the server. The required/minlength attributes
 * on the form are a convenience for people typing; they can be bypassed,
 * so every check is repeated here where it counts.
 *
 * @package cheremosh-theme
 */

// Stop the file being loaded directly by visiting its URL.
defined( 'ABSPATH' ) || exit;

/**
 * Send someone back to the sign-up page with a reason.
 *
 * Used for every failure path so they all behave the same way.
 *
 * @param string $reason  One of the keys page-signup.php knows about.
 * @param array  $keep    Name and email to put back in the form.
 */
function cheremosh_signup_bail( $reason, $keep = array() ) {
	$page = get_page_by_path( 'sign-up' );

	// No Sign Up page: nothing sensible to go back to.
	$url = $page ? get_permalink( $page ) : home_url( '/' );

	$args = array( 'signup' => $reason );

	// Hand the name and email back so they aren't retyped. Never the password.
	if ( ! empty( $keep['name'] ) ) {
		$args['name'] = rawurlencode( $keep['name'] );
	}
	if ( ! empty( $keep['email'] ) ) {
		$args['email'] = rawurlencode( $keep['email'] );
	}

	// wp_safe_redirect refuses to send anyone to another domain.
	wp_safe_redirect( add_query_arg( $args, $url ) );
	exit; // Always exit after a redirect.
}

/**
 * Handle a sign-up submission.
 *
 * Hooked to both admin_post_nopriv_ (logged out, which is everyone
 * signing up) and admin_post_ (logged in, in case someone wanders in).
 */
function cheremosh_handle_signup() {

	/*
	 * Check the nonce first, before looking at anything else.
	 *
	 * This confirms the submission came from our own form. Without it,
	 * another site could post to this endpoint on a visitor's behalf.
	 * wp_verify_nonce returns false if it's missing, wrong or expired.
	 */
	if (
		! isset( $_POST['cheremosh_signup_nonce'] )
		|| ! wp_verify_nonce(
			sanitize_key( wp_unslash( $_POST['cheremosh_signup_nonce'] ) ),
			'cheremosh_signup'
		)
	) {
		cheremosh_signup_bail( 'failed' );
	}

	/*
	 * Read the fields.
	 *
	 * wp_unslash undoes the slashes WordPress adds to incoming data.
	 * sanitize_text_field strips tags and stray whitespace.
	 * sanitize_email strips anything that can't appear in an address.
	 * The password is deliberately NOT sanitised — altering it would
	 * change what the person typed. It's hashed, never printed.
	 */
	$name     = isset( $_POST['signup_name'] ) ? sanitize_text_field( wp_unslash( $_POST['signup_name'] ) ) : '';
	$email    = isset( $_POST['signup_email'] ) ? sanitize_email( wp_unslash( $_POST['signup_email'] ) ) : '';
	$password = isset( $_POST['signup_password'] ) ? (string) $_POST['signup_password'] : '';

	$keep = array(
		'name'  => $name,
		'email' => $email,
	);

	// All three are required.
	if ( ! $name || ! $email || ! $password ) {
		cheremosh_signup_bail( 'missing', $keep );
	}

	// is_email returns false for anything that isn't a valid address.
	if ( ! is_email( $email ) ) {
		cheremosh_signup_bail( 'email', $keep );
	}

	// Matches the minlength on the form.
	if ( strlen( $password ) < 8 ) {
		cheremosh_signup_bail( 'weak', $keep );
	}

	// Already registered? Say so rather than failing silently.
	if ( email_exists( $email ) ) {
		cheremosh_signup_bail( 'exists', $keep );
	}

	/*
	 * Create the user.
	 *
	 * WordPress needs a username separate from the email. We use the email
	 * as the username so there's only one thing to remember, which is what
	 * the login page expects too.
	 *
	 * display_name is what shows publicly; first_name is set as well so the
	 * profile screen isn't blank.
	 *
	 * The role is Subscriber — the lowest level, with no access to the
	 * admin area beyond their own profile. Never give sign-ups anything
	 * higher.
	 */
	$user_id = wp_insert_user(
		array(
			'user_login'   => $email,
			'user_email'   => $email,
			'user_pass'    => $password,
			'display_name' => $name,
			'first_name'   => $name,
			'role'         => 'subscriber',
		)
	);

	// wp_insert_user returns a WP_Error if anything went wrong.
	if ( is_wp_error( $user_id ) ) {
		cheremosh_signup_bail( 'failed', $keep );
	}

	/*
	 * Save what they're interested in.
	 *
	 * The checkboxes arrive as an array. We keep only the two values we
	 * offer, so nothing unexpected can be stored by editing the form.
	 */
	$allowed  = array( 'school-of-dance', 'dance-company' );
	$interest = isset( $_POST['signup_interest'] ) ? (array) wp_unslash( $_POST['signup_interest'] ) : array();
	$interest = array_values( array_intersect( $allowed, array_map( 'sanitize_key', $interest ) ) );

	if ( $interest ) {
		update_user_meta( $user_id, 'cheremosh_interest', $interest );
	}

	/*
	 * Tell WordPress to email the new user their details, and the site
	 * admin that someone signed up. 'both' sends both notifications.
	 */
	wp_new_user_notification( $user_id, null, 'both' );

	/*
	 * Sign them in straight away, so they don't have to type the password
	 * they just chose. These three calls are what WordPress itself does
	 * after a successful login.
	 */
	wp_set_current_user( $user_id );
	wp_set_auth_cookie( $user_id );
	do_action( 'wp_login', $email, get_userdata( $user_id ) );

	// Send them to their account page, or the home page if it isn't made yet.
	$account = cheremosh_get_account_page();
	wp_safe_redirect( $account ? get_permalink( $account ) : home_url( '/' ) );
    	exit;
}
add_action( 'admin_post_nopriv_cheremosh_signup', 'cheremosh_handle_signup' );
add_action( 'admin_post_cheremosh_signup', 'cheremosh_handle_signup' );