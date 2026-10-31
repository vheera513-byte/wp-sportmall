<?php
/**
 * Main category cards and brand strip.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$defaults = array(
	'women' => array(
		'name'  => __( 'زنانه', 'sportmall' ),
		'text'  => __( 'قدرت، در راحت‌ترین شکلش', 'sportmall' ),
		'label' => '01 / WOMEN',
		'image' => 'category-women.jpg',
	),
	'men'   => array(
		'name'  => __( 'مردانه', 'sportmall' ),
		'text'  => __( 'آماده برای یک قدم بیشتر', 'sportmall' ),
		'label' => '02 / MEN',
		'image' => 'category-men.jpg',
	),
	'shoes' => array(
		'name'  => __( 'کفش ورزشی', 'sportmall' ),
		'text'  => __( 'شروع هر مسیر خوب', 'sportmall' ),
		'label' => '03 / FOOTWEAR',
		'image' => 'category-shoes.jpg',
	),
);

$cards = array();
foreach ( $defaults as $slug => $data ) {
	$term = taxonomy_exists( 'product_cat' ) ? get_term_by( 'slug', $slug, 'product_cat' ) : null;
	if ( $term && ! is_wp_error( $term ) ) {
		$cards[] = array(
			'name'  => $term->name,
			'text'  => $term->description ? wp_trim_words( wp_strip_all_tags( $term->description ), 8 ) : $data['text'],
			'label' => $data['label'],
			'image' => sportmall_category_image( $term ),
			'url'   => get_term_link( $term ),
			'class' => 'shoes' === $slug ? ' shoes-category' : '',
		);
	} else {
		$cards[] = array(
			'name'  => $data['name'],
			'text'  => $data['text'],
			'label' => $data['label'],
			'image' => sportmall_asset( 'images/' . $data['image'] ),
			'url'   => add_query_arg( 'product_cat', $slug, sportmall_shop_url() ),
			'class' => 'shoes' === $slug ? ' shoes-category' : '',
		);
	}
}
?>
<section class="section categories shell" id="categories" aria-labelledby="categories-title">
	<div class="section-heading">
		<div>
			<p class="eyebrow"><?php echo esc_html( sportmall_mod( 'categories_eyebrow' ) ); ?></p>
			<h2 class="section-title" id="categories-title"><?php echo esc_html( sportmall_mod( 'categories_title' ) ); ?></h2>
		</div>
		<p class="section-description"><?php echo wp_kses_post( nl2br( sportmall_mod( 'categories_text' ) ) ); ?></p>
	</div>

	<div class="category-grid">
		<?php foreach ( $cards as $card ) : ?>
			<a class="category-card<?php echo esc_attr( $card['class'] ); ?>" href="<?php echo esc_url( $card['url'] ); ?>">
				<img src="<?php echo esc_url( $card['image'] ); ?>" alt="<?php echo esc_attr( $card['name'] ); ?>" loading="lazy" width="900" height="1100">
				<span class="category-number"><?php echo esc_html( $card['label'] ); ?></span>
				<div class="category-copy">
					<h3><?php echo esc_html( $card['name'] ); ?></h3>
					<p><?php echo esc_html( $card['text'] ); ?></p>
				</div>
				<span class="circle-arrow"><?php sportmall_the_icon( 'arrow' ); ?></span>
			</a>
		<?php endforeach; ?>
	</div>

	<?php if ( sportmall_is_on( 'show_brands' ) ) : ?>
		<?php $brands = sportmall_get_brands( 6 ); ?>
		<?php if ( $brands ) : ?>
			<div class="brand-strip" id="brands">
				<p class="brand-strip-label"><?php echo wp_kses_post( nl2br( sportmall_mod( 'brands_label' ) ) ); ?></p>
				<div class="brand-row">
					<?php foreach ( $brands as $brand ) : ?>
						<a href="<?php echo esc_url( $brand['url'] ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'محصولات %s', 'sportmall' ), $brand['name'] ) ); ?>">
							<img src="<?php echo esc_url( $brand['logo'] ); ?>" alt="<?php echo esc_attr( $brand['name'] ); ?>" width="83" height="36" loading="lazy">
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>
</section>
