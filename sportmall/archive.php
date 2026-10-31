<?php
/**
 * Archive template for journal, stories and outfits.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

get_header();

$post_type = get_query_var( 'post_type' );
$post_type = is_array( $post_type ) ? reset( $post_type ) : $post_type;

if ( is_post_type_archive() ) {
	$archive_object = get_queried_object();
	if ( $archive_object instanceof WP_Post_Type ) {
		$post_type = $archive_object->name;
	}
}
$title     = get_the_archive_title();
$subtitle  = get_the_archive_description();
$eyebrow   = __( 'آرشیو', 'sportmall' );

if ( is_category() || is_tag() || is_tax() ) {
	$title   = single_term_title( '', false );
	$eyebrow = is_tag() ? __( 'برچسب', 'sportmall' ) : __( 'موضوع', 'sportmall' );
} elseif ( 'sm_story' === $post_type ) {
	$title   = __( 'استوری‌های مشتریان', 'sportmall' );
	$eyebrow = __( 'روایت‌های حرکت', 'sportmall' );
	$subtitle = __( 'هر انتخاب، یک داستان دارد. این‌بار راوی شما هستید.', 'sportmall' );
} elseif ( 'sm_outfit' === $post_type ) {
	$title   = __( 'ست‌های ورزشی', 'sportmall' );
	$eyebrow = __( 'یک استایل کامل', 'sportmall' );
	$subtitle = __( 'ترکیب‌های آماده برای تمرین، دویدن و روزهای پرتحرک.', 'sportmall' );
} elseif ( is_author() ) {
	$title   = get_the_author();
	$eyebrow = __( 'نویسنده', 'sportmall' );
} elseif ( is_date() ) {
	$eyebrow = __( 'آرشیو تاریخ', 'sportmall' );
}

get_template_part( 'template-parts/header/page-hero', null, array(
	'title'    => $title,
	'eyebrow'  => $eyebrow,
	'subtitle' => $subtitle,
	'class'    => 'page-hero--archive',
) );
?>

<main id="main-content" class="page-main shell">
	<?php if ( have_posts() ) : ?>
		<?php if ( 'sm_story' === $post_type || is_post_type_archive( 'sm_story' ) ) : ?>
			<div class="stories-grid stories-grid--archive">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/story/card' ); ?>
				<?php endwhile; ?>
			</div>
		<?php elseif ( 'sm_outfit' === $post_type || is_post_type_archive( 'sm_outfit' ) ) : ?>
			<div class="outfits-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/outfit/card' ); ?>
				<?php endwhile; ?>
			</div>
		<?php else : ?>
			<div class="archive-layout">
				<div class="archive-primary">
					<div class="archive-grid">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'template-parts/blog/card' ); ?>
						<?php endwhile; ?>
					</div>
					<?php sportmall_pagination(); ?>
				</div>
				<?php get_sidebar( 'blog' ); ?>
			</div>
		<?php endif; ?>

		<?php if ( in_array( $post_type, array( 'sm_story', 'sm_outfit' ), true ) || is_post_type_archive( 'sm_story' ) || is_post_type_archive( 'sm_outfit' ) ) : ?>
			<?php sportmall_pagination(); ?>
		<?php endif; ?>
	<?php else : ?>
		<div class="no-results">
			<h2><?php esc_html_e( 'اینجا هنوز چیزی نیست.', 'sportmall' ); ?></h2>
			<p><?php esc_html_e( 'به‌زودی محتوای تازه‌ای در این بخش منتشر می‌شود.', 'sportmall' ); ?></p>
			<a class="accent-button" href="<?php echo esc_url( sportmall_shop_url() ); ?>"><?php esc_html_e( 'رفتن به فروشگاه', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
		</div>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
