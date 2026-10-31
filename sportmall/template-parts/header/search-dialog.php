<?php
/**
 * Search overlay.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$is_woo = class_exists( 'WooCommerce' );
?>
<dialog class="search-panel" id="search-panel" aria-labelledby="search-title" aria-modal="true" aria-hidden="true">
	<div class="search-heading">
		<h2 id="search-title"><?php esc_html_e( 'جستجو در اسپرت‌مال', 'sportmall' ); ?></h2>
		<button class="search-close" type="button" aria-label="<?php esc_attr_e( 'بستن جستجو', 'sportmall' ); ?>" data-sm-close>
			<?php sportmall_the_icon( 'close' ); ?>
		</button>
	</div>
	<form class="search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" data-sm-search-form>
		<?php sportmall_the_icon( 'search', 'search-form-icon' ); ?>
		<?php if ( $is_woo ) : ?>
			<input type="hidden" name="post_type" value="product">
		<?php endif; ?>
		<input class="search-input" type="search" name="s" placeholder="<?php esc_attr_e( 'دنبال چه محصولی می‌گردی؟', 'sportmall' ); ?>" autocomplete="off" aria-label="<?php esc_attr_e( 'عبارت جستجو', 'sportmall' ); ?>" data-sm-search-input required minlength="2">
		<button class="search-clear" type="button" aria-label="<?php esc_attr_e( 'پاک کردن جستجو', 'sportmall' ); ?>" data-sm-search-clear hidden>&times;</button>
		<button class="search-submit" type="submit" aria-label="<?php esc_attr_e( 'جستجو', 'sportmall' ); ?>">
			<?php sportmall_the_icon( 'arrow-left' ); ?>
		</button>
	</form>
	<p class="search-note"><?php esc_html_e( 'نام محصول، برند یا دسته‌بندی را وارد کن.', 'sportmall' ); ?></p>
	<p class="search-status" aria-live="polite" data-sm-search-status></p>
	<div id="search-results" class="search-results" data-sm-search-results></div>
</dialog>
