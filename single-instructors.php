<?php

/**
 * Single instructor: photo, bio, and the programs they teach.
 */

get_header();
?>

<main id="main-content">
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class(); ?>>
            <h1><?php the_title(); ?></h1>

            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium'); ?>
            <?php endif; ?>

            <?php the_content(); ?>

            <?php $programs = get_field('related_program'); ?>

            <?php if ($programs) : ?>
                <section class="instructor-programs">
                    <h2>Programs</h2>
                    <ul>
                        <?php foreach ($programs as $program) : ?>
                            <li>
                                <a href="<?php echo esc_url(get_permalink($program)); ?>">
                                    <?php echo esc_html(get_the_title($program)); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>
        </article>
    <?php endwhile; ?>
</main>

<?php
get_footer();