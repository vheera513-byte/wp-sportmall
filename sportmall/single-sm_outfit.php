<?php
/**
 * Single curated outfit.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$products = sportmall_outfit_products( get_the_ID() );
	$edition  = get_post_meta( get_the_ID(), '_sm_edition', true ) ?: 'THE EDIT';
	$desc     = get_post_meta( get_the_ID(), '_sm_description', true );
	$tags     = array_filter( array_map( 'trim', explode( ',', (string) get_post_meta( get_the_ID(), '_sm_tags', true ) ) ) );
	$position = get_post_meta( get_the_ID(), '_sm_position', true ) ?: '50% 40%';
	$sum      = 0;
	foreach ( $products as $product ) {
		$sum += (float) $product->get_price();
	}

	get_template_part( 'template-parts/header/page-hero', null, array(
		'title'    => get_the_title(),
		'eyebrow'  => $edition,
		'subtitle' => $desc ?: get_the_excerpt(),
		'class'    => 'page-hero--outfit',
	) );
	?>

	<main id="main-content" class="page-main shell">
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'outfit-single' ); ?>>
			<div class="outfit-single-hero">
				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="outfit-single-look">
						<?php the_post_thumbnail( 'large', array( 'style' => 'object-position:' . esc_attr( $position ), 'loading' => 'eager' ) ); ?>
						<figcaption><?php esc_html_e( 'LOOK / اسپرت‌مال', 'sportmall' ); ?></figcaption>
					</figure>
				<?php endif; ?>
				<div class="outfit-single-copy">
					<?php if ( $tags ) : ?>
						<div class="outfit-tags">
							<?php foreach ( $tags as $tag ) : ?>
								<span><?php echo esc_html( $tag ); ?></span>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<div class="outfit-single-total">
						<span><?php esc_html_e( 'قیمت مجموع این ست', 'sportmall' ); ?></span>
						<strong><?php echo esc_html( sportmall_money( $sum ) ); ?></strong>
					</div>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
					<p class="outfit-single-note"><?php esc_html_e( 'هر آیتم را جداگانه انتخاب کن تا سایز مناسب خودت را داشته باشی.', 'sportmall' ); ?></p>
					<a class="outline-button" href="<?php echo esc_url( sportmall_shop_url() ); ?>"><?php esc_html_e( 'دیدن همهٔ محصولات', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
				</div>
			</div>

			<?php if ( $products ) : ?>
				<section class="outfit-products section">
					<div class="section-heading">
						<div>
							<p class="eyebrow"><?php esc_html_e( 'آیتم‌های این ست', 'sportmall' ); ?></p>
							<h2 class="section-title"><?php esc_html_e( 'با هم، یک استایل', 'sportmall' ); ?></h2>
						</div>
					</div>
					<div class="product-grid">
						<?php foreach ( $products as $product ) : ?>
							<?php sportmall_product_card( $product ); ?>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endif; ?>
		</article>

		<?php
		$more = new WP_Query( array(
			'post_type'      => 'sm_outfit',
			'posts_per_page' => 2,
			'post__not_in'   => array( get_the_ID() ),
		) );
		if ( $more->have_posts() ) :
			?>
			<section class="related-outfits section">
				<div class="section-heading">
					<div>
						<p class="eyebrow"><?php esc_html_e( 'ادامهٔ استایل‌ها', 'sportmall' ); ?></p>
						<h2 class="section-title"><?php esc_html_e( 'ست‌های دیگر', 'sportmall' ); ?></h2>
					</div>
				</div>
				<div class="outfits-grid">
					<?php while ( $more->have_posts() ) : $more->the_post(); ?>
						<?php get_template_part( 'template-parts/outfit/card' ); ?>
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
