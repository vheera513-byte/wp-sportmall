<?php
/**
 * Single product wrapper.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

while ( have_posts() ) :
	the_post();
	$product = wc_get_product( get_the_ID() );
	$cats    = get_the_terms( get_the_ID(), 'product_cat' );
	$cat     = $cats && ! is_wp_error( $cats ) ? $cats[0] : null;

	get_template_part( 'template-parts/header/page-hero', null, array(
		'title'    => get_the_title(),
		'eyebrow'  => $cat ? $cat->name : __( 'محصول اسپرت‌مال', 'sportmall' ),
		'subtitle' => $product ? wp_trim_words( wp_strip_all_tags( $product->get_short_description() ), 22 ) : '',
		'class'    => 'page-hero--product',
		'compact'  => true,
	) );
	?>
	<main id="main-content" class="product-main">
		<div class="shell">
			<?php wc_get_template_part( 'content', 'single-product' ); ?>
		</div>
	</main>
	<?php
endwhile;

get_footer( 'shop' );
