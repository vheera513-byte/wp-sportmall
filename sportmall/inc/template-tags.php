<?php
/**
 * Template helpers and presentation functions.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default values for every Customizer setting used by the theme.
 *
 * @return array
 */
function sportmall_defaults() {
	$defaults = array(
		'announcement_text'   => __( '۲۰٪ تخفیف برای اولین سفارش شما', 'sportmall' ),
		'announcement_link'   => '',
		'header_note'         => __( 'ارسال رایگان برای سفارش‌های بالای ۲ میلیون تومان', 'sportmall' ),
		'hero_autoplay'       => true,
		'slide_1_image'       => sportmall_asset( 'images/hero-motion.jpg' ),
		'slide_1_kicker'      => __( 'برای حرکت آماده‌ای؟', 'sportmall' ),
		'slide_1_title'       => __( "استایل ورزشی،\nانرژی بی‌وقفه", 'sportmall' ),
		'slide_1_text'        => __( 'لباس و تجهیزات ورزشی برای هر قدمی که رو به جلو برمی‌داری.', 'sportmall' ),
		'slide_1_cta_label'   => __( 'مشاهده محصولات', 'sportmall' ),
		'slide_1_cta_url'     => '',
		'slide_1_position'    => 'center 45%',
		'slide_1_position_m'  => '57% center',
		'slide_2_image'       => sportmall_asset( 'images/hero-strength.jpg' ),
		'slide_2_kicker'      => __( 'قدرتت را پیدا کن', 'sportmall' ),
		'slide_2_title'       => __( "هر روز،\nیک قدم قوی‌تر", 'sportmall' ),
		'slide_2_text'        => __( 'برای تمرین‌های جدی، انتخابی راحت و مطمئن داشته باش.', 'sportmall' ),
		'slide_2_cta_label'   => __( 'مشاهده محصولات', 'sportmall' ),
		'slide_2_cta_url'     => '',
		'slide_2_position'    => 'center 42%',
		'slide_2_position_m'  => '55% center',
		'slide_3_image'       => sportmall_asset( 'images/hero-adventure.jpg' ),
		'slide_3_kicker'      => __( 'آماده‌ی ماجراجویی', 'sportmall' ),
		'slide_3_title'       => __( "حرکت کن،\nمتفاوت باش", 'sportmall' ),
		'slide_3_text'        => __( 'تازه‌ترین پوشاک ورزشی را برای سبک زندگی پرتحرکت ببین.', 'sportmall' ),
		'slide_3_cta_label'   => __( 'مشاهده محصولات', 'sportmall' ),
		'slide_3_cta_url'     => '',
		'slide_3_position'    => 'center 50%',
		'slide_3_position_m'  => '50% center',
		'show_quick'          => true,
		'show_categories'     => true,
		'show_brands'         => true,
		'show_deals'          => true,
		'show_products'       => true,
		'show_outfits'        => true,
		'show_running'        => true,
		'show_offer'          => true,
		'show_stories'        => true,
		'show_journal'        => true,
		'show_services'       => true,
		'quick_title'         => __( 'از کجا شروع کنیم؟', 'sportmall' ),
		'quick_subtitle'      => __( 'همه‌چیز برای حرکت', 'sportmall' ),
		'categories_eyebrow'  => __( 'برای هر روزِ پرتحرک تو', 'sportmall' ),
		'categories_title'    => __( 'حرکت، به سبک تو.', 'sportmall' ),
		'categories_text'     => __( "از اولین قدم تا آخرین تکرار؛\nهمراهت را پیدا کن.", 'sportmall' ),
		'brands_label'        => __( "نام‌های آشنا،\nانتخاب‌های تازه.", 'sportmall' ),
		'deals_eyebrow'       => __( 'انتخاب امروز، قیمت بهتر', 'sportmall' ),
		'deals_title'         => __( "تخفیف‌های\nروز اسپرت‌مال", 'sportmall' ),
		'deals_text'          => __( "همان کیفیتی که می‌خواهی،\nبا قیمتی که دوست داری.", 'sportmall' ),
		'deals_stamp'         => '۲۵',
		'products_eyebrow'    => __( 'منتخب اسپرت‌مال', 'sportmall' ),
		'products_title'      => __( 'همراه‌های حرکت تو', 'sportmall' ),
		'outfits_eyebrow'     => __( 'چند تکه، یک استایل کامل', 'sportmall' ),
		'outfits_title'       => __( 'ست‌های ورزشی', 'sportmall' ),
		'running_eyebrow'     => 'THE RUNNING EDIT / 01',
		'running_title'       => __( "مسیر مهم نیست،\nحرکت از توست.", 'sportmall' ),
		'running_text'        => __( 'برای صبح‌های زود، مسیرهای تازه و آن یک کیلومتر بیشتر. انتخاب‌هایی برای پیدا کردن ریتم خودت.', 'sportmall' ),
		'running_cta'         => __( 'مجموعهٔ دویدن را ببین', 'sportmall' ),
		'running_url'         => '',
		'running_image'       => sportmall_asset( 'images/running-campaign.jpg' ),
		'offer_eyebrow'       => __( 'یک شروع خوب، با یک پیشنهاد بهتر', 'sportmall' ),
		'offer_title'         => __( 'اولین قدمت را مهمان ما باش.', 'sportmall' ),
		'offer_text'          => __( 'کد خوش‌آمدگویی برای اولین سفارش تو', 'sportmall' ),
		'offer_code'          => 'SPORT20',
		'offer_percent'       => '۲۰',
		'offer_terms'         => '',
		'stories_eyebrow'     => __( 'قاب‌هایی از همراهی شما', 'sportmall' ),
		'stories_title'       => __( 'حس خوب، از نگاه شما.', 'sportmall' ),
		'stories_text'        => __( 'هر انتخاب، یک داستان دارد. این‌بار راوی شما هستید.', 'sportmall' ),
		'journal_eyebrow'     => __( 'چند دقیقه برای انتخاب بهتر', 'sportmall' ),
		'journal_title'       => __( 'بیشتر از یک فروشگاه', 'sportmall' ),
		'journal_link_label'  => __( 'ژورنال اسپرت‌مال', 'sportmall' ),
		'newsletter_eyebrow'  => 'A LITTLE MOTIVATION. IN YOUR INBOX.',
		'newsletter_title'    => __( 'انرژی خوب، ادامه دارد.', 'sportmall' ),
		'newsletter_text'     => __( 'از مجموعه‌های تازه و پیشنهادهای ویژه باخبر شو.', 'sportmall' ),
		'newsletter_note'     => __( 'فقط خبرهای خوب. هر زمان خواستی می‌توانی لغو کنی.', 'sportmall' ),
		'footer_about'        => __( "برای ما ورزش فقط یک ساعت از روز نیست؛\nیک جور زندگی کردن است. اینجاییم تا همراهِ حرکت‌های کوچک و هدف‌های بزرگت باشیم.", 'sportmall' ),
		'footer_contact'      => __( "برای انتخاب بهتر،\nاز راهنماهای ما شروع کن.", 'sportmall' ),
		'footer_journal'      => __( 'SPORTMALL JOURNAL ↗', 'sportmall' ),
		'footer_journal_url'  => '',
		'footer_copyright'    => __( '© ۱۴۰۵ اسپرت‌مال. ساخته‌شده برای حرکت.', 'sportmall' ),
		'footer_note'         => __( 'اسپرت‌مال؛ انتخاب‌هایی برای زندگی در حرکت.', 'sportmall' ),
		'social_instagram'    => '',
		'social_telegram'     => '',
		'social_whatsapp'     => '',
		'social_youtube'      => '',
		'services'            => array(),
	);

	return apply_filters( 'sportmall_defaults', $defaults );
}

