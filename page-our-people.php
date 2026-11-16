<?php
/**
 * Our People page template
 *
 * WordPress uses this file for the page with the slug "our-people"
 * (page-{slug}.php).
 *
 * The design gives each of the three groups its own layout, so this file
 * renders them separately rather than looping one card design three times:
 *
 *   Artistic Director — a full-width banner: portrait left, text right.
 *   Instructors       — a row of landscape photos with a name bar under each.
 *   Board             — a grid of cards: photo, name, short bio.
 *
 * Fields come from Sam's ACF "Info" group: photo (image URL), bio (text).
 * There is no job-title or social-link field yet, so the Board cards leave
 * those out for now.
 *
 * @package cheremosh-theme
 */

get_header(); // Loads header.php (skip link, announcement bar, menu).

/**
 * Fetch people for a section.
 *
 * Wrapped in a function so the three sections below each read as one line
 * instead of repeating the same twenty lines of WP_Query arguments.
 *
 * @param string $post_type 'people' or 'instructors'.
 * @param string $role      A slug from the People > Roles taxonomy, or ''.
 * @return WP_Query
 */
function cheremosh_get_people( $post_type, $role = '' ) {
	$args = array(
		'post_type'      => $post_type,
		'posts_per_page' => -1,   // No paging; these lists are small.
		'orderby'        => 'title',
		'order'          => 'ASC',
	);

	// Narrow to one role (e.g. just the Board) when a slug is given.
	if ( $role ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'role',
				'field'    => 'slug',
				'terms'    => $role,
			),
		);
	}

	return new WP_Query( $args );
}

/**
 * The photo for a person, as an <img> tag.
 *
 * Prefers the ACF photo field and falls back to the featured image, so a
 * person entered either way still shows a picture.
 *
 * @param string $class CSS class for the image.
 * @param int    $width Width attribute, in pixels.
 * @return string The <img> markup, or '' when there is no photo.
 */
function cheremosh_person_photo( $class, $width ) {
	$photo = function_exists( 'get_field' ) ? get_field( 'photo' ) : '';

	if ( $photo ) {
		return sprintf(
			'<img class="%1$s" src="%2$s" alt="%3$s" width="%4$d" loading="lazy">',
			esc_attr( $class ),
			esc_url( $photo ),
			esc_attr( get_the_title() ),
			absint( $width )
		);
	}

	if ( has_post_thumbnail() ) {
		return get_the_post_thumbnail(
			get_the_ID(),
			'medium',
			array(
				'class'   => $class,
				'loading' => 'lazy',
			)
		);
	}

	return ''; // No photo: the layouts below cope with it being absent.
}
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<?php
	// The page's own intro text, typed into the editor.
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class(); ?>>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</article>
	<?php endwhile; ?>


	<?php /* ============================================================
	       SECTION 1 — Artistic Director

	       A banner, not a card: portrait on the left, text on the right.
	       Usually one person, but written as a loop so a second one
	       stacks underneath instead of breaking the layout.
	       ============================================================ */ ?>

	<?php $director = cheremosh_get_people( 'people', 'artistic-director' ); ?>

	<?php if ( $director->have_posts() ) : ?>
		<section class="people-feature">
			<h2 class="people-heading">Artistic Director</h2>

			<?php while ( $director->have_posts() ) : $director->the_post(); ?>
				<article class="feature-person">

					<?php
					// 400px: the banner portrait is the largest photo on the page.
					echo cheremosh_person_photo( 'feature-photo', 400 );
					?>

					<div class="feature-text">
						<?php
						/*
						 * The small label above the name ("ARTISTIC DIRECTOR").
						 * Taken from the person's Role term rather than hard-coded,
						 * so it still reads correctly if the term is renamed.
						 */
						$terms = get_the_terms( get_the_ID(), 'role' );

						if ( $terms && ! is_wp_error( $terms ) ) :
							?>
							<p class="feature-role"><?php echo esc_html( $terms[0]->name ); ?></p>
						<?php endif; ?>

						<h3 class="feature-name"><?php the_title(); ?></h3>

						<?php
						// Bio, trimmed. Falls back to the excerpt if the field is empty.
						$bio = function_exists( 'get_field' ) ? get_field( 'bio' ) : '';
						?>
						<?php if ( $bio ) : ?>
							<p class="feature-bio"><?php echo esc_html( wp_trim_words( $bio, 45 ) ); ?></p>
						<?php else : ?>
							<?php the_excerpt(); ?>
						<?php endif; ?>

						<a class="button" href="<?php the_permalink(); ?>"
						   aria-label="Learn more about <?php the_title_attribute(); ?>">Learn More</a>
					</div>

				</article>
			<?php endwhile; ?>
		</section>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>


	<?php /* ============================================================
	       SECTION 2 — Instructors

	       A row of landscape photos, each with the name on a bar
	       underneath. No bio and no button in the design — the whole
	       tile is the link.
	       ============================================================ */ ?>

	<?php $instructors = cheremosh_get_people( 'instructors' ); ?>

	<?php if ( $instructors->have_posts() ) : ?>
		<section class="people-instructors">
			<h2 class="people-heading">Meet Our Instructors</h2>

			<ul class="instructor-grid">
				<?php while ( $instructors->have_posts() ) : $instructors->the_post(); ?>
					<li class="instructor-tile">
						<?php
						/*
						 * The whole tile is one link wrapping photo and name,
						 * so there's a single large target rather than a small
						 * text link — easier to hit, and one stop for keyboard
						 * users instead of two.
						 */
						?>
						<a href="<?php the_permalink(); ?>">
							<?php echo cheremosh_person_photo( 'instructor-photo', 400 ); ?>
							<span class="instructor-name"><?php the_title(); ?></span>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
		</section>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>


	<?php /* ============================================================
	       SECTION 3 — Board

	       A grid of cards: photo, name, short bio. The design also shows
	       a job title and social icons; there are no ACF fields for those
	       yet, so they're left out rather than faked.
	       ============================================================ */ ?>

	<?php $board = cheremosh_get_people( 'people', 'board' ); ?>

	<?php if ( $board->have_posts() ) : ?>
		<section class="people-board">
			<h2 class="people-heading">Our Board</h2>

			<ul class="board-grid">
				<?php while ( $board->have_posts() ) : $board->the_post(); ?>
					<li class="board-card">
						<?php echo cheremosh_person_photo( 'board-photo', 300 ); ?>

						<h3 class="board-name"><?php the_title(); ?></h3>

						<?php $bio = function_exists( 'get_field' ) ? get_field( 'bio' ) : ''; ?>
						<?php if ( $bio ) : ?>
							<p class="board-bio"><?php echo esc_html( wp_trim_words( $bio, 25 ) ); ?></p>
						<?php endif; ?>

						<a class="board-link" href="<?php the_permalink(); ?>"
						   aria-label="Learn more about <?php the_title_attribute(); ?>">Learn More</a>
					</li>
				<?php endwhile; ?>
			</ul>
		</section>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>

</main>

<?php
get_footer(); // Loads footer.php.