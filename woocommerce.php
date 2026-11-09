<?php
/**
 * WooCommerce template
 *
 * WordPress uses this file for all WooCommerce pages: the Shop page,
 * single product pages and product categories. (Cart, Checkout and
 * My Account are normal pages, so they use page.php.)
 *
 * Wrapping WooCommerce in our own header, <main> and footer keeps the
 * shop looking like the rest of the site.
 * Structure only: styling comes later.
 */

get_header(); // Loads header.php (skip link, announcement bar, logo, main menu).
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<?php
	// woocommerce_content() works out which shop page we're on
	// (shop, product, category) and prints the right content for it.
	// We can swap in more specific WooCommerce templates later if needed.
	woocommerce_content();
	?>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright, wp_footer()).