<?php
/**
 * Journal / page sidebar.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$sidebar_id = is_active_sidebar( 'blog-sidebar' ) ? 'blog-sidebar' : 'page-sidebar';
?>
<aside class="archive-sidebar" aria-label="<?php esc_attr_e( 'ستون کنار', 'sportmall' ); ?>">
	<?php if ( is_active_sidebar( $sidebar_id ) ) : ?>
		<?php dynamic_sidebar( $sidebar_id ); ?>
	<?php else : ?>
		<section class="widget">
			<h3 class="widget-title"><?php esc_html_e( 'موضوع‌های ژورنال', 'sportmall' ); ?></h3>
			<ul class="widget-cats">
				<?php
				$cats = get_categories( array( 'hide_empty' => true, 'number' => 6 ) );
				if ( $cats ) :
					foreach ( $cats as $cat ) :
						?>
						<li><a href="<?php echo esc_url( get_category_link( $cat ) ); ?>"><span><?php echo esc_html( $cat->name ); ?></span><small><?php echo esc_html( sportmall_fa_digits( $cat->count ) ); ?></small></a></li>
						<?php
					endforeach;
				else :
					?>
					<li><a href="<?php echo esc_url( sportmall_journal_url() ); ?>"><?php esc_html_e( 'همهٔ نوشته‌ها', 'sportmall' ); ?></a></li>
				<?php endif; ?>
			</ul>
		</section>

		<section class="widget">
			<h3 class="widget-title"><?php esc_html_e( 'تازه‌ترین نوشته‌ها', 'sportmall' ); ?></h3>
			<?php
			$recent = new WP_Query( array( 'posts_per_page' => 3, 'ignore_sticky_posts' => true ) );
			if ( $recent->have_posts() ) :
				?>
				<div class="widget-posts">
					<?php while ( $recent->have_posts() ) : $recent->the_post(); ?>
						<a class="widget-post" href="<?php the_permalink(); ?>">
							<?php echo wp_kses_post( sportmall_post_image( get_the_ID(), 'thumbnail', array( 'loading' => 'lazy' ) ) ); ?>
							<span>
								<strong><?php the_title(); ?></strong>
								<small><?php echo esc_html( sportmall_reading_time( get_the_ID() ) ); ?></small>
							</span>
						</a>
					<?php endwhile; ?>
				</div>
				<?php
				wp_reset_postdata();
			endif;
			?>
		</section>

		<section class="widget widget-cta">
			<p class="widget-eyebrow"><?php esc_html_e( 'یک قدم تازه', 'sportmall' ); ?></p>
			<h3><?php esc_html_e( 'انتخاب‌های تازه، منتظر تو هستند.', 'sportmall' ); ?></h3>
			<a class="accent-button" href="<?php echo esc_url( sportmall_shop_url() ); ?>"><?php esc_html_e( 'مشاهده محصولات', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
		</section>
	<?php endif; ?>
</aside>
