<?php
/**
 * Customer stories and curated outfits (editorial content types).
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the editorial post types.
 */
function sportmall_register_editorial_types() {
	register_post_type( 'sm_story', array(
		'labels' => array(
			'name'          => __( 'استوری مشتریان', 'sportmall' ),
			'singular_name' => __( 'استوری', 'sportmall' ),
			'add_new'       => __( 'استوری تازه', 'sportmall' ),
			'add_new_item'  => __( 'افزودن استوری تازه', 'sportmall' ),
			'edit_item'     => __( 'ویرایش استوری', 'sportmall' ),
			'view_item'     => __( 'دیدن استوری', 'sportmall' ),
			'search_items'  => __( 'جستجوی استوری', 'sportmall' ),
			'not_found'     => __( 'استوری‌ای پیدا نشد.', 'sportmall' ),
		),
		'public'        => true,
		'has_archive'   => 'stories',
		'rewrite'       => array( 'slug' => 'stories', 'with_front' => false ),
		'menu_icon'     => 'dashicons-format-quote',
		'menu_position' => 21,
		'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'show_in_rest'  => true,
	) );

	register_post_type( 'sm_outfit', array(
		'labels' => array(
			'name'          => __( 'ست‌های ورزشی', 'sportmall' ),
			'singular_name' => __( 'ست', 'sportmall' ),
			'add_new'       => __( 'ست تازه', 'sportmall' ),
			'add_new_item'  => __( 'افزودن ست تازه', 'sportmall' ),
			'edit_item'     => __( 'ویرایش ست', 'sportmall' ),
			'view_item'     => __( 'دیدن ست', 'sportmall' ),
			'search_items'  => __( 'جستجوی ست', 'sportmall' ),
			'not_found'     => __( 'ستی پیدا نشد.', 'sportmall' ),
		),
		'public'        => true,
		'has_archive'   => 'outfits',
		'rewrite'       => array( 'slug' => 'outfits', 'with_front' => false ),
		'menu_icon'     => 'dashicons-tag',
		'menu_position' => 22,
		'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'show_in_rest'  => true,
	) );
}
add_action( 'init', 'sportmall_register_editorial_types' );

/**
 * Flush rewrite rules once when the theme is activated.
 */
function sportmall_flush_rewrites() {
	sportmall_register_editorial_types();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'sportmall_flush_rewrites' );

/**
 * Register meta boxes.
 */
function sportmall_add_meta_boxes() {
	add_meta_box(
		'sportmall_story_meta',
		__( 'جزئیات استوری', 'sportmall' ),
		'sportmall_story_meta_box',
		'sm_story',
		'normal',
		'high'
	);
	add_meta_box(
		'sportmall_outfit_meta',
		__( 'جزئیات ست', 'sportmall' ),
		'sportmall_outfit_meta_box',
		'sm_outfit',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'sportmall_add_meta_boxes' );

/**
 * Story meta box.
 *
 * @param WP_Post $post Post.
 */
function sportmall_story_meta_box( $post ) {
	wp_nonce_field( 'sportmall_save_meta', 'sportmall_meta_nonce' );

	$name     = get_post_meta( $post->ID, '_sm_name', true );
	$activity = get_post_meta( $post->ID, '_sm_activity', true );
	$initial  = get_post_meta( $post->ID, '_sm_initial', true );
	$quote    = get_post_meta( $post->ID, '_sm_quote', true );
	$category = get_post_meta( $post->ID, '_sm_category', true );
	$product  = (int) get_post_meta( $post->ID, '_sm_product', true );
	$position = get_post_meta( $post->ID, '_sm_position', true );

	$products = function_exists( 'wc_get_products' ) ? wc_get_products( array( 'limit' => 200, 'status' => 'publish', 'return' => 'objects' ) ) : array();
	?>
	<div class="sportmall-meta-grid">
		<p>
			<label for="sm_name"><strong><?php esc_html_e( 'نام مشتری', 'sportmall' ); ?></strong></label>
			<input type="text" id="sm_name" name="sm_name" value="<?php echo esc_attr( $name ); ?>" class="widefat">
		</p>
		<p>
			<label for="sm_activity"><strong><?php esc_html_e( 'ورزش / فعالیت', 'sportmall' ); ?></strong></label>
			<input type="text" id="sm_activity" name="sm_activity" value="<?php echo esc_attr( $activity ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'پیلاتس و تمرین', 'sportmall' ); ?>">
		</p>
		<p>
			<label for="sm_initial"><strong><?php esc_html_e( 'حرف اول نام', 'sportmall' ); ?></strong></label>
			<input type="text" id="sm_initial" name="sm_initial" value="<?php echo esc_attr( $initial ); ?>" class="widefat" maxlength="4">
		</p>
		<p>
			<label for="sm_category"><strong><?php esc_html_e( 'برچسب بالای عنوان', 'sportmall' ); ?></strong></label>
			<input type="text" id="sm_category" name="sm_category" value="<?php echo esc_attr( $category ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'از انتخاب تا اولین تمرین', 'sportmall' ); ?>">
		</p>
		<p>
			<label for="sm_product"><strong><?php esc_html_e( 'محصول همراه استوری', 'sportmall' ); ?></strong></label>
			<select id="sm_product" name="sm_product" class="widefat">
				<option value="0"><?php esc_html_e( '— انتخاب محصول —', 'sportmall' ); ?></option>
				<?php foreach ( $products as $product_option ) : ?>
					<option value="<?php echo esc_attr( $product_option->get_id() ); ?>" <?php selected( $product, $product_option->get_id() ); ?>><?php echo esc_html( $product_option->get_name() ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="sm_position"><strong><?php esc_html_e( 'موقعیت تصویر', 'sportmall' ); ?></strong></label>
			<input type="text" id="sm_position" name="sm_position" value="<?php echo esc_attr( $position ); ?>" class="widefat" placeholder="50% 32%">
			<span class="description"><?php esc_html_e( 'مقدار CSS object-position برای تصویر شاخص.', 'sportmall' ); ?></span>
		</p>
		<p class="widefat">
			<label for="sm_quote"><strong><?php esc_html_e( 'نقل‌قول کوتاه مشتری', 'sportmall' ); ?></strong></label>
			<textarea id="sm_quote" name="sm_quote" rows="4" class="widefat"><?php echo esc_textarea( $quote ); ?></textarea>
			<span class="description"><?php esc_html_e( 'در کارت استوری و بالای صفحهٔ استوری نمایش داده می‌شود.', 'sportmall' ); ?></span>
		</p>
	</div>
	<?php
}

/**
 * Outfit meta box.
 *
 * @param WP_Post $post Post.
 */
function sportmall_outfit_meta_box( $post ) {
	wp_nonce_field( 'sportmall_save_meta', 'sportmall_meta_nonce' );

	$edition     = get_post_meta( $post->ID, '_sm_edition', true );
	$name        = get_post_meta( $post->ID, '_sm_outfit_name', true );
	$description = get_post_meta( $post->ID, '_sm_description', true );
	$tags        = get_post_meta( $post->ID, '_sm_tags', true );
	$product_ids = array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $post->ID, '_sm_products', true ) ) ) );
	$position    = get_post_meta( $post->ID, '_sm_position', true );

	$products = function_exists( 'wc_get_products' ) ? wc_get_products( array( 'limit' => 200, 'status' => 'publish', 'return' => 'objects' ) ) : array();
	?>
	<div class="sportmall-meta-grid">
		<p>
			<label for="sm_edition"><strong><?php esc_html_e( 'کد ادیتوریال', 'sportmall' ); ?></strong></label>
			<input type="text" id="sm_edition" name="sm_edition" value="<?php echo esc_attr( $edition ); ?>" class="widefat" placeholder="01 / THE TRAINING EDIT">
		</p>
		<p>
			<label for="sm_outfit_name"><strong><?php esc_html_e( 'نام کوتاه ست', 'sportmall' ); ?></strong></label>
			<input type="text" id="sm_outfit_name" name="sm_outfit_name" value="<?php echo esc_attr( $name ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'تمرین روزانه', 'sportmall' ); ?>">
		</p>
		<p class="widefat">
			<label for="sm_description"><strong><?php esc_html_e( 'توضیح ست', 'sportmall' ); ?></strong></label>
			<textarea id="sm_description" name="sm_description" rows="3" class="widefat"><?php echo esc_textarea( $description ); ?></textarea>
		</p>
		<p class="widefat">
			<label for="sm_tags"><strong><?php esc_html_e( 'برچسب‌ها', 'sportmall' ); ?></strong></label>
			<input type="text" id="sm_tags" name="sm_tags" value="<?php echo esc_attr( $tags ); ?>" class="widefat" placeholder="<?php esc_attr_e( '۴ آیتم هماهنگ، تمرین و باشگاه', 'sportmall' ); ?>">
			<span class="description"><?php esc_html_e( 'برچسب‌ها را با ویرگول جدا کنید.', 'sportmall' ); ?></span>
		</p>
		<p class="widefat">
			<label for="sm_products"><strong><?php esc_html_e( 'محصولات ست', 'sportmall' ); ?></strong></label>
			<select id="sm_products" name="sm_products[]" multiple size="8" class="widefat">
				<?php foreach ( $products as $product_option ) : ?>
					<option value="<?php echo esc_attr( $product_option->get_id() ); ?>" <?php echo in_array( $product_option->get_id(), $product_ids, true ) ? 'selected' : ''; ?>><?php echo esc_html( $product_option->get_name() ); ?></option>
				<?php endforeach; ?>
			</select>
			<span class="description"><?php esc_html_e( 'برای انتخاب چند محصول، Ctrl (یا Command) را نگه دارید. ترتیب انتخاب، ترتیب نمایش روی برد است.', 'sportmall' ); ?></span>
		</p>
		<p>
			<label for="sm_position"><strong><?php esc_html_e( 'موقعیت تصویر', 'sportmall' ); ?></strong></label>
			<input type="text" id="sm_position" name="sm_position" value="<?php echo esc_attr( $position ); ?>" class="widefat" placeholder="50% 38%">
		</p>
	</div>
	<?php
}

