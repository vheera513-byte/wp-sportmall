<?php
/**
 * Floating storefront header.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$variant   = isset( $args['variant'] ) ? $args['variant'] : 'solid';
$account   = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url();
$cart_url  = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/' );
$wishlist  = sportmall_wishlist_url();
$logo_id   = (int) get_theme_mod( 'custom_logo' );
?>
<header class="site-header site-header--<?php echo esc_attr( $variant ); ?>" data-sm-header>
	<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( sprintf( __( '%s، صفحه اصلی', 'sportmall' ), get_bloginfo( 'name' ) ) ); ?>">
		<?php if ( $logo_id ) : ?>
			<?php echo wp_get_attachment_image( $logo_id, 'medium', false, array( 'class' => 'brand-logo-img', 'alt' => get_bloginfo( 'name' ) ) ); ?>
		<?php else : ?>
			<?php bloginfo( 'name' ); ?>
		<?php endif; ?>
	</a>

	<?php sportmall_primary_nav(); ?>

	<div class="header-actions">
		<a href="#search" class="header-action header-action--search" data-sm-open="search" aria-label="<?php esc_attr_e( 'جستجو', 'sportmall' ); ?>" aria-controls="search-panel">
			<?php sportmall_the_icon( 'search' ); ?>
		</a>
		<a href="<?php echo esc_url( $account ); ?>" class="header-action header-action--account" aria-label="<?php esc_attr_e( 'حساب کاربری', 'sportmall' ); ?>">
			<?php sportmall_the_icon( 'user' ); ?>
		</a>
		<a href="<?php echo esc_url( $wishlist ); ?>" class="header-action header-action--wishlist" aria-label="<?php esc_attr_e( 'علاقه‌مندی‌ها', 'sportmall' ); ?>" data-sm-wishlist-link>
			<?php sportmall_the_icon( 'heart' ); ?>
			<span class="wishlist-badge" data-sm-wishlist-count hidden>۰</span>
		</a>
		<a href="<?php echo esc_url( $cart_url ); ?>" class="header-action header-action--cart" data-sm-open="cart" aria-controls="cart-panel" aria-haspopup="dialog" aria-label="<?php esc_attr_e( 'سبد خرید', 'sportmall' ); ?>">
			<?php if ( function_exists( 'sportmall_cart_count_html' ) ) : ?>
				<?php echo sportmall_cart_count_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php endif; ?>
			<?php sportmall_the_icon( 'bag' ); ?>
		</a>
	</div>

	<button class="mobile-menu" type="button" aria-label="<?php esc_attr_e( 'منو', 'sportmall' ); ?>" aria-expanded="false" aria-controls="main-nav" data-sm-menu>
		<svg viewBox="0 0 24 24" aria-hidden="true"><path class="i-open" d="M3 6h18M3 12h18M3 18h18"/><path class="i-close" d="M5 5l14 14M19 5 5 19"/></svg>
	</button>
</header>
