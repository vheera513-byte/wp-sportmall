<?php
/**
 * Product card used on the home page, shop, wishlist and AJAX responses.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$product = isset( $args['product'] ) ? $args['product'] : null;
if ( ! $product instanceof WC_Product || ! $product->is_visible() ) {
	return;
}

$tag        = isset( $args['tag'] ) ? $args['tag'] : 'article';
$tag        = in_array( $tag, array( 'article', 'li', 'div' ), true ) ? $tag : 'article';
$classes    = implode( ' ', wc_get_product_class( 'product-card', $product ) );
$permalink  = get_permalink( $product->get_id() );
$name       = $product->get_name();
$on_sale    = $product->is_on_sale();
$percent    = sportmall_discount_percent( $product );
$is_new     = false;
$created    = $product->get_date_created();
if ( $created && ( time() - $created->getTimestamp() ) < 30 * DAY_IN_SECONDS ) {
	$is_new = true;
}
$cat_slugs  = sportmall_product_cat_slugs( $product );
$kind_terms = get_the_terms( $product->get_id(), 'product_cat' );
$kind       = array();
if ( $kind_terms && ! is_wp_error( $kind_terms ) ) {
	foreach ( $kind_terms as $term ) {
		if ( in_array( $term->slug, array( 'women', 'men', 'uncategorized' ), true ) ) {
			continue;
		}
		$kind[] = $term->name;
	}
}
$kind    = array_slice( array_unique( $kind ), 0, 2 );
$colors  = sportmall_color_swatches( $product );
$badge   = '';
if ( $on_sale ) {
	$badge = $percent > 0 ? sprintf( __( '%s٪ تخفیف', 'sportmall' ), sportmall_fa_digits( $percent ) ) : __( 'تخفیف', 'sportmall' );
} elseif ( $is_new ) {
	$badge = __( 'تازه‌رسیده', 'sportmall' );
}

$button_label = $product->is_type( 'variable' ) ? __( 'انتخاب گزینه‌ها', 'sportmall' ) : __( 'انتخاب و خرید', 'sportmall' );
?>
<<?php echo esc_attr( $tag ); ?> class="<?php echo esc_attr( $classes ); ?>" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" data-cats="<?php echo esc_attr( $cat_slugs ); ?>">
	<div class="product-visual">
		<?php if ( $badge ) : ?>
			<span class="product-badge<?php echo $on_sale ? ' sale' : ''; ?>"><?php echo esc_html( $badge ); ?></span>
		<?php endif; ?>

		<button class="favorite-button" type="button" data-sm-favorite="<?php echo esc_attr( $product->get_id() ); ?>" aria-pressed="false" aria-label="<?php echo esc_attr( sprintf( __( 'افزودن به علاقه‌مندی‌ها: %s', 'sportmall' ), $name ) ); ?>">
			<?php sportmall_the_icon( 'heart' ); ?>
		</button>

		<a class="product-open" href="<?php echo esc_url( $permalink ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'مشاهده %s', 'sportmall' ), $name ) ); ?>">
			<?php echo wp_kses_post( $product->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy' ) ) ); ?>
		</a>

		<?php if ( $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() ) : ?>
			<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="quick-add ajax_add_to_cart add_to_cart_button" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" data-quantity="1" aria-label="<?php echo esc_attr( sprintf( __( 'افزودن %s به سبد خرید', 'sportmall' ), $name ) ); ?>" rel="nofollow">
				<?php sportmall_the_icon( 'plus' ); ?><span><?php echo esc_html( $button_label ); ?></span>
			</a>
		<?php else : ?>
			<a href="<?php echo esc_url( $permalink ); ?>" class="quick-add">
				<?php sportmall_the_icon( 'plus' ); ?><span><?php echo esc_html( $button_label ); ?></span>
			</a>
		<?php endif; ?>
	</div>

	<div class="product-info">
		<div class="product-brand" lang="en" dir="ltr"><?php echo esc_html( sportmall_product_brand( $product ) ); ?></div>
		<h3 class="product-name"><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $name ); ?></a></h3>
		<p class="product-kind"><?php echo esc_html( $kind ? implode( ' · ', $kind ) : $product->get_short_description() ? wp_trim_words( wp_strip_all_tags( $product->get_short_description() ), 4 ) : __( 'انتخاب اسپرت‌مال', 'sportmall' ) ); ?></p>

		<div class="product-bottom">
			<div class="product-price">
				<?php echo wp_kses_post( sportmall_product_price_html( $product ) ); ?>
			</div>
			<?php if ( $colors ) : ?>
				<div class="product-colors" aria-label="<?php esc_attr_e( 'رنگ‌های موجود', 'sportmall' ); ?>">
					<?php foreach ( $colors as $color ) : ?>
						<span style="background-color:<?php echo esc_attr( $color ); ?>" aria-hidden="true"></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</<?php echo esc_attr( $tag ); ?>>