/**
 * Save editorial meta.
 *
 * @param int $post_id Post ID.
 */
function sportmall_save_meta( $post_id ) {
	if ( ! isset( $_POST['sportmall_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['sportmall_meta_nonce'] ) ), 'sportmall_save_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$text_fields = array(
		'sm_name'        => '_sm_name',
		'sm_activity'    => '_sm_activity',
		'sm_initial'     => '_sm_initial',
		'sm_category'    => '_sm_category',
		'sm_position'    => '_sm_position',
		'sm_edition'     => '_sm_edition',
		'sm_outfit_name' => '_sm_outfit_name',
		'sm_tags'        => '_sm_tags',
		'sm_description' => '_sm_description',
		'sm_quote'       => '_sm_quote',
	);
	foreach ( $text_fields as $field => $meta_key ) {
		if ( isset( $_POST[ $field ] ) ) {
			$value = sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) );
			if ( $value ) {
				update_post_meta( $post_id, $meta_key, $value );
			} else {
				delete_post_meta( $post_id, $meta_key );
			}
		}
	}

	if ( isset( $_POST['sm_product'] ) ) {
		update_post_meta( $post_id, '_sm_product', absint( $_POST['sm_product'] ) );
	}

	if ( isset( $_POST['sm_products'] ) && is_array( $_POST['sm_products'] ) ) {
		$ids = array_map( 'absint', wp_unslash( $_POST['sm_products'] ) );
		update_post_meta( $post_id, '_sm_products', implode( ',', array_unique( array_filter( $ids ) ) ) );
	} else {
		delete_post_meta( $post_id, '_sm_products' );
	}
}
add_action( 'save_post_sm_story', 'sportmall_save_meta' );
add_action( 'save_post_sm_outfit', 'sportmall_save_meta' );

/**
 * Add story/outfit metadata columns in the admin list.
 *
 * @param array $columns Columns.
 * @return array
 */
function sportmall_editorial_admin_columns( $columns ) {
	$columns['sm_meta'] = __( 'جزئیات', 'sportmall' );
	return $columns;
}
add_filter( 'manage_sm_story_posts_columns', 'sportmall_editorial_admin_columns' );
add_filter( 'manage_sm_outfit_posts_columns', 'sportmall_editorial_admin_columns' );

/**
 * Render admin columns.
 *
 * @param string $column Column key.
 * @param int    $post_id Post ID.
 */
function sportmall_editorial_admin_column( $column, $post_id ) {
	if ( 'sm_meta' !== $column ) {
		return;
	}
	if ( 'sm_story' === get_post_type( $post_id ) ) {
		echo esc_html( trim( get_post_meta( $post_id, '_sm_name', true ) . ' — ' . get_post_meta( $post_id, '_sm_activity', true ), ' —' ) );
	} else {
		echo esc_html( get_post_meta( $post_id, '_sm_outfit_name', true ) );
	}
}
add_action( 'manage_sm_story_posts_custom_column', 'sportmall_editorial_admin_column', 10, 2 );
add_action( 'manage_sm_outfit_posts_custom_column', 'sportmall_editorial_admin_column', 10, 2 );

/**
 * Style the meta boxes a little.
 */
function sportmall_admin_styles() {
	$screen = get_current_screen();
	if ( $screen && in_array( $screen->post_type, array( 'sm_story', 'sm_outfit' ), true ) ) {
		echo '<style>.sportmall-meta-grid{display:grid;grid-template-columns:1fr 1fr;gap:0 24px}.sportmall-meta-grid .widefat{grid-column:1/-1}.sportmall-meta-grid label{display:block;margin-bottom:6px}.sportmall-meta-grid .description{display:block;margin-top:4px;color:#666}</style>';
	}
}
add_action( 'admin_head', 'sportmall_admin_styles' );
