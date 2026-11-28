<?php
/**
 * Template Name: Festival Video Tutorials
 *
 * Festival Registration Video Tutorials page template
 *
 * The "Template Name" line above makes this template show up in the page
 * settings in wp-admin. That is what makes the video link boxes appear on
 * the page (see inc/festival-videos-fields.php).
 *
 * The seven videos show schools how to use the festival registration system
 * (reg.cheremosh.ca). The titles come from the client's copy document
 * (section 5, Festival Subpages). There is no Figma design for this page, so
 * it reuses the Press Kit page's cards and button (.press-kit-*).
 *
 * @package cheremosh-theme
 */

get_header(); // Loads header.php (skip link, announcement bar, logo, main menu).
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<section class="press-kit" aria-labelledby="festival-videos-heading">
		<div class="press-kit-inner">

			<p class="about-label">Dance Festival</p>
			<h1 id="festival-videos-heading" class="press-kit-title">Festival Registration Video Tutorials</h1>
			<span class="about-rule" aria-hidden="true"></span>

			<p class="press-kit-note">Watch step-by-step video walkthroughs of the festival registration system.</p>

			<!-- One card per video. A list, because it is seven items. -->
			<ul class="press-kit-list">
				<?php foreach ( cheremosh_festival_video_titles() as $index => $title ) : ?>
					<?php
					// The link the client pasted in wp-admin. Empty means no video yet.
					$video_url = get_field( 'festival_video_' . ( $index + 1 ) . '_link' );
					?>
					<li class="press-kit-item">
						<h2 class="press-kit-item-title"><?php echo esc_html( $title ); ?></h2>

						<?php if ( $video_url ) : ?>
							<!-- The video is ready: link straight to it. aria-label says which one. -->
							<a class="button press-kit-button" href="<?php echo esc_url( $video_url ); ?>" aria-label="<?php echo esc_attr( 'Watch the video: ' . $title ); ?>">Watch Video</a>
						<?php else : ?>
							<!-- No video yet: plain text, so there is no button that goes nowhere. -->
							<p>Video coming soon.</p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>

			<!-- Where the tutorials are used. -->
			<p class="press-kit-note">Ready to enter? <a href="https://reg.cheremosh.ca">Go to the festival registration system</a>.</p>
		</div>
	</section>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright).