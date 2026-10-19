<?php
/**
 * Our People page: page content, then a list of all instructors.
 */

get_header();
?>

<main id="main-content">
    <?php while ( have_posts() ) : the_post(); ?>
        <article <?php post_class(); ?>>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </article>
    <?php endwhile; ?>

    <?php
    $instructors = new WP_Query(
        array(
            'post_type'      => 'instructors',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
        )
    );
    ?>

    <?php if ( $instructors->have_posts() ) : ?>
        <section class="instructors-list">
            <h2>Instructors</h2>
            <ul>
                <?php while ( $instructors->have_posts() ) : $instructors->the_post(); ?>
                    <li>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'medium' ); ?>
                        <?php endif; ?>

                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                        <?php the_excerpt(); ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        </section>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
</main>

<?php
get_footer();