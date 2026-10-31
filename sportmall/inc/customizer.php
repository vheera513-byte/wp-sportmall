<?php
/**
 * Customizer settings for the storefront.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sanitize a checkbox.
 *
 * @param mixed $value Value.
 * @return bool
 */
function sportmall_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Sanitize textarea content.
 *
 * @param string $value Value.
 * @return string
 */
function sportmall_sanitize_textarea( $value ) {
	return wp_kses_post( $value );
}

/**
 * Register Customizer panels, sections and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function sportmall_customize_register( $wp_customize ) {
	$defaults = sportmall_defaults();

	$wp_customize->add_panel( 'sportmall_panel', array(
		'title'       => __( 'تنظیمات اسپرت‌مال', 'sportmall' ),
		'description' => __( 'متن‌ها، اسلایدها و بخش‌های صفحه اصلی. محصولات و دسته‌بندی‌ها از ووکامرس خوانده می‌شوند.', 'sportmall' ),
		'priority'    => 10,
	) );

	$wp_customize->add_section( 'sportmall_general', array(
		'title' => __( 'نوار اعلان و هدر', 'sportmall' ),
		'panel' => 'sportmall_panel',
	) );

	$wp_customize->add_setting( 'announcement_text', array(
		'default'           => $defaults['announcement_text'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'announcement_text', array(
		'label'   => __( 'متن نوار اعلان', 'sportmall' ),
		'section' => 'sportmall_general',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'announcement_link', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'announcement_link', array(
		'label'       => __( 'لینک نوار اعلان', 'sportmall' ),
		'description' => __( 'اختیاری. اگر خالی بماند، لینک نمایش داده نمی‌شود.', 'sportmall' ),
		'section'     => 'sportmall_general',
		'type'        => 'url',
	) );

	$wp_customize->add_setting( 'header_note', array(
		'default'           => $defaults['header_note'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'header_note', array(
		'label'   => __( 'یادداشت کوتاه هدر', 'sportmall' ),
		'section' => 'sportmall_general',
		'type'    => 'text',
	) );

	/* Hero ------------------------------------------------------------------ */
	$wp_customize->add_section( 'sportmall_hero', array(
		'title'       => __( 'اسلایدر صفحه اصلی', 'sportmall' ),
		'description' => __( 'سه اسلاید تصویری. عنوان را با خط جدید (Enter) به دو خط تقسیم کنید.', 'sportmall' ),
		'panel'       => 'sportmall_panel',
	) );

	$wp_customize->add_setting( 'hero_autoplay', array(
		'default'           => true,
		'sanitize_callback' => 'sportmall_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'hero_autoplay', array(
		'label'   => __( 'پخش خودکار اسلایدها', 'sportmall' ),
		'section' => 'sportmall_hero',
		'type'    => 'checkbox',
	) );

	for ( $i = 1; $i <= 3; $i++ ) {
		$wp_customize->add_setting( "slide_{$i}_image", array(
			'default'           => $defaults[ "slide_{$i}_image" ],
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			"slide_{$i}_image",
			array(
				/* translators: %d: slide number. */
				'label'       => sprintf( __( 'اسلاید %d — تصویر', 'sportmall' ), $i ),
				'section'     => 'sportmall_hero',
				'settings'    => "slide_{$i}_image",
				'description' => __( 'پیشنهاد: ۱۹۲۰×۱۰۸۰ پیکسل.', 'sportmall' ),
			)
		) );

		$fields = array(
			'kicker'   => array( __( 'بالانویس', 'sportmall' ), 'text', 'sanitize_text_field' ),
			'title'    => array( __( 'عنوان', 'sportmall' ), 'textarea', 'sportmall_sanitize_textarea' ),
			'text'     => array( __( 'توضیح', 'sportmall' ), 'textarea', 'sportmall_sanitize_textarea' ),
			'cta_label'=> array( __( 'متن دکمه', 'sportmall' ), 'text', 'sanitize_text_field' ),
			'cta_url'  => array( __( 'لینک دکمه', 'sportmall' ), 'url', 'esc_url_raw' ),
			'position' => array( __( 'موقعیت تصویر (دسکتاپ)', 'sportmall' ), 'text', 'sanitize_text_field' ),
			'position_m' => array( __( 'موقعیت تصویر (موبایل)', 'sportmall' ), 'text', 'sanitize_text_field' ),
		);
		foreach ( $fields as $field => $config ) {
			$wp_customize->add_setting( "slide_{$i}_{$field}", array(
				'default'           => $defaults[ "slide_{$i}_{$field}" ],
				'sanitize_callback' => $config[2],
			) );
			$wp_customize->add_control( "slide_{$i}_{$field}", array(
				'label'   => $config[0],
				'section' => 'sportmall_hero',
				'type'    => $config[1],
			) );
		}
	}

	/* Home sections ---------------------------------------------------------- */
	$wp_customize->add_section( 'sportmall_home', array(
		'title' => __( 'بخش‌های صفحه اصلی', 'sportmall' ),
		'panel' => 'sportmall_panel',
	) );

	$toggles = array(
		'show_quick'      => __( 'دسته‌بندی سریع', 'sportmall' ),
		'show_categories' => __( 'دسته‌بندی‌های اصلی', 'sportmall' ),
		'show_brands'     => __( 'نوار برندها', 'sportmall' ),
		'show_deals'      => __( 'تخفیف‌های روز', 'sportmall' ),
		'show_products'   => __( 'کاتالوگ منتخب', 'sportmall' ),
		'show_outfits'    => __( 'ست‌های ورزشی', 'sportmall' ),
		'show_running'    => __( 'بخش دویدن', 'sportmall' ),
		'show_offer'      => __( 'کد خوش‌آمدگویی', 'sportmall' ),
		'show_stories'    => __( 'استوری مشتریان', 'sportmall' ),
		'show_journal'    => __( 'ژورنال', 'sportmall' ),
		'show_services'   => __( 'نوار خدمات', 'sportmall' ),
	);
	foreach ( $toggles as $key => $label ) {
		$wp_customize->add_setting( $key, array(
			'default'           => true,
			'sanitize_callback' => 'sportmall_sanitize_checkbox',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $label,
			'section' => 'sportmall_home',
			'type'    => 'checkbox',
		) );
	}

	$texts = array(
		'quick_title'        => __( 'عنوان دسته‌بندی سریع', 'sportmall' ),
		'quick_subtitle'     => __( 'زیرنویس دسته‌بندی سریع', 'sportmall' ),
		'categories_eyebrow' => __( 'بالانویس دسته‌بندی‌ها', 'sportmall' ),
		'categories_title'   => __( 'عنوان دسته‌بندی‌ها', 'sportmall' ),
		'categories_text'    => __( 'توضیح دسته‌بندی‌ها', 'sportmall' ),
		'brands_label'       => __( 'متن کنار لوگوی برندها', 'sportmall' ),
		'deals_eyebrow'      => __( 'بالانویس تخفیف‌ها', 'sportmall' ),
		'deals_title'        => __( 'عنوان تخفیف‌ها', 'sportmall' ),
		'deals_text'         => __( 'توضیح تخفیف‌ها', 'sportmall' ),
		'deals_stamp'        => __( 'درصد روی مهر تخفیف', 'sportmall' ),
		'products_eyebrow'   => __( 'بالانویس کاتالوگ', 'sportmall' ),
		'products_title'     => __( 'عنوان کاتالوگ', 'sportmall' ),
		'outfits_eyebrow'    => __( 'بالانویس ست‌ها', 'sportmall' ),
		'outfits_title'      => __( 'عنوان ست‌ها', 'sportmall' ),
		'running_eyebrow'    => __( 'بالانویس بخش دویدن', 'sportmall' ),
		'running_title'      => __( 'عنوان بخش دویدن', 'sportmall' ),
		'running_text'       => __( 'توضیح بخش دویدن', 'sportmall' ),
		'running_cta'        => __( 'دکمه بخش دویدن', 'sportmall' ),
		'offer_eyebrow'      => __( 'بالانویس پیشنهاد', 'sportmall' ),
		'offer_title'        => __( 'عنوان پیشنهاد', 'sportmall' ),
		'offer_text'         => __( 'توضیح پیشنهاد', 'sportmall' ),
		'offer_code'         => __( 'کد تخفیف', 'sportmall' ),
		'offer_percent'      => __( 'درصد تخفیف', 'sportmall' ),
		'stories_eyebrow'    => __( 'بالانویس استوری‌ها', 'sportmall' ),
		'stories_title'      => __( 'عنوان استوری‌ها', 'sportmall' ),
		'stories_text'       => __( 'توضیح استوری‌ها', 'sportmall' ),
		'journal_eyebrow'    => __( 'بالانویس ژورنال', 'sportmall' ),
		'journal_title'      => __( 'عنوان ژورنال', 'sportmall' ),
		'journal_link_label' => __( 'متن لینک ژورنال', 'sportmall' ),
	);

	foreach ( $texts as $key => $label ) {
		$is_textarea = in_array( $key, array( 'categories_text', 'brands_label', 'deals_text', 'deals_title', 'running_title', 'offer_title', 'stories_text' ), true );
		$wp_customize->add_setting( $key, array(
			'default'           => $defaults[ $key ],
			'sanitize_callback' => $is_textarea ? 'sportmall_sanitize_textarea' : 'sanitize_text_field',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $label,
			'section' => 'sportmall_home',
			'type'    => $is_textarea ? 'textarea' : 'text',
		) );
	}

	$wp_customize->add_setting( 'running_image', array(
		'default'           => $defaults['running_image'],
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'running_image',
		array(
			'label'   => __( 'تصویر بخش دویدن', 'sportmall' ),
			'section' => 'sportmall_home',
		)
	) );

	$wp_customize->add_setting( 'running_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'running_url', array(
		'label'       => __( 'لینک بخش دویدن', 'sportmall' ),
		'description' => __( 'اگر خالی بماند به دسته‌بندی «running» یا فروشگاه لینک می‌شود.', 'sportmall' ),
		'section'     => 'sportmall_home',
		'type'        => 'url',
	) );

	/* Newsletter & footer ---------------------------------------------------- */
	$wp_customize->add_section( 'sportmall_footer', array(
		'title' => __( 'فوتر و خبرنامه', 'sportmall' ),
		'panel' => 'sportmall_panel',
	) );

	$footer_fields = array(
		'newsletter_eyebrow' => array( __( 'بالانویس خبرنامه', 'sportmall' ), 'text', 'sanitize_text_field' ),
		'newsletter_title'   => array( __( 'عنوان خبرنامه', 'sportmall' ), 'text', 'sanitize_text_field' ),
		'newsletter_text'    => array( __( 'توضیح خبرنامه', 'sportmall' ), 'textarea', 'sportmall_sanitize_textarea' ),
		'newsletter_note'    => array( __( 'یادداشت خبرنامه', 'sportmall' ), 'text', 'sanitize_text_field' ),
		'footer_about'       => array( __( 'درباره فروشگاه در فوتر', 'sportmall' ), 'textarea', 'sportmall_sanitize_textarea' ),
		'footer_contact'     => array( __( 'متن تماس در فوتر', 'sportmall' ), 'textarea', 'sportmall_sanitize_textarea' ),
		'footer_journal'     => array( __( 'متن لینک ژورنال', 'sportmall' ), 'text', 'sanitize_text_field' ),
		'footer_journal_url' => array( __( 'لینک ژورنال', 'sportmall' ), 'url', 'esc_url_raw' ),
		'footer_copyright'   => array( __( 'کپی‌رایت', 'sportmall' ), 'text', 'sanitize_text_field' ),
		'footer_note'        => array( __( 'یادداشت پایین فوتر', 'sportmall' ), 'text', 'sanitize_text_field' ),
		'social_instagram'   => array( __( 'اینستاگرام', 'sportmall' ), 'url', 'esc_url_raw' ),
		'social_telegram'    => array( __( 'تلگرام', 'sportmall' ), 'url', 'esc_url_raw' ),
		'social_whatsapp'    => array( __( 'واتس‌اپ', 'sportmall' ), 'url', 'esc_url_raw' ),
		'social_youtube'     => array( __( 'یوتیوب', 'sportmall' ), 'url', 'esc_url_raw' ),
	);
	foreach ( $footer_fields as $key => $config ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $defaults[ $key ],
			'sanitize_callback' => $config[2],
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $config[0],
			'section' => 'sportmall_footer',
			'type'    => $config[1],
		) );
	}
}
add_action( 'customize_register', 'sportmall_customize_register' );
