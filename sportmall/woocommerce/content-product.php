<?php
/**
 * Product card inside WooCommerce loops.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

sportmall_product_card( $product, array( 'tag' => 'li' ) );
