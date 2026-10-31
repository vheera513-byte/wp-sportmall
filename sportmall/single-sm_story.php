<?php
/**
 * Single customer story.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	$name     = get_post_meta( get_the_ID(), '_sm_name', true ) ?: get_the_title();
	$activity = get_post_meta( get_the_ID(), '_sm_activity', true );
	$initial  = get_post_meta( get_the_ID(), '_sm_initial', true );
	$category = get_post_meta( get_the_ID(), '_sm_category', true );
	$quote    = get_post_meta( get_the_ID(), '_sm_quote', true );
	$product  = (int) get_post_meta( get_the_ID(), '_sm_product', true );
	$position = get_post_meta( get_the_ID(), '_sm_position', true ) ?: '50% 35%';
	$image    = get_the_post_thumbnail_url( get_the_ID(), 'full' );
	if ( ! $image ) {
		$image = sportmall_asset( 'images/category-women.jpg' );
	}
	if ( ! $initial ) {
		$initial = sportmall_first_char( $name );
	}

	get_template_part( 'template-parts/header/page-hero', null, array(
		'title'    => get_the_title(),
		'eyebrow'  => $category ?: __( 'استوری مشتریان', 'sportmall' ),
		'subtitle' => $activity ? sprintf( __( 'روایت %1$s از %2$s', 'sportmall' ), $name, $activity ) : '',
		'class'    => 'page-hero--story',
	) );
	?>

	<main id="main-content" class="page-main shell">
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'story-single' ); ?>>
			<figure class="story-single-cover">
				<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $name ); ?>" style="object-position:<?php echo esc_attr( $position ); ?>" loading="eager">
				<figcaption class="story-single-person">
					<span class="story-avatar"><?php echo esc_html( $initial ); ?></span>
					<span>
						<strong><?php echo esc_html( $name ); ?></strong>
						<?php if ( $activity ) : ?><small><?php echo esc_html( $activity ); ?></small><?php endif; ?>
					</span>
				</figcaption>
			</figure>

			<div class="story-single-layout">
				<div class="story-single-body">
					<?php if ( $quote ) : ?>
						<blockquote class="story-quote"><?php echo esc_html( $quote ); ?></blockquote>
					<?php endif; ?>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>

					<?php
					if ( $product && function_exists( 'wc_get_product' ) ) :
						$product_obj = wc_get_product( $product );
						if ( $product_obj && $product_obj->is_visible() ) :
							?>
							<div class="story-product-card">
								<a class="story-product-card-image" href="<?php echo esc_url( get_permalink( $product ) ); ?>">
									<?php echo wp_kses_post( $product_obj->get_image( 'woocommerce_thumbnail' ) ); ?>
								</a>
								<div>
									<small><?php esc_html_e( 'محصول همراه این داستان', 'sportmall' ); ?></small>
									<h3><a href="<?php echo esc_url( get_permalink( $product ) ); ?>"><?php echo esc_html( $product_obj->get_name() ); ?></a></h3>
									<div class="product-price"><?php echo wp_kses_post( sportmall_product_price_html( $product_obj ) ); ?></div>
								</div>
								<a class="outline-button" href="<?php echo esc_url( get_permalink( $product ) ); ?>"><?php esc_html_e( 'مشاهده محصول', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>

				<aside class="story-single-aside">
					<p class="eyebrow"><?php esc_html_e( 'داستان‌های بیشتر', 'sportmall' ); ?></p>
					<?php
					$more = new WP_Query( array(
						'post_type'      => 'sm_story',
						'posts_per_page' => 3,
						'post__not_in'   => array( get_the_ID() ),
					) );
					if ( $more->have_posts() ) :
						?>
						<div class="story-side-list">
							<?php while ( $more->have_posts() ) : $more->the_post(); ?>
								<a class="story-side-item" href="<?php the_permalink(); ?>">
									<?php echo wp_kses_post( sportmall_post_image( get_the_ID(), 'thumbnail' ) ); ?>
									<span>
										<strong><?php the_title(); ?></strong>
										<small><?php echo esc_html( get_post_meta( get_the_ID(), '_sm_name', true ) ); ?></small>
									</span>
								</a>
							<?php endwhile; ?>
						</div>
						<?php
						wp_reset_postdata();
					endif;
					?>
					<a class="accent-button" href="<?php echo esc_url( sportmall_stories_url() ); ?>"><?php esc_html_e( 'همهٔ استوری‌ها', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
				</aside>
			</div>
		</article>
	</main>

	<?php
endwhile;

get_footer();
