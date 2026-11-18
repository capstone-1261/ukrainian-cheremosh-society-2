<?php
/**
 * Dance Festival page template
 *
 * WordPress picks this file up automatically for the page whose slug is
 * "dance-festival" (the page-{slug}.php naming rule).
 *
 * The page is mostly client-written prose — the postponement notice, the
 * festival history, the adjudicator bio and the scholarship winners table.
 * All of that is entered in the WordPress editor rather than typed into
 * this file, for two reasons:
 *
 *   1. The postponement notice is temporary. Cheremosh needs to be able to
 *      take it down themselves once the festival is rescheduled.
 *   2. The scholarship winners change every year.
 *
 * What this template does own is the parts that shouldn't be retyped by
 * hand each time: the page wrapper, and the list of festival subpages at
 * the bottom, which is built from the page's children so adding a subpage
 * in the editor makes it appear here automatically.
 *
 * @package cheremosh-theme
 */

get_header(); // Loads header.php (skip link, announcement bar, menu).
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<?php
	/*
	 * The page itself: title, then whatever has been built in the editor.
	 *
	 * Written as a loop because that's how WordPress hands over a page's
	 * content, even though a page template only ever runs for one page.
	 */
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class( 'festival-page' ); ?>>

			<h1 class="festival-title"><?php the_title(); ?></h1>

			<?php
			/*
			 * the_content() prints the blocks from the editor. The notice,
			 * the history, the venue details, the adjudicator bio and the
			 * winners table all arrive through here.
			 *
			 * Styling hooks for those live in main.css:
			 *   .festival-notice  — the postponement callout
			 *   .festival-table   — the scholarship winners table
			 *
			 * Both are applied in the editor via the block's Advanced >
			 * Additional CSS class field.
			 */
			the_content();
			?>

		</article>
	<?php endwhile; ?>


	<?php
	/* ================================================================
	   Festival subpages

	   The account portal, entry fee payment, donations and the tutorial
	   videos each get their own page. Rather than hard-coding four links
	   that break the moment a page is renamed, this pulls the current
	   page's child pages.

	   Adding a child page in the editor adds it here. Removing one
	   removes it. Nothing to update in code.
	   ================================================================ */

	$festival_subpages = new WP_Query(
		array(
			'post_type'      => 'page',
			'post_parent'    => get_the_ID(), // Children of this page only.
			'posts_per_page' => -1,           // No paging; there are a handful.
			'orderby'        => 'menu_order', // Editor's Order field, so the
			'order'          => 'ASC',        // client controls the sequence.
		)
	);
	?>

	<?php if ( $festival_subpages->have_posts() ) : ?>
		<section class="festival-subpages">

			<h2 class="festival-subpages-heading">Festival Pages</h2>

			<ul class="festival-subpage-grid">
				<?php
				while ( $festival_subpages->have_posts() ) :
					$festival_subpages->the_post();
					?>
					<li class="festival-subpage-card">
						<?php
						/*
						 * The whole card is one link wrapping the heading and
						 * the summary, so there's a single large target rather
						 * than a small text link — easier to hit, and one stop
						 * for keyboard users instead of two.
						 */
						?>
						<a href="<?php the_permalink(); ?>">

							<h3 class="festival-subpage-name"><?php the_title(); ?></h3>

							<?php
							/*
							 * The subpage's excerpt as a one-line summary.
							 * Only printed when one has been written — an empty
							 * paragraph under a heading looks like a mistake.
							 */
							$summary = get_the_excerpt();
							?>
							<?php if ( $summary ) : ?>
								<p class="festival-subpage-summary">
									<?php echo esc_html( wp_trim_words( $summary, 20 ) ); ?>
								</p>
							<?php endif; ?>

						</a>
					</li>
				<?php endwhile; ?>
			</ul>

		</section>

		<?php
		/*
		 * Puts the main page back as the "current" post. Without this,
		 * anything after the loop (including the footer) would still think
		 * it was on the last subpage.
		 */
		wp_reset_postdata();
		?>
	<?php endif; ?>

</main>

<?php
get_footer(); // Loads footer.php.