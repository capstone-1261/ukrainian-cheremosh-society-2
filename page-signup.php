<?php
/**
 * Template Name: Sign Up
 *
 * The member sign-up page.
 *
 * To use it: create a Page called "Sign Up" (slug "sign-up", which is what
 * page-login.php looks for), set its Template to "Sign Up", and publish.
 *
 * Unlike the login page, WordPress has no ready-made front-end registration
 * form we can call, so this is our own markup. The form posts to
 * admin-post.php and inc/signup.php does the work — validating, creating
 * the user and sending them onward.
 *
 * Styling reuses the .auth-* classes from the login page so the two pages
 * match; only the checkbox group has classes of its own.
 *
 * @package cheremosh-theme
 */

get_header();

// Someone already signed in has no use for a sign-up form.
$is_logged_in = is_user_logged_in();

// The Log In page, for the tab and the "Have an account?" link.
$login_page = get_page_by_path( 'log-in' );
$login_url  = $login_page ? get_permalink( $login_page ) : '';

/*
 * Why they were sent back here, if they were.
 *
 * inc/signup.php redirects failures back with ?signup=<reason> so we can
 * say what went wrong. sanitize_key() strips anything that isn't a
 * lowercase letter, number, dash or underscore — nothing from the URL is
 * trusted, and we only compare against values we set ourselves.
 */
$signup_status = isset( $_GET['signup'] ) ? sanitize_key( wp_unslash( $_GET['signup'] ) ) : '';

$signup_message = '';

switch ( $signup_status ) {
	case 'missing':
		$signup_message = 'Please fill in your name, email and a password.';
		break;
	case 'email':
		$signup_message = 'That doesn\'t look like a valid email address.';
		break;
	case 'exists':
		$signup_message = 'There is already an account with that email address.';
		break;
	case 'weak':
		$signup_message = 'Please choose a password of at least 8 characters.';
		break;
	case 'failed':
		$signup_message = 'Something went wrong creating your account. Please try again.';
		break;
}

/*
 * If a submission failed, inc/signup.php passes the name and email back so
 * people don't have to retype them. Passwords are never passed back.
 */
$old_name  = isset( $_GET['name'] ) ? sanitize_text_field( wp_unslash( $_GET['name'] ) ) : '';
$old_email = isset( $_GET['email'] ) ? sanitize_email( wp_unslash( $_GET['email'] ) ) : '';
?>

<main id="main-content" class="auth-page">

	<div class="auth-card">

		<?php /* Tabs: Sign Up | Log In. Sign Up is the current page. */ ?>
		<nav class="auth-tabs" aria-label="Account">
			<span class="auth-tab is-current" aria-current="page">
				Sign Up
			</span>

			<?php if ( $login_url ) : ?>
				<a class="auth-tab" href="<?php echo esc_url( $login_url ); ?>">
					Log In
				</a>
			<?php endif; ?>
		</nav>

		<h1 class="auth-title">Sign Up</h1>

		<?php if ( $is_logged_in ) : ?>

			<?php $current_user = wp_get_current_user(); ?>
			<p class="auth-intro">
				You're already signed in as
				<strong><?php echo esc_html( $current_user->display_name ); ?></strong>.
			</p>

			<p class="auth-intro">
				<a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>">
					Log out
				</a>
			</p>

		<?php else : ?>

			<?php if ( $signup_message ) : ?>
				<?php
				/*
				 * role="alert" makes a screen reader announce this on load.
				 * The message says what went wrong in words — the red border
				 * alone isn't enough, since not everyone sees colour.
				 */
				?>
				<p class="auth-error" role="alert">
					<?php echo esc_html( $signup_message ); ?>
				</p>
			<?php endif; ?>

			<p class="auth-intro">
				Create an account to register for programs.
			</p>

			<?php
			/*
			 * admin-post.php is WordPress's built-in endpoint for handling
			 * form submissions. The hidden "action" field below tells it
			 * which handler to run — ours, in inc/signup.php.
			 */
			?>
			<form id="signupform" method="post"
			      action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

				<?php
				/*
				 * The security nonce. WordPress checks this on the other side
				 * to confirm the submission came from our own form and not
				 * from somewhere else pretending to be us.
				 */
				wp_nonce_field( 'cheremosh_signup', 'cheremosh_signup_nonce' );
				?>

				<input type="hidden" name="action" value="cheremosh_signup">

				<p>
					<label for="signup-name">Name</label>
					<?php
					/*
					 * autocomplete="name" lets the browser and password
					 * managers fill this in. required gives us the browser's
					 * own check before the form is even sent; inc/signup.php
					 * checks again on the server, which is the one that counts.
					 */
					?>
					<input type="text" id="signup-name" name="signup_name"
					       value="<?php echo esc_attr( $old_name ); ?>"
					       autocomplete="name" required>
				</p>

				<p>
					<label for="signup-email">Email</label>
					<input type="email" id="signup-email" name="signup_email"
					       value="<?php echo esc_attr( $old_email ); ?>"
					       autocomplete="email" required>
				</p>

				<p>
					<label for="signup-password">Password</label>
					<?php
					// autocomplete="new-password" tells password managers to
					// offer a generated password rather than a saved one.
					?>
					<input type="password" id="signup-password" name="signup_password"
					       autocomplete="new-password" minlength="8" required>
					<span class="signup-hint">At least 8 characters.</span>
				</p>

				<?php
				/*
				 * The interest checkboxes.
				 *
				 * A <fieldset> with a <legend> is the correct grouping for
				 * related checkboxes: a screen reader reads the legend before
				 * each option, so "School of Dance" is heard in context rather
				 * than on its own.
				 *
				 * The name ends in [] so both boxes arrive as an array when
				 * someone ticks both.
				 */
				?>
				<fieldset class="signup-interests">
					<legend>What are you looking to sign up for?</legend>
					<p class="signup-hint">Can be both if you wish.</p>

					<label class="signup-check">
						<input type="checkbox" name="signup_interest[]" value="school-of-dance">
						School of Dance
					</label>

					<label class="signup-check">
						<input type="checkbox" name="signup_interest[]" value="dance-company">
						Dance Company Membership
					</label>
				</fieldset>

				<p class="signup-submit">
					<button type="submit">Create Account</button>
				</p>
			</form>

			<?php if ( $login_url ) : ?>
				<p class="auth-switch">
					Have an account?
					<a href="<?php echo esc_url( $login_url ); ?>">Log in</a>
				</p>
			<?php endif; ?>

		<?php endif; ?>

	</div><!-- .auth-card -->

</main>

<?php
get_footer();