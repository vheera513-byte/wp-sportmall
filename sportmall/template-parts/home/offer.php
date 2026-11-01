<?php
/**
 * Welcome coupon banner.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$code    = sportmall_mod( 'offer_code' );
$percent = sportmall_mod( 'offer_percent' );
$terms   = get_page_by_path( 'discount-terms' );
$terms   = $terms ? get_permalink( $terms ) : add_query_arg( 'on_sale', '1', sportmall_shop_url() );
?>
<section class="section sale-section shell" id="welcome-offer" aria-labelledby="sale-title">
	<div class="sale-box">
		<div class="sale-copy">
			<p class="eyebrow"><?php echo esc_html( sportmall_mod( 'offer_eyebrow' ) ); ?></p>
			<h2 id="sale-title"><?php echo esc_html( sportmall_mod( 'offer_title' ) ); ?></h2>
			<p><?php echo esc_html( sportmall_mod( 'offer_text' ) ); ?></p>
		</div>
		<div class="sale-action">
			<div class="sale-percent" aria-label="<?php echo esc_attr( sprintf( __( '%s درصد', 'sportmall' ), $percent ) ); ?>"><?php echo esc_html( $percent ); ?><small>%</small></div>
			<div>
				<button class="sale-code" type="button" data-sm-copy="<?php echo esc_attr( $code ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'کپی کد تخفیف %s', 'sportmall' ), $code ) ); ?>">
					<?php echo esc_html( $code ); ?>
					<?php sportmall_the_icon( 'copy' ); ?>
				</button>
				<a class="text-link" href="<?php echo esc_url( $terms ); ?>"><?php esc_html_e( 'شرایط پیشنهاد', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
			</div>
		</div>
	</div>
</section>
