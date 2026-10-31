<?php
/**
 * Outfit card.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$products = sportmall_outfit_products( get_the_ID() );
$image    = get_the_post_thumbnail_url( get_the_ID(), 'sportmall-wide' );
if ( ! $image ) {
	$image = sportmall_asset( 'images/category-men.jpg' );
}
$edition  = get_post_meta( get_the_ID(), '_sm_edition', true ) ?: 'THE EDIT';
$name     = get_post_meta( get_the_ID(), '_sm_outfit_name', true ) ?: get_the_title();
$sum      = 0;
foreach ( $products as $product ) {
	$sum += (float) $product->get_price();
}
?>
<article <?php post_class( 'outfit-card' ); ?>>
	<a class="outfit-card-image" href="<?php the_permalink(); ?>">
		<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy">
		<span class="outfit-edition" lang="en"><?php echo esc_html( $edition ); ?></span>
	</a>
	<div class="outfit-card-body">
		<span class="eyebrow"><?php echo esc_html( sprintf( _n( '%s آیتم', '%s آیتم', count( $products ), 'sportmall' ), sportmall_fa_digits( count( $products ) ) ) ); ?></span>
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<p><?php echo esc_html( get_the_excerpt() ); ?></p>
		<div class="outfit-card-footer">
			<span class="outfit-card-price"><?php echo esc_html( sportmall_money( $sum ) ); ?></span>
			<a class="text-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'دیدن ست', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
		</div>
	</div>
</article>
