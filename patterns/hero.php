<?php

/**
 * Title: Hero
 * Slug: cheremosh/hero
 * Categories: banner
 * Description: Full-width hero banner with a background photo, dark overlay, heading, tagline and Register button.
 *
 * Built on WordPress's core Cover block so the client can swap the background photo for video (or back again) in the editor with "Replace", no code needed.
 *
 * Accessibility:
 * - The 40% black overlay keeps the white text readable on any photo or video.
 * - The H1 is the only H1 on the homepage.
 * - If a video is used, assets/js/hero-video.js adds a Pause/Play button (WCAG 2.2.2 Pause, Stop, Hide) and respects the "reduce motion" setting.
 *
 * Note: patterns are COPIED into a page when inserted. Changing this file does not update pages that already use it; remove the old hero and insert this one again.
 */

// Placeholder background photo shipped with the theme
// (assets/images/hero.jpg). The client replaces it with their own photo or video in the editor.

// Cover block: background media + overlay + content on top.
//  className "cheremosh-hero" is our own hook for the styles in main.css.
//  contentPosition "bottom left" puts the text in the lower-left like Daina's design.
//  dimRatio 40 = 40% overlay opacity.
//  customOverlayColor = the overlay colour (black).
//  minHeight 600px gives the hero its height. align full = edge to edge.
//  Inside: the <span> is the 40% black overlay, the <img> is the background
//  photo (alt="" because it's decorative), and the inner container holds the
//  H1 (only H1 on the homepage), tagline and Register button.
//  home_url() builds the Register link so it works on local, dev and live.
//  NOTE: no HTML comments inside the block, or WordPress marks it invalid.
$cheremosh_hero_image = get_theme_file_uri('assets/images/hero.jpg');
?>
<!-- wp:cover {
	"url":"<?php echo esc_url($cheremosh_hero_image); ?>",
	"dimRatio":40,
	"customOverlayColor":"#000000",
	"isUserOverlayColor":true,
	"minHeight":600,
	"minHeightUnit":"px",
	"contentPosition":"bottom left",
	"align":"full",
	"className":"cheremosh-hero"
} -->
<div
	class="wp-block-cover alignfull has-custom-content-position is-position-bottom-left cheremosh-hero"
	style="min-height:600px">

	<span
		aria-hidden="true"
		class="wp-block-cover__background has-background-dim-40 has-background-dim"
		style="background-color:#000000"></span>

	<img
		class="wp-block-cover__image-background"
		alt=""
		src="<?php echo esc_url($cheremosh_hero_image); ?>"
		data-object-fit="cover" />

	<div class="wp-block-cover__inner-container">

		<!-- wp:heading {"level":1} -->
		<h1 class="wp-block-heading">Cheremosh</h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"className":"hero-tagline"} -->
		<p class="hero-tagline">Ukrainian Dance in Motion</p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button -->
			<div class="wp-block-button">
				<a
					class="wp-block-button__link wp-element-button"
					href="<?php echo esc_url(home_url('/register/')); ?>">Register for a Program</a>
			</div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->

	</div>
</div>
<!-- /wp:cover -->