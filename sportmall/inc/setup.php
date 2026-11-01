<?php
/**
 * Theme setup, menus, sidebars and image sizes.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme features.
 */
function sportmall_setup() {
	load_theme_textdomain( 'sportmall', SPORTMALL_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 220,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'register_block_style' );
	add_editor_style( array( 'assets/css/base.css', 'assets/css/pages.css' ) );

	add_image_size( 'sportmall-card', 640, 760, true );
	add_image_size( 'sportmall-square', 640, 640, true );
	add_image_size( 'sportmall-wide', 1000, 620, true );
	add_image_size( 'sportmall-portrait', 640, 810, true );
	add_image_size( 'sportmall-category', 900, 1100, true );
	add_image_size( 'sportmall-hero', 1920, 1080, true );

	if ( class_exists( 'WooCommerce' ) ) {
		add_theme_support(
			'woocommerce',
			array(
				'thumbnail_image_width' => 640,
				'single_image_width'    => 900,
				'product_grid'          => array(
					'default_rows'    => 3,
					'min_rows'        => 1,
					'default_columns' => 3,
					'min_columns'     => 2,
					'max_columns'     => 4,
				),
			)
		);
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	register_nav_menus( array(
		'primary'     => __( 'منوی اصلی (اختیاری)', 'sportmall' ),
		'footer_shop' => __( 'فوتر — خرید', 'sportmall' ),
		'footer_help' => __( 'فوتر — راهنما', 'sportmall' ),
		'footer_info' => __( 'فوتر — درباره', 'sportmall' ),
	) );

	add_post_type_support( 'post', 'excerpt' );
}
add_action( 'after_setup_theme', 'sportmall_setup' );

/**
 * Register widget areas.
 */
function sportmall_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'ستون کنار فروشگاه', 'sportmall' ),
		'id'            => 'shop-sidebar',
		'description'   => __( 'ابزارک‌های فیلتر و دسته‌بندی فروشگاه. اگر خالی بماند، فیلترهای خود قالب نمایش داده می‌شوند.', 'sportmall' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'ستون کنار ژورنال', 'sportmall' ),
		'id'            => 'blog-sidebar',
		'description'   => __( 'ابزارک‌های کنار مطلب و آرشیو ژورنال.', 'sportmall' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'ستون کنار برگه', 'sportmall' ),
		'id'            => 'page-sidebar',
		'description'   => __( 'ابزارک‌های کنار برگه‌های معمولی.', 'sportmall' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'sportmall_widgets_init' );

/**
 * Content width used by embeds and wide blocks.
 */
function sportmall_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'sportmall_content_width', 800 );
}
add_action( 'after_setup_theme', 'sportmall_content_width', 0 );

/**
 * Remove the default WooCommerce wrapper. The theme ships its own templates.
 */
function sportmall_woocommerce_setup_wrappers() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
}
add_action( 'init', 'sportmall_woocommerce_setup_wrappers' );

/**
 * Add a theme options shortcut to the admin bar.
 *
 * @param WP_Admin_Bar $bar Admin bar instance.
 */
function sportmall_admin_bar_links( $bar ) {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	$bar->add_node( array(
		'id'    => 'sportmall-customize',
		'title' => __( 'تنظیمات اسپرت‌مال', 'sportmall' ),
		'href'  => admin_url( 'customize.php' ),
		'meta'  => array( 'title' => __( 'تنظیمات قالب اسپرت‌مال', 'sportmall' ) ),
	) );
}
add_action( 'admin_bar_menu', 'sportmall_admin_bar_links', 80 );
