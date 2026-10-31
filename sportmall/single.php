<?php
/**
 * Single journal article.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	$cats = get_the_category();
	$cat  = $cats ? $cats[0] : null;

	get_template_part( 'template-parts/header/page-hero', null, array(
		'title'    => get_the_title(),
		'eyebrow'  => $cat ? $cat->name : __( 'ژورنال اسپرت‌مال', 'sportmall' ),
		'subtitle' => has_excerpt() ? get_the_excerpt() : '',
		'class'    => 'page-hero--article',
	) );
	?>

	<main id="main-content" class="page-main shell">
		<div class="article-layout">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-body' ); ?>>
				<div class="article-meta">
					<span><?php echo esc_html( sportmall_fa_digits( get_the_date( 'j F Y' ) ) ); ?></span>
					<span><?php echo esc_html( sportmall_reading_time() ); ?></span>
					<?php if ( $cat ) : ?>
						<a href="<?php echo esc_url( get_category_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
					<?php endif; ?>
				</div>

				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="article-cover">
						<?php the_post_thumbnail( 'sportmall-wide', array( 'loading' => 'eager' ) ); ?>
					</figure>
				<?php endif; ?>

				<div class="entry-content">
					<?php the_content(); ?>
					<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">',
						'after'  => '</div>',
					) );
					?>
				</div>

				<?php if ( has_tag() ) : ?>
					<div class="article-tags">
						<?php the_tags( '<span>' . esc_html__( 'برچسب‌ها:', 'sportmall' ) . '</span> ', ' ', '' ); ?>
					</div>
				<?php endif; ?>

				<div class="article-author">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 64, '', get_the_author(), array( 'class' => 'author-avatar' ) ); ?>
					<div>
						<small><?php esc_html_e( 'نوشتهٔ', 'sportmall' ); ?></small>
						<strong><?php the_author(); ?></strong>
						<p><?php echo esc_html( get_the_author_meta( 'description' ) ?: __( 'از تیم محتوای اسپرت‌مال.', 'sportmall' ) ); ?></p>
					</div>
				</div>

				<nav class="post-navigation" aria-label="<?php esc_attr_e( 'پیمایش نوشته‌ها', 'sportmall' ); ?>">
					<?php
					$prev = get_previous_post();
					$next = get_next_post();
					?>
					<?php if ( $prev ) : ?>
						<a class="post-nav-link post-nav-link--prev" href="<?php echo esc_url( get_permalink( $prev ) ); ?>">
							<?php sportmall_the_icon( 'chevron-right' ); ?>
							<span><small><?php esc_html_e( 'نوشتهٔ قبلی', 'sportmall' ); ?></small><strong><?php echo esc_html( get_the_title( $prev ) ); ?></strong></span>
						</a>
					<?php endif; ?>
					<?php if ( $next ) : ?>
						<a class="post-nav-link post-nav-link--next" href="<?php echo esc_url( get_permalink( $next ) ); ?>">
							<span><small><?php esc_html_e( 'نوشتهٔ بعدی', 'sportmall' ); ?></small><strong><?php echo esc_html( get_the_title( $next ) ); ?></strong></span>
							<?php sportmall_the_icon( 'chevron-left' ); ?>
						</a>
					<?php endif; ?>
				</nav>

				<?php
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				?>
			</article>

			<?php get_sidebar( 'blog' ); ?>
		</div>

		<?php
		$related = new WP_Query( array(
			'post_type'           => 'post',
			'posts_per_page'      => 3,
			'post__not_in'        => array( get_the_ID() ),
			'ignore_sticky_posts' => true,
			'category__in'        => $cat ? array( $cat->term_id ) : array(),
		) );
		if ( $related->have_posts() ) :
			?>
			<section class="related-posts section">
				<div class="section-heading">
					<div>
						<p class="eyebrow"><?php esc_html_e( 'ادامهٔ خواندن', 'sportmall' ); ?></p>
						<h2 class="section-title"><?php esc_html_e( 'بیشتر از ژورنال', 'sportmall' ); ?></h2>
					</div>
					<a class="text-link" href="<?php echo esc_url( sportmall_journal_url() ); ?>"><?php esc_html_e( 'همهٔ نوشته‌ها', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
				</div>
				<div class="archive-grid archive-grid--three">
					<?php while ( $related->have_posts() ) : $related->the_post(); ?>
						<?php get_template_part( 'template-parts/blog/card' ); ?>
					<?php endwhile; ?>
				</div>
			</section>
			<?php
			wp_reset_postdata();
		endif;
		?>
	</main>

	<?php
endwhile;

get_footer();