/**
 * Read a theme setting with a sensible default.
 *
 * @param string $key Setting key.
 * @return mixed
 */
function sportmall_mod( $key ) {
	$defaults = sportmall_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	return get_theme_mod( $key, $default );
}

/**
 * Boolean setting check.
 *
 * @param string $key Setting key.
 * @return bool
 */
function sportmall_is_on( $key ) {
	return (bool) sportmall_mod( $key );
}

/**
 * Theme asset URL.
 *
 * @param string $path Relative path inside assets.
 * @return string
 */
function sportmall_asset( $path ) {
	return SPORTMALL_URI . '/assets/' . ltrim( $path, '/' );
}

/**
 * Convert Latin digits to Persian digits.
 *
 * @param string $value Value.
 * @return string
 */
function sportmall_fa_digits( $value ) {
	$latin   = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
	$persian = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
	return str_replace( $latin, $persian, (string) $value );
}

/**
 * Return the first UTF-8 character of a string without requiring mbstring.
 *
 * @param string $text Text.
 * @return string
 */
function sportmall_first_char( $text ) {
	$text = trim( (string) $text );
	if ( '' === $text ) {
		return '';
	}
	if ( preg_match( '/^./u', $text, $match ) ) {
		return $match[0];
	}
	return substr( $text, 0, 1 );
}

/**
 * Format an integer for display.
 *
 * @param int|float $number Number.
 * @return string
 */
function sportmall_num( $number ) {
	return sportmall_fa_digits( number_format( (float) $number, 0, '.', '٬' ) );
}

/**
 * Format a price amount with the active currency label.
 *
 * @param int|float $amount Amount.
 * @param bool      $with_currency Include currency label.
 * @return string
 */
function sportmall_money( $amount, $with_currency = true ) {
	$label = class_exists( 'WooCommerce' ) ? get_woocommerce_currency_symbol() : __( 'تومان', 'sportmall' );
	$value = sportmall_num( $amount );
	return $with_currency ? $value . ' ' . $label : $value;
}

/**
 * Price block for a product card.
 *
 * @param WC_Product $product Product object.
 * @return string
 */
function sportmall_product_price_html( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return '';
	}

	$label = get_woocommerce_currency_symbol();

	if ( $product->is_type( 'variable' ) ) {
		$min = (float) $product->get_variation_price( 'min', true );
		$max = (float) $product->get_variation_price( 'max', true );
		$old = (float) $product->get_variation_regular_price( 'min', true );

		ob_start();
		if ( $product->is_on_sale() && $old > $min ) {
			echo '<del class="old-price">' . esc_html( sportmall_money( $old, false ) ) . '</del>';
		}
		echo '<span class="price-from"><strong>' . esc_html( sportmall_num( $min ) );
		if ( $max > $min ) {
			echo ' – ' . esc_html( sportmall_num( $max ) );
		}
		echo '</strong> <small>' . esc_html( $label ) . '</small></span>';
		return ob_get_clean();
	}

	$price    = (float) $product->get_price();
	$regular  = (float) $product->get_regular_price();
	$on_sale  = $product->is_on_sale() && $regular > $price;

	ob_start();
	if ( $on_sale ) {
		echo '<del class="old-price">' . esc_html( sportmall_money( $regular, false ) ) . '</del>';
	}
	echo '<span><strong>' . esc_html( sportmall_num( $price ) ) . '</strong> <small>' . esc_html( $label ) . '</small></span>';
	return ob_get_clean();
}

/**
 * Discount percentage for a product.
 *
 * @param WC_Product $product Product.
 * @return int
 */
function sportmall_discount_percent( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return 0;
	}
	if ( $product->is_type( 'variable' ) ) {
		$regular = (float) $product->get_variation_regular_price( 'min', true );
		$price   = (float) $product->get_variation_price( 'min', true );
	} else {
		$regular = (float) $product->get_regular_price();
		$price   = (float) $product->get_price();
	}
	if ( $regular <= 0 || $price >= $regular ) {
		return 0;
	}
	return (int) round( ( ( $regular - $price ) / $regular ) * 100 );
}

/**
 * Shop page URL.
 *
 * @return string
 */
function sportmall_shop_url() {
	return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
}

/**
 * Wishlist page URL.
 *
 * @return string
 */
function sportmall_wishlist_url() {
	$page = get_page_by_path( 'wishlist' );
	if ( $page ) {
		return get_permalink( $page );
	}
	return home_url( '/?sportmall_wishlist=1' );
}

/**
 * Journal page URL.
 *
 * @return string
 */
function sportmall_journal_url() {
	$page_id = (int) get_option( 'page_for_posts' );
	return $page_id ? get_permalink( $page_id ) : home_url( '/' );
}

/**
 * Stories archive URL.
 *
 * @return string
 */
function sportmall_stories_url() {
	$post_type = get_post_type_object( 'sm_story' );
	return $post_type ? get_post_type_archive_link( 'sm_story' ) : home_url( '/' );
}

/**
 * Fallback category imagery keyed by slug.
 *
 * @param string $slug Category slug.
 * @return string
 */
