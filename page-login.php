<?php
/**
 * Template Name: Login
 *
 * The member log-in page.
 *
 * To use it: create a Page in WordPress called "Log In", then in the page
 * editor open the Page tab in the right sidebar and set Template to "Login".
 *
 * The form itself comes from wp_login_form(), a WordPress core function.
 * We let core build it rather than writing our own <form> because core
 * handles the security nonce, the session cookie and the redirect after
 * login. WordPress also accepts an email address in the username field
 * out of the box, which is what our design asks for.
 *
 * Failed logins are sent back here by inc/login.php, which adds
 * ?login=failed or ?login=empty to the URL. The message block below
 * turns that into something readable.
 *
 * @package cheremosh-theme
 */

get_header();

/*
 * If someone who is already signed in lands here, there is no point
 * showing them a login form. is_user_logged_in() is a core function that
 * returns true when the current visitor has a valid session.
 */
$is_logged_in = is_user_logged_in();

/*
 * The Sign Up page may not exist yet. get_page_by_path() looks a page up
 * by its slug and returns null if it isn't there, so we can hide the link
 * instead of printing a dead one.
 */
$signup_page = get_page_by_path( 'sign-up' );
$signup_url  = $signup_page ? get_permalink( $signup_page ) : '';

/*
 * ---- THE LOGIN MESSAGE, PART 1 OF 2: work out what to say ----
 *
 * inc/login.php sends a failed attempt back here with ?login=failed
 * (wrong details) or ?login=empty (blank fields) on the URL.
 *
 * sanitize_key() strips anything that isn't a lowercase letter, number,
 * dash or underscore. Nothing from the URL is ever trusted as-is, and we
 * only ever compare it against the two values we set ourselves.
 */
$login_status = isset( $_GET['login'] ) ? sanitize_key( wp_unslash( $_GET['login'] ) ) : '';

$login_message = '';

if ( 'failed' === $login_status ) {
	$login_message = 'That email or password wasn\'t right. Please try again.';
} elseif ( 'empty' === $login_status ) {
	$login_message = 'Please fill in both your email and your password.';
}
?>

<main id="main-content" class="auth-page">

	<div class="auth-card">

		<?php /* Tabs across the top: Sign Up | Log In. */ ?>
		<nav class="auth-tabs" aria-label="Account">
			<?php if ( $signup_url ) : ?>
				<a class="auth-tab" href="<?php echo esc_url( $signup_url ); ?>">
					Sign Up
				</a>
			<?php endif; ?>

			<?php
			/*
			 * The current tab is a <span>, not a link — there's nowhere to go.
			 * aria-current="page" tells a screen reader this is the page
			 * you're on, so the underline isn't the only way to know.
			 */
			?>
			<span class="auth-tab is-current" aria-current="page">
				Log In
			</span>
		</nav>

		<h1 class="auth-title">Log In</h1>

		<?php if ( $is_logged_in ) : ?>

			<?php
			/*
			 * Already signed in: greet them and offer a way out.
			 * wp_logout_url() builds a log-out link with its own security
			 * nonce; the argument is where to send them afterwards.
			 */
			$current_user = wp_get_current_user();
			?>
			<p class="auth-intro">
				You're signed in as
				<strong><?php echo esc_html( $current_user->display_name ); ?></strong>.
			</p>

			<p class="auth-intro">
				<a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>">
					Log out
				</a>
			</p>

		<?php else : ?>

			<?php
			/*
			 * ---- THE LOGIN MESSAGE, PART 2 OF 2: show it ----
			 *
			 * This is the spot: under the heading, above the intro line and
			 * the form. It prints nothing at all unless they've just had a
			 * failed attempt.
			 *
			 * role="alert" makes a screen reader announce it as soon as the
			 * page loads, instead of only reading it if the user happens to
			 * move through it. The text says what went wrong in words — the
			 * red border alone isn't enough, since not everyone sees colour.
			 */
			?>
			<?php if ( $login_message ) : ?>
				<p class="auth-error" role="alert">
					<?php echo esc_html( $login_message ); ?>
				</p>
			<?php endif; ?>

			<p class="auth-intro">
				Sign in to register for programs and manage your account.
			</p>

			<?php
			/*
			 * "Forgot your password?"
			 *
			 * The design puts this beside the Password field, inside the
			 * form. wp_login_form() doesn't take that as an argument, but
			 * core runs its output through filters, and login_form_middle
			 * lands between the password field and the submit button —
			 * exactly where we need it.
			 *
			 * We store the function in a variable so we can remove the
			 * filter again straight after; otherwise it would attach itself
			 * to every other login form on the site.
			 *
			 * wp_lostpassword_url() is core's reset-password screen.
			 */
			$cheremosh_forgot_link = function () {
				return '<p class="auth-forgot"><a href="'
					. esc_url( wp_lostpassword_url() )
					. '">Forgot your password?</a></p>';
			};

			add_filter( 'login_form_middle', $cheremosh_forgot_link );

			/*
			 * wp_login_form() prints the form. Every option below is one of
			 * core's accepted arguments:
			 *
			 * echo           — print it rather than return it as a string.
			 * redirect       — where to send them after a successful login.
			 * label_username — core calls it "Username"; our design says Email.
			 * remember       — false, because the design has no "remember me"
			 *                  checkbox. Set it true if that changes.
			 * id_*           — ids we can target from CSS.
			 *
			 * We deliberately do NOT pass form_id, so the form keeps core's
			 * default id of "loginform", which is what main.css targets.
			 */
			wp_login_form(
				array(
					'echo'           => true,
					'redirect'       => get_permalink(),
					'label_username' => 'Email',
					'label_password' => 'Password',
					'label_log_in'   => 'Log In',
					'id_username'    => 'cheremosh-login-email',
					'id_password'    => 'cheremosh-login-password',
					'id_submit'      => 'cheremosh-login-submit',
					'remember'       => false,
				)
			);

			// Take the filter back off so it can't affect any other form.
			remove_filter( 'login_form_middle', $cheremosh_forgot_link );
			?>

			<?php if ( $signup_url ) : ?>
				<p class="auth-switch">
					Don't have an account?
					<a href="<?php echo esc_url( $signup_url ); ?>">Sign up</a>
				</p>
			<?php endif; ?>

		<?php endif; ?>

	</div><!-- .auth-card -->

</main>

<?php
get_footer();