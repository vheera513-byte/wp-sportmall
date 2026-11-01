<?php
/**
 * WooCommerce integration.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

/**
 * Register Toman as a store currency when it is not provided by a plugin.
 * Store owners who use a gateway plugin with its own Toman support can disable
 * this with: add_filter( 'sportmall_enable_toman_currency', '__return_false' );
 */
function sportmall_register_toman() {
	if ( ! apply_filters( 'sportmall_enable_toman_currency', true ) ) {
		return;
	}
	add_filter( 'woocommerce_currencies', function( $currencies ) {
		if ( ! isset( $currencies['IRT'] ) ) {
			$currencies['IRT'] = __( 'تومان ایران', 'sportmall' );
		}
		return $currencies;
	} );

	add_filter( 'woocommerce_currency_symbol', function( $symbol, $currency ) {
		if ( 'IRT' === $currency ) {
			return 'تومان';
		}
		return $symbol;
	}, 10, 2 );
}
sportmall_register_toman();

/**
 * Persian digits in WooCommerce prices and counts.
 *
 * @param string $html Price HTML.
 * @return string
 */
function sportmall_persian_price_digits( $html ) {
	return sportmall_fa_digits( $html );
}
add_filter( 'wc_price', 'sportmall_persian_price_digits', 20 );
add_filter( 'number_format_i18n', 'sportmall_fa_digits' );

/**
 * Expose the storefront strings in Persian even before language packs are
 * installed. Site owners can disable this with the sportmall_translate_woocommerce filter.
 *
 * @param string $translation Translated text.
 * @param string $text        Original text.
 * @param string $domain      Text domain.
 * @return string
 */
function sportmall_woocommerce_strings( $translation, $text, $domain ) {
	if ( is_admin() || 'woocommerce' !== $domain || ! apply_filters( 'sportmall_translate_woocommerce', true ) ) {
		return $translation;
	}

	$strings = array(
		'Add to cart'                 => 'افزودن به سبد',
		'Add to basket'               => 'افزودن به سبد',
		'View cart'                   => 'مشاهده سبد خرید',
		'View basket'                 => 'مشاهده سبد خرید',
		'Checkout'                    => 'تکمیل سفارش',
		'Cart'                        => 'سبد خرید',
		'Basket'                      => 'سبد خرید',
		'Shop'                        => 'فروشگاه',
		'Product'                     => 'محصول',
		'Products'                    => 'محصولات',
		'Related products'            => 'محصولات مرتبط',
		'You may also like&hellip;'   => 'شاید این‌ها را هم دوست داشته باشی…',
		'Description'                 => 'توضیحات',
		'Additional information'      => 'مشخصات',
		'Reviews (%d)'                => 'دیدگاه‌ها (%d)',
		'Reviews (%s)'                => 'دیدگاه‌ها (%s)',
		'Subtotal'                    => 'جمع جزء',
		'Total'                       => 'مجموع',
		'Quantity'                    => 'تعداد',
		'Price'                       => 'قیمت',
		'Remove this item'            => 'حذف این آیتم',
		'Update cart'                 => 'به‌روزرسانی سبد',
		'Apply coupon'                => 'اعمال کد تخفیف',
		'Coupon code'                 => 'کد تخفیف',
		'Coupon:'                     => 'کد تخفیف:',
		'Cart totals'                 => 'جمع سبد خرید',
		'Proceed to checkout'         => 'ادامه و تکمیل سفارش',
		'Continue shopping'           => 'ادامه خرید',
		'No products in the cart.'    => 'سبد خرید تو خالی است.',
		'Your cart is currently empty.' => 'سبد خرید تو خالی است.',
		'Return to shop'              => 'بازگشت به فروشگاه',
		'Free shipping'               => 'ارسال رایگان',
		'Shipping'                    => 'ارسال',
		'Calculate shipping'          => 'محاسبهٔ ارسال',
		'Update totals'               => 'به‌روزرسانی مجموع',
		'Have a coupon?'              => 'کد تخفیف داری؟',
		'Click here to enter your code' => 'برای وارد کردن کد اینجا بزن',
		'Billing details'             => 'اطلاعات پرداخت',
		'Your order'                  => 'سفارش تو',
		'Place order'                 => 'ثبت سفارش',
		'Order notes'                 => 'یادداشت سفارش',
		'Order summary'               => 'خلاصهٔ سفارش',
		'Order details'               => 'جزئیات سفارش',
		'Order number'                => 'شمارهٔ سفارش',
		'Date'                        => 'تاریخ',
		'Status'                      => 'وضعیت',
		'My account'                  => 'حساب کاربری',
		'Log in'                      => 'ورود',
		'Log out'                     => 'خروج',
		'Register'                    => 'ثبت‌نام',
		'Username or email address'   => 'نام کاربری یا ایمیل',
		'Password'                    => 'رمز عبور',
		'Remember me'                 => 'مرا به خاطر بسپار',
		'Lost your password?'         => 'رمز عبورت را فراموش کردی؟',
		'Orders'                      => 'سفارش‌ها',
		'Addresses'                   => 'آدرس‌ها',
		'Account details'             => 'جزئیات حساب',
		'Dashboard'                   => 'پیشخوان',
		'Downloads'                   => 'دانلودها',
		'In stock'                    => 'موجود',
		'Out of stock'                => 'ناموجود',
		'Sale!'                       => 'تخفیف!',
		'Sale'                        => 'تخفیف',
		'Choose an option'            => 'یک گزینه انتخاب کن',
		'Select options'              => 'انتخاب گزینه‌ها',
		'Clear'                       => 'پاک کردن',
		'View products'               => 'مشاهده محصولات',
		'Shop now'                    => 'خرید کن',
		'Search results for: %s'      => 'نتیجهٔ جستجو برای: %s',
		'Go to shop'                  => 'رفتن به فروشگاه',
		'First name'                  => 'نام',
		'Last name'                   => 'نام خانوادگی',
		'Company name'                => 'نام شرکت',
		'Country / Region'            => 'کشور / منطقه',
		'Street address'              => 'نشانی',
		'Apartment, suite, unit, etc. (optional)' => 'واحد، طبقه، پلاک (اختیاری)',
		'Town / City'                 => 'شهر',
		'State / County'              => 'استان',
		'Postcode / ZIP'              => 'کد پستی',
		'Phone'                       => 'شمارهٔ تماس',
		'Email address'               => 'ایمیل',
		'Notes about your order, e.g. special notes for delivery.' => 'توضیحی برای سفارش، مثلاً نکته‌ای برای تحویل.',
		'Ship to a different address?' => 'به نشانی دیگری ارسال شود؟',
		'Create an account?'          => 'حساب کاربری بسازم؟',
		'Account password'            => 'رمز عبور حساب',
		'Payment'                     => 'پرداخت',
		'Shipping details'            => 'اطلاعات ارسال',
		'Available on backorder'      => 'قابل سفارش پیش‌فروش',
		'Remove'                      => 'حذف',
		'Update'                      => 'به‌روزرسانی',
		'Continue'                    => 'ادامه',
		'Apply'                       => 'اعمال',
		'Privacy policy'              => 'حریم خصوصی',
		'Terms and conditions'        => 'قوانین و شرایط',
		'I have read and agree to the website terms and conditions' => 'قوانین و شرایط سایت را خوانده‌ام و می‌پذیرم.',
		'Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy.' => 'اطلاعات تو برای پردازش سفارش، پشتیبانی و اهدافی که در سیاست حریم خصوصی آمده استفاده می‌شود.',
		' Cash on delivery'           => 'پرداخت در محل',
		'Cash on delivery'            => 'پرداخت در محل',
		'Direct bank transfer'        => 'انتقال بانکی',
		'Check payments'              => 'پرداخت با چک',
		'Pay via PayPal; you can pay with your credit card if you don\'t have a PayPal account.' => 'پرداخت آنلاین با کارت بانکی.',
		'Login'                       => 'ورود',
		'Username'                    => 'نام کاربری',
		'No order has been made yet.' => 'هنوز سفارشی ثبت نشده است.',
		'No downloads available yet.' => 'هنوز فایلی برای دانلود نیست.',
		'Default sorting'             => 'مرتب‌سازی پیش‌فرض',
		'Sort by popularity'          => 'پرفروش‌ترین',
		'Sort by average rating'      => 'بهترین امتیاز',
		'Sort by latest'              => 'جدیدترین',
		'Sort by price: low to high'  => 'ارزان‌ترین',
		'Sort by price: high to low'  => 'گران‌ترین',
		'Cart updated.'               => 'سبد خرید به‌روزرسانی شد.',
		'No products were found matching your selection.' => 'محصولی با این انتخاب پیدا نشد.',
		'Showing %1$d–%2$d of %3$d results' => 'نمایش %1$s تا %2$s از %3$s محصول',
		'Showing the single result'   => 'نمایش تنها نتیجه',
		'Showing all %d results'      => 'نمایش همهٔ %s محصول',
	);

	if ( isset( $strings[ $text ] ) ) {
		return $strings[ $text ];
	}
	return $translation;
}
add_filter( 'gettext', 'sportmall_woocommerce_strings', 20, 3 );

/**
 * Shop grid: three columns next to the filter sidebar.
 *
 * @return int
 */
function sportmall_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'sportmall_loop_columns', 20 );

/**
 * Products per shop page.
 *
 * @return int
 */
function sportmall_products_per_page() {
	return 9;
}
add_filter( 'loop_shop_per_page', 'sportmall_products_per_page', 20 );

/**
 * Related products setup.
 *
 * @param array $args Args.
 * @return array
 */
function sportmall_related_products( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'sportmall_related_products' );

/**
 * Gallery thumbnail columns.
 *
 * @return int
 */
function sportmall_gallery_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'sportmall_gallery_columns' );

/**
 * Custom sale badge with discounts.
 *
 * @param string     $html    Badge HTML.
 * @param WP_Post    $post    Post.
 * @param WC_Product $product Product.
 * @return string
 */
function sportmall_sale_flash( $html, $post = null, $product = null ) {
	$product = $product instanceof WC_Product ? $product : wc_get_product( get_the_ID() );
	if ( ! $product ) {
		return $html;
	}
	$percent = sportmall_discount_percent( $product );
	$label   = $percent > 0 ? sprintf( '%s٪ تخفیف', sportmall_fa_digits( $percent ) ) : __( 'تخفیف', 'sportmall' );
	return '<span class="onsale product-badge sale">' . esc_html( $label ) . '</span>';
}
add_filter( 'woocommerce_sale_flash', 'sportmall_sale_flash', 20, 3 );

/**
 * Cart badge markup.
 *
 * @return string
 */
function sportmall_cart_count_html() {
	$count = WC()->cart ? (int) WC()->cart->get_cart_contents_count() : 0;
	return '<span class="cart-badge sm-cart-count"' . ( $count ? '' : ' hidden' ) . '>' . esc_html( sportmall_fa_digits( $count ) ) . '</span>';
}

/**
 * Refresh the header cart count and mini cart with WooCommerce fragments.
 *
 * @param array $fragments Fragments.
 * @return array
 */
function sportmall_cart_fragments( $fragments ) {
	$fragments['.sm-cart-count'] = sportmall_cart_count_html();

	ob_start();
	woocommerce_mini_cart();
	$fragments['div.widget_shopping_cart_content'] = '<div class="widget_shopping_cart_content">' . ob_get_clean() . '</div>';

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'sportmall_cart_fragments' );

/**
 * Product brand above the single product title.
 */
function sportmall_single_brand() {
	global $product;
	if ( ! $product ) {
		return;
	}
	echo '<p class="detail-eyebrow single-brand">' . esc_html( sportmall_product_brand( $product ) ) . '</p>';
}
add_action( 'woocommerce_single_product_summary', 'sportmall_single_brand', 4 );

/**
 * Size guide link before add-to-cart.
 */
function sportmall_size_guide_link() {
	global $product;
	if ( ! $product || ! $product->is_type( 'variable' ) ) {
		return;
	}
	$page = get_page_by_path( 'size-guide' );
	$url  = $page ? get_permalink( $page ) : '#' . 'size-guide';
	echo '<a class="size-guide-link" href="' . esc_url( $url ) . '">' . sportmall_icon( 'ruler' ) . '<span>' . esc_html__( 'راهنمای سایز', 'sportmall' ) . '</span></a>';
}
add_action( 'woocommerce_before_add_to_cart_button', 'sportmall_size_guide_link', 15 );

/**
 * Trust row under add-to-cart.
 */
function sportmall_single_trust() {
	?>
	<ul class="single-trust">
		<li><?php sportmall_the_icon( 'shield' ); ?><span><strong><?php esc_html_e( 'اصالت کالا', 'sportmall' ); ?></strong><small><?php esc_html_e( 'انتخاب مطمئن از برندهای معتبر', 'sportmall' ); ?></small></span></li>
		<li><?php sportmall_the_icon( 'truck' ); ?><span><strong><?php esc_html_e( 'ارسال سریع', 'sportmall' ); ?></strong><small><?php esc_html_e( 'بسته‌بندی امن و پیگیری سفارش', 'sportmall' ); ?></small></span></li>
		<li><?php sportmall_the_icon( 'return' ); ?><span><strong><?php esc_html_e( 'تعویض آسان', 'sportmall' ); ?></strong><small><?php esc_html_e( 'سایز درست، بدون نگرانی', 'sportmall' ); ?></small></span></li>
	</ul>
	<?php
}
add_action( 'woocommerce_single_product_summary', 'sportmall_single_trust', 36 );

/**
 * Filter the shop query by the theme filters in the URL.
 *
 * @param WP_Query $query Query.
 */
