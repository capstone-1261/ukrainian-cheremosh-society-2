<?php
/**
 * Press Kit page template
 *
 * WordPress uses this file for the page with the slug "press-kit"
 * (page-{slug}.php). It gives media and presenters the four things they
 * need: the brand standards guide, the company biography, logos and fonts,
 * and press photos and the promo video.
 *
 * There is no Figma design for this page, so it reuses the About page
 * banner (.about-hero). Wording comes from the client's copy document
 * (section 3.4).
 */

// The four press kit items. Each one has a title, a short description and
// a "url" for the file. While a url is empty, the card shows a "Request
// this file" email link instead of a download button. When the files are
// ready, upload them to the Media Library and paste each file's URL here.
$press_items = array(
	array(
		'title' => 'Brand Standards Guide',
		'text'  => 'Rules for logo placement, colour palettes, and typography.',
		'url'   => '',
	),
	array(
		'title' => 'Official Company Biography',
		'text'  => 'Ready-to-publish short and long biographies for programs and press releases.',
		'url'   => '',
	),
	array(
		'title' => 'Logos, Fonts & Vector Graphics',
		'text'  => 'Official Company logos in PNG and vector formats alongside approved brand fonts.',
		'url'   => '',
	),
	array(
		'title' => 'High-Resolution Press Photos & Promo Video',
		'text'  => 'Stage photography and a one-minute broadcast promotional reel (HD and SD).',
		'url'   => '',
	),
);

// Where media requests go while a file has no download yet.
$press_email = 'performances@cheremosh.ca';

get_header(); // Loads header.php (skip link, announcement bar, logo, main menu).
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<!--
		1. HERO BANNER
		Same layout as the About page banner. The photo is this page's
		Featured image, set in the page editor.
	-->
	<section class="about-hero">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'full', array( 'class' => 'about-hero-image', 'alt' => '' ) ); ?>
		<?php endif; ?>

		<div class="about-hero-text">
			<p class="about-hero-tagline">Cheremosh | Edmonton since 1969</p>
			<h1 class="about-hero-title about-hero-title--wide">Media &amp; Presenter Press Kit</h1>
			<div class="about-hero-bottom">
				<p class="about-hero-description">Download official bios, high-resolution performance photography, broadcast video, and logo files for the Cheremosh Ukrainian Dance Company.</p>
			</div>
		</div>
	</section>

	<!--
		2. THE FOUR PRESS KIT ITEMS
		A list, because it is four items. Each one is a card with a title,
		a short description and a button.
	-->
	<section class="press-kit" aria-labelledby="press-kit-heading">
		<div class="press-kit-inner">

			<p class="about-label">Press Kit</p>
			<h2 id="press-kit-heading" class="press-kit-title">What&rsquo;s in the Kit</h2>
			<span class="about-rule" aria-hidden="true"></span>

			<ul class="press-kit-list">
				<?php foreach ( $press_items as $item ) : ?>
					<li class="press-kit-item">
						<h3 class="press-kit-item-title"><?php echo esc_html( $item['title'] ); ?></h3>
						<p><?php echo esc_html( $item['text'] ); ?></p>

						<?php if ( $item['url'] ) : ?>
							<!-- A file is ready: link straight to it. aria-label says which one. -->
							<a class="button press-kit-button" href="<?php echo esc_url( $item['url'] ); ?>" aria-label="<?php echo esc_attr( 'Download ' . $item['title'] ); ?>">Download</a>
						<?php else : ?>
							<!-- No file yet: an email link, with the item name filled into the subject. -->
							<a class="button press-kit-button" href="<?php echo esc_url( 'mailto:' . $press_email . '?subject=' . rawurlencode( 'Press kit request: ' . $item['title'] ) ); ?>" aria-label="<?php echo esc_attr( 'Request ' . $item['title'] ); ?>">Request this file</a>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>

			<!-- For media who need something that is not listed. -->
			<p class="press-kit-note">Need something else? Email <a href="<?php echo esc_url( 'mailto:' . $press_email ); ?>"><?php echo esc_html( $press_email ); ?></a>.</p>
		</div>
	</section>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright).