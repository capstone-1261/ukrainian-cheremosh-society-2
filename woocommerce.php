<?php
/**
 * WooCommerce template
 *
 * WordPress uses this file for all WooCommerce pages: the Shop page,
 * single product pages and product categories. (Cart, Checkout and
 * My Account are normal pages, so they use page.php.)
 *
 * On the Shop, category and product-search pages it prints our own layout:
 * banner, filter sidebar and product grid. Single products still use
 * WooCommerce's own layout for now.
 */

get_header(); // Loads header.php (skip link, announcement bar, logo, main menu).
?>

<main id="main-content"> <!-- The skip link in header.php jumps here. -->

	<?php
	// is_shop() = the main Shop page. is_product_taxonomy() = a category page
	// such as /product-category/team-wear/. is_search() = a keyword search.
	// Single products are none of these, so they skip our layout.
	if ( is_shop() || is_product_taxonomy() || is_search() ) :

		// The banner photo is the Featured Image of the Shop page
		// (wp-admin > Pages > Shop > Featured image).
		$shop_page_id = wc_get_page_id( 'shop' );
		$shop_url     = wc_get_page_permalink( 'shop' ); // e.g. http://localhost:10043/shop/

		// ---- Data for the sidebar ----

		// All product categories, A-Z, skipping WooCommerce's default "Uncategorized".
		$shop_categories = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
				'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
				'orderby'    => 'term_id', // Creation order = the order in the design (Team Wear first).
			)
		);

		// ID of the category being viewed (0 on the main Shop page).
		$current_cat_id = is_product_category() ? get_queried_object_id() : 0;

		// Where the search and sort forms send people: the current category, or the Shop.
		$form_action = $current_cat_id ? get_term_link( $current_cat_id, 'product_cat' ) : $shop_url;

		// Current search word and sort choice from the URL (?s=...&orderby=...).
		$search_term = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';
		$current_sort = isset( $_GET['orderby'] ) ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) : 'menu_order';

		// Sort choices WooCommerce understands (value => label).
		$sort_options = array(
			'menu_order' => 'Default sorting',
			'popularity' => 'Most popular',
			'rating'     => 'Average rating',
			'date'       => 'Newest',
			'price'      => 'Price: low to high',
			'price-desc' => 'Price: high to low',
		);

		// "Showing X of Y": X = products on this page, Y = products found in total.
		global $wp_query;
		$showing_count = $wp_query->post_count;
		$total_count   = $wp_query->found_posts;
		?>

		<!-- ===== BANNER: reuses the .about-hero styles from the About page ===== -->
		<section class="about-hero">
			<?php if ( $shop_page_id > 0 && has_post_thumbnail( $shop_page_id ) ) : ?>
				<!-- Decorative photo, so the alt text is empty. -->
				<?php echo get_the_post_thumbnail( $shop_page_id, 'full', array( 'class' => 'about-hero-image', 'alt' => '' ) ); ?>
			<?php endif; ?>

			<div class="about-hero-text">
				<p class="about-hero-tagline">Shop</p>
				<!-- Only H1 on the page. -->
				<h1 class="about-hero-title">Shop our store</h1>
			</div>
		</section>

		<!-- ===== SIDEBAR + PRODUCT GRID ===== -->
		<section class="shop-layout">
			<div class="shop-layout-inner">

				<!-- Sidebar: categories, keyword search, sort. -->
				<aside class="shop-sidebar" aria-label="Shop filters">

					<div class="shop-sidebar-head">
						<div>
							<h2 class="shop-sidebar-title">Filters</h2>
							<p class="shop-sidebar-count">Showing <?php echo esc_html( $showing_count ); ?> of <?php echo esc_html( $total_count ); ?></p>
						</div>
						<!-- Clear all = back to the plain Shop page (no category, search or sort). -->
						<a class="shop-clear" href="<?php echo esc_url( $shop_url ); ?>">Clear all</a>
					</div>

					<!-- Category links. The one being viewed gets aria-current for styling. -->
					<nav class="shop-categories" aria-label="Product categories">
						<ul>
							<li>
								<a href="<?php echo esc_url( $shop_url ); ?>"<?php echo ( ! $current_cat_id ) ? ' aria-current="page"' : ''; ?>>All</a>
							</li>
							<?php if ( ! is_wp_error( $shop_categories ) ) : ?>
								<?php foreach ( $shop_categories as $shop_cat ) : ?>
									<li>
										<a href="<?php echo esc_url( get_term_link( $shop_cat ) ); ?>"<?php echo ( (int) $shop_cat->term_id === (int) $current_cat_id ) ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $shop_cat->name ); ?></a>
									</li>
								<?php endforeach; ?>
							<?php endif; ?>
						</ul>
					</nav>

					<!-- Keyword search. post_type=product keeps the results to products only. -->
					<form class="shop-filter" role="search" method="get" action="<?php echo esc_url( $form_action ); ?>">
						<label class="shop-filter-label" for="shop-search">Search</label>
						<input id="shop-search" class="shop-filter-input" type="search" name="s" value="<?php echo esc_attr( $search_term ); ?>" placeholder="Keyword">
						<input type="hidden" name="post_type" value="product">
					</form>

					<!-- Sort. onchange submits the form as soon as a choice is picked. -->
					<form class="shop-filter" method="get" action="<?php echo esc_url( $form_action ); ?>">
						<label class="shop-filter-label" for="shop-sort">Sort by</label>
						<select id="shop-sort" class="shop-filter-select" name="orderby" onchange="this.form.submit()">
							<?php foreach ( $sort_options as $sort_value => $sort_label ) : ?>
								<option value="<?php echo esc_attr( $sort_value ); ?>" <?php selected( $current_sort, $sort_value ); ?>><?php echo esc_html( $sort_label ); ?></option>
							<?php endforeach; ?>
						</select>
					</form>

				</aside>

				<!-- Product grid. -->
				<div class="shop-products">
					<?php if ( have_posts() ) : ?>

						<div class="shop-grid">
							<?php
							// The Loop: runs once per product on this page.
							while ( have_posts() ) :
								the_post();
								$product = wc_get_product( get_the_ID() ); // WooCommerce product object.
								?>
								<article class="shop-card">
									<!-- Product photo (or WooCommerce's placeholder if none is set). -->
									<div class="shop-card-media">
										<?php echo wp_kses_post( woocommerce_get_product_thumbnail( 'woocommerce_single' ) ); ?>
									</div>

									<div class="shop-card-body">
										<div class="shop-card-info">
											<h3 class="shop-card-title"><?php the_title(); ?></h3>
											<!-- Price as WooCommerce formats it (handles sale prices too). -->
											<p class="shop-card-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
										</div>
										<a class="button shop-card-button" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( 'Details for ' . get_the_title() ); ?>">Details</a>
									</div>
								</article>
							<?php endwhile; ?>
						</div>

						<?php woocommerce_pagination(); // Page numbers when there are more products than fit. ?>

					<?php else : ?>
						<p class="shop-empty">No products found. Try clearing the filters.</p>
					<?php endif; ?>
				</div>

			</div>
		</section>

	<?php else : ?>

		<?php
		// Single product pages: our own layout (template-parts/product-single.php).
		get_template_part( 'template-parts/product-single' );
		?>

	<?php endif; ?>

</main>

<?php
get_footer(); // Loads footer.php (footer menu, social links, copyright, wp_footer()).