<?php
/**
 * Single product layout
 *
 * One product page: breadcrumbs, name, description, price, buttons and a
 * photo gallery. woocommerce.php loads this file for single products.
 *
 * Everything here comes from the product itself in wp-admin > Products, so
 * the client edits the name, description, price and photos there:
 *   - Name, price, photos: the product edit screen.
 *   - Text next to the name: the "Short description" box (falls back to
 *     the long description if the short one is empty).
 *   - Small title above the name: the product's category.
 */

// A single product page has exactly one product, so this loop runs once.
while ( have_posts() ) :
	the_post();

	$product = wc_get_product( get_the_ID() );
	if ( ! $product ) {
		continue;
	}

	// ---- Category (used for the small title and the breadcrumbs) ----
	// A product can have several categories. We use the first real one.
	$category = null;
	$terms    = get_the_terms( $product->get_id(), 'product_cat' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			// WooCommerce's built-in "Uncategorized" isn't worth showing.
			if ( 'uncategorized' !== $term->slug ) {
				$category = $term;
				break;
			}
		}
	}

	// ---- Text beside the name ----
	// Short description first. If it's empty, use the start of the long one.
	$description = $product->get_short_description();
	if ( ! $description ) {
		$description = wp_trim_words( wp_strip_all_tags( $product->get_description() ), 45 );
	}

	// ---- Photos: the main photo first, then the gallery photos. Max 4. ----
	$image_ids = array();
	if ( $product->get_image_id() ) {
		$image_ids[] = $product->get_image_id();
	}
	foreach ( $product->get_gallery_image_ids() as $gallery_id ) {
		$image_ids[] = $gallery_id;
	}
	$image_ids = array_slice( $image_ids, 0, 4 );

	$shop_url = wc_get_page_permalink( 'shop' );
	?>

	<?php
	// "Added to cart" and error messages from WooCommerce.
	wc_print_notices();
	?>

	<section class="product-page">

		<!-- Breadcrumbs: Shop all > Category > Product name -->
		<nav class="product-breadcrumbs" aria-label="Breadcrumb">
			<!-- WISHLIST: the design has an "Add to Wishlist" button here.
			     It needs a wishlist plugin, so it is left out for now. -->
			<ol>
				<li><a href="<?php echo esc_url( $shop_url ); ?>">Shop all</a></li>
				<?php if ( $category ) : ?>
					<li><a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a></li>
				<?php endif; ?>
				<li aria-current="page"><?php echo esc_html( $product->get_name() ); ?></li>
			</ol>
		</nav>

		<div class="product-layout">

			<!-- LEFT: the words and buttons -->
			<div class="product-info">
				<?php if ( $category ) : ?>
					<p class="product-tagline"><?php echo esc_html( $category->name ); ?></p>
				<?php endif; ?>

				<h1 class="product-title"><?php echo esc_html( $product->get_name() ); ?></h1>

				<?php if ( $description ) : ?>
					<div class="product-description">
						<?php echo wp_kses_post( wpautop( $description ) ); ?>
					</div>
				<?php endif; ?>

				<!-- Price. WooCommerce builds this, so sale prices work too. -->
				<div class="product-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>

				<p class="product-stock">
					<?php echo $product->is_in_stock() ? 'In stock' : 'Out of stock'; ?>
				</p>

				<!-- Buttons. The Add to cart form is WooCommerce's own, so
				     quantity and options (size, colour) keep working. -->
				<div class="product-actions">
					<a class="product-back" href="<?php echo esc_url( $shop_url ); ?>">Back to Shop</a>
					<?php woocommerce_template_single_add_to_cart(); ?>
				</div>
			</div>

			<!-- RIGHT: the photos. If the product has no photo, WooCommerce's
			     grey placeholder shows instead. -->
			<div class="product-gallery" data-product-gallery>
				<div class="product-main-photo">
					<?php if ( $image_ids ) : ?>
						<?php
						echo wp_get_attachment_image(
							$image_ids[0],
							'woocommerce_single',
							false,
							array( 'data-product-main' => '' )
						);
						?>
					<?php else : ?>
						<img src="<?php echo esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ); ?>" alt="" data-product-main>
					<?php endif; ?>
				</div>

				<?php
				// Small photos under the big one. Only shown if there is more than
				// one photo. Clicking one swaps the big photo (product-gallery.js).
				if ( count( $image_ids ) > 1 ) :
					?>
					<ul class="product-thumbs">
						<?php foreach ( $image_ids as $index => $image_id ) : ?>
							<li>
								<button
									type="button"
									class="product-thumb"
									data-full="<?php echo esc_url( wp_get_attachment_image_url( $image_id, 'woocommerce_single' ) ); ?>"
									data-alt="<?php echo esc_attr( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ); ?>"
									aria-label="Show photo <?php echo (int) ( $index + 1 ); ?>">
									<?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
								</button>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

		</div>
	</section>

<?php endwhile; ?>