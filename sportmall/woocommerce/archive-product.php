<?php
/**
 * Product archive (shop, categories, sale, brand).
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$shop_url  = wc_get_page_permalink( 'shop' );
$base_url  = is_product_taxonomy() ? get_term_link( get_queried_object() ) : $shop_url;
$base_url  = is_wp_error( $base_url ) ? $shop_url : $base_url;
$base_url  = remove_query_arg( 'paged', $base_url );
$title     = woocommerce_page_title( false );
$subtitle  = '';
$eyebrow   = __( 'فروشگاه اسپرت‌مال', 'sportmall' );
$brand     = isset( $_GET['brand'] ) ? sanitize_title( wp_unslash( $_GET['brand'] ) ) : '';
$on_sale   = ! empty( $_GET['on_sale'] );
$brand_term = $brand && taxonomy_exists( 'pa_brand' ) ? get_term_by( 'slug', $brand, 'pa_brand' ) : null;

if ( is_product_taxonomy() ) {
	$term     = get_queried_object();
	$title    = $term->name;
	$subtitle = term_description( $term );
	$eyebrow  = __( 'دسته‌بندی محصولات', 'sportmall' );
} elseif ( is_search() ) {
	$title    = sprintf( __( 'نتیجه‌های «%s»', 'sportmall' ), get_search_query() );
	$eyebrow  = __( 'جستجو در فروشگاه', 'sportmall' );
} else {
	$shop_page_id = wc_get_page_id( 'shop' );
	$subtitle     = $shop_page_id > 0 ? apply_filters( 'the_content', get_post_field( 'post_content', $shop_page_id ) ) : '';
}

if ( $brand_term && ! is_wp_error( $brand_term ) ) {
	$eyebrow = __( 'برند', 'sportmall' );
	$title   = $brand_term->name;
}

if ( $on_sale ) {
	$eyebrow = __( 'فرصت محدود', 'sportmall' );
	$title   = __( 'پیشنهادهای ویژه', 'sportmall' );
}

get_template_part( 'template-parts/header/page-hero', null, array(
	'title'    => $title,
	'eyebrow'  => $eyebrow,
	'subtitle' => $subtitle,
	'class'    => 'page-hero--shop',
) );
?>

<div class="shell woo-notices">
	<?php if ( function_exists( 'woocommerce_output_all_notices' ) ) : ?>
		<?php woocommerce_output_all_notices(); ?>
	<?php endif; ?>
</div>

<main id="main-content" class="shop-main">
	<div class="shell shop-layout">
		<aside class="shop-sidebar" id="shop-sidebar" aria-label="<?php esc_attr_e( 'فیلتر محصولات', 'sportmall' ); ?>" data-sm-shop-sidebar>
			<div class="shop-filter-head">
				<h2><?php esc_html_e( 'فیلترها', 'sportmall' ); ?></h2>
				<a class="shop-filter-clear" href="<?php echo esc_url( $base_url ); ?>"><?php esc_html_e( 'پاک کردن همه', 'sportmall' ); ?></a>
				<button class="shop-filter-close" type="button" aria-label="<?php esc_attr_e( 'بستن فیلترها', 'sportmall' ); ?>" data-sm-filter-toggle><?php sportmall_the_icon( 'close' ); ?></button>
			</div>

			<?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
				<?php dynamic_sidebar( 'shop-sidebar' ); ?>
			<?php else : ?>
				<?php
				$terms = get_terms( array(
					'taxonomy'   => 'product_cat',
					'hide_empty' => true,
					'orderby'    => 'menu_order',
					'order'      => 'ASC',
				) );
				if ( ! is_wp_error( $terms ) && $terms ) :
					?>
					<section class="shop-filter">
						<h3 class="shop-filter-title"><?php esc_html_e( 'دسته‌بندی‌ها', 'sportmall' ); ?></h3>
						<ul class="shop-cat-list">
							<li class="<?php echo is_shop() && ! $brand && ! $on_sale ? 'is-active' : ''; ?>">
								<a href="<?php echo esc_url( remove_query_arg( array( 'brand', 'on_sale', 'min_price', 'max_price', 'stock' ), $base_url ) ); ?>"><?php esc_html_e( 'همهٔ محصولات', 'sportmall' ); ?><small><?php echo esc_html( sportmall_fa_digits( $GLOBALS['wp_query']->found_posts ) ); ?></small></a>
							</li>
							<?php foreach ( $terms as $cat ) : ?>
								<?php
								$is_current = is_product_category( $cat->slug );
								$depth      = count( get_ancestors( $cat->term_id, 'product_cat' ) );
								?>
								<li class="<?php echo $is_current ? 'is-active' : ''; ?><?php echo $depth ? ' is-child' : ''; ?>">
									<a href="<?php echo esc_url( remove_query_arg( array( 'brand', 'on_sale', 'min_price', 'max_price', 'stock' ), get_term_link( $cat ) ) ); ?>">
										<?php echo esc_html( $cat->name ); ?>
										<small><?php echo esc_html( sportmall_fa_digits( $cat->count ) ); ?></small>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</section>
				<?php endif; ?>

				<?php
				$bounds = sportmall_price_bounds();
				$min    = isset( $_GET['min_price'] ) ? (int) $_GET['min_price'] : $bounds['min'];
				$max    = isset( $_GET['max_price'] ) ? (int) $_GET['max_price'] : $bounds['max'];
				?>
				<section class="shop-filter">
					<h3 class="shop-filter-title"><?php esc_html_e( 'محدودهٔ قیمت', 'sportmall' ); ?></h3>
					<form class="shop-price-filter" method="get" action="<?php echo esc_url( $base_url ); ?>">
						<label>
							<span><?php esc_html_e( 'از', 'sportmall' ); ?></span>
							<input type="number" name="min_price" value="<?php echo esc_attr( $min ); ?>" min="0" step="10000" inputmode="numeric">
						</label>
						<label>
							<span><?php esc_html_e( 'تا', 'sportmall' ); ?></span>
							<input type="number" name="max_price" value="<?php echo esc_attr( $max ); ?>" min="0" step="10000" inputmode="numeric">
						</label>
						<?php if ( $on_sale ) : ?><input type="hidden" name="on_sale" value="1"><?php endif; ?>
						<?php if ( $brand ) : ?><input type="hidden" name="brand" value="<?php echo esc_attr( $brand ); ?>"><?php endif; ?>
						<button type="submit" class="outline-button"><?php esc_html_e( 'اعمال قیمت', 'sportmall' ); ?></button>
					</form>
					<p class="shop-price-note"><?php echo esc_html( sprintf( __( 'از %1$s تا %2$s', 'sportmall' ), sportmall_money( $bounds['min'] ), sportmall_money( $bounds['max'] ) ) ); ?></p>
				</section>

				<?php
				if ( taxonomy_exists( 'pa_brand' ) ) :
					$brand_terms = get_terms( array( 'taxonomy' => 'pa_brand', 'hide_empty' => true, 'number' => 30 ) );
					if ( ! is_wp_error( $brand_terms ) && $brand_terms ) :
						?>
						<section class="shop-filter">
							<h3 class="shop-filter-title"><?php esc_html_e( 'برندها', 'sportmall' ); ?></h3>
							<ul class="shop-brand-list">
								<?php foreach ( $brand_terms as $brand_item ) : ?>
									<li class="<?php echo $brand === $brand_item->slug ? 'is-active' : ''; ?>">
										<a href="<?php echo esc_url( add_query_arg( 'brand', $brand_item->slug, $base_url ) ); ?>">
											<span><?php echo esc_html( $brand_item->name ); ?></span>
											<small><?php echo esc_html( sportmall_fa_digits( $brand_item->count ) ); ?></small>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</section>
					<?php endif; ?>
				<?php endif; ?>

				<section class="shop-filter shop-filter--quick">
					<h3 class="shop-filter-title"><?php esc_html_e( 'انتخاب سریع', 'sportmall' ); ?></h3>
					<ul class="shop-quick-links">
						<li class="<?php echo $on_sale ? 'is-active' : ''; ?>"><a href="<?php echo esc_url( add_query_arg( 'on_sale', '1', $base_url ) ); ?>"><?php sportmall_the_icon( 'tag' ); ?><?php esc_html_e( 'فقط تخفیف‌دارها', 'sportmall' ); ?></a></li>
						<li class="<?php echo ! empty( $_GET['stock'] ) ? 'is-active' : ''; ?>"><a href="<?php echo esc_url( add_query_arg( 'stock', 'instock', $base_url ) ); ?>"><?php sportmall_the_icon( 'check' ); ?><?php esc_html_e( 'فقط موجودها', 'sportmall' ); ?></a></li>
						<li><a href="<?php echo esc_url( add_query_arg( 'orderby', 'date', $base_url ) ); ?>"><?php sportmall_the_icon( 'spark' ); ?><?php esc_html_e( 'تازه‌رسیده‌ها', 'sportmall' ); ?></a></li>
						<li><a href="<?php echo esc_url( add_query_arg( 'orderby', 'popularity', $base_url ) ); ?>"><?php sportmall_the_icon( 'star' ); ?><?php esc_html_e( 'پرفروش‌ترین‌ها', 'sportmall' ); ?></a></li>
					</ul>
				</section>
			<?php endif; ?>

			<div class="shop-sidebar-note">
				<?php sportmall_the_icon( 'headphones' ); ?>
				<p><?php esc_html_e( 'در انتخاب تردید داری؟ راهنمای سایز و تماس با ما کنارت هستند.', 'sportmall' ); ?></p>
				<a class="text-link" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'کمک می‌خواهم', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
			</div>
		</aside>

		<div class="shop-content">
			<button class="shop-filter-toggle" type="button" data-sm-filter-toggle aria-expanded="false" aria-controls="shop-sidebar">
				<?php sportmall_the_icon( 'filter' ); ?><span><?php esc_html_e( 'فیلترها', 'sportmall' ); ?></span>
			</button>

			<?php if ( woocommerce_product_loop() ) : ?>
				<?php sportmall_shop_toolbar(); ?>
				<?php woocommerce_product_loop_start(); ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php wc_get_template_part( 'content', 'product' ); ?>
				<?php endwhile; ?>
				<?php woocommerce_product_loop_end(); ?>
				<?php woocommerce_pagination(); ?>
			<?php else : ?>
				<div class="no-results shop-no-results">
					<?php sportmall_the_icon( 'search' ); ?>
					<h2><?php esc_html_e( 'محصولی با این فیلتر پیدا نشد.', 'sportmall' ); ?></h2>
					<p><?php esc_html_e( 'فیلترها را پاک کن یا دسته‌بندی دیگری را ببین.', 'sportmall' ); ?></p>
					<a class="accent-button" href="<?php echo esc_url( $base_url ); ?>"><?php esc_html_e( 'پاک کردن فیلترها', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</main>

<?php get_footer( 'shop' ); ?>
