<?php
/**
 * One-click demo content for the Sportmall theme.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the demo importer page.
 */
function sportmall_demo_admin_menu() {
	add_theme_page(
		__( 'محتوای نمونه اسپرت‌مال', 'sportmall' ),
		__( 'محتوای نمونه', 'sportmall' ),
		'edit_theme_options',
		'sportmall-demo',
		'sportmall_demo_admin_page'
	);
}
add_action( 'admin_menu', 'sportmall_demo_admin_menu' );

/**
 * Admin page markup.
 */
function sportmall_demo_admin_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$status = isset( $_GET['sportmall_demo'] ) ? sanitize_key( wp_unslash( $_GET['sportmall_demo'] ) ) : '';
	$woo    = class_exists( 'WooCommerce' );
	$count  = (int) wp_count_posts( 'product' )->publish;
	$pages  = array( 'home', 'journal', 'wishlist', 'contact' );

	$messages = array(
		'done'   => array( 'success', __( 'محتوای نمونه با موفقیت ساخته شد. حالا صفحه اصلی، فروشگاه، ژورنال و استوری‌ها آماده‌اند.', 'sportmall' ) ),
		'nowoo'  => array( 'error', __( 'برای ساخت محصولات و صفحه‌های فروشگاه، اول ووکامرس را نصب و فعال کن.', 'sportmall' ) ),
		'error'  => array( 'error', __( 'ساخت محتوا کامل نشد. دوباره تلاش کن یا گزارش خطا را در لاگ بررسی کن.', 'sportmall' ) ),
	);
	?>
	<div class="wrap sportmall-demo-wrap">
		<h1><?php esc_html_e( 'محتوای نمونه اسپرت‌مال', 'sportmall' ); ?></h1>

		<?php if ( $status && isset( $messages[ $status ] ) ) : ?>
			<div class="notice notice-<?php echo esc_attr( $messages[ $status ][0] ); ?> is-dismissible">
				<p><?php echo esc_html( $messages[ $status ][1] ); ?></p>
			</div>
		<?php endif; ?>

		<div class="sportmall-demo-card">
			<h2><?php esc_html_e( 'یک فروشگاه کامل، در یک کلیک', 'sportmall' ); ?></h2>
			<p>
				<?php esc_html_e( 'این ابزار دسته‌بندی‌ها، برندها، ۱۰ محصول نمونه، ست‌های ورزشی، استوری مشتریان، نوشته‌های ژورنال، برگه‌های راهنما و منوهای فوتر را می‌سازد. محتوای قبلی حذف نمی‌شود و اجرای دوباره، آیتم‌های تکراری نمی‌سازد.', 'sportmall' ); ?>
			</p>

			<ul class="sportmall-demo-status">
				<li>
					<span class="dashicons <?php echo $woo ? 'dashicons-yes-alt' : 'dashicons-warning'; ?>"></span>
					<?php echo $woo ? esc_html__( 'ووکامرس فعال است.', 'sportmall' ) : esc_html__( 'ووکامرس فعال نیست؛ فقط برگه‌ها و محتوای ژورنال ساخته می‌شوند.', 'sportmall' ); ?>
				</li>
				<li>
					<span class="dashicons dashicons-products"></span>
					<?php
					/* translators: %s: product count. */
					echo esc_html( sprintf( __( 'محصولات منتشرشده: %s', 'sportmall' ), number_format_i18n( $count ) ) );
					?>
				</li>
				<li>
					<span class="dashicons dashicons-admin-page"></span>
					<?php
					$missing = array();
					foreach ( $pages as $slug ) {
						if ( ! get_page_by_path( $slug ) ) {
							$missing[] = $slug;
						}
					}
					echo $missing
						? esc_html__( 'برگه‌های اصلی هنوز ساخته نشده‌اند.', 'sportmall' )
						: esc_html__( 'برگه‌های اصلی آماده‌اند.', 'sportmall' );
					?>
				</li>
				<li>
					<span class="dashicons dashicons-store"></span>
					<?php
					$shop_id = function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'shop' ) : 0;
					echo $shop_id > 0
						? esc_html__( 'برگه فروشگاه به ووکامرس وصل است.', 'sportmall' )
						: esc_html__( 'برگه فروشگاه به ووکامرس وصل نیست.', 'sportmall' );
					?>
				</li>
			</ul>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="sportmall_import_demo">
				<?php wp_nonce_field( 'sportmall_import_demo' ); ?>
				<?php submit_button( __( 'ساخت / تکمیل محتوای نمونه', 'sportmall' ), 'primary large', 'submit', false ); ?>
				<a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'دیدن سایت', 'sportmall' ); ?></a>
				<a class="button" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'تنظیمات ظاهری', 'sportmall' ); ?></a>
			</form>

			<p class="description">
				<?php esc_html_e( 'پیشنهاد: بعد از ساخت محتوا، در «تنظیمات > پیوندهای یکتا» روی «نام نوشته» ذخیره کن تا نشانی صفحه‌ها مرتب شود.', 'sportmall' ); ?>
			</p>
		</div>
	</div>
	<style>
		.sportmall-demo-wrap { max-width: 800px; }
		.sportmall-demo-card { margin-top: 24px; padding: 28px; background: #fff; border: 1px solid #dcdcde; border-radius: 12px; box-shadow: 0 8px 30px -22px rgba(0,0,0,.35); }
		.sportmall-demo-card h2 { margin-top: 0; }
		.sportmall-demo-card > p { max-width: 68ch; font-size: 14px; line-height: 2; color: #50575e; }
		.sportmall-demo-status { margin: 20px 0; padding: 0; list-style: none; display: grid; gap: 10px; }
		.sportmall-demo-status li { display: flex; align-items: center; gap: 9px; font-size: 13px; }
		.sportmall-demo-status .dashicons { color: #2271b1; }
		.sportmall-demo-status .dashicons-yes-alt { color: #00a32a; }
		.sportmall-demo-status .dashicons-warning { color: #d63638; }
		.sportmall-demo-card form { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; margin-top: 18px; }
		.sportmall-demo-card .description { margin-top: 18px; font-size: 12px; }
	</style>
	<?php
}

/**
 * Handle the demo import request.
 */
function sportmall_demo_handle_import() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'اجازهٔ انجام این کار را نداری.', 'sportmall' ) );
	}
	check_admin_referer( 'sportmall_import_demo' );

	$status = sportmall_demo_import() ? 'done' : 'error';
	wp_safe_redirect( add_query_arg( 'sportmall_demo', $status, admin_url( 'themes.php?page=sportmall-demo' ) ) );
	exit;
}
add_action( 'admin_post_sportmall_import_demo', 'sportmall_demo_handle_import' );

/**
 * Create a demo attachment from a bundled theme image.
 *
 * @param string $file File name inside assets/images.
 * @return int Attachment ID, 0 on failure.
 */
function sportmall_demo_attachment( $file ) {
	static $cache = array();

	if ( isset( $cache[ $file ] ) ) {
		return $cache[ $file ];
	}

	$existing = get_posts( array(
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'posts_per_page' => 1,
		'fields'         => 'ids',
		'meta_key'       => '_sportmall_demo_file',
		'meta_value'     => $file,
	) );
	if ( $existing ) {
		$cache[ $file ] = (int) $existing[0];
		return $cache[ $file ];
	}

	$source = SPORTMALL_DIR . '/assets/images/' . $file;
	if ( ! file_exists( $source ) ) {
		return 0;
	}

	$contents = file_get_contents( $source ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	$upload   = wp_upload_bits( $file, null, $contents );
	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}

	$type = wp_check_filetype( $upload['file'] );
	$id   = wp_insert_attachment( array(
		'post_mime_type' => $type['type'] ? $type['type'] : 'image/jpeg',
		'post_title'     => pathinfo( $file, PATHINFO_FILENAME ),
		'post_content'   => '',
		'post_status'    => 'inherit',
	), $upload['file'] );

	if ( is_wp_error( $id ) || ! $id ) {
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );
	update_post_meta( $id, '_sportmall_demo_file', $file );
	update_post_meta( $id, '_wp_attachment_image_alt', 'اسپرت‌مال' );

	$cache[ $file ] = (int) $id;
	return $cache[ $file ];
}