function sportmall_category_image_fallback( $slug ) {
	$map = array(
		'women'       => 'category-women.jpg',
		'men'         => 'category-men.jpg',
		'shoes'       => 'category-shoes.jpg',
		'clothing'    => 'product-tee.jpg',
		'accessories' => 'product-bag.jpg',
		'tops'        => 'product-tee.jpg',
		'leggings'    => 'product-leggings.jpg',
		'shorts'      => 'product-shorts.jpg',
		'bags'        => 'product-bag.jpg',
		'socks'       => 'product-socks.jpg',
		'bottles'     => 'product-bottle.jpg',
		'running'     => 'running-campaign.jpg',
		'training'    => 'journal-training.jpg',
		'yoga'        => 'category-women.jpg',
	);
	$file = isset( $map[ $slug ] ) ? $map[ $slug ] : 'category-shoes.jpg';
	return sportmall_asset( 'images/' . $file );
}

/**
 * Resolve a category image.
 *
 * @param WP_Term|int $term Term or term ID.
 * @param string      $size Image size.
 * @return string
 */
function sportmall_category_image( $term, $size = 'sportmall-category' ) {
	$term = get_term( $term );
	if ( ! $term instanceof WP_Term ) {
		return sportmall_category_image_fallback( 'shoes' );
	}
	$thumbnail_id = (int) get_term_meta( $term->term_id, 'thumbnail_id', true );
	if ( $thumbnail_id ) {
		$url = wp_get_attachment_image_url( $thumbnail_id, $size );
		if ( $url ) {
			return $url;
		}
	}
	return sportmall_category_image_fallback( $term->slug );
}

/**
 * Brands available in the store.
 *
 * @param int $limit Maximum number.
 * @return array<int,array<string,string>>
 */
function sportmall_get_brands( $limit = 8 ) {
	$brands = array();
	if ( taxonomy_exists( 'pa_brand' ) ) {
		$terms = get_terms( array(
			'taxonomy'   => 'pa_brand',
			'hide_empty' => false,
			'number'     => $limit,
			'orderby'    => 'name',
		) );
		if ( ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$brands[] = array(
					'name'  => $term->name,
					'slug'  => $term->slug,
					'logo'  => sportmall_brand_logo( $term ),
					'url'   => add_query_arg( 'brand', $term->slug, sportmall_shop_url() ),
					'count' => $term->count,
				);
			}
		}
	}

	if ( empty( $brands ) ) {
		$fallbacks = array(
			'nike'        => array( 'نایکی', 'logo-nike.svg' ),
			'adidas'      => array( 'آدیداس', 'logo-adidas.svg' ),
			'puma'        => array( 'پوما', 'logo-puma.svg' ),
			'newbalance'  => array( 'نیو بالانس', 'logo-newbalance.svg' ),
			'reebok'      => array( 'ریباک', 'logo-reebok.svg' ),
			'asics'       => array( 'آسیکس', 'logo-asics.svg' ),
			'underarmour' => array( 'آندر آرمور', 'logo-underarmour.svg' ),
			'skechers'    => array( 'اسکچرز', 'logo-skechers.svg' ),
		);
		foreach ( array_slice( $fallbacks, 0, $limit, true ) as $slug => $data ) {
			$brands[] = array(
				'name'  => $data[0],
				'slug'  => $slug,
				'logo'  => sportmall_asset( 'images/' . $data[1] ),
				'url'   => add_query_arg( 'brand', $slug, sportmall_shop_url() ),
				'count' => 0,
			);
		}
	}

	return apply_filters( 'sportmall_brands', $brands, $limit );
}

/**
 * Brand logo URL from a term.
 *
 * @param WP_Term $term Brand term.
 * @return string
 */
function sportmall_brand_logo( $term ) {
	$logo_id = (int) get_term_meta( $term->term_id, 'sportmall_logo_id', true );
	if ( ! $logo_id ) {
		$logo_id = (int) get_term_meta( $term->term_id, 'thumbnail_id', true );
	}
	if ( $logo_id ) {
		$url = wp_get_attachment_image_url( $logo_id, 'medium' );
		if ( $url ) {
			return $url;
		}
	}
	$map = array(
		'nike'        => 'logo-nike.svg',
		'adidas'      => 'logo-adidas.svg',
		'puma'        => 'logo-puma.svg',
		'newbalance'  => 'logo-newbalance.svg',
		'new-balance'=> 'logo-newbalance.svg',
		'reebok'      => 'logo-reebok.svg',
		'asics'       => 'logo-asics.svg',
		'underarmour' => 'logo-underarmour.svg',
		'under-armour'=> 'logo-underarmour.svg',
		'skechers'    => 'logo-skechers.svg',
	);
	return sportmall_asset( 'images/' . ( isset( $map[ $term->slug ] ) ? $map[ $term->slug ] : 'logo-nike.svg' ) );
}

/**
 * Product brand label.
 *
 * @param WC_Product $product Product.
 * @return string
 */
function sportmall_product_brand( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return '';
	}
	if ( taxonomy_exists( 'pa_brand' ) ) {
		$terms = get_the_terms( $product->get_id(), 'pa_brand' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			return wp_specialchars_decode( $terms[0]->name, ENT_QUOTES );
		}
	}
	$terms = get_the_terms( $product->get_id(), 'product_tag' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			if ( in_array( $term->slug, array( 'nike', 'adidas', 'puma', 'reebok', 'asics', 'newbalance', 'skechers', 'underarmour' ), true ) ) {
				return $term->name;
			}
		}
	}
	return __( 'اسپرت‌مال', 'sportmall' );
}

/**
 * Color swatches for product cards.
 *
 * @param WC_Product $product Product.
 * @param int        $limit Number of swatches.
 * @return array<int,string>
 */
function sportmall_color_swatches( $product, $limit = 3 ) {
	if ( ! $product instanceof WC_Product ) {
		return array();
	}
	$map = array(
		'مشکی'      => '#242525',
		'سیاه'      => '#242525',
		'سفید'      => '#f2f1ea',
		'کرم'       => '#e7e1d2',
		'خاکستری'   => '#8c8d89',
		'طوسی'      => '#8c8d89',
		'سبز'       => '#6d786a',
		'سبز زیتونی'=> '#536252',
		'آبی'       => '#3d5d75',
		'قرمز'      => '#b94a36',
		'صورتی'     => '#d9a1a1',
		'مرجانی'    => '#e86b52',
		'نارنجی'    => '#e0813e',
		'زرد'       => '#d9bd55',
		'بژ'        => '#d7cbb8',
		'قهوه‌ای'   => '#765c48',
	);
	$colors = array();
	$terms  = get_the_terms( $product->get_id(), 'pa_color' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$name = trim( $term->name );
			if ( isset( $map[ $name ] ) ) {
				$colors[] = $map[ $name ];
			}
		}
	}
	if ( empty( $colors ) && $product->is_type( 'variable' ) ) {
		foreach ( $product->get_available_variations() as $variation ) {
			$attributes = $variation['attributes'];
			foreach ( $attributes as $key => $value ) {
				if ( false !== strpos( $key, 'color' ) && isset( $map[ $value ] ) ) {
					$colors[] = $map[ $value ];
				}
			}
		}
	}
	return array_slice( array_values( array_unique( $colors ) ), 0, $limit );
}

/**
 * Reading time for an article.
 *
 * @param int|null $post_id Post ID.
 * @return string
 */
function sportmall_reading_time( $post_id = null ) {
	$post = get_post( $post_id );
	if ( ! $post ) {
		return '';
	}
	$text  = trim( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ) );
	$words = preg_split( '/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY );
	$words = is_array( $words ) ? count( $words ) : 0;
	$minutes = max( 1, (int) ceil( $words / 200 ) );
	/* translators: %s: reading time in minutes. */
	return sprintf( __( '%s دقیقه مطالعه', 'sportmall' ), sportmall_fa_digits( $minutes ) );
}

/**
 * Post meta line (date + reading time).
 *
 * @param int|null $post_id Post ID.
 */
function sportmall_posted_on( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	printf(
		'<span>%s</span><span>%s</span>',
		esc_html( sportmall_fa_digits( get_the_date( 'j F Y', $post_id ) ) ),
		esc_html( sportmall_reading_time( $post_id ) )
	);
}

/**
 * Image with a graceful fallback.
 *
 * @param int    $post_id Post ID.
 * @param string $size Image size.
 * @param array  $attr Extra attributes.
 * @return string
 */
function sportmall_post_image( $post_id, $size = 'sportmall-wide', $attr = array() ) {
	$thumb_id = get_post_thumbnail_id( $post_id );
	if ( $thumb_id ) {
		return wp_get_attachment_image( $thumb_id, $size, false, $attr );
	}
	$fallback = sportmall_asset( 'images/journal-running.jpg' );
	return '<img src="' . esc_url( $fallback ) . '" alt="" loading="lazy" decoding="async">';
}

/**
 * Fallback for menus when a location is empty.
 *
 * @param array $args Menu args.
 */
function sportmall_menu_fallback( $args ) {
	$pages = array(
		'shop'      => array( __( 'فروشگاه', 'sportmall' ), sportmall_shop_url() ),
		'journal'   => array( __( 'ژورنال', 'sportmall' ), sportmall_journal_url() ),
		'about'     => array( __( 'درباره ما', 'sportmall' ), home_url( '/about/' ) ),
		'contact'   => array( __( 'تماس با ما', 'sportmall' ), home_url( '/contact/' ) ),
	);

	$location = isset( $args['theme_location'] ) ? $args['theme_location'] : '';
	if ( 'footer_shop' === $location || 'footer_help' === $location ) {
		$pages = array(
			'shop'      => array( __( 'همهٔ محصولات', 'sportmall' ), sportmall_shop_url() ),
			'sale'      => array( __( 'پیشنهادهای ویژه', 'sportmall' ), add_query_arg( 'on_sale', '1', sportmall_shop_url() ) ),
			'shipping'  => array( __( 'ارسال و تحویل', 'sportmall' ), home_url( '/shipping/' ) ),
			'returns'   => array( __( 'تعویض و بازگشت', 'sportmall' ), home_url( '/returns/' ) ),
			'sizes'     => array( __( 'راهنمای سایز', 'sportmall' ), home_url( '/size-guide/' ) ),
		);
	}

	$class = isset( $args['menu_class'] ) ? $args['menu_class'] : '';
	echo '<ul class="' . esc_attr( $class ) . '">';
	foreach ( $pages as $page ) {
		echo '<li><a href="' . esc_url( $page[1] ) . '">' . esc_html( $page[0] ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Site breadcrumb trail.
 */
function sportmall_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}

	$items = array(
		array( __( 'خانه', 'sportmall' ), home_url( '/' ) ),
	);

	if ( function_exists( 'is_woocommerce' ) && ( is_shop() || is_product_taxonomy() || is_product() ) ) {
		$items[] = array( __( 'فروشگاه', 'sportmall' ), sportmall_shop_url() );

		if ( is_product_taxonomy() ) {
			$term     = get_queried_object();
			$taxonomy = isset( $term->taxonomy ) ? $term->taxonomy : 'product_cat';
			$parents  = array_reverse( get_ancestors( $term->term_id, $taxonomy ) );
			foreach ( $parents as $parent_id ) {
				$parent = get_term( $parent_id, $taxonomy );
				if ( $parent && ! is_wp_error( $parent ) ) {
					$items[] = array( $parent->name, get_term_link( $parent ) );
				}
			}
			$items[] = array( $term->name, get_term_link( $term ) );
		} elseif ( is_product() ) {
			$terms = get_the_terms( get_the_ID(), 'product_cat' );
			if ( $terms && ! is_wp_error( $terms ) ) {
				$term    = $terms[0];
				$parents = array_reverse( get_ancestors( $term->term_id, 'product_cat' ) );
				foreach ( $parents as $parent_id ) {
					$parent = get_term( $parent_id, 'product_cat' );
					if ( $parent && ! is_wp_error( $parent ) ) {
						$items[] = array( $parent->name, get_term_link( $parent ) );
					}
				}
				$items[] = array( $term->name, get_term_link( $term ) );
			}
			$items[] = array( get_the_title(), get_permalink() );
		}
	} elseif ( is_singular( 'post' ) ) {
		$posts_page = (int) get_option( 'page_for_posts' );
		$items[]    = array( $posts_page ? get_the_title( $posts_page ) : __( 'ژورنال', 'sportmall' ), sportmall_journal_url() );
		$cats    = get_the_category();
		if ( $cats ) {
			$items[] = array( $cats[0]->name, get_category_link( $cats[0]->term_id ) );
		}
		$items[] = array( get_the_title(), get_permalink() );
	} elseif ( is_singular( 'sm_story' ) ) {
		$items[] = array( __( 'استوری‌ها', 'sportmall' ), sportmall_stories_url() );
		$items[] = array( get_the_title(), get_permalink() );
	} elseif ( is_singular( 'sm_outfit' ) ) {
		$items[] = array( __( 'ست‌های ورزشی', 'sportmall' ), get_post_type_archive_link( 'sm_outfit' ) );
		$items[] = array( get_the_title(), get_permalink() );
	} elseif ( is_page() ) {
		foreach ( array_reverse( get_post_ancestors( get_the_ID() ) ) as $ancestor ) {
			$items[] = array( get_the_title( $ancestor ), get_permalink( $ancestor ) );
		}
		$items[] = array( get_the_title(), get_permalink() );
	} elseif ( is_search() ) {
		/* translators: %s: search query. */
		$items[] = array( sprintf( __( 'جستجو برای «%s»', 'sportmall' ), get_search_query() ), '' );
	} elseif ( is_archive() ) {
		$items[] = array( get_the_archive_title(), '' );
	} elseif ( is_404() ) {
		$items[] = array( __( 'صفحه پیدا نشد', 'sportmall' ), '' );
	}

	$items = apply_filters( 'sportmall_breadcrumbs', $items );

	echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'مسیر صفحه', 'sportmall' ) . '"><ol>';
	$last = count( $items ) - 1;
	foreach ( $items as $index => $item ) {
		echo '<li>';
		if ( $index === $last || empty( $item[1] ) ) {
			echo '<span aria-current="page">' . esc_html( $item[0] ) . '</span>';
		} else {
			echo '<a href="' . esc_url( $item[1] ) . '">' . esc_html( $item[0] ) . '</a>';
		}
		echo '</li>';
	}
	echo '</ol></nav>';
}

