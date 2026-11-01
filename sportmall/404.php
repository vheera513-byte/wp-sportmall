<?php
/**
 * 404 page.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

get_header();

get_template_part( 'template-parts/header/page-hero', null, array(
	'title'    => __( 'این مسیر به جایی نمی‌رسد.', 'sportmall' ),
	'eyebrow'  => __( '۴۰۴ / صفحه پیدا نشد', 'sportmall' ),
	'subtitle' => __( 'شاید نشانی تغییر کرده باشد. از اینجا دوباره مسیرت را پیدا کن.', 'sportmall' ),
) );
?>

<main id="main-content" class="page-main shell">
	<div class="not-found">
		<div class="not-found-art" aria-hidden="true">404</div>
		<div class="not-found-copy">
			<p><?php esc_html_e( 'می‌توانی جستجو کنی، به فروشگاه برگردی یا از دسته‌بندی‌های محبوب شروع کنی.', 'sportmall' ); ?></p>
			<?php get_search_form(); ?>
			<div class="not-found-actions">
				<a class="accent-button" href="<?php echo esc_url( sportmall_shop_url() ); ?>"><?php esc_html_e( 'رفتن به فروشگاه', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
				<a class="outline-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'صفحه اصلی', 'sportmall' ); ?></a>
			</div>
		</div>
	</div>

	<?php
	if ( class_exists( 'WooCommerce' ) ) :
		$products = sportmall_home_products( 4 );
		if ( $products ) :
			?>
			<section class="section not-found-products">
				<div class="section-heading">
					<div>
						<p class="eyebrow"><?php esc_html_e( 'شاید این‌ها را بخواهی', 'sportmall' ); ?></p>
						<h2 class="section-title"><?php esc_html_e( 'انتخاب‌های تازه', 'sportmall' ); ?></h2>
					</div>
				</div>
				<div class="product-grid">
					<?php foreach ( $products as $product ) : ?>
						<?php sportmall_product_card( $product ); ?>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
