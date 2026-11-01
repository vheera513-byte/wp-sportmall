<?php
/**
 * Search results.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

get_header();

$is_product_search = isset( $_GET['post_type'] ) && 'product' === sanitize_key( wp_unslash( $_GET['post_type'] ) );
$query             = get_search_query();

get_template_part( 'template-parts/header/page-hero', null, array(
	/* translators: %s: search query. */
	'title'    => sprintf( __( 'نتیجه‌هایی برای «%s»', 'sportmall' ), $query ),
	'eyebrow'  => __( 'جستجو', 'sportmall' ),
	'subtitle' => sprintf(
		/* translators: %s: result count. */
		__( '%s نتیجه پیدا شد. اگر انتخاب دقیق‌تری می‌خواهی، فیلترها را تغییر بده.', 'sportmall' ),
		sportmall_fa_digits( $GLOBALS['wp_query']->found_posts )
	),
) );
?>

<main id="main-content" class="page-main shell">
	<div class="search-page-bar">
		<?php get_search_form(); ?>
	</div>

	<?php if ( have_posts() ) : ?>
		<?php
		$products = array();
		$others   = array();
		while ( have_posts() ) :
			the_post();
			if ( 'product' === get_post_type() ) {
				$products[] = get_the_ID();
			} else {
				$others[] = get_the_ID();
			}
		endwhile;
		?>

		<?php if ( $products && class_exists( 'WooCommerce' ) ) : ?>
			<section class="search-products section">
				<div class="section-heading">
					<div>
						<p class="eyebrow"><?php esc_html_e( 'از فروشگاه', 'sportmall' ); ?></p>
						<h2 class="section-title"><?php esc_html_e( 'محصولات مرتبط', 'sportmall' ); ?></h2>
					</div>
					<a class="text-link" href="<?php echo esc_url( sportmall_shop_url() ); ?>"><?php esc_html_e( 'همهٔ محصولات', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
				</div>
				<div class="product-grid search-product-grid">
					<?php
					foreach ( $products as $product_id ) {
						$product = wc_get_product( $product_id );
						if ( $product && $product->is_visible() ) {
							sportmall_product_card( $product );
						}
					}
					?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $others ) : ?>
			<section class="search-posts section">
				<div class="section-heading">
					<div>
						<p class="eyebrow"><?php esc_html_e( 'از ژورنال', 'sportmall' ); ?></p>
						<h2 class="section-title"><?php esc_html_e( 'نوشته‌ها و برگه‌ها', 'sportmall' ); ?></h2>
					</div>
				</div>
				<div class="archive-grid archive-grid--three">
					<?php
					foreach ( $others as $post_id ) {
						$GLOBALS['post'] = get_post( $post_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
						setup_postdata( $GLOBALS['post'] );
						get_template_part( 'template-parts/blog/card' );
					}
					wp_reset_postdata();
					?>
				</div>
			</section>
		<?php endif; ?>

		<?php sportmall_pagination(); ?>
	<?php else : ?>
		<div class="no-results search-no-results">
			<?php sportmall_the_icon( 'search' ); ?>
			<h2><?php esc_html_e( 'چیزی پیدا نشد.', 'sportmall' ); ?></h2>
			<p><?php esc_html_e( 'عبارت دیگری را امتحان کن یا از دسته‌بندی‌ها شروع کن.', 'sportmall' ); ?></p>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<div class="search-suggestions">
					<?php
					$terms = sportmall_type_categories( 4 );
					foreach ( $terms as $term ) :
						?>
						<a class="outline-button" href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<a class="accent-button" href="<?php echo esc_url( sportmall_shop_url() ); ?>"><?php esc_html_e( 'رفتن به فروشگاه', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
		</div>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
