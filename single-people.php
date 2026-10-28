<?php

/**
 * Single Person template
 *
 * WordPress uses this file automatically for any post in the "people"
 * post type (single-{post_type}.php), for example the Artistic Director
 * or a Board member. Instructors have their own template
 * (single-instructors.php).
 *
 * Shows: name, role, photo, bio, and any extra page content.
 * Structure only: no styling yet.
 */

get_header(); // Loads header.php (skip link, site name, main menu).
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

    <?php
    // The Loop: on a single page this runs once, for the person being viewed.
    while (have_posts()) :
        the_post();

        // ACF fields (set up by Sameer in inc/content-types.php, "Info" group).
        // function_exists() stops the page from crashing if ACF is ever turned off.
        $photo = function_exists('get_field') ? get_field('photo') : ''; // Image
        $bio = function_exists('get_field') ? get_field('bio') : ''; // Plain text bio

        // The "role" taxonomy (Artistic Director, Board, etc.) as a comma-separated list.
        $roles = get_the_term_list(get_the_ID(), 'role', '', ', ');
    ?>

        <article <?php post_class(); ?>>

            <!-- Person's name (post title). Only H1 on the page. -->
            <h1><?php the_title(); ?></h1>

            <?php
            // Role(s). strip_tags() removes the term links so it shows as plain text.
            if ($roles && ! is_wp_error($roles)) :
            ?>
                <p><?php echo wp_kses_post(strip_tags($roles)); ?></p>
            <?php endif; ?>

            <?php
            // Photo: use the ACF photo field first. If it's empty, fall back to
            // the featured image. The alt text is the person's name for screen readers.
            if ($photo) :
            ?>
                <img src="<?php echo esc_url($photo); ?>" alt="<?php the_title_attribute(); ?>">
            <?php elseif (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium'); ?>
            <?php endif; ?>

            <?php
            // Bio from ACF. wpautop() turns line breaks into paragraphs,
            // wp_kses_post() keeps the output safe.
            if ($bio) :
                echo wp_kses_post(wpautop($bio));
            endif;
            ?>

            <?php
            // Any extra content typed into the block editor for this person.
            the_content();
            ?>
        </article>

    <?php endwhile; ?>

</main>
<?php
get_footer(); // Loads the footer.php (footer menu, copyright, wp_footer()).