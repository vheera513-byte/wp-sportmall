<?php
/**
 * Selected products with client-side category filtering.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$products = sportmall_home_products( 8 );
if ( empty( $products ) ) {
	return;
}
$tabs     = sportmall_type_categories( 3 );
$shop     = sportmall_shop_url();
$wishlist = sportmall_wishlist_url();
?>
<section class="section products-section shell" id="products" aria-labelledby="products-title" data-sm-catalog>
	<div class="section-heading">
		<div>
			<p class="eyebrow"><?php echo esc_html( sportmall_mod( 'products_eyebrow' ) ); ?></p>
			<h2 class="section-title" id="products-title"><?php echo esc_html( sportmall_mod( 'products_title' ) ); ?></h2>
		</div>
		<a class="text-link" href="<?php echo esc_url( $wishlist ); ?>">
			<span><?php esc_html_e( 'علاقه‌مندی‌های من', 'sportmall' ); ?></span>
			<?php sportmall_the_icon( 'heart' ); ?>
		</a>
	</div>

	<div class="product-tools">
		<div class="product-tabs" role="group" aria-label="<?php esc_attr_e( 'فیلتر محصولات', 'sportmall' ); ?>">
			<button class="product-tab" type="button" data-filter="all" aria-pressed="true"><?php esc_html_e( 'همه', 'sportmall' ); ?></button>
			<?php foreach ( $tabs as $tab ) : ?>
				<button class="product-tab" type="button" data-filter="<?php echo esc_attr( $tab->slug ); ?>" aria-pressed="false"><?php echo esc_html( $tab->name ); ?></button>
			<?php endforeach; ?>
		</div>
		<div class="catalog-summary">
			<span data-sm-catalog-count>
				<?php
				/* translators: %s: product count. */
				echo esc_html( sprintf( __( '%s محصول', 'sportmall' ), sportmall_fa_digits( count( $products ) ) ) );
				?>
			</span>
			<button class="clear-filters" type="button" data-sm-clear-filters hidden><?php esc_html_e( 'حذف فیلتر', 'sportmall' ); ?></button>
		</div>
	</div>

	<p class="filter-status" aria-live="polite" data-sm-filter-status></p>

	<div class="product-grid" id="product-grid" data-sm-product-grid>
		<?php foreach ( $products as $product ) : ?>
			<?php sportmall_product_card( $product ); ?>
		<?php endforeach; ?>
	</div>

	<div class="load-more-wrap">
		<a class="outline-button" href="<?php echo esc_url( $shop ); ?>"><?php esc_html_e( 'انتخاب‌های بیشتر', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
	</div>
</section>
