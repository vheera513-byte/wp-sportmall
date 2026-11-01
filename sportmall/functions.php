<?php
/**
 * Sportmall theme bootstrap.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

define( 'SPORTMALL_VERSION', '1.0.0' );
define( 'SPORTMALL_DIR', get_template_directory() );
define( 'SPORTMALL_URI', get_template_directory_uri() );

require SPORTMALL_DIR . '/inc/setup.php';
require SPORTMALL_DIR . '/inc/icons.php';
require SPORTMALL_DIR . '/inc/template-tags.php';
require SPORTMALL_DIR . '/inc/nav.php';
require SPORTMALL_DIR . '/inc/customizer.php';
require SPORTMALL_DIR . '/inc/stories.php';
require SPORTMALL_DIR . '/inc/newsletter.php';
require SPORTMALL_DIR . '/inc/contact.php';
require SPORTMALL_DIR . '/inc/search.php';
require SPORTMALL_DIR . '/inc/woocommerce.php';
require SPORTMALL_DIR . '/inc/demo-content.php';

/**
 * Enqueue theme assets.
 */
function sportmall_enqueue_assets() {
	$base = SPORTMALL_URI . '/assets';

	wp_enqueue_style(
		'sportmall-base',
		$base . '/css/base.css',
		array(),
		SPORTMALL_VERSION
	);

	wp_enqueue_style(
		'sportmall-pages',
		$base . '/css/pages.css',
		array( 'sportmall-base' ),
		SPORTMALL_VERSION
	);

	if ( class_exists( 'WooCommerce' ) ) {
		$woo_deps = array( 'sportmall-base', 'sportmall-pages' );
		if ( wp_style_is( 'woocommerce-general', 'registered' ) ) {
			$woo_deps[] = 'woocommerce-general';
		}
		wp_enqueue_style(
			'sportmall-woocommerce',
			$base . '/css/woocommerce.css',
			$woo_deps,
			SPORTMALL_VERSION
		);
	}

	wp_enqueue_style(
		'sportmall-style',
		get_stylesheet_uri(),
		array( 'sportmall-base', 'sportmall-pages' ),
		SPORTMALL_VERSION
	);

	wp_enqueue_script(
		'sportmall-theme',
		$base . '/js/theme.js',
		array(),
		SPORTMALL_VERSION,
		true
	);

	wp_localize_script(
		'sportmall-theme',
		'SportmallData',
		array(
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'homeUrl'     => home_url( '/' ),
			'shopUrl'     => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ),
			'cartUrl'     => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/' ),
			'checkoutUrl' => function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/' ),
			'wishlistUrl' => sportmall_wishlist_url(),
			'isWoo'       => class_exists( 'WooCommerce' ),
			'nonce'       => wp_create_nonce( 'sportmall_ajax' ),
			'strings'     => array(
				'addedToWishlist'    => __( 'به علاقه‌مندی‌ها اضافه شد.', 'sportmall' ),
				'removedFromWishlist' => __( 'از علاقه‌مندی‌ها حذف شد.', 'sportmall' ),
				'wishlistEmpty'      => __( 'هنوز محصولی به علاقه‌مندی‌ها اضافه نکرده‌ای. قلب روی کارت محصولات را بزن تا اینجا جمع شوند.', 'sportmall' ),
				'searching'          => __( 'در حال جستجو…', 'sportmall' ),
				'noResults'          => __( 'چیزی پیدا نشد. عبارت دیگری را امتحان کن.', 'sportmall' ),
				'viewAllResults'     => __( 'دیدن همهٔ نتیجه‌ها', 'sportmall' ),
				'copied'             => __( 'کد تخفیف کپی شد.', 'sportmall' ),
				'loadError'          => __( 'ارتباط برقرار نشد. دوباره تلاش کن.', 'sportmall' ),
				'addedToCart'        => __( 'به سبد خرید اضافه شد.', 'sportmall' ),
				'showFilter'         => __( 'فیلترها', 'sportmall' ),
				'hideFilter'         => __( 'بستن فیلترها', 'sportmall' ),
			),
		)
	);

	if ( class_exists( 'WooCommerce' ) ) {
		if ( wp_script_is( 'wc-add-to-cart', 'registered' ) ) {
			wp_enqueue_script( 'wc-add-to-cart' );
		}
		if ( ( is_front_page() || ( function_exists( 'is_shop' ) && ( is_shop() || is_product_taxonomy() ) ) ) && wp_script_is( 'wc-cart-fragments', 'registered' ) ) {
			wp_enqueue_script( 'wc-cart-fragments' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'sportmall_enqueue_assets', 20 );

/**
 * Preload the variable Persian font to avoid a flash of fallback type.
 */
function sportmall_preload_font() {
	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
		esc_url( SPORTMALL_URI . '/assets/fonts/vazirmatn.woff2' )
	);
}
add_action( 'wp_head', 'sportmall_preload_font', 1 );

/**
 * Print the inline icon sprite once, right after <body>.
 */
function sportmall_print_icon_sprite() {
	echo sportmall_get_icon_sprite(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static SVG markup.
}
add_action( 'wp_body_open', 'sportmall_print_icon_sprite', 1 );

/**
 * Add helpful classes to the body element.
 *
 * @param array $classes Existing classes.
 * @return array
 */
function sportmall_body_classes( $classes ) {
	$classes[] = is_front_page() ? 'sportmall-home' : 'sportmall-inner';
	$classes[] = 'sportmall-rtl';

	if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_product_taxonomy() || is_product() || is_cart() || is_checkout() || is_account_page() ) ) {
		$classes[] = 'sportmall-woo-page';
	}

	return $classes;
}
add_filter( 'body_class', 'sportmall_body_classes' );

/**
 * Keep excerpts short and typographically quiet.
 *
 * @return int
 */
function sportmall_excerpt_length() {
	return 26;
}
add_filter( 'excerpt_length', 'sportmall_excerpt_length' );

/**
 * Replace the default excerpt ellipsis with a RTL friendly one.
 *
 * @return string
 */
function sportmall_excerpt_more() {
	return ' …';
}
add_filter( 'excerpt_more', 'sportmall_excerpt_more' );
