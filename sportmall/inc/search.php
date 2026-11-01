<?php
/**
 * AJAX search suggestions and the localStorage wishlist bridge.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

/**
 * Product search suggestions.
 */
function sportmall_ajax_search() {
	check_ajax_referer( 'sportmall_ajax', 'nonce' );

	$term = isset( $_GET['term'] ) ? sanitize_text_field( wp_unslash( $_GET['term'] ) ) : '';
	$term_length = function_exists( 'mb_strlen' ) ? mb_strlen( $term ) : strlen( $term );
	if ( $term_length < 2 ) {
		wp_send_json_success( array( 'html' => '', 'total' => 0 ) );
	}

	$html  = '';
	$total = 0;

	if ( class_exists( 'WooCommerce' ) ) {
		$query = new WP_Query( array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			's'              => $term,
			'posts_per_page' => 5,
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'exclude-from-catalog',
					'operator' => 'NOT IN',
				),
			),
		) );

		$total = (int) $query->found_posts;
		foreach ( $query->posts as $post ) {
			$product = wc_get_product( $post->ID );
			if ( ! $product || ! $product->is_visible() ) {
				continue;
			}
			$image = $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'search-result-image', 'loading' => 'lazy' ) );
			$html .= '<a class="search-result" href="' . esc_url( get_permalink( $product->get_id() ) ) . '">';
			$html .= $image;
			$html .= '<span class="search-result-copy">' . esc_html( $product->get_name() ) . '<small>' . esc_html( sportmall_product_brand( $product ) ) . '</small></span>';
			$html .= '<span class="search-result-price">' . wp_kses_post( $product->get_price_html() ) . '</span>';
			$html .= '</a>';
		}
	}

	$posts_query = new WP_Query( array(
		'post_type'      => array( 'post', 'page' ),
		'post_status'    => 'publish',
		's'              => $term,
		'posts_per_page' => 3,
	) );
	$total      += (int) $posts_query->found_posts;
	foreach ( $posts_query->posts as $post ) {
		$html .= '<a class="search-result search-result--post" href="' . esc_url( get_permalink( $post ) ) . '">';
		$html .= '<span class="search-result-icon">' . sportmall_icon( 'arrow' ) . '</span>';
		$html .= '<span class="search-result-copy">' . esc_html( get_the_title( $post ) ) . '<small>' . esc_html( get_post_type_object( $post->post_type )->labels->singular_name ) . '</small></span>';
		$html .= '</a>';
	}

	$view_all = add_query_arg(
		array(
			's'         => $term,
			'post_type' => class_exists( 'WooCommerce' ) ? 'product' : 'post',
		),
		home_url( '/' )
	);

	wp_send_json_success( array(
		'html'    => $html,
		'total'   => $total,
		'viewAll' => $view_all,
	) );
}
add_action( 'wp_ajax_sportmall_search', 'sportmall_ajax_search' );
add_action( 'wp_ajax_nopriv_sportmall_search', 'sportmall_ajax_search' );

/**
 * Return rendered product cards for a set of wishlist IDs.
 */
function sportmall_ajax_wishlist() {
	check_ajax_referer( 'sportmall_ajax', 'nonce' );

	$ids = isset( $_POST['ids'] ) ? (array) wp_unslash( $_POST['ids'] ) : array();
	$ids = array_values( array_filter( array_map( 'absint', $ids ) ) );

	if ( empty( $ids ) || ! function_exists( 'wc_get_products' ) ) {
		wp_send_json_success( array( 'html' => '', 'count' => 0 ) );
	}

	$products = wc_get_products( array(
		'include' => array_slice( $ids, 0, 60 ),
		'limit'   => 60,
		'status'  => 'publish',
		'return'  => 'objects',
	) );

	ob_start();
	foreach ( $products as $product ) {
		if ( ! $product->is_visible() ) {
			continue;
		}
		get_template_part( 'template-parts/product/card', null, array( 'product' => $product ) );
	}
	$html = ob_get_clean();

	wp_send_json_success( array(
		'html'  => $html,
		'count' => count( $products ),
	) );
}
add_action( 'wp_ajax_sportmall_wishlist', 'sportmall_ajax_wishlist' );
add_action( 'wp_ajax_nopriv_sportmall_wishlist', 'sportmall_ajax_wishlist' );

/**
 * Allow searching products from the default search form on the front end.
 *
 * @param WP_Query $query Query.
 */
function sportmall_search_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_search() && ! empty( $_GET['post_type'] ) && 'product' === sanitize_key( wp_unslash( $_GET['post_type'] ) ) ) {
		$query->set( 'post_type', 'product' );
	}
}
add_action( 'pre_get_posts', 'sportmall_search_query' );
