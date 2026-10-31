<?php
/**
 * Template Name: علاقه‌مندی‌ها
 * Description: محصولات ذخیره‌شده در مرورگر کاربر.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

get_header();

get_template_part( 'template-parts/header/page-hero', null, array(
	'title'    => get_the_title(),
	'eyebrow'  => __( 'انتخاب‌های ذخیره‌شده', 'sportmall' ),
	'subtitle' => __( 'هر محصولی را که دوست داری اینجا نگه دار و بعداً راحت‌تر پیدا کن.', 'sportmall' ),
) );
?>

<main id="main-content" class="page-main shell" data-sm-wishlist-page>
	<div class="wishlist-empty" data-sm-wishlist-empty hidden>
		<div class="wishlist-empty-icon"><?php sportmall_the_icon( 'heart' ); ?></div>
		<h2><?php esc_html_e( 'هنوز انتخابی اینجا نیست.', 'sportmall' ); ?></h2>
		<p><?php esc_html_e( 'با زدن قلب روی کارت محصولات، انتخاب‌هایت را برای بعد ذخیره کن.', 'sportmall' ); ?></p>
		<a class="accent-button" href="<?php echo esc_url( sportmall_shop_url() ); ?>"><?php esc_html_e( 'دیدن محصولات', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
	</div>
	<div class="wishlist-loading" data-sm-wishlist-loading>
		<span class="sm-spinner" aria-hidden="true"></span>
		<p><?php esc_html_e( 'در حال خواندن علاقه‌مندی‌ها…', 'sportmall' ); ?></p>
	</div>
	<div class="product-grid" data-sm-wishlist-grid></div>
	<div class="wishlist-note">
		<?php sportmall_the_icon( 'info' ); ?>
		<p><?php esc_html_e( 'این فهرست در همین مرورگر ذخیره می‌شود و با پاک کردن داده‌های سایت از بین می‌رود.', 'sportmall' ); ?></p>
	</div>
</main>

<?php get_footer(); ?>