/**
 * Accessible numeric pagination used on blog and story archives.
 */
function sportmall_pagination() {
	the_posts_pagination( array(
		'mid_size'  => 1,
		'prev_text' => sportmall_icon( 'chevron-right' ) . '<span>' . esc_html__( 'قبلی', 'sportmall' ) . '</span>',
		'next_text' => '<span>' . esc_html__( 'بعدی', 'sportmall' ) . '</span>' . sportmall_icon( 'chevron-left' ),
		'screen_reader_text' => __( 'صفحه‌بندی مطالب', 'sportmall' ),
	) );
}

/**
 * Hero slides from Customizer values.
 *
 * @return array<int,array<string,mixed>>
 */
function sportmall_hero_slides() {
	$defaults = sportmall_defaults();
	$shop     = sportmall_shop_url();
	$slides   = array();

	for ( $i = 1; $i <= 3; $i++ ) {
		$image = sportmall_mod( "slide_{$i}_image" );
		if ( ! $image ) {
			continue;
		}
		$slides[] = array(
			'image'    => $image,
			'kicker'   => sportmall_mod( "slide_{$i}_kicker" ),
			'title'    => sportmall_mod( "slide_{$i}_title" ),
			'text'     => sportmall_mod( "slide_{$i}_text" ),
			'cta'      => sportmall_mod( "slide_{$i}_cta_label" ),
			'url'      => sportmall_mod( "slide_{$i}_cta_url" ) ?: $shop,
			'position' => sportmall_mod( "slide_{$i}_position" ) ?: 'center 45%',
			'position_m' => sportmall_mod( "slide_{$i}_position_m" ) ?: '57% center',
		);
	}

	return apply_filters( 'sportmall_hero_slides', $slides );
}

/**
 * Top-level store categories (excluding audience categories) used in home tabs.
 *
 * @param int $limit Number of tabs.
 * @return array<int,WP_Term>
 */
function sportmall_type_categories( $limit = 3 ) {
	if ( ! taxonomy_exists( 'product_cat' ) ) {
		return array();
	}
	$terms = get_terms( array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => false,
		'parent'     => 0,
		'orderby'    => 'menu_order',
		'order'      => 'ASC',
		'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
	) );
	if ( is_wp_error( $terms ) ) {
		return array();
	}
	$exclude = array( 'women', 'men', 'uncategorized' );
	$filtered = array();
	foreach ( $terms as $term ) {
		if ( in_array( $term->slug, $exclude, true ) ) {
			continue;
		}
		$filtered[] = $term;
	}
	return array_slice( $filtered, 0, $limit );
}

