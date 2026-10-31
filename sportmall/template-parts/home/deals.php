<?php
/**
 * Daily deals strip.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$products = sportmall_sale_products( 3 );
if ( empty( $products ) ) {
	return;
}
$shop     = sportmall_shop_url();
$sale_url = add_query_arg( 'on_sale', '1', $shop );
?>
<section class="daily-deals shell" id="sale" aria-labelledby="daily-title">
	<div class="deal-intro">
		<p class="eyebrow"><?php echo esc_html( sportmall_mod( 'deals_eyebrow' ) ); ?></p>
		<h2 id="daily-title"><?php echo wp_kses_post( nl2br( sportmall_mod( 'deals_title' ) ) ); ?></h2>
		<p class="deal-description"><?php echo wp_kses_post( nl2br( sportmall_mod( 'deals_text' ) ) ); ?></p>
		<div class="deal-stamp">
			<span><?php esc_html_e( 'تا', 'sportmall' ); ?></span>
			<strong><?php echo esc_html( sportmall_mod( 'deals_stamp' ) ); ?><small>٪</small></strong>
			<span><?php esc_html_e( 'تخفیف روی منتخب‌ها', 'sportmall' ); ?></span>
		</div>
		<a class="deal-link" href="<?php echo esc_url( $sale_url ); ?>"><?php esc_html_e( 'همهٔ تخفیف‌ها', 'sportmall' ); ?> <?php sportmall_the_icon( 'arrow' ); ?></a>
	</div>
	<div class="deal-products" id="deal-products">
		<?php foreach ( $products as $product ) : ?>
			<?php sportmall_product_card( $product ); ?>
		<?php endforeach; ?>
	</div>
</section>
