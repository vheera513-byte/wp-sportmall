<?php
/**
 * Journal index / fallback template.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

get_header();

$page_for_posts = (int) get_option( 'page_for_posts' );
$title          = $page_for_posts ? get_the_title( $page_for_posts ) : __( 'ژورنال اسپرت‌مال', 'sportmall' );
$subtitle       = $page_for_posts ? get_post_field( 'post_excerpt', $page_for_posts ) : __( 'راهنماها، استایل‌ها و روایت‌هایی برای زندگی در حرکت.', 'sportmall' );

get_template_part( 'template-parts/header/page-hero', null, array(
	'title'    => $title,
	'eyebrow'  => __( 'بیشتر از یک فروشگاه', 'sportmall' ),
	'subtitle' => $subtitle,
) );
?>

<main id="main-content" class="page-main shell">
	<div class="archive-layout">
		<div class="archive-primary">
			<?php if ( have_posts() ) : ?>
				<div class="archive-grid">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/blog/card' ); ?>
					<?php endwhile; ?>
				</div>
				<?php sportmall_pagination(); ?>
			<?php else : ?>
				<div class="no-results">
					<h2><?php esc_html_e( 'هنوز نوشته‌ای منتشر نشده است.', 'sportmall' ); ?></h2>
					<p><?php esc_html_e( 'به‌زودی راهنماها و روایت‌های تازه اینجا منتشر می‌شوند.', 'sportmall' ); ?></p>
					<a class="accent-button" href="<?php echo esc_url( sportmall_shop_url() ); ?>"><?php esc_html_e( 'رفتن به فروشگاه', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
				</div>
			<?php endif; ?>
		</div>
		<?php get_sidebar( 'blog' ); ?>
	</div>
</main>

<?php get_footer(); ?>
