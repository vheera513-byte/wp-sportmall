<?php
/**
 * Running editorial banner.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$url = sportmall_mod( 'running_url' );
if ( ! $url ) {
	$term = taxonomy_exists( 'product_cat' ) ? get_term_by( 'slug', 'running', 'product_cat' ) : null;
	$url  = $term && ! is_wp_error( $term ) ? get_term_link( $term ) : add_query_arg( 'product_cat', 'running', sportmall_shop_url() );
}
$image = sportmall_mod( 'running_image' );
if ( ! $image ) {
	$image = sportmall_asset( 'images/running-campaign.jpg' );
}
?>
<section class="running-section" id="running" aria-labelledby="running-title">
	<div class="running-copy">
		<p class="eyebrow"><?php echo esc_html( sportmall_mod( 'running_eyebrow' ) ); ?></p>
		<h2 id="running-title"><?php echo wp_kses_post( nl2br( sportmall_mod( 'running_title' ) ) ); ?></h2>
		<p><?php echo wp_kses_post( sportmall_mod( 'running_text' ) ); ?></p>
		<a class="accent-button" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( sportmall_mod( 'running_cta' ) ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
		<div class="running-note">
			<span><?php esc_html_e( 'کفش‌های دویدن', 'sportmall' ); ?></span>
			<span><?php esc_html_e( 'پوشاک سبک', 'sportmall' ); ?></span>
			<span><?php esc_html_e( 'اکسسوری‌های همراه', 'sportmall' ); ?></span>
		</div>
	</div>
	<div class="running-visual">
		<img src="<?php echo esc_url( $image ); ?>" alt="<?php esc_attr_e( 'دونده‌ها در حرکت', 'sportmall' ); ?>" loading="lazy" width="1600" height="1067">
		<small>FIND YOUR OWN PACE.</small>
		<span class="running-word" aria-hidden="true">JUST GO.</span>
	</div>
</section>
