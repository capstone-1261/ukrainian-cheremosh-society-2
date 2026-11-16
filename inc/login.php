<?php
/**
 * Login handling.
 *
 * By default, a failed login sends the visitor to WordPress's own
 * wp-login.php screen — the grey one with the WordPress logo. That throws
 * them out of our site's design mid-task.
 *
 * The hook below keeps them on our Log In page and passes the reason
 * along in the URL so the template can show a message.
 *
 * @package cheremosh-theme
 */

// Stop the file being loaded directly by visiting its URL.
defined( 'ABSPATH' ) || exit;

/**
 * Find our Log In page.
 *
 * Kept in one place so there's a single line to change if the page slug
 * ever changes.
 *
 * @return string The page URL, or an empty string if the page is missing.
 */
function cheremosh_login_page_url() {
	$page = get_page_by_path( 'log-in' );

	return $page ? get_permalink( $page ) : '';
}

/**
 * Send a failed login back to our page instead of wp-login.php.
 *
 * wp_login_failed fires whenever authentication returns an error — wrong
 * password, unknown email, and blank fields alike. The error object tells
 * us which, so one hook covers every case.
 *
 * @param string   $username What they typed in the email field.
 * @param WP_Error $error    Why it failed.
 */
function cheremosh_redirect_failed_login( $username, $error = null ) {
	$url = cheremosh_login_page_url();

	// No Log In page yet — let WordPress do its normal thing.
	if ( ! $url ) {
		return;
	}

	/*
	 * Only take over logins that came from our own page.
	 *
	 * Without this, an admin mistyping their password on wp-login.php
	 * would be thrown out to the front-end login page. wp_get_referer()
	 * is the page the form was submitted from; we only act when that's
	 * our Log In page.
	 */
	$referer = wp_get_referer();

	if ( ! $referer || 0 !== strpos( $referer, $url ) ) {
		return;
	}

	/*
	 * Blank fields or wrong details?
	 *
	 * WordPress gives empty submissions the error codes empty_username
	 * and empty_password. Anything else we treat as wrong credentials.
	 *
	 * Note we never say which of the two was wrong — telling someone the
	 * email exists but the password doesn't is how you let an attacker
	 * confirm who has an account.
	 */
	$code = is_wp_error( $error ) ? $error->get_error_code() : '';

	$status = in_array( $code, array( 'empty_username', 'empty_password' ), true )
		? 'empty'
		: 'failed';

	/*
	 * add_query_arg() appends ?login=failed (or empty) to the URL.
	 * wp_safe_redirect() refuses to send anyone to another domain, which
	 * stops this being used to bounce people off-site.
	 */
	wp_safe_redirect( add_query_arg( 'login', $status, $url ) );
	exit; // Always exit after a redirect, or the rest of the page runs too.
}
add_action( 'wp_login_failed', 'cheremosh_redirect_failed_login', 10, 2 );