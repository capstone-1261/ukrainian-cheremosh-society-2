<?php
/**
 * Template Name: Account
 *
 * The page a member lands on after signing in.
 *
 * To use it: create a Page called "My Account", then set its Template to
 * "Account" in the Page tab of the editor sidebar.
 *
 * There is no Figma design for this page yet, so the markup here is kept
 * deliberately plain and reuses the .auth-* classes from the login page.
 * When Daina designs it, the structure below shouldn't need to change —
 * only the CSS.
 *
 * @package cheremosh-theme
 */

get_header();

/*
 * Everything on this page is private, so the first thing we do is check
 * whether anyone is actually signed in.
 *
 * Note this is a soft check, not security: it decides what to display.
 * Anything that must be protected (a member-only registration form, a
 * payment) has to be checked again at the point it's used, not just here.
 */
$is_logged_in = is_user_logged_in();

/*
 * Find the Log In page so we can link to it. Same approach as the login
 * template uses for Sign Up — look it up by slug, and fall back to the
 * home page if someone hasn't created it yet, so the link is never dead.
 */
$login_page = get_page_by_path( 'log-in' );
$login_url  = $login_page ? get_permalink( $login_page ) : home_url( '/' );
?>

<main id="main-content" class="auth-page">

	<div class="account-card">

		<?php if ( ! $is_logged_in ) : ?>

			<?php /* Signed out: say so plainly and point at the login page. */ ?>
			<h1 class="auth-title">My Account</h1>

			<p class="auth-intro">
				You need to be signed in to see this page.
			</p>

			<p class="auth-switch">
				<a href="<?php echo esc_url( $login_url ); ?>">Log in</a>
			</p>

		<?php else : ?>

			<?php
			/*
			 * wp_get_current_user() returns a WP_User object for whoever is
			 * signed in. display_name is what WordPress shows publicly;
			 * user_email is the address they signed up with.
			 */
			$current_user = wp_get_current_user();
			?>

			<h1 class="auth-title">
				Welcome, <?php echo esc_html( $current_user->display_name ); ?>
			</h1>

			<?php /* ---- Their details ---- */ ?>
			<section class="account-section">
				<h2 class="account-heading">Your details</h2>

				<?php
				/*
				 * A description list is the right element here: each item is
				 * a label paired with a value, which is exactly what <dl>
				 * describes. Screen readers announce the pairing.
				 */
				?>
				<dl class="account-details">
					<dt>Name</dt>
					<dd><?php echo esc_html( $current_user->display_name ); ?></dd>

					<dt>Email</dt>
					<dd><?php echo esc_html( $current_user->user_email ); ?></dd>
				</dl>

				<?php
				/*
				 * get_edit_profile_url() is core's profile screen in wp-admin.
				 * It works today, but it drops members into the WordPress
				 * back end, which is not where we want volunteers' parents
				 * to end up. Replace this with our own edit form once the
				 * design exists.
				 */
				?>
				<p class="account-action">
					<a href="<?php echo esc_url( get_edit_profile_url() ); ?>">
						Edit your details
					</a>
				</p>
			</section>

			<?php /* ---- Their program registrations ---- */ ?>
			<section class="account-section">
				<h2 class="account-heading">Your registrations</h2>

				<?php
				/*
				 * Nothing to list yet — program registrations aren't built.
				 * When they are, this is where that query goes: find the
				 * registrations belonging to $current_user->ID and loop them
				 * out, with this paragraph as the empty state.
				 */
				?>
				<p class="account-empty">
					You aren't registered for any programs yet.
				</p>

				<?php
				/*
				 * Link to the programs listing so the empty state gives them
				 * somewhere to go. Looked up by slug, hidden if missing.
				 */
				$programs_page = get_page_by_path( 'dance-with-us' );
				?>
				<?php if ( $programs_page ) : ?>
					<p class="account-action">
						<a href="<?php echo esc_url( get_permalink( $programs_page ) ); ?>">
							Browse programs
						</a>
					</p>
				<?php endif; ?>
			</section>

			<?php /* ---- Sign out ---- */ ?>
			<p class="account-logout">
				<?php
				/*
				 * wp_logout_url() builds a log-out link carrying its own
				 * security nonce. The argument is where to send them after.
				 */
				?>
				<a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>">
					Log out
				</a>
			</p>

		<?php endif; ?>

	</div><!-- .account-card -->

</main>

<?php
get_footer();