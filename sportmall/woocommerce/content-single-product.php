<?php
/**
 * Single product content.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product || ! $product->is_visible() ) {
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'single-product-layout', $product ); ?>>
	<?php
	/**
	 * Notices and hooks before the product layout.
	 */
	do_action( 'woocommerce_before_single_product' );
	?>

	<div class="single-product-grid">
		<div class="single-product-media">
			<?php
			/**
			 * Product gallery.
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
			?>
		</div>

		<div class="single-product-summary summary entry-summary">
			<?php
			/**
			 * Product summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action( 'woocommerce_single_product_summary' );
			?>
		</div>
	</div>

	<?php
	/**
	 * Tabs, upsells and related products.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>