/**
 * Products shown in the home catalog.
 *
 * @param int $limit Number of products.
 * @return array<int,WC_Product>
 */
function sportmall_home_products( $limit = 8 ) {
	if ( ! function_exists( 'wc_get_products' ) ) {
		return array();
	}
	return wc_get_products( array(
		'status'  => 'publish',
		'limit'   => $limit,
		'orderby' => 'date',
		'order'   => 'DESC',
		'return'  => 'objects',
	) );
}

/**
 * Products on sale ordered by largest discount.
 *
 * @param int $limit Number.
 * @return array<int,WC_Product>
 */
function sportmall_sale_products( $limit = 3 ) {
	if ( ! function_exists( 'wc_get_product_ids_on_sale' ) ) {
		return array();
	}
	$ids = wc_get_product_ids_on_sale();
	if ( empty( $ids ) ) {
		return array();
	}
	$products = wc_get_products( array(
		'include' => $ids,
		'limit'   => 60,
		'status'  => 'publish',
		'return'  => 'objects',
	) );
	$products = array_values( array_filter( $products, function( $product ) {
		return $product instanceof WC_Product && ! $product->is_type( 'variation' );
	} ) );
	usort( $products, function( $a, $b ) {
		return sportmall_discount_percent( $b ) <=> sportmall_discount_percent( $a );
	} );
	return array_slice( $products, 0, $limit );
}

/**
 * Category slugs for a product, including ancestors. Used for client-side tabs.
 *
 * @param WC_Product $product Product.
 * @return string
 */
function sportmall_product_cat_slugs( $product ) {
	$slugs = array();
	$terms = get_the_terms( $product->get_id(), 'product_cat' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$slugs[] = $term->slug;
			foreach ( get_ancestors( $term->term_id, 'product_cat' ) as $ancestor ) {
				$parent = get_term( $ancestor, 'product_cat' );
				if ( $parent && ! is_wp_error( $parent ) ) {
					$slugs[] = $parent->slug;
				}
			}
		}
	}
	return implode( ' ', array_unique( $slugs ) );
}

/**
 * Query products for an outfit.
 *
 * @param int $post_id Outfit post ID.
 * @return array<int,WC_Product>
 */
function sportmall_outfit_products( $post_id ) {
	$ids = get_post_meta( $post_id, '_sm_products', true );
	$ids = array_filter( array_map( 'absint', explode( ',', (string) $ids ) ) );
	if ( empty( $ids ) || ! function_exists( 'wc_get_products' ) ) {
		return array();
	}
	return wc_get_products( array(
		'include' => $ids,
		'limit'   => count( $ids ),
		'status'  => 'publish',
		'orderby' => 'include',
		'return'  => 'objects',
	) );
}

/**
 * Service promises shown above the newsletter.
 *
 * @return array<int,array<string,string>>
 */
function sportmall_services() {
	$services = array(
		array(
			'icon'  => 'shield',
			'title' => __( 'با خیال راحت انتخاب کن', 'sportmall' ),
			'text'  => __( 'راهنمای اصالت محصولات', 'sportmall' ),
			'url'   => home_url( '/about/' ),
		),
		array(
			'icon'  => 'truck',
			'title' => __( 'از ما تا درِ خانهٔ تو', 'sportmall' ),
			'text'  => __( 'راهنمای ارسال سفارش', 'sportmall' ),
			'url'   => home_url( '/shipping/' ),
		),
		array(
			'icon'  => 'ruler',
			'title' => __( 'اندازهٔ درست، حس بهتر', 'sportmall' ),
			'text'  => __( 'راهنمای سایز و تعویض', 'sportmall' ),
			'url'   => home_url( '/size-guide/' ),
		),
		array(
			'icon'  => 'headphones',
			'title' => __( 'کنار تو، در هر قدم', 'sportmall' ),
			'text'  => __( 'پاسخ به پرسش‌های خرید', 'sportmall' ),
			'url'   => home_url( '/contact/' ),
		),
	);

	return apply_filters( 'sportmall_services', $services );
}
