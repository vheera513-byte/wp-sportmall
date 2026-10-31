<?php
/**
 * Quick category shortcuts.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$slugs = array( 'shoes', 'tops', 'leggings', 'shorts', 'bags', 'socks', 'bottles' );
$items = array();

if ( taxonomy_exists( 'product_cat' ) ) {
	foreach ( $slugs as $slug ) {
		$term = get_term_by( 'slug', $slug, 'product_cat' );
		if ( $term && ! is_wp_error( $term ) ) {
			$items[] = array(
				'name'  => $term->name,
				'url'   => get_term_link( $term ),
				'image' => sportmall_category_image( $term, 'sportmall-square' ),
			);
		}
	}
}

if ( empty( $items ) ) {
	$fallback = array(
		'shoes'    => array( __( 'کفش ورزشی', 'sportmall' ), 'product-pegasus.jpg' ),
		'tops'     => array( __( 'تی‌شرت و تاپ', 'sportmall' ), 'product-tee.jpg' ),
		'leggings' => array( __( 'لگ و شلوار', 'sportmall' ), 'product-leggings.jpg' ),
		'shorts'   => array( __( 'شلوارک', 'sportmall' ), 'product-shorts.jpg' ),
		'bags'     => array( __( 'ساک ورزشی', 'sportmall' ), 'product-bag.jpg' ),
		'socks'    => array( __( 'جوراب ورزشی', 'sportmall' ), 'product-socks.jpg' ),
		'bottles'  => array( __( 'قمقمه', 'sportmall' ), 'product-bottle.jpg' ),
	);
	foreach ( $fallback as $slug => $data ) {
		$items[] = array(
			'name'  => $data[0],
			'url'   => add_query_arg( 'product_cat', $slug, sportmall_shop_url() ),
			'image' => sportmall_asset( 'images/' . $data[1] ),
		);
	}
}
?>
<section class="quick-categories shell" aria-labelledby="quick-categories-title">
	<div class="quick-heading">
		<h2 id="quick-categories-title"><?php echo esc_html( sportmall_mod( 'quick_title' ) ); ?></h2>
		<span><?php echo esc_html( sportmall_mod( 'quick_subtitle' ) ); ?></span>
	</div>
	<div class="quick-category-grid">
		<?php foreach ( $items as $item ) : ?>
			<a class="quick-category" href="<?php echo esc_url( $item['url'] ); ?>">
				<span class="quick-category-image">
					<img src="<?php echo esc_url( $item['image'] ); ?>" alt="" loading="lazy" width="160" height="160">
				</span>
				<span><?php echo esc_html( $item['name'] ); ?></span>
			</a>
		<?php endforeach; ?>
		<a class="quick-category quick-category-all" href="<?php echo esc_url( sportmall_shop_url() ); ?>">
			<span class="quick-category-image">
				<?php sportmall_the_icon( 'arrow' ); ?>
				<small>LET’S MOVE</small>
			</span>
			<span><?php esc_html_e( 'همهٔ محصولات', 'sportmall' ); ?></span>
		</a>
	</div>
</section>
