<?php
/**
 * Curated outfits carousel.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$query = new WP_Query( array(
	'post_type'      => 'sm_outfit',
	'post_status'    => 'publish',
	'posts_per_page' => 3,
	'orderby'        => 'menu_order date',
	'order'          => 'ASC',
) );

if ( ! $query->have_posts() ) {
	return;
}

$outfits = array_values( array_filter( $query->posts, function ( $outfit ) {
	return ! empty( sportmall_outfit_products( $outfit->ID ) );
} ) );

if ( empty( $outfits ) ) {
	wp_reset_postdata();
	return;
}

$total = count( $outfits );
?>
<section class="section outfits-section shell" id="outfits" aria-labelledby="outfits-title" data-sm-outfits>
	<div class="section-heading">
		<div>
			<p class="eyebrow"><?php echo esc_html( sportmall_mod( 'outfits_eyebrow' ) ); ?></p>
			<h2 class="section-title" id="outfits-title"><?php echo esc_html( sportmall_mod( 'outfits_title' ) ); ?></h2>
		</div>
		<div class="carousel-controls">
			<button class="round-control" type="button" aria-label="<?php esc_attr_e( 'ست قبلی', 'sportmall' ); ?>" data-sm-outfit-prev><?php sportmall_the_icon( 'arrow' ); ?></button>
			<span data-sm-outfit-counter>۰۱ / <?php echo esc_html( sportmall_fa_digits( str_pad( $total, 2, '0', STR_PAD_LEFT ) ) ); ?></span>
			<button class="round-control" type="button" aria-label="<?php esc_attr_e( 'ست بعدی', 'sportmall' ); ?>" data-sm-outfit-next><?php sportmall_the_icon( 'arrow' ); ?></button>
		</div>
	</div>

	<div class="outfit-stages" data-sm-outfit-stages>
		<?php foreach ( $outfits as $index => $outfit ) : ?>
			<?php
			$products = sportmall_outfit_products( $outfit->ID );
			$sum   = 0;
			foreach ( $products as $product ) {
				$sum += (float) $product->get_price();
			}
			$name  = get_post_meta( $outfit->ID, '_sm_outfit_name', true ) ?: get_the_title( $outfit );
			$tags  = array_filter( array_map( 'trim', explode( ',', (string) get_post_meta( $outfit->ID, '_sm_tags', true ) ) ) );
			$edition = get_post_meta( $outfit->ID, '_sm_edition', true ) ?: sprintf( '%02d / THE EDIT', $index + 1 );
			$position = get_post_meta( $outfit->ID, '_sm_position', true ) ?: '50% 40%';
			$image = get_the_post_thumbnail_url( $outfit, 'large' );
			if ( ! $image ) {
				$image = sportmall_asset( 'images/category-women.jpg' );
			}
			?>
			<div class="outfit-stage<?php echo 0 === $index ? ' is-active' : ''; ?>" data-sm-outfit-stage <?php echo 0 === $index ? '' : 'hidden'; ?> <?php echo 0 === $index ? 'role="region" aria-roledescription="کاروسل"' : ''; ?> aria-label="<?php echo esc_attr( sprintf( __( 'ست %1$s از %2$s: %3$s', 'sportmall' ), sportmall_fa_digits( $index + 1 ), sportmall_fa_digits( $total ), $name ) ); ?>">
				<div class="outfit-copy">
					<span class="outfit-edition" lang="en"><?php echo esc_html( $edition ); ?></span>
					<h3><?php echo wp_kses_post( nl2br( get_the_title( $outfit ) ) ); ?></h3>
					<p><?php echo esc_html( get_post_meta( $outfit->ID, '_sm_description', true ) ?: get_the_excerpt( $outfit ) ); ?></p>
					<?php if ( $tags ) : ?>
						<div class="outfit-tags">
							<?php foreach ( $tags as $tag ) : ?>
								<span><?php echo esc_html( $tag ); ?></span>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<div class="outfit-total">
						<span><?php esc_html_e( 'قیمت مجموع آیتم‌ها', 'sportmall' ); ?></span>
						<strong><?php echo esc_html( sportmall_num( $sum ) ); ?></strong>
						<small><?php echo esc_html( get_woocommerce_currency_symbol() ); ?></small>
					</div>
					<a class="outfit-buy" href="<?php echo esc_url( get_permalink( $outfit ) ); ?>"><?php esc_html_e( 'این ست را انتخاب کن', 'sportmall' ); ?> <?php sportmall_the_icon( 'arrow' ); ?></a>
				</div>
				<div class="outfit-look">
					<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( sprintf( __( 'الهام تصویری برای استایل %s', 'sportmall' ), $name ) ); ?>" style="object-position:<?php echo esc_attr( $position ); ?>" loading="lazy">
					<small>LOOK / <?php echo esc_html( sportmall_fa_digits( str_pad( $index + 1, 2, '0', STR_PAD_LEFT ) ) ); ?></small>
					<span><?php esc_html_e( 'الهام بگیر؛ ترکیب خودت را بساز.', 'sportmall' ); ?></span>
				</div>
				<div class="outfit-board">
					<?php foreach ( $products as $p_index => $product ) : ?>
						<a class="outfit-piece" href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'مشاهده %s', 'sportmall' ), $product->get_name() ) ); ?>">
							<span class="outfit-piece-num"><?php echo esc_html( sportmall_fa_digits( str_pad( $p_index + 1, 2, '0', STR_PAD_LEFT ) ) ); ?></span>
							<?php echo wp_kses_post( $product->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy', 'width' => 180, 'height' => 160 ) ) ); ?>
							<span class="outfit-piece-title"><?php echo esc_html( wp_trim_words( $product->get_name(), 4 ) ); ?><?php sportmall_the_icon( 'plus' ); ?></span>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="outfit-tabs" role="group" aria-label="<?php esc_attr_e( 'انتخاب ست', 'sportmall' ); ?>" data-sm-outfit-tabs>
		<?php foreach ( $outfits as $index => $outfit ) : ?>
			<button class="outfit-tab" type="button" data-sm-outfit-tab="<?php echo esc_attr( $index ); ?>" aria-pressed="<?php echo 0 === $index ? 'true' : 'false'; ?>">
				<span><?php echo esc_html( sportmall_fa_digits( str_pad( $index + 1, 2, '0', STR_PAD_LEFT ) ) ); ?></span>
				<?php echo esc_html( get_post_meta( $outfit->ID, '_sm_outfit_name', true ) ?: get_the_title( $outfit ) ); ?>
			</button>
		<?php endforeach; ?>
	</div>
</section>
<?php wp_reset_postdata(); ?>
