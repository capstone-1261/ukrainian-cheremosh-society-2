<?php
/**
 * Camps page template
 *
 * WordPress uses this file automatically for the page whose slug is
 * "camps" (the page-{slug}.php naming rule, same as page-about.php).
 *
 * Layout:
 *   1. Hero       — title, intro and register button.
 *   2. Overview   — camp cards row with dots and arrows.
 *   3. Directors  — two director profiles.
 *   4. FAQ        — accordion with a contact button.
 *
 * Styling lives in assets/css/main.css.
 * Scripts (camps.js, camps-faq.js) are loaded in functions.php.
 *
 * @package cheremosh-theme
 */

get_header(); // Loads header.php (skip link, announcement bar, menu).
?>

<main class="camps-page">

    <!-- 1. Hero -->
    <section class="camps-hero">
        <img class="camps-hero-photo"
             src="<?php echo esc_url( get_theme_file_uri( 'assets/images/hero.jpg' ) ); ?>"
             alt="">
        <div class="camps-hero-inner">
            <p class="camps-hero-tagline">Camps</p>
            <h1 class="camps-hero-title">Summer Camps</h1>
            <p class="camps-hero-text">Cheremosh Summer Camps offers something for ALL Ages and Skill Levels.</p>
            <p class="camps-hero-text">Led by talented instructors, beginner to advanced level dancers are trained in a way that challenges them to be their very best.</p>
            <a class="camps-hero-button" href="<?php echo esc_url( home_url( '/camp-registration/' ) ); ?>">Register to camp</a>
        </div>
    </section>

    <!-- 2. Overview -->
    <section class="camps-overview">
        <div class="camps-ribbon" aria-hidden="true">
            <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/camps/ribbon.svg' ) ); ?>" alt="">
        </div>

        <div class="camps-container">
            <div class="camps-overview-head">
                <div>
                    <p class="camps-tagline">Overview</p>
                    <h2 class="camps-heading">Camps Overview</h2>
                    <span class="camps-line"></span>
                </div>
                <p class="camps-intro">
                    All camps will take place in Edmonton at the
                    <a href="https://www.google.com/maps/search/?api=1&amp;query=4005+115+Ave+NW+Edmonton+AB" target="_blank" rel="noopener">Cheremosh Studio, 4005 115 Avenue NW</a>.
                </p>
            </div>

            <?php
            $camps = array(
                array( 'title' => 'Cheremosh Masterclass', 'details' => array( 'Age 14+', 'July 20-24', '6:00 pm - 9:00 pm' ) ),
                array( 'title' => 'Beginner Camp', 'details' => array( 'Age 4*-6', 'August 4-7', '9:00 am - 12:00 pm', '*or 4 by December 31, 2025' ) ), // Date is in the past: confirm with the client.
                array( 'title' => 'Intermediate Camp', 'details' => array( 'Age 7-10', 'August 10-14', '8:30 am - 4:00 pm', 'Early/late pickup available for an additional fee' ) ),
                array( 'title' => 'Advanced Camp', 'details' => array( 'Age 11+', 'August 17-21', '8:30 am - 4:00 pm', 'Early/late pickup available for an additional fee' ) ),
                array( 'title' => 'Training Camp', 'details' => array( 'Age 14+*', 'August 24-28', '6:00 pm - 9:30 pm', '*Or Cheremshyna' ) ),
            );
            $register_url = home_url( '/camp-registration/' ); // Confirm this page slug.
            $card_image   = get_theme_file_uri( 'assets/images/camps/horizontal-screen-image-camps.png' ); // Temporary until camp photos arrive.
            ?>

            <div class="camps-track">
                <?php foreach ( $camps as $camp ) : ?>
                    <article class="camps-card">
                        <img src="<?php echo esc_url( $card_image ); ?>" alt="">
                        <div class="camps-card-body">
                            <div>
                                <h3 class="camps-card-title"><?php echo esc_html( $camp['title'] ); ?></h3>
                                <ul class="camps-card-details">
                                    <?php foreach ( $camp['details'] as $line ) : ?>
                                        <li><?php echo esc_html( $line ); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <a class="camps-card-button" href="<?php echo esc_url( $register_url ); ?>">Register</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="camps-controls">
                <div class="camps-dots" role="group" aria-label="Camps pages">
                    <?php foreach ( $camps as $i => $camp ) : ?>
                        <button type="button"
                                class="camps-dot"
                                aria-label="<?php echo esc_attr( sprintf( 'Show camps page %d of %d', $i + 1, count( $camps ) ) ); ?>"
                                <?php echo 0 === $i ? 'aria-current="true"' : ''; ?>></button>
                    <?php endforeach; ?>
                </div>
                <div class="camps-arrows">
                    <button type="button" class="camps-prev" aria-label="Previous camps">
                        <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/camps/arrow-left.svg' ) ); ?>" alt="">
                    </button>
                    <button type="button" class="camps-next" aria-label="Next camps">
                        <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/camps/arrow-right.svg' ) ); ?>" alt="">
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Directors -->
    <section class="camps-directors">
        <div class="camps-pattern-vertical" aria-hidden="true"
             style="background-image: url('<?php echo esc_url( get_theme_file_uri( 'assets/images/camps/vertical-pattern.png' ) ); ?>');"></div>

        <div class="camps-container">
            <div class="camps-section-head">
                <p class="camps-tagline">Directors</p>
                <h2 class="camps-heading-md">Camp Directors</h2>
                <span class="camps-line"></span>
            </div>

            <!-- Carter: photo on the left, text on the right -->
            <div class="camps-director">
                <img class="camps-director-photo"
                     src="<?php echo esc_url( get_theme_file_uri( 'assets/images/camps/carter-camps-director.png' ) ); ?>"
                     alt="Carter Winkel, Summer Camp Co-Director">
                <div class="camps-director-text">
                    <h3 class="camps-director-name">Carter Winkel</h3>
                    <span class="camps-line"></span>
                    <p>Beginning as a student in the Cheremosh School of Dance, Carter had grown up and danced in the Society for almost 10 years before he was invited to become a Cheremosh Company dancer in early 2022. Since then, he has been dancing for more than 10 hours a week and has had the opportunity to perform all across Canada. Currently, Carter trains in both Ukrainian Dance and Cecchetti ballet. He has spent the past two years providing instructing assistance to the Cheremosh Academy and previous Summer Dance Camps, and this past season has had the opportunity of teaching ballet class as well as Ukrainian Dance. Carter is very excited to be taking on the position of Summer Camp Co-Director, it has always been his goal as an instructor to provide the same supportive and constructive learning environment that Cheremosh has given him, and he is thrilled to be able to teach and work with students that share his passion for Ukrainian Dance.</p>
                </div>
            </div>

            <!-- Talia: text on the left, photo on the right -->
            <div class="camps-director camps-director--reverse">
                <div class="camps-director-text">
                    <h3 class="camps-director-name">Talia Chander</h3>
                    <span class="camps-line"></span>
                    <p>Ukrainian dance is Talia’s greatest passion, and she is excited to share her enthusiasm with campers once again this summer! Talia danced with the Cheremosh School of Dance for 11 years before joining the Cheremosh Ukrainian Dance Company in 2022. She is proud to have been involved in Cheremosh's 50th anniversary tour, Mriya: Life in Rhythm (2022), as well as the Vydnokray Tour (2025), granting her the opportunity to travel across Western Canada and the Balkans with the Company. Talia has been an Assistant Instructor for the Cheremosh Academy for four years and an Instructor for the School of Dance for one year, and is passionate about shaping the next generation of Cheremosh dancers. She had the privilege of attending Cheremosh summer camps for many years, and is thrilled to take on the role of Summer Camp Co-Director again this year. Talia is excited to continue sharing her love of dance with young people and to provide them with a fun, constructive, and engaging experience this summer.</p>
                </div>
                <img class="camps-director-photo"
                     src="<?php echo esc_url( get_theme_file_uri( 'assets/images/camps/talia-camps-director.png' ) ); ?>"
                     alt="Talia Chander, Summer Camp Co-Director">
            </div>
        </div>
    </section>

    <!-- 4. FAQ -->
    <section class="camps-faq">
        <div class="camps-faq-inner">

            <!-- Left column: heading, intro, and contact block -->
            <div class="camps-faq-left">
                <p class="camps-tagline">FAQ</p>
                <h2 class="camps-heading-md">Summer Camp FAQ</h2>
                <span class="camps-line"></span>
                <p class="camps-faq-intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.</p>

                <div class="camps-faq-contact">
                    <h3 class="camps-faq-contact-title">Still have questions?</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <a class="camps-faq-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" aria-label="Contact us">Contact</a>
                </div>
            </div>

            <!-- Right column: accordion -->
            <div class="camps-faq-list">
                <?php
                $faqs = array(
                    'What can my Dancer Expect at Camp?',
                    'What if I don\'t have a skirt or part of the dress code?',
                    'When is drop off and pick up?',
                    'What should my dancer bring for lunch?',
                );

                foreach ( $faqs as $i => $question ) :
                    $id = 'camps-faq-' . ( $i + 1 );
                    ?>
                    <div class="camps-faq-item">
                        <h3 class="camps-faq-question">
                            <button type="button"
                                    id="<?php echo esc_attr( $id ); ?>-button"
                                    aria-expanded="false"
                                    aria-controls="<?php echo esc_attr( $id ); ?>">
                                <?php echo esc_html( $question ); ?>
                                <span class="camps-faq-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24"><path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2"/></svg>
                                </span>
                            </button>
                        </h3>
                        <div class="camps-faq-answer" id="<?php echo esc_attr( $id ); ?>" role="region" aria-labelledby="<?php echo esc_attr( $id ); ?>-button" inert>
                            <div class="camps-faq-answer-inner">
                                <p>Answer text goes here.</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Pattern strip along the bottom edge -->
        <div class="camps-pattern-horizontal" aria-hidden="true"
             style="background-image: url('<?php echo esc_url( get_theme_file_uri( 'assets/images/camps/horizontal-pattern.png' ) ); ?>');"></div>
    </section>


    <script>
        // Camps carousel: arrows, dots, and the active dot as the row scrolls.

    </script>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright).