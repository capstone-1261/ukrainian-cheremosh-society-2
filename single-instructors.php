<?php
/**
 * Single Instructor template
 *
 * WordPress uses this file automatically for any post in the "instructors"
 * post type (single-{post_type}.php).
 *
 * Shows: name, role, photo, bio (from the ACF "Info" fields, same as
 * single-people.php), any extra page content, the programs they teach,
 * and a link back to Our People.
 * Structure only: styling comes later.
 */
get_header(); // Loads header.php (skip link, announcement bar, logo, main menu).
?>
<main id="main-content"> <!-- The skip link in header.php jumps here. -->
	<?php
	// The Loop: on a single page this runs once, for the instructor being viewed.
	while ( have_posts() ) :
		the_post();

		// ACF fields (Sam's "Info" group in inc/content-types.php).
		// function_exists() stops the page from crashing if ACF is ever turned off.
		$photo    = function_exists( 'get_field' ) ? get_field( 'photo' ) : '';            // Image URL.
		$bio      = function_exists( 'get_field' ) ? get_field( 'bio' ) : '';              // Plain text bio.
		$programs = function_exists( 'get_field' ) ? get_field( 'related_program' ) : ''; // Programs they teach (two-way with the program's Instructors list).

		// The "role" taxonomy (e.g. Instructor, Artistic Director) as plain text.
		$roles = get_the_term_list( get_the_ID(), 'role', '', ', ' );
	?>
		<article <?php post_class(); ?>>

			<!-- Instructor's name (post title). Only H1 on the page. -->
			<h1><?php the_title(); ?></h1>

			<?php if ( $roles && ! is_wp_error( $roles ) ) : ?>
				<!-- wp_strip_all_tags() removes the term links so the role shows as plain text. -->
				<p class="instructor-role"><?php echo esc_html( wp_strip_all_tags( $roles ) ); ?></p>
			<?php endif; ?>

			<?php if ( $photo ) : ?>
				<!-- ACF photo. Alt text is the instructor's name.
				     ACF only gives us the image URL, so the browser would show it full size.
				     width="400" caps it; with no height set, the browser keeps the proportions.
				     The class lets us style it properly in main.css later.
				     loading="lazy" waits to load the image until it's near the screen. -->
				<img class="instructor-photo" src="<?php echo esc_url( $photo ); ?>" alt="<?php the_title_attribute(); ?>" width="400" loading="lazy">
			<?php elseif ( has_post_thumbnail() ) : ?>
				<!-- Fallback: the featured image, if there's no ACF photo.
				     'medium' is a WordPress image size (300px wide by default), so it's already small. -->
				<?php the_post_thumbnail( 'medium', array( 'class' => 'instructor-photo' ) ); ?>
			<?php endif; ?>

			<?php if ( $bio ) : ?>
				<!-- wpautop() turns line breaks in the bio into proper paragraphs. -->
				<?php echo wp_kses_post( wpautop( $bio ) ); ?>
			<?php endif; ?>

			<?php
			// Any extra content added in the editor (optional).
			the_content();
			?>

			<?php if ( $programs ) : ?>
				<!-- Programs this instructor teaches, linked to each program page. -->
				<section class="instructor-programs" aria-labelledby="instructor-programs-heading">
					<h2 id="instructor-programs-heading">Programs</h2>
					<ul>
						<?php foreach ( $programs as $program ) : ?>
							<li>
								<a href="<?php echo esc_url( get_permalink( $program ) ); ?>">
									<?php echo esc_html( get_the_title( $program ) ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endif; ?>

			<!-- Back link so visitors aren't stuck on a dead end. -->
			<p class="back-link">
				<a href="<?php echo esc_url( home_url( '/our-people/' ) ); ?>">&larr; Back to Our People</a>
			</p>

		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright, wp_footer()).