/**
 * Create a term if needed.
 *
 * @param string $taxonomy Taxonomy.
 * @param string $name     Name.
 * @param string $slug     Slug.
 * @param int    $parent   Parent term.
 * @param string $image    Optional image file.
 * @return int Term ID.
 */
function sportmall_demo_term( $taxonomy, $name, $slug, $parent = 0, $image = '' ) {
	$existing = get_term_by( 'slug', $slug, $taxonomy );
	if ( $existing && ! is_wp_error( $existing ) ) {
		if ( $image ) {
			$attachment = sportmall_demo_attachment( $image );
			if ( $attachment ) {
				update_term_meta( $existing->term_id, 'thumbnail_id', $attachment );
			}
		}
		return (int) $existing->term_id;
	}

	$result = wp_insert_term( $name, $taxonomy, array(
		'slug'   => $slug,
		'parent' => $parent,
	) );
	if ( is_wp_error( $result ) ) {
		return 0;
	}

	if ( $image ) {
		$attachment = sportmall_demo_attachment( $image );
		if ( $attachment ) {
			update_term_meta( $result['term_id'], 'thumbnail_id', $attachment );
		}
	}

	return (int) $result['term_id'];
}

/**
 * Ensure a global WooCommerce attribute exists and is registered for this request.
 *
 * @param string $slug Attribute slug without pa_ prefix.
 * @param string $name Label.
 * @return string Taxonomy name.
 */
function sportmall_demo_attribute( $slug, $name ) {
	global $wpdb;

	$taxonomy = 'pa_' . $slug;

	if ( ! taxonomy_exists( $taxonomy ) ) {
		$exists = $wpdb->get_var( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$wpdb->prepare( "SELECT attribute_name FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = %s", $slug )
		);
		if ( ! $exists ) {
			wc_create_attribute( array(
				'name'         => $name,
				'slug'         => $slug,
				'type'         => 'select',
				'order_by'     => 'menu_order',
				'has_archives' => false,
			) );
			delete_transient( 'wc_attribute_taxonomies' );
			if ( class_exists( 'WC_Cache_Helper' ) ) {
				WC_Cache_Helper::invalidate_cache_group( 'woocommerce-attributes' );
			}
		}

		register_taxonomy( $taxonomy, array( 'product' ), array(
			'hierarchical' => false,
			'public'       => false,
			'show_ui'      => false,
			'query_var'    => true,
			'rewrite'      => false,
			'labels'       => array( 'name' => $name ),
		) );
	}

	return $taxonomy;
}

/**
 * Create a demo product.
 *
 * @param array $data Product data.
 * @param array $terms Term IDs keyed by taxonomy.
 * @return int Product ID.
 */
function sportmall_demo_product( $data, $terms ) {
	$existing = get_page_by_path( $data['slug'], OBJECT, 'product' );
	if ( $existing ) {
		update_post_meta( $existing->ID, '_sportmall_demo', '1' );
		return (int) $existing->ID;
	}

	$is_variable = ! empty( $data['sizes'] );
	$product     = $is_variable ? new WC_Product_Variable() : new WC_Product_Simple();

	$product->set_name( $data['name'] );
	$product->set_slug( $data['slug'] );
	$product->set_status( 'publish' );
	$product->set_catalog_visibility( 'visible' );
	$product->set_description( $data['description'] );
	$product->set_short_description( $data['short'] );
	$product->set_sku( $data['sku'] );
	$product->set_manage_stock( false );
	$product->set_stock_status( 'instock' );
	$product->set_featured( ! empty( $data['featured'] ) );
	$product->set_category_ids( array_filter( array_map( 'absint', isset( $terms['product_cat'] ) ? (array) $terms['product_cat'] : array() ) ) );
	$product->set_tag_ids( isset( $terms['product_tag'] ) ? (array) $terms['product_tag'] : array() );

	$image = sportmall_demo_attachment( $data['image'] );
	if ( $image ) {
		$product->set_image_id( $image );

		$gallery = array();
		if ( ! empty( $data['gallery'] ) ) {
			foreach ( $data['gallery'] as $gallery_file ) {
				$gallery_id = sportmall_demo_attachment( $gallery_file );
				if ( $gallery_id && $gallery_id !== $image ) {
					$gallery[] = $gallery_id;
				}
			}
		}
		if ( $gallery ) {
			$product->set_gallery_image_ids( $gallery );
		}
	}

	if ( $is_variable ) {
		$size_taxonomy = 'pa_size';
		$attribute     = new WC_Product_Attribute();
		$attribute->set_id( (int) wc_attribute_taxonomy_id_by_name( 'size' ) );
		$attribute->set_name( $size_taxonomy );
		$attribute->set_options( array_map( 'absint', (array) $data['size_terms'] ) );
		$attribute->set_position( 0 );
		$attribute->set_visible( true );
		$attribute->set_variation( true );
		$product->set_attributes( array( $attribute ) );
		$product->set_regular_price( '' );
		$product->set_sale_price( '' );
	} else {
		$product->set_regular_price( (string) $data['regular_price'] );
		if ( ! empty( $data['sale_price'] ) ) {
			$product->set_sale_price( (string) $data['sale_price'] );
		}
	}

	$product_id = $product->save();
	if ( ! $product_id ) {
		return 0;
	}

	if ( $is_variable ) {
		foreach ( (array) $data['sizes'] as $index => $size_slug ) {
			if ( empty( $data['size_terms'][ $index ] ) ) {
				continue;
			}
			$variation = new WC_Product_Variation();
			$variation->set_parent_id( $product_id );
			$variation->set_attributes( array( 'pa_size' => $size_slug ) );
			$variation->set_regular_price( (string) $data['regular_price'] );
			if ( ! empty( $data['sale_price'] ) ) {
				$variation->set_sale_price( (string) $data['sale_price'] );
			}
			$variation->set_sku( $data['sku'] . '-' . $size_slug );
			$variation->set_manage_stock( false );
			$variation->set_stock_status( 'instock' );
			$variation->save();
		}
		WC_Product_Variable::sync( $product_id );
	}

	if ( ! empty( $data['colors'] ) ) {
		wp_set_object_terms( $product_id, (array) $data['colors'], 'pa_color', false );
	}
	if ( ! empty( $terms['pa_brand'] ) ) {
		wp_set_object_terms( $product_id, (array) $terms['pa_brand'], 'pa_brand', false );
	}
	if ( ! empty( $terms['product_cat'] ) ) {
		wp_set_object_terms( $product_id, array_map( 'absint', (array) $terms['product_cat'] ), 'product_cat', false );
	}
	if ( ! empty( $terms['product_tag'] ) ) {
		wp_set_object_terms( $product_id, array_map( 'absint', (array) $terms['product_tag'] ), 'product_tag', false );
	}

	update_post_meta( $product_id, '_sportmall_demo', '1' );
	update_post_meta( $product_id, '_sm_category', isset( $data['label'] ) ? $data['label'] : '' );

	return (int) $product_id;
}

/**
 * Create or update a demo post.
 *
 * @param array $args Post args.
 * @param array $meta Meta values.
 * @return int Post ID.
 */
function sportmall_demo_post( $args, $meta = array() ) {
	$existing = get_page_by_path( $args['post_name'], OBJECT, $args['post_type'] );
	if ( $existing ) {
		$args['ID'] = $existing->ID;
	}

	$post_id = wp_insert_post( $args );
	if ( is_wp_error( $post_id ) || ! $post_id ) {
		return 0;
	}

	foreach ( $meta as $key => $value ) {
		update_post_meta( $post_id, $key, $value );
	}

	update_post_meta( $post_id, '_sportmall_demo', '1' );

	return (int) $post_id;
}

/**
 * Make sure the standard WooCommerce pages exist and are assigned.
 *
 * @return array<string,int> Page IDs.
 */
function sportmall_demo_woo_pages() {
	$ids = array();

	$definitions = array(
		'shop'      => array( 'فروشگاه', '' ),
		'cart'      => array( 'سبد خرید', '[woocommerce_cart]' ),
		'checkout'  => array( 'تکمیل سفارش', '[woocommerce_checkout]' ),
		'myaccount' => array( 'حساب کاربری', '[woocommerce_my_account]' ),
	);

	foreach ( $definitions as $key => $definition ) {
		$page_id = function_exists( 'wc_get_page_id' ) ? (int) wc_get_page_id( $key ) : 0;

		if ( $page_id <= 0 || ! get_post( $page_id ) ) {
			$existing = get_page_by_path( $key === 'myaccount' ? 'my-account' : ( 'shop' === $key ? 'shop' : $key ) );
			if ( $existing ) {
				$page_id = (int) $existing->ID;
			} else {
				$page_id = wp_insert_post( array(
					'post_type'    => 'page',
					'post_status'  => 'publish',
					'post_title'   => $definition[0],
					'post_name'    => $key === 'myaccount' ? 'my-account' : ( 'shop' === $key ? 'shop' : $key ),
					'post_content' => $definition[1],
					'post_author'  => get_current_user_id(),
				) );
				if ( is_wp_error( $page_id ) ) {
					continue;
				}
				update_post_meta( $page_id, '_sportmall_demo', '1' );
			}
		}

		update_option( 'woocommerce_' . $key . '_page_id', (int) $page_id );
		$ids[ $key ] = (int) $page_id;
	}

	return $ids;
}

/**
 * Import the full demo catalogue and editorial content.
 *
 * @return bool
 */
