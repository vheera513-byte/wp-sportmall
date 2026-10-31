<?php
/**
 * Standard page template. Also renders the WooCommerce cart, checkout and
 * account pages through their shortcodes/templates.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

get_header();

$is_woo_page = function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() );
$eyebrow     = '';

if ( function_exists( 'is_cart' ) && is_cart() ) {
	$eyebrow = __( 'یک قدم تا شروع', 'sportmall' );
} elseif ( function_exists( 'is_checkout' ) && is_checkout() ) {
	$eyebrow = __( 'تکمیل سفارش', 'sportmall' );
} elseif ( function_exists( 'is_account_page' ) && is_account_page() ) {
	$eyebrow = __( 'حساب اسپرت‌مال', 'sportmall' );
}

get_template_part( 'template-parts/header/page-hero', null, array(
	'title'    => get_the_title(),
	'eyebrow'  => $eyebrow,
	'subtitle' => has_excerpt() ? get_the_excerpt() : '',
	'class'    => $is_woo_page ? 'page-hero--woo' : '',
) );

if ( function_exists( 'wc_print_notices' ) && ( is_cart() || is_checkout() || is_account_page() ) ) {
	echo '<div class="shell woo-notices">';
	wc_print_notices();
	echo '</div>';
}
?>

<main id="main-content" class="page-main shell<?php echo $is_woo_page ? ' page-main--woo' : ''; ?>">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( $is_woo_page ? 'page-entry page-entry--woo' : 'entry-content page-entry' ); ?>>
			<?php if ( $is_woo_page ) : ?>
				<div class="woo-page-content">
			<?php endif; ?>

			<?php the_content(); ?>

			<?php if ( $is_woo_page ) : ?>
				</div>
			<?php endif; ?>

			<?php
			if ( ! $is_woo_page ) {
				wp_link_pages( array(
					'before' => '<div class="page-links">',
					'after'  => '</div>',
				) );
			}
			?>
		</article>
		<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
	?>
</main>

<?php get_footer(); ?>
