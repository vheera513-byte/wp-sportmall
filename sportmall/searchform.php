<?php
/**
 * Search form used on search, 404 and widget areas.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$id = 'search-form-' . wp_unique_id();
?>
<form role="search" method="get" class="site-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $id ); ?>"><?php esc_html_e( 'جستجو', 'sportmall' ); ?></label>
	<?php if ( class_exists( 'WooCommerce' ) ) : ?>
		<input type="hidden" name="post_type" value="product">
	<?php endif; ?>
	<?php sportmall_the_icon( 'search', 'site-search-icon' ); ?>
	<input id="<?php echo esc_attr( $id ); ?>" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'دنبال چه محصولی می‌گردی؟', 'sportmall' ); ?>" required minlength="2">
	<button type="submit" class="accent-button"><?php esc_html_e( 'جستجو', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></button>
</form>
