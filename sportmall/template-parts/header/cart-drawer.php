<?php
/**
 * Slide-in cart drawer.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$count  = function_exists( 'WC' ) && WC()->cart ? (int) WC()->cart->get_cart_contents_count() : 0;
$is_woo = class_exists( 'WooCommerce' );
?>
<dialog class="cart-panel" id="cart-panel" aria-labelledby="cart-title" aria-modal="true">
	<div class="cart-heading">
		<div class="cart-heading-title">
			<h2 id="cart-title"><?php esc_html_e( 'سبد خرید', 'sportmall' ); ?></h2>
			<span class="cart-count" data-sm-cart-count-text><?php echo esc_html( sprintf( _n( '%s کالا', '%s کالا', $count, 'sportmall' ), sportmall_fa_digits( $count ) ) ); ?></span>
		</div>
		<button class="cart-close" type="button" aria-label="<?php esc_attr_e( 'بستن سبد خرید', 'sportmall' ); ?>" data-sm-close autofocus>
			<?php sportmall_the_icon( 'close' ); ?>
		</button>
	</div>
	<div class="cart-content">
		<div class="widget_shopping_cart_content">
		<?php if ( $is_woo ) : ?>
			<?php woocommerce_mini_cart(); ?>
		<?php else : ?>
			<div class="cart-empty">
				<div class="cart-empty-icon"><?php sportmall_the_icon( 'bag' ); ?></div>
				<h3><?php esc_html_e( 'جای انتخاب‌های تو خالیه', 'sportmall' ); ?></h3>
				<p><?php esc_html_e( 'برای فعال شدن فروشگاه، افزونه ووکامرس را نصب و فعال کن.', 'sportmall' ); ?></p>
			</div>
		<?php endif; ?>
		</div>
	</div>
</dialog>