function sportmall_shop_filters( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( ! ( function_exists( 'is_shop' ) && ( is_shop() || is_product_taxonomy() ) ) ) {
		return;
	}

	$tax_query = (array) $query->get( 'tax_query' );

	if ( ! empty( $_GET['on_sale'] ) ) {
		$ids = wc_get_product_ids_on_sale();
		$query->set( 'post__in', empty( $ids ) ? array( 0 ) : $ids );
	}

	if ( ! empty( $_GET['brand'] ) && taxonomy_exists( 'pa_brand' ) ) {
		$brand = sanitize_title( wp_unslash( $_GET['brand'] ) );
		$tax_query[] = array(
			'taxonomy' => 'pa_brand',
			'field'    => 'slug',
			'terms'    => $brand,
		);
		$query->set( 'tax_query', $tax_query );
	}

}
add_action( 'pre_get_posts', 'sportmall_shop_filters' );

/**
 * Apply the price and stock filters to WooCommerce's product meta query.
 *
 * Using `woocommerce_product_query_meta_query` keeps WooCommerce's own
 * visibility rules (hidden products, catalog visibility) intact, which a
 * manual meta_query in pre_get_posts would overwrite.
 *
 * @param array $meta_query Meta query clauses.
 * @return array
 */
function sportmall_product_meta_filters( $meta_query ) {
	if ( isset( $_GET['min_price'] ) || isset( $_GET['max_price'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$min = isset( $_GET['min_price'] ) ? (float) wp_unslash( $_GET['min_price'] ) : 0;
		$max = isset( $_GET['max_price'] ) ? (float) wp_unslash( $_GET['max_price'] ) : 999999999;
		if ( $min > $max ) {
			$swap = $min;
			$min  = $max;
			$max  = $swap;
		}
		$meta_query[] = array(
			'key'     => '_price',
			'value'   => array( $min, $max ),
			'compare' => 'BETWEEN',
			'type'    => 'NUMERIC',
		);
	}

	if ( isset( $_GET['stock'] ) && 'instock' === sanitize_key( wp_unslash( $_GET['stock'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$meta_query[] = array(
			'key'   => '_stock_status',
			'value' => 'instock',
		);
	}

	return $meta_query;
}
add_filter( 'woocommerce_product_query_meta_query', 'sportmall_product_meta_filters' );

/**
 * Output the product card markup.
 *
 * @param WC_Product $product Product.
 * @param array      $args    Optional arguments.
 */
function sportmall_product_card( $product, $args = array() ) {
	get_template_part( 'template-parts/product/card', null, array_merge( array( 'product' => $product ), $args ) );
}

/**
 * Get product categories for filter sidebar with counts.
 *
 * @return array<int,WP_Term>
 */
function sportmall_shop_categories() {
	$terms = get_terms( array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
		'parent'     => 0,
		'orderby'    => 'menu_order',
		'order'      => 'ASC',
	) );
	return is_wp_error( $terms ) ? array() : $terms;
}

/**
 * Min and max prices in the catalog for the filter UI.
 *
 * @return array{min:int,max:int}
 */
function sportmall_price_bounds() {
	global $wpdb;
	$row = $wpdb->get_row( "SELECT MIN( CAST( pm.meta_value AS DECIMAL(18,2) ) ) AS min_price, MAX( CAST( pm.meta_value AS DECIMAL(18,2) ) ) AS max_price FROM {$wpdb->postmeta} pm INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id WHERE pm.meta_key = '_price' AND pm.meta_value <> '' AND p.post_status = 'publish' AND p.post_type = 'product'" );
	return array(
		'min' => $row && $row->min_price !== null ? (int) floor( $row->min_price ) : 0,
		'max' => $row && $row->max_price !== null ? (int) ceil( $row->max_price ) : 10000000,
	);
}

/**
 * Shop toolbar: result count and ordering.
 */
function sportmall_shop_toolbar() {
	if ( ! woocommerce_product_loop() ) {
		return;
	}
	?>
	<div class="shop-toolbar">
		<div class="shop-results">
			<?php woocommerce_result_count(); ?>
		</div>
		<div class="shop-ordering">
			<?php woocommerce_catalog_ordering(); ?>
		</div>
	</div>
	<?php
}

/**
 * Custom pagination for shop pages.
 */
function sportmall_woocommerce_pagination() {
	woocommerce_pagination();
}

/**
 * Declare compatibility with WooCommerce high-performance order storage.
 */
function sportmall_declare_woocommerce_compatibility() {
	if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', SPORTMALL_DIR . '/style.css', true );
	}
}
add_action( 'before_woocommerce_init', 'sportmall_declare_woocommerce_compatibility' );
