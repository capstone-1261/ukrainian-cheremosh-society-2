<?php
/**
 * Template for regular pages.
 */
get_header();
?>

<main id="main-content">
	<?php
	woocommerce_content(); // Can be adjusted as time goes on
	?>
</main>

<?php
get_footer();