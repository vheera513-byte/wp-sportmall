<?php
/**
 * Storefront home page.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$GLOBALS['sportmall_header_in_hero'] = true;
get_header();

$slides = sportmall_hero_slides();
$first  = ! empty( $slides ) ? $slides[0] : null;
?>
<main id="main-content">

	<section class="hero-slider" tabindex="-1" aria-roledescription="<?php esc_attr_e( 'کاروسل', 'sportmall' ); ?>" aria-label="<?php esc_attr_e( 'پیشنهادهای ویژه اسپرت‌مال', 'sportmall' ); ?>" data-sm-hero data-autoplay="<?php echo sportmall_is_on( 'hero_autoplay' ) ? '1' : '0'; ?>">
		<div class="slides" aria-hidden="true">
			<?php foreach ( $slides as $index => $slide ) : ?>
				<div class="slide<?php echo 0 === $index ? ' is-active' : ''; ?>"
					data-kicker="<?php echo esc_attr( $slide['kicker'] ); ?>"
					data-title="<?php echo esc_attr( $slide['title'] ); ?>"
					data-text="<?php echo esc_attr( $slide['text'] ); ?>"
					data-cta="<?php echo esc_attr( $slide['cta'] ); ?>"
					data-url="<?php echo esc_url( $slide['url'] ); ?>">
					<div class="slide-img" style="--pos:<?php echo esc_attr( $slide['position'] ); ?>;--pos-m:<?php echo esc_attr( $slide['position_m'] ); ?>;background-image:url('<?php echo esc_url( $slide['image'] ); ?>')"></div>
				</div>
			<?php endforeach; ?>
		</div>

		<?php get_template_part( 'template-parts/header/site-header', null, array( 'variant' => 'overlay' ) ); ?>

		<?php if ( $first ) : ?>
			<div class="hero-content animate" data-sm-hero-content>
				<p class="hero-kicker" data-sm-hero-kicker><?php echo esc_html( $first['kicker'] ); ?></p>
				<h1 class="hero-title" data-sm-hero-title><?php echo wp_kses_post( nl2br( $first['title'] ) ); ?></h1>
				<p class="hero-description" data-sm-hero-text><?php echo esc_html( $first['text'] ); ?></p>
				<div>
					<a class="hero-cta" href="<?php echo esc_url( $first['url'] ); ?>" data-sm-hero-cta>
						<span><?php echo esc_html( $first['cta'] ); ?></span>
						<?php sportmall_the_icon( 'arrow' ); ?>
					</a>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( count( $slides ) > 1 ) : ?>
			<button class="slider-arrow slider-arrow--previous" type="button" aria-label="<?php esc_attr_e( 'اسلاید قبلی', 'sportmall' ); ?>" data-sm-hero-prev>
				<?php sportmall_the_icon( 'chevron-left' ); ?>
			</button>
			<button class="slider-arrow slider-arrow--next" type="button" aria-label="<?php esc_attr_e( 'اسلاید بعدی', 'sportmall' ); ?>" data-sm-hero-next>
				<?php sportmall_the_icon( 'chevron-right' ); ?>
			</button>
			<div class="slider-dots" role="group" aria-label="<?php esc_attr_e( 'انتخاب اسلاید', 'sportmall' ); ?>">
				<?php foreach ( $slides as $index => $slide ) : ?>
					<button class="slider-dot<?php echo 0 === $index ? ' is-active' : ''; ?>" type="button" aria-label="<?php echo esc_attr( sprintf( __( 'اسلاید %s', 'sportmall' ), sportmall_fa_digits( $index + 1 ) ) ); ?>" <?php echo 0 === $index ? 'aria-current="true"' : ''; ?> data-sm-hero-dot="<?php echo esc_attr( $index ); ?>">
						<span class="slider-pill" aria-hidden="true"><span class="slider-pill-fill"></span></span>
					</button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</section>

	<?php if ( sportmall_is_on( 'show_quick' ) ) : ?>
		<?php get_template_part( 'template-parts/home/quick-categories' ); ?>
	<?php endif; ?>

	<?php if ( sportmall_is_on( 'show_categories' ) ) : ?>
		<?php get_template_part( 'template-parts/home/categories' ); ?>
	<?php endif; ?>

	<?php if ( sportmall_is_on( 'show_deals' ) && class_exists( 'WooCommerce' ) ) : ?>
		<?php get_template_part( 'template-parts/home/deals' ); ?>
	<?php endif; ?>

	<?php if ( sportmall_is_on( 'show_products' ) && class_exists( 'WooCommerce' ) ) : ?>
		<?php get_template_part( 'template-parts/home/catalog' ); ?>
	<?php endif; ?>

	<?php if ( sportmall_is_on( 'show_outfits' ) && post_type_exists( 'sm_outfit' ) ) : ?>
		<?php get_template_part( 'template-parts/home/outfits' ); ?>
	<?php endif; ?>

	<?php if ( sportmall_is_on( 'show_running' ) ) : ?>
		<?php get_template_part( 'template-parts/home/running' ); ?>
	<?php endif; ?>

	<?php if ( sportmall_is_on( 'show_offer' ) ) : ?>
		<?php get_template_part( 'template-parts/home/offer' ); ?>
	<?php endif; ?>

	<?php if ( sportmall_is_on( 'show_stories' ) && post_type_exists( 'sm_story' ) ) : ?>
		<?php get_template_part( 'template-parts/home/stories' ); ?>
	<?php endif; ?>

	<?php if ( sportmall_is_on( 'show_journal' ) ) : ?>
		<?php get_template_part( 'template-parts/home/journal' ); ?>
	<?php endif; ?>

	<?php if ( sportmall_is_on( 'show_services' ) ) : ?>
		<?php get_template_part( 'template-parts/home/services' ); ?>
	<?php endif; ?>

</main>

<?php get_footer(); ?>