function sportmall_demo_import() {
	if ( get_transient( 'sportmall_demo_importing' ) ) {
		return false;
	}
	set_transient( 'sportmall_demo_importing', 1, 2 * MINUTE_IN_SECONDS );

	if ( function_exists( 'set_time_limit' ) ) {
		@set_time_limit( 180 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
	}

	wp_defer_term_counting( true );

	$has_woo = class_exists( 'WooCommerce' );

	if ( $has_woo ) {
		sportmall_demo_woo_pages();
	}

	/* ---------------------------------------------------------------- Terms */
	$category_ids = array();
	if ( $has_woo ) {
		$category_data = array(
			'women'       => array( 'زنانه', 'انتخاب‌هایی برای او؛ از تمرین سبک تا روزهای پرتحرک.', 'category-women.jpg' ),
			'men'         => array( 'مردانه', 'پوشاک و کفش ورزشی برای هر روز و هر تمرین.', 'category-men.jpg' ),
			'shoes'       => array( 'کفش ورزشی', 'از دویدن تا باشگاه؛ روی هر سطح، راحت و مطمئن.', 'category-shoes.jpg' ),
			'clothing'    => array( 'پوشاک ورزشی', 'لایه‌های سبک، خنک و آزاد برای حرکت.', 'product-tee.jpg' ),
			'accessories' => array( 'اکسسوری', 'جزئیات کوچک، تفاوت‌های بزرگ.', 'product-bag.jpg' ),
			'running'     => array( 'دویدن', 'برای صبح‌های زود و مسیرهای تازه.', 'running-campaign.jpg' ),
			'training'    => array( 'تمرین و باشگاه', 'انتخاب‌هایی برای تمرین‌های جدی.', 'journal-training.jpg' ),
		);

		foreach ( $category_data as $slug => $data ) {
			$category_ids[ $slug ] = sportmall_demo_term( 'product_cat', $data[0], $slug, 0, $data[2] );
			if ( $category_ids[ $slug ] && ! empty( $data[1] ) ) {
				wp_update_term( $category_ids[ $slug ], 'product_cat', array( 'description' => $data[1] ) );
			}
		}

		$child_categories = array(
			'running-shoes' => array( 'کفش دویدن', 'shoes' ),
			'training-shoes' => array( 'کفش تمرین', 'shoes' ),
			'tops'          => array( 'تی‌شرت و تاپ', 'clothing' ),
			'leggings'      => array( 'لگ و ساپورت', 'clothing' ),
			'shorts'        => array( 'شورت ورزشی', 'clothing' ),
			'bags'          => array( 'کیف و کوله', 'accessories' ),
			'bottles'       => array( 'بطری و قمقمه', 'accessories' ),
			'socks'         => array( 'جوراب', 'accessories' ),
		);
		foreach ( $child_categories as $slug => $data ) {
			$parent = isset( $category_ids[ $data[1] ] ) ? $category_ids[ $data[1] ] : 0;
			$category_ids[ $slug ] = sportmall_demo_term( 'product_cat', $data[0], $slug, $parent );
		}
	}

	$brand_ids = array();
	$size_terms = array();
	$color_terms = array();
	if ( $has_woo ) {
		$brand_taxonomy = sportmall_demo_attribute( 'brand', 'برند' );
		$size_taxonomy  = sportmall_demo_attribute( 'size', 'سایز' );
		$color_taxonomy = sportmall_demo_attribute( 'color', 'رنگ' );

		$brands = array(
			'nike'       => 'نایک',
			'adidas'     => 'آدیداس',
			'puma'       => 'پوما',
			'asics'      => 'آسیکس',
			'newbalance' => 'نیوبالانس',
			'reebok'     => 'ریباک',
			'underarmour' => 'آندرآرمور',
			'skechers'   => 'اسکچرز',
		);
		foreach ( $brands as $slug => $name ) {
			$brand_ids[ $slug ] = sportmall_demo_term( $brand_taxonomy, $name, $slug );
		}

		$sizes = array(
			'40' => '۴۰',
			'41' => '۴۱',
			'42' => '۴۲',
			'43' => '۴۳',
			'44' => '۴۴',
			'45' => '۴۵',
			's'  => 'S',
			'm'  => 'M',
			'l'  => 'L',
			'xl' => 'XL',
		);
		foreach ( $sizes as $slug => $name ) {
			$size_terms[ $slug ] = sportmall_demo_term( $size_taxonomy, $name, $slug );
		}

		$colors = array(
			'black'  => 'مشکی',
			'white'  => 'سفید',
			'gray'   => 'خاکستری',
			'green'  => 'سبز زیتونی',
			'blue'   => 'آبی',
			'coral'  => 'مرجانی',
		);
		foreach ( $colors as $slug => $name ) {
			$color_terms[ $slug ] = sportmall_demo_term( $color_taxonomy, $name, $slug );
		}
	}

	/* ------------------------------------------------------------- Products */
	$product_ids = array();
	if ( $has_woo ) {
		$products = array(
			array(
				'slug'          => 'pegasus-41',
				'sku'           => 'SM-PEG-41',
				'name'          => 'کفش دویدن نایک پگاسوس ۴۱',
				'label'         => 'کفش دویدن',
				'description'   => '<p>پگاسوس ۴۱ برای دویدن‌های روزانه ساخته شده است: فوم نرم و برگشت‌پذیر، رویهٔ مش سبک و پاشنهٔ پایدار. اگر دنبال یک کفش همه‌کاره برای مسیرهای شهری و تمرین‌های سبک هستی، این انتخاب ساده و مطمئن است.</p><ul><li>رویهٔ مش تنفس‌پذیر</li><li>کفی نرم با بازگشت انرژی</li><li>وزن سبک و مناسب دویدن روزانه</li></ul>',
				'short'         => 'کفش همه‌کارهٔ دویدن با رویهٔ مش سبک و کفی نرم.',
				'image'         => 'product-pegasus.jpg',
				'gallery'       => array( 'category-shoes.jpg', 'running-campaign.jpg' ),
				'brand'         => 'nike',
				'categories'    => array( 'women', 'men', 'shoes', 'running-shoes', 'running' ),
				'colors'        => array( 'black', 'white', 'gray' ),
				'sizes'         => array( '40', '41', '42', '43', '44' ),
				'regular_price' => 7900000,
				'sale_price'    => 6900000,
				'featured'      => true,
			),
			array(
				'slug'          => 'adidas-training',
				'sku'           => 'SM-ADS-TEE',
				'name'          => 'تی‌شرت تمرین آدیداس هایپرلایت',
				'label'         => 'تی‌شرت تمرین',
				'description'   => '<p>یک تی‌شرت سبک با پارچهٔ رطوبت‌کش برای جلسه‌های تمرین و روزهای گرم. برش آزاد و دوخت صاف، اجازهٔ حرکت کامل می‌دهد.</p><p>پیشنهاد می‌کنیم با شورت ورزشی و یکی از جوراب‌های اسپرت‌مال ست کنی.</p>',
				'short'         => 'تی‌شرت تمرین سبک با پارچهٔ رطوبت‌کش و برش آزاد.',
				'image'         => 'product-tee.jpg',
				'gallery'       => array( 'category-men.jpg', 'journal-training.jpg' ),
				'brand'         => 'adidas',
				'categories'    => array( 'men', 'clothing', 'tops', 'training' ),
				'colors'        => array( 'green', 'black' ),
				'sizes'         => array( 's', 'm', 'l', 'xl' ),
				'regular_price' => 2300000,
				'sale_price'    => 1850000,
				'featured'      => true,
			),
			array(
				'slug'          => 'nike-one',
				'sku'           => 'SM-NKE-LEG',
				'name'          => 'لگ ورزشی نایک وان',
				'label'         => 'لگ ورزشی',
				'description'   => '<p>لگ با کمر بلند و پارچهٔ کشسان که در حرکت جابه‌جا نمی‌شود. مناسب یوگا، تمرین با وزنه و روزهای پرمشغله.</p><ul><li>کمر بلند و پهن</li><li>پارچهٔ نرم و غیرشفاف</li><li>جیب کوچک داخلی</li></ul>',
				'short'         => 'لگ کمر بلند با پارچهٔ کشسان و پوشش کامل.',
				'image'         => 'product-leggings.jpg',
				'gallery'       => array( 'category-women.jpg', 'journal-training.jpg' ),
				'brand'         => 'nike',
				'categories'    => array( 'women', 'clothing', 'leggings', 'training' ),
				'colors'        => array( 'black', 'gray' ),
				'sizes'         => array( 's', 'm', 'l' ),
				'regular_price' => 2450000,
				'sale_price'    => '',
				'featured'      => true,
			),
			array(
				'slug'          => 'nike-brasilia',
				'sku'           => 'SM-NKE-BAG',
				'name'          => 'کیف ورزشی نایک برازیلیا',
				'label'         => 'کیف ورزشی',
				'description'   => '<p>کیف جمع‌وجمع با فضای کافی برای لباس، کفش و بطری. بند بلند قابل تنظیم و پارچهٔ مقاوم، آن را همراه همیشگی باشگاه می‌کند.</p>',
				'short'         => 'کیف ورزشی سبک با فضای کافی برای باشگاه.',
				'image'         => 'product-bag.jpg',
				'gallery'       => array( 'product-bottle.jpg' ),
				'brand'         => 'nike',
				'categories'    => array( 'women', 'men', 'accessories', 'bags' ),
				'colors'        => array( 'black', 'white' ),
				'regular_price' => 3200000,
				'sale_price'    => '',
				'featured'      => false,
			),
			array(
				'slug'          => 'adidas-response',
				'sku'           => 'SM-ADS-RSP',
				'name'          => 'کفش تمرین آدیداس ریسپانس',
				'label'         => 'کفش تمرین',
				'description'   => '<p>کفشی با پایداری بالا برای تمرین‌های قدرتی و جلسه‌های باشگاه. زیرهٔ چسبنده و پاشنهٔ محکم، تعادل را در حرکت‌های سریع حفظ می‌کند.</p>',
				'short'         => 'کفش تمرین با پایداری بالا و زیرهٔ چسبنده.',
				'image'         => 'product-adidas-shoe.jpg',
				'gallery'       => array( 'category-shoes.jpg' ),
				'brand'         => 'adidas',
				'categories'    => array( 'men', 'women', 'shoes', 'training-shoes', 'training' ),
				'colors'        => array( 'white', 'blue' ),
				'sizes'         => array( '40', '41', '42', '43', '44', '45' ),
				'regular_price' => 6400000,
				'sale_price'    => 5400000,
				'featured'      => true,
			),
			array(
				'slug'          => 'nike-park',
				'sku'           => 'SM-NKE-PRK',
				'name'          => 'شورت ورزشی نایک پارک',
				'label'         => 'شورت ورزشی',
				'description'   => '<p>شورت سبک با کش کمر و بند تنظیم‌شونده؛ انتخاب ساده برای فوتبال، دویدن و تمرین‌های روزانه.</p>',
				'short'         => 'شورت سبک با بند تنظیم‌شونده برای تمرین روزانه.',
				'image'         => 'product-shorts.jpg',
				'gallery'       => array( 'category-men.jpg' ),
				'brand'         => 'nike',
				'categories'    => array( 'men', 'clothing', 'shorts' ),
				'colors'        => array( 'black', 'green' ),
				'regular_price' => 1800000,
				'sale_price'    => 1350000,
				'featured'      => false,
			),
			array(
				'slug'          => 'nike-everyday',
				'sku'           => 'SM-NKE-SCK',
				'name'          => 'جوراب نایک اور‌دی',
				'label'         => 'جوراب',
				'description'   => '<p>جوراب نرم با کفی ضربه‌گیر و بافت تنفس‌پذیر. بستهٔ سه‌عددی برای تمرین و روزهای معمولی.</p>',
				'short'         => 'جوراب نرم و تنفس‌پذیر، بستهٔ سه‌عددی.',
				'image'         => 'product-socks.jpg',
				'brand'         => 'nike',
				'categories'    => array( 'women', 'men', 'accessories', 'socks' ),
				'colors'        => array( 'white', 'black' ),
				'regular_price' => 780000,
				'sale_price'    => '',
				'featured'      => false,
			),
			array(
				'slug'          => 'nike-bottle',
				'sku'           => 'SM-NKE-BTL',
				'name'          => 'قمقمهٔ ورزشی نایک هایپر‌اسپورت',
				'label'         => 'قمقمه',
				'description'   => '<p>قمقمهٔ ۷۰۰ میلی‌لیتری با درِ پیچی و بدنهٔ سبک؛ همراه سادهٔ تمرین و پیاده‌روی.</p>',
				'short'         => 'قمقمهٔ ۷۰۰ میلی‌لیتری سبک و نشتی‌ندار.',
				'image'         => 'product-bottle.jpg',
				'brand'         => 'nike',
				'categories'    => array( 'women', 'men', 'accessories', 'bottles' ),
				'colors'        => array( 'coral', 'white' ),
				'regular_price' => 890000,
				'sale_price'    => '',
				'featured'      => false,
			),
			array(
				'slug'          => 'nike-swoosh',
				'sku'           => 'SM-NKE-SWS',
				'name'          => 'تاپ ورزشی نایک سووش',
				'label'         => 'تاپ ورزشی',
				'description'   => '<p>تاپ ورزشی با بندهای قابل تنظیم و پشتیبانی متوسط. مناسب یوگا، پیلاتس و تمرین‌های سبک.</p>',
				'short'         => 'تاپ ورزشی با پشتیبانی متوسط و بند قابل تنظیم.',
				'image'         => 'product-swoosh.png',
				'brand'         => 'nike',
				'categories'    => array( 'women', 'clothing', 'tops' ),
				'colors'        => array( 'black', 'coral' ),
				'regular_price' => 2150000,
				'sale_price'    => '',
				'featured'      => false,
			),
			array(
				'slug'          => 'nike-miler',
				'sku'           => 'SM-NKE-MIL',
				'name'          => 'تی‌شرت دویدن نایک مایلر',
				'label'         => 'تی‌شرت دویدن',
				'description'   => '<p>تی‌شرت دویدن با پارچهٔ فوق‌سبک و تهویهٔ بالا. درزهای صاف، اصطکاک را کم می‌کنند و حرکت دست‌ها آزاد است.</p>',
				'short'         => 'تی‌شرت فوق‌سبک دویدن با تهویهٔ بالا.',
				'image'         => 'product-miler.png',
				'gallery'       => array( 'running-campaign.jpg' ),
				'brand'         => 'nike',
				'categories'    => array( 'men', 'clothing', 'tops', 'running' ),
				'colors'        => array( 'white', 'black' ),
				'regular_price' => 2350000,
				'sale_price'    => '',
				'featured'      => false,
			),
		);

		$size_lookup = array(
			'40' => '40',
			'41' => '41',
			'42' => '42',
			'43' => '43',
			'44' => '44',
			'45' => '45',
			's'  => 's',
			'm'  => 'm',
			'l'  => 'l',
			'xl' => 'xl',
		);

		foreach ( $products as $product_data ) {
			$product_cat_terms   = array();
			$product_tag_terms   = array();
			$product_brand_terms = array();

			foreach ( $product_data['categories'] as $category_slug ) {
				if ( ! empty( $category_ids[ $category_slug ] ) ) {
					$product_cat_terms[] = (int) $category_ids[ $category_slug ];
				}
			}
			if ( ! empty( $brand_ids[ $product_data['brand'] ] ) ) {
				$product_brand_terms[] = (int) $brand_ids[ $product_data['brand'] ];
			}

			$brand_names = array(
				'nike'   => 'نایک',
				'adidas' => 'آدیداس',
			);
			if ( isset( $brand_names[ $product_data['brand'] ] ) ) {
				$product_tag_terms[] = sportmall_demo_term( 'product_tag', $brand_names[ $product_data['brand'] ], $product_data['brand'] );
			}

			$size_term_ids = array();
			$size_slugs    = array();
			if ( ! empty( $product_data['sizes'] ) ) {
				foreach ( $product_data['sizes'] as $size ) {
					if ( ! empty( $size_terms[ $size_lookup[ $size ] ] ) ) {
						$size_term_ids[] = (int) $size_terms[ $size_lookup[ $size ] ];
						$size_slugs[]    = $size_lookup[ $size ];
					}
				}
			}

			$color_slugs = array();
			foreach ( $product_data['colors'] as $color ) {
				if ( ! empty( $color_terms[ $color ] ) ) {
					$color_slugs[] = $color;
				}
			}

			$product_data['size_terms'] = $size_term_ids;
			$product_data['sizes']      = $size_slugs;

			$product_id = sportmall_demo_product(
				$product_data,
				array(
					'product_cat' => $product_cat_terms,
					'product_tag' => $product_tag_terms,
					'pa_brand'    => $product_brand_terms,
					'pa_color'    => $color_slugs,
				)
			);

			if ( $product_id ) {
				$product_ids[ $product_data['slug'] ] = $product_id;
			}
		}
	}

	/* -------------------------------------------------------------- Outfits */
	$outfits = array(
		array(
			'slug'      => 'city-everyday',
			'title'     => 'ست روزمرهٔ شهری',
			'excerpt'   => 'ترکیبی ساده و راحت برای روزهایی که از تمرین به شهر می‌رسی.',
			'content'   => '<p>این ست از یک تی‌شرت سبک، شورت ورزشی و کفش تمرین ساخته شده است؛ سه آیتم که بدون تلاش با هم هماهنگ می‌شوند و از صبح تا عصر همراهت می‌مانند.</p><p>کیف ورزشی و قمقمه را هم اضافه کن تا برای یک روز کامل آماده باشی.</p>',
			'image'     => 'category-men.jpg',
			'edition'   => 'THE CITY EDIT / 01',
			'name'      => 'شهری روزمره',
			'tags'      => '۴ آیتم هماهنگ, سبک روزمره, حرکت',
			'products'  => array( 'nike-park', 'adidas-training', 'adidas-response', 'nike-brasilia' ),
		),
		array(
			'slug'      => 'morning-training',
			'title'     => 'ست تمرین صبحگاهی',
			'excerpt'   => 'برای جلسه‌های تمرین با وزنه و صبح‌های پرانرژی.',
			'content'   => '<p>لگ کمر بلند، تاپ ورزشی و یک کفش پایدار؛ انتخاب‌هایی که در حرکت جابه‌جا نمی‌شوند و تمرکزت را حفظ می‌کنند.</p><p>جوراب نرم و قمقمه را فراموش نکن؛ جزئیات کوچک، تفاوت بزرگ می‌سازند.</p>',
			'image'     => 'category-women.jpg',
			'edition'   => 'THE TRAINING EDIT / 02',
			'name'      => 'تمرین صبحگاهی',
			'tags'      => '۵ آیتم هماهنگ, تمرین و باشگاه, پشتیبانی',
			'products'  => array( 'nike-one', 'nike-swoosh', 'adidas-response', 'nike-everyday', 'nike-bottle' ),
		),
		array(
			'slug'      => 'weekend-running',
			'title'     => 'ست دویدن آخر هفته',
			'excerpt'   => 'سبک، خنک و آماده برای یک مسیر تازه.',
			'content'   => '<p>تی‌شرت مایلر، کفش پگاسوس و جوراب نایک؛ ترکیبی که برای دویدن‌های طولانی و مسیرهای شهری طراحی شده است.</p><p>با یک بطری آب و هدفی کوچک شروع کن؛ بقیهٔ مسیر خودش می‌آید.</p>',
			'image'     => 'running-campaign.jpg',
			'edition'   => 'THE RUNNING EDIT / 03',
			'name'      => 'دویدن آخر هفته',
			'tags'      => '۴ آیتم هماهنگ, دویدن, مسیر شهری',
			'products'  => array( 'nike-miler', 'pegasus-41', 'nike-everyday', 'nike-bottle' ),
		),
	);

	foreach ( $outfits as $outfit ) {
		$image_id = sportmall_demo_attachment( $outfit['image'] );
		$post_id  = sportmall_demo_post(
			array(
				'post_type'    => 'sm_outfit',
				'post_status'  => 'publish',
				'post_title'   => $outfit['title'],
				'post_name'    => $outfit['slug'],
				'post_excerpt' => $outfit['excerpt'],
				'post_content' => $outfit['content'],
			),
			array(
				'_sm_edition'     => $outfit['edition'],
				'_sm_outfit_name' => $outfit['name'],
				'_sm_description' => $outfit['excerpt'],
				'_sm_tags'        => $outfit['tags'],
				'_sm_products'    => implode( ',', array_filter( array_map( function( $slug ) use ( $product_ids ) {
					return isset( $product_ids[ $slug ] ) ? $product_ids[ $slug ] : 0;
				}, $outfit['products'] ) ) ),
				'_sm_position'    => '50% 40%',
			)
		);
		if ( $post_id && $image_id ) {
			set_post_thumbnail( $post_id, $image_id );
		}
	}

	/* -------------------------------------------------------------- Stories */
	$stories = array(
		array(
			'slug'     => 'sara-pilates',
			'title'    => 'صبح‌های آرام، با یک تصمیم کوچک',
			'name'     => 'سارا',
			'activity' => 'پیلاتس و تمرین',
			'initial'  => 'س',
			'category' => 'از انتخاب تا اولین تمرین',
			'quote'    => 'برای من ورزش از یک تصمیم کوچک شروع شد؛ همان روزی که تصمیم گرفتم صبح‌ها با خودم مهربان‌تر باشم.',
			'image'    => 'category-women.jpg',
			'product'  => 'nike-one',
			'content'  => '<p>سارا سه سال است پیلاتس کار می‌کند. اولش فقط می‌خواست کمی حرکت کند و از پشت میز بلند شود؛ اما حالا صبح‌ها قبل از هر کاری، ده دقیقه برای خودش وقت می‌گذارد.</p><h2>باشگاه، جای رقابت نیست</h2><p>«یاد گرفتم به بدنم گوش کنم. لازم نیست هر روز بهترین باشم؛ کافی است هر روز حاضر باشم.»</p><p>انتخاب لگ و تاپ مناسب، برای او بخشی از همین مسیر بوده است؛ چیزی که راحت باشد و اجازه دهد روی حرکت تمرکز کند.</p>',
			'position' => '50% 32%',
		),
		array(
			'slug'     => 'amir-running',
			'title'    => 'یک کیلومتر بیشتر، هر هفته',
			'name'     => 'امیر',
			'activity' => 'دویدن',
			'initial'  => 'ا',
			'category' => 'مسیرهای تازه',
			'quote'    => 'هر هفته یک کیلومتر اضافه کردم. نه برای رکورد؛ برای این که ببینم می‌توانم.',
			'image'    => 'running-campaign.jpg',
			'product'  => 'pegasus-41',
			'content'  => '<p>امیر کارمند است و بعد از ساعت کاری می‌دود. شروعش سخت بود؛ اما برنامه‌ای ساده برای خودش ساخت: سه جلسه در هفته و هر هفته کمی بیشتر.</p><h2>مسیر مهم نیست</h2><p>«وقتی به خودت قول می‌دهی و عمل می‌کنی، اعتماد به نفس دیگری پیدا می‌کنی. حالا روزهایی که نمی‌دوم، دلم برای مسیر تنگ می‌شود.»</p><p>کفش مناسب، برای او تفاوت بین یک دویدن دلچسب و یک تجربهٔ خسته‌کننده بوده است.</p>',
			'position' => '50% 40%',
		),
		array(
			'slug'     => 'nazanin-strength',
			'title'    => 'قوی‌تر از دیروز',
			'name'     => 'نازنین',
			'activity' => 'تمرین قدرتی',
			'initial'  => 'ن',
			'category' => 'قدرت، در راحتی',
			'quote'    => 'قدرت فقط وزنه زدن نیست؛ این است که بدانی چقدر می‌توانی و چقدر می‌خواهی.',
			'image'    => 'hero-strength.jpg',
			'product'  => 'adidas-response',
			'content'  => '<p>نازنین از تمرین‌های خانگی شروع کرد و بعد به باشگاه رفت. برایش مهم بود لباسی پیدا کند که در حرکت‌های سنگین محدودش نکند.</p><h2>حرکت، با اعتماد</h2><p>«اولش نگران قضاوت بودم. بعد فهمیدم هر کسی آنجا با خودش درگیر است. حالا تمرین برایم مثل یک قرار ثابت با خودم است.»</p>',
			'position' => '50% 28%',
		),
		array(
			'slug'     => 'reza-weekend',
			'title'    => 'آخر هفته‌ها، وقت حرکت است',
			'name'     => 'رضا',
			'activity' => 'کوه‌پیمایی و پیاده‌روی',
			'initial'  => 'ر',
			'category' => 'به سبک خودت',
			'quote'    => 'برای من ورزش یعنی وقت گذاشتن برای چیزهایی که واقعاً دوستشان دارم.',
			'image'    => 'category-men.jpg',
			'product'  => 'nike-brasilia',
			'content'  => '<p>رضا آخر هفته‌ها با دوستانش به کوه می‌رود. تجهیزاتش ساده است: یک کوله، یک بطری و کفشی که سال‌ها همراه او بوده.</p><p>«لازم نیست حرفه‌ای باشی. کافی است از خانه بیرون بزنی و مسیر خودت را پیدا کنی.»</p>',
			'position' => '50% 35%',
		),
		array(
			'slug'     => 'mahsa-yoga',
			'title'    => 'نفس بکش، دوباره شروع کن',
			'name'     => 'مهسا',
			'activity' => 'یوگا',
			'initial'  => 'م',
			'category' => 'آرامش در حرکت',
			'quote'    => 'یوگا به من یاد داد که لازم نیست همیشه بدوم؛ بعضی وقت‌ها فقط باید نفس بکشم.',
			'image'    => 'journal-training.jpg',
			'product'  => 'nike-swoosh',
			'content'  => '<p>مهسا بعد از یک دورهٔ پرمشغله تصمیم گرفت آرام‌تر حرکت کند. یوگا شد راهی برای برگشتن به بدن و ذهن خودش.</p><p>«هر جلسه یک شروع تازه‌است. مهم نیست دیروز چطور بود؛ امروز فقط روی نفسم تمرکز می‌کنم.»</p>',
			'position' => '50% 30%',
		),
	);

	foreach ( $stories as $story ) {
		$image_id = sportmall_demo_attachment( $story['image'] );
		$post_id  = sportmall_demo_post(
			array(
				'post_type'    => 'sm_story',
				'post_status'  => 'publish',
				'post_title'   => $story['title'],
				'post_name'    => $story['slug'],
				'post_excerpt' => $story['quote'],
				'post_content' => $story['content'],
			),
			array(
				'_sm_name'     => $story['name'],
				'_sm_activity' => $story['activity'],
				'_sm_initial'  => $story['initial'],
				'_sm_category' => $story['category'],
				'_sm_quote'    => $story['quote'],
				'_sm_product'  => isset( $product_ids[ $story['product'] ] ) ? $product_ids[ $story['product'] ] : 0,
				'_sm_position' => $story['position'],
			)
		);
		if ( $post_id && $image_id ) {
			set_post_thumbnail( $post_id, $image_id );
		}
	}

	/* ---------------------------------------------------------------- Posts */
	$blog_categories = array(
		'guides'   => 'راهنمای خرید',
		'training' => 'تمرین',
		'style'    => 'استایل',
	);
	$blog_category_ids = array();
	foreach ( $blog_categories as $slug => $name ) {
		$blog_category_ids[ $slug ] = sportmall_demo_term( 'category', $name, $slug );
	}

	$posts = array(
		array(
			'slug'     => 'choosing-running-shoes',
			'title'    => 'چطور کفش دویدن درست را انتخاب کنیم؟',
			'excerpt'  => 'از نوع قدم تا اندازهٔ کفش؛ راهنمای ساده برای انتخابی که ماه‌ها همراهت می‌ماند.',
			'image'    => 'journal-running.jpg',
			'category' => 'guides',
			'content'  => '<p>کفش دویدن، مهم‌ترین تجهیزات هر دونده است. اما لازم نیست پیچیدهاش کنی. سه پرسش ساده می‌تواند انتخاب را روشن کند: کجا می‌دوی، چقدر می‌دوی و قدمت چگونه است؟</p><h2>۱. نوع قدمت را بشناس</h2><p>اگر پاهایت هنگام دویدن به داخل می‌چرخد، کفشی با پایداری متوسط انتخاب کن. اگر قدم خنثی داری، کفش نرم و سبک معمولاً انتخاب بهتری است.</p><h2>۲. اندازه را با جوراب امتحان کن</h2><p>همیشه با همان جورابی کفش را پرو کن که قرار است با آن بدوی. نیم تا یک سایز فضای اضافه در پنجه، برای تورم طبیعی پا مفید است.</p><h2>۳. تعادل بین نرمی و بازخورد</h2><p>کفش خیلی نرم برای مسیرهای طولانی راحت است؛ اما برای تمرین‌های سرعتی، کفشی با بازخورد بیشتر بهتر عمل می‌کند.</p><blockquote>قانون طلایی: کفشی که در فروشگاه راحت است، همیشه در مسیر هم راحت نیست. اگر امکان دارد، چند دقیقه راه برو و قدمت را حس کن.</blockquote><p>در اسپرت‌مال می‌توانی بین مدل‌های همه‌کاره و تخصصی انتخاب کنی؛ اگر مطمئن نیستی، راهنمای سایز و تیم پشتیبانی کنارت هستند.</p>',
		),
		array(
			'slug'     => 'morning-workout-habits',
			'title'    => 'عادت صبحگاهی؛ سه قدم برای شروع',
			'excerpt'  => 'لازم نیست قهرمان بیدار شوی. یک برنامهٔ کوتاه و واقعی، بهترین شروع است.',
			'image'    => 'journal-training.jpg',
			'category' => 'training',
			'content'  => '<p>صبح‌ها برای بسیاری از ما شلوغ‌ترین بخش روز است. اما همان‌جا هم می‌توان یک عادت کوچک ساخت؛ عادتی که به کل روز شکل می‌دهد.</p><h2>قدم اول: لباس را شب قبل آماده کن</h2><p>وقتی صبح بیدار می‌شوی و لباس ورزشی آماده است، یک مانع کمتر داری. این تصمیم کوچک، احتمال حرکت را بیشتر می‌کند.</p><h2>قدم دوم: ده دقیقه کافی است</h2><p>شروع با ده دقیقه حرکت کششی، پیاده‌روی سریع یا چند تمرین ساده، بهتر از یک برنامهٔ سنگین است که هیچ‌وقت اجرا نشود.</p><h2>قدم سوم: به خودت جایزه بده</h2><p>بعد از تمرین، یک صبحانهٔ خوب یا چند دقیقه سکوت و قهوه؛ هر چیزی که مغزت آن را به عنوان پاداش بشناسد.</p><p>پایداری از شدت مهم‌تر است. بدن تو با تکرار، قوی‌تر می‌شود؛ نه با یک روز قهرمانانه.</p>',
		),
		array(
			'slug'     => 'training-outfit-guide',
			'title'    => 'راهنمای ست کردن لباس تمرین',
			'excerpt'  => 'از رنگ‌های خنثی تا لایه‌های سبک؛ چطور یک ست راحت و هماهنگ بسازیم؟',
			'image'    => 'category-women.jpg',
			'category' => 'style',
			'content'  => '<p>ست ورزشی خوب، فقط زیبا نیست؛ باید در حرکت هم راحت باشد. بهترین ترکیب‌ها معمولاً از دو یا سه رنگ خنثی و یک رنگ تأکید ساخته می‌شوند.</p><h2>لایه‌ها را جدی بگیر</h2><p>یک تی‌شرت سبک، یک لگ یا شورت و یک لایهٔ نازک برای بعد از تمرین. این ترکیب در بیشتر فصل‌ها جواب می‌دهد.</p><h2>رنگ‌ها را محدود کن</h2><p>مشکی، سفید، خاکستری و سبز زیتونی پایه‌های خوبی هستند. یک رنگ گرم مثل مرجانی یا نارنجی می‌تواند نقطهٔ تمرکز ست باشد.</p><h2>کفش را فراموش نکن</h2><p>کفش تمرین باید پایداری داشته باشد؛ کفش دویدن برای مسیر و کفش باشگاه برای حرکت‌های جانبی. اگر فقط یک جفت داری، یک مدل همه‌کاره انتخاب کن.</p><p>در بخش ست‌های ورزشی، ترکیب‌های آماده را ببین و با یک کلیک آیتم‌ها را جداگانه انتخاب کن.</p>',
		),
		array(
			'slug'     => 'first-week-gym',
			'title'    => 'هفتهٔ اول باشگاه؛ چه انتظاری داشته باشیم؟',
			'excerpt'  => 'یک راهنمای واقعی برای کسی که تازه تصمیم گرفته شروع کند.',
			'image'    => 'running-campaign.jpg',
			'category' => 'training',
			'content'  => '<p>هفتهٔ اول همیشه سخت‌ترین و در عین حال مهم‌ترین هفته است. هدف این هفته، ساختن رکورد نیست؛ پیدا کردن ریتم است.</p><h2>با برنامهٔ ساده شروع کن</h2><p>دو یا سه جلسه در هفته کافی است. هر جلسه ۳۰ تا ۴۰ دقیقه، با تمرین‌های پایه و استراحت کافی.</p><h2>به بدن گوش کن</h2><p>درد عضلانی خفیف طبیعی است؛ درد تیز و مفصلی نه. اگر جایی درد گرفت، متوقف شو و از مربی کمک بخواه.</p><h2>لباس و کفش مناسب</h2><p>لباس راحت و کفش پایدار، اعتماد به نفس را در حرکت بیشتر می‌کند. بطری آب و حولهٔ کوچک را هم فراموش نکن.</p><p>مهم‌ترین چیز این است که برگردی؛ حتی اگر جلسهٔ دوم کوتاه‌تر باشد.</p>',
		),
	);

	$post_index = 0;
	foreach ( $posts as $post ) {
		$image_id = sportmall_demo_attachment( $post['image'] );
		$post_id  = sportmall_demo_post(
			array(
				'post_type'     => 'post',
				'post_status'   => 'publish',
				'post_title'    => $post['title'],
				'post_name'     => $post['slug'],
				'post_excerpt'  => $post['excerpt'],
				'post_content'  => $post['content'],
				'post_category' => array( (int) $blog_category_ids[ $post['category'] ] ),
				'post_date'     => gmdate( 'Y-m-d H:i:s', time() - ( $post_index * 3 * DAY_IN_SECONDS ) ),
			),
			array()
		);
		if ( $post_id && $image_id ) {
			set_post_thumbnail( $post_id, $image_id );
		}
		++$post_index;
	}

	/* ---------------------------------------------------------------- Pages */
	$home_id = 0;
	$journal_id = 0;

	$pages = array(
		'home' => array(
			'title'    => 'خانه',
			'template' => '',
			'content'  => '',
		),
		'journal' => array(
			'title'    => 'ژورنال',
			'template' => '',
			'content'  => '',
		),
		'about' => array(
			'title'    => 'درباره اسپرت‌مال',
			'template' => '',
			'content'  => '<h2>ما برای حرکت ساخته شده‌ایم</h2><p>اسپرت‌مال از یک باور ساده شروع شد: ورزش نباید پیچیده باشد. ما انتخاب‌های ورزشی را جمع می‌کنیم تا پیدا کردن لباس، کفش و تجهیزات مناسب، ساده‌تر و لذت‌بخش‌تر شود.</p><p>از یک پیاده‌روی صبحگاهی تا تمرین سخت باشگاه، هر حرکت یک شروع است. ما کنار تو هستیم تا آن شروع، ادامه پیدا کند.</p><h2>چه چیزی ما را متفاوت می‌کند؟</h2><ul><li>انتخاب‌های محدود اما دقیق؛ نه فهرست بی‌پایان.</li><li>راهنمای سایز و خرید، قبل از هر سفارش.</li><li>بازگشت آسان و پشتیبانی واقعی.</li><li>محتوای آموزشی برای انتخاب بهتر.</li></ul><p>ممنون که این مسیر را با ما می‌روی.</p>',
		),
		'shipping' => array(
			'title'    => 'ارسال سفارش',
			'template' => '',
			'content'  => '<h2>ارسال سریع، در تمام ایران</h2><p>سفارش‌های ثبت‌شده تا ساعت ۱۴ در روزهای کاری، همان روز آماده‌سازی می‌شوند. زمان رسیدن بسته به شهر مقصد بین ۱ تا ۴ روز کاری است.</p><h2>هزینهٔ ارسال</h2><ul><li>سفارش‌های بالای ۲ میلیون تومان: ارسال رایگان.</li><li>سفارش‌های کمتر از ۲ میلیون تومان: هزینهٔ ارسال بر اساس مقصد محاسبه می‌شود.</li><li>تهران و کرج: امکان ارسال سریع در همان روز.</li></ul><h2>پیگیری سفارش</h2><p>بعد از ارسال، کد پیگیری از طریق پیامک برای تو فرستاده می‌شود. همچنین می‌توانی از بخش «حساب کاربری > سفارش‌ها» وضعیت سفارش را ببینی.</p>',
		),
		'size-guide' => array(
			'title'    => 'راهنمای سایز',
			'template' => '',
			'content'  => '<h2>سایز مناسب، حس بهتر</h2><p>اندازه‌ها ممکن است بین برندها کمی متفاوت باشند. با اندازه‌گیری دقیق و مقایسه با جدول زیر، انتخاب مطمئن‌تری داشته باش.</p><h3>پوشاک</h3><table><thead><tr><th>سایز</th><th>دور سینه (سانتی‌متر)</th><th>دور کمر</th></tr></thead><tbody><tr><td>S</td><td>۸۶–۹۱</td><td>۷۱–۷۶</td></tr><tr><td>M</td><td>۹۲–۹۷</td><td>۷۷–۸۲</td></tr><tr><td>L</td><td>۹۸–۱۰۳</td><td>۸۳–۸۸</td></tr><tr><td>XL</td><td>۱۰۴–۱۰۹</td><td>۸۹–۹۴</td></tr></tbody></table><h3>کفش</h3><p>طول پا را در پایان روز اندازه بگیر و به آن نیم سایز اضافه کن. اگر بین دو سایز هستی، سایز بزرگ‌تر را انتخاب کن.</p><p>اگر در انتخاب سایز شک داری، با پشتیبانی تماس بگیر؛ تعویض سایز رایگان است.</p>',
		),
		'returns' => array(
			'title'    => 'بازگشت و تعویض',
			'template' => '',
			'content'  => '<h2>خرید بدون نگرانی</h2><p>تا ۷ روز پس از دریافت سفارش، می‌توانی کالای استفاده‌نشده را با بسته‌بندی اصلی برای تعویض یا بازگشت ثبت کنی.</p><h2>شرایط بازگشت</h2><ul><li>کالا استفاده نشده و برچسب آن سالم باشد.</li><li>بسته‌بندی و متعلقات کامل باشد.</li><li>شمارهٔ سفارش را همراه داشته باشی.</li></ul><h2>مراحل</h2><ol><li>از بخش «حساب کاربری» درخواست بازگشت ثبت کن.</li><li>همکاران ما درخواست را بررسی می‌کنند.</li><li>پس از تأیید، هزینه به حساب یا کیف پول تو برمی‌گردد.</li></ol><p>برای کالاهای معیوب یا اشتباه ارسال‌شده، هزینهٔ ارسال با ماست.</p>',
		),
		'faq' => array(
			'title'    => 'پرسش‌های پرتکرار',
			'template' => '',
			'content'  => '<h2>سفارش و پرداخت</h2><h3>آیا امکان پرداخت در محل وجود دارد؟</h3><p>بله، برای برخی شهرها امکان پرداخت در محل فعال است؛ در صفحهٔ تکمیل سفارش، گزینه‌های موجود را می‌بینی.</p><h3>چطور کد تخفیف را اعمال کنم؟</h3><p>در صفحهٔ سبد خرید، بخش «کد تخفیف داری؟» را باز کن و کد را وارد کن.</p><h2>اندازه و انتخاب</h2><h3>اگر سایز مناسب نبود چه کنم؟</h3><p>اولین تعویض سایز رایگان است. کافی است تا ۷ روز درخواست ثبت کنی.</p><h3>محصولات اورجینال هستند؟</h3><p>همهٔ محصولات از تأمین‌کننده‌های معتبر تهیه می‌شوند و راهنمای اصالت در صفحهٔ محصول ارائه می‌شود.</p><h2>حساب کاربری</h2><h3>رمز عبورم را فراموش کرده‌ام.</h3><p>از صفحهٔ ورود، روی «رمز عبورت را فراموش کردی؟» بزن تا لینک بازیابی برایت ارسال شود.</p>',
		),
		'privacy' => array(
			'title'    => 'حریم خصوصی',
			'template' => '',
			'content'  => '<h2>حریم خصوصی تو برای ما مهم است</h2><p>اطلاعاتی که در هنگام خرید وارد می‌کنی، فقط برای پردازش سفارش، ارسال و پشتیبانی استفاده می‌شود. ما اطلاعات تو را به فروش نمی‌رسانیم.</p><h2>چه اطلاعاتی ذخیره می‌شود؟</h2><ul><li>نام و اطلاعات تماس برای ارسال سفارش.</li><li>نشانی و کد پستی برای تحویل.</li><li>سابقهٔ سفارش برای پشتیبانی و بازگشت کالا.</li></ul><h2>کوکی‌ها</h2><p>برای نگه‌داشتن سبد خرید و علاقه‌مندی‌ها از کوکی و حافظهٔ محلی مرورگر استفاده می‌کنیم. می‌توانی هر زمان آن‌ها را از تنظیمات مرورگر پاک کنی.</p>',
		),
		'contact' => array(
			'title'    => 'تماس با اسپرت‌مال',
			'template' => 'page-templates/contact.php',
			'content'  => '<p>سؤالی دربارهٔ سایز، سفارش یا انتخاب محصول داری؟ تیم ما در روزهای کاری از ۹ تا ۱۸ پاسخ می‌دهد.</p>',
		),
		'wishlist' => array(
			'title'    => 'علاقه‌مندی‌های من',
			'template' => 'page-templates/wishlist.php',
			'content'  => '',
		),
	);

	foreach ( $pages as $slug => $page ) {
		$existing = get_page_by_path( $slug );
		$page_id  = sportmall_demo_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $page['title'],
				'post_name'    => $slug,
				'post_content' => $page['content'],
			)
		);
		if ( ! $page_id ) {
			continue;
		}
		if ( $page['template'] ) {
			update_post_meta( $page_id, '_wp_page_template', $page['template'] );
		}
		if ( 'home' === $slug ) {
			$home_id = $page_id;
		}
		if ( 'journal' === $slug ) {
			$journal_id = $page_id;
		}
	}

	/* --------------------------------------------------------------- Reading */
	if ( $home_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}
	if ( $journal_id ) {
		update_option( 'page_for_posts', $journal_id );
	}

	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}

	$site_title = get_option( 'blogname' );
	if ( ! $site_title || in_array( $site_title, array( 'My WordPress', 'WordPress', 'My Blog' ), true ) ) {
		update_option( 'blogname', 'اسپرت‌مال' );
		update_option( 'blogdescription', 'حرکت، به سبک تو.' );
	}

	/* ------------------------------------------------------------ Woo config */
	if ( $has_woo ) {
		if ( in_array( get_option( 'woocommerce_currency' ), array( '', 'USD', 'IRT' ), true ) ) {
			update_option( 'woocommerce_currency', 'IRT' );
		}
		update_option( 'woocommerce_price_num_decimals', 0 );
		update_option( 'woocommerce_price_thousand_sep', ',' );
		update_option( 'woocommerce_price_decimal_sep', '.' );
		update_option( 'woocommerce_currency_pos', 'right_space' );
		update_option( 'woocommerce_weight_unit', 'kg' );
		update_option( 'woocommerce_dimension_unit', 'cm' );
		update_option( 'woocommerce_enable_reviews', 'yes' );
		update_option( 'woocommerce_enable_guest_checkout', 'yes' );
		update_option( 'woocommerce_calc_taxes', 'no' );
		update_option( 'woocommerce_default_country', 'IR' );
	}

	/* ---------------------------------------------------------------- Menus */
	$shop_url  = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
	$women_url = ! empty( $category_ids['women'] ) ? get_term_link( $category_ids['women'], 'product_cat' ) : $shop_url;
	$men_url   = ! empty( $category_ids['men'] ) ? get_term_link( $category_ids['men'], 'product_cat' ) : $shop_url;
	$shoes_url = ! empty( $category_ids['shoes'] ) ? get_term_link( $category_ids['shoes'], 'product_cat' ) : $shop_url;

	$menu_definitions = array(
		'footer_shop' => array(
			'name'  => 'منوی فوتر — خرید',
			'items' => array(
				array( 'همهٔ محصولات', $shop_url ),
				array( 'زنانه', $women_url ),
				array( 'مردانه', $men_url ),
				array( 'کفش ورزشی', $shoes_url ),
				array( 'حراجی', add_query_arg( 'on_sale', '1', $shop_url ) ),
			),
		),
		'footer_help' => array(
			'name'  => 'منوی فوتر — راهنما',
			'items' => array(
				array( 'تماس با ما', home_url( '/contact/' ) ),
				array( 'ارسال سفارش', home_url( '/shipping/' ) ),
				array( 'بازگشت و تعویض', home_url( '/returns/' ) ),
				array( 'راهنمای سایز', home_url( '/size-guide/' ) ),
				array( 'پرسش‌های پرتکرار', home_url( '/faq/' ) ),
			),
		),
		'footer_info' => array(
			'name'  => 'منوی فوتر — درباره',
			'items' => array(
				array( 'دربارهٔ اسپرت‌مال', home_url( '/about/' ) ),
				array( 'ژورنال', home_url( '/journal/' ) ),
				array( 'استوری مشتریان', home_url( '/stories/' ) ),
				array( 'حریم خصوصی', home_url( '/privacy/' ) ),
			),
		),
	);

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	foreach ( $menu_definitions as $location => $definition ) {
		$menu = wp_get_nav_menu_object( $definition['name'] );
		$menu_id = $menu ? (int) $menu->term_id : 0;

		if ( ! $menu_id ) {
			$menu_id = wp_create_nav_menu( $definition['name'] );
			if ( is_wp_error( $menu_id ) ) {
				continue;
			}
			foreach ( $definition['items'] as $item ) {
				if ( empty( $item[1] ) || is_wp_error( $item[1] ) ) {
					continue;
				}
				wp_update_nav_menu_item( $menu_id, 0, array(
					'menu-item-title'  => $item[0],
					'menu-item-url'    => $item[1],
					'menu-item-status' => 'publish',
					'menu-item-type'   => 'custom',
				) );
			}
		}

		$locations[ $location ] = $menu_id;
	}
	set_theme_mod( 'nav_menu_locations', $locations );

	/* --------------------------------------------------------------- Cleanup */
	wp_defer_term_counting( false );
	delete_transient( 'sportmall_demo_importing' );
	update_option( 'sportmall_demo_imported', time() );
	flush_rewrite_rules();

	return true;
}

/**
 * Admin notice inviting the user to import the demo.
 */
function sportmall_demo_admin_notice() {
	if ( ! current_user_can( 'edit_theme_options' ) || get_option( 'sportmall_demo_imported' ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( ! $screen || 'appearance_page_sportmall-demo' === $screen->id ) {
		return;
	}
	?>
	<div class="notice notice-info is-dismissible">
		<p>
			<?php esc_html_e( 'قالب اسپرت‌مال آماده است. برای ساخت محصولات، ست‌ها، استوری‌ها و برگه‌های نمونه یک کلیک فاصله داری.', 'sportmall' ); ?>
			<a href="<?php echo esc_url( admin_url( 'themes.php?page=sportmall-demo' ) ); ?>"><?php esc_html_e( 'ساخت محتوای نمونه', 'sportmall' ); ?></a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'sportmall_demo_admin_notice' );
