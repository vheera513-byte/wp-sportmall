<?php
/**
 * Site footer, global dialogs and newsletter.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;
?>
<?php
$sportmall_show_newsletter = ! ( function_exists( 'is_checkout' ) && ( is_checkout() || is_cart() ) );
if ( $sportmall_show_newsletter ) {
	get_template_part( 'template-parts/home/newsletter' );
}
?>

<footer class="site-footer" id="about">
	<div class="footer-main">
		<div class="footer-brand">
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			<p><?php echo wp_kses_post( sportmall_mod( 'footer_about' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php
			$socials = array(
				'instagram' => sportmall_mod( 'social_instagram' ),
				'telegram'  => sportmall_mod( 'social_telegram' ),
				'whatsapp'  => sportmall_mod( 'social_whatsapp' ),
				'youtube'   => sportmall_mod( 'social_youtube' ),
			);
			?>
			<?php if ( array_filter( $socials ) ) : ?>
				<div class="footer-social">
					<?php foreach ( $socials as $network => $url ) : ?>
						<?php if ( $url ) : ?>
							<a href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( ucfirst( $network ) ); ?>" target="_blank" rel="noopener"><?php sportmall_the_icon( $network ); ?></a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<div class="footer-social">
					<a href="<?php echo esc_url( sportmall_journal_url() ); ?>" aria-label="<?php esc_attr_e( 'ژورنال اسپرت‌مال', 'sportmall' ); ?>"><?php sportmall_the_icon( 'globe' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" aria-label="<?php esc_attr_e( 'تماس با اسپرت‌مال', 'sportmall' ); ?>"><?php sportmall_the_icon( 'mail' ); ?></a>
				</div>
			<?php endif; ?>
		</div>

		<div class="footer-col">
			<h3><?php esc_html_e( 'وقت حرکت است', 'sportmall' ); ?></h3>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'footer_shop',
				'container'      => false,
				'menu_class'     => 'footer-menu',
				'depth'          => 1,
				'fallback_cb'    => 'sportmall_menu_fallback',
			) );
			?>
		</div>

		<div class="footer-col">
			<h3><?php esc_html_e( 'کنارت هستیم', 'sportmall' ); ?></h3>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'footer_help',
				'container'      => false,
				'menu_class'     => 'footer-menu',
				'depth'          => 1,
				'fallback_cb'    => 'sportmall_menu_fallback',
			) );
			?>
		</div>

		<div class="footer-col">
			<h3><?php esc_html_e( 'با هم در ارتباط باشیم', 'sportmall' ); ?></h3>
			<p class="contact-label"><?php echo wp_kses_post( sportmall_mod( 'footer_contact' ) ); ?></p>
			<a class="footer-contact" href="<?php echo esc_url( sportmall_mod( 'footer_journal_url' ) ?: sportmall_journal_url() ); ?>"><?php echo esc_html( sportmall_mod( 'footer_journal' ) ); ?></a>
			<?php
			$contact_page = get_page_by_path( 'contact' );
			if ( $contact_page ) :
				?>
				<a class="footer-contact" href="<?php echo esc_url( get_permalink( $contact_page ) ); ?>"><?php esc_html_e( 'مرکز راهنمای خرید ←', 'sportmall' ); ?></a>
			<?php endif; ?>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'footer_info',
				'container'      => false,
				'menu_class'     => 'footer-menu',
				'depth'          => 1,
				'fallback_cb'    => false,
			) );
			?>
		</div>
	</div>

	<div class="footer-wordmark" aria-hidden="true"><span>SPORTMALL</span></div>

	<div class="footer-bottom">
		<p><?php echo wp_kses_post( sportmall_mod( 'footer_copyright' ) ); ?></p>
		<a class="back-top" href="#top"><?php esc_html_e( 'برگشت به بالا', 'sportmall' ); ?><?php sportmall_the_icon( 'up' ); ?></a>
	</div>
	<?php if ( sportmall_mod( 'footer_note' ) ) : ?>
		<p class="preview-note"><?php echo wp_kses_post( sportmall_mod( 'footer_note' ) ); ?></p>
	<?php endif; ?>
</footer>

<?php get_template_part( 'template-parts/header/search-dialog' ); ?>
<?php get_template_part( 'template-parts/header/cart-drawer' ); ?>

<div id="toast" class="toast" role="status" aria-live="polite"></div>

<?php wp_footer(); ?>
</body>
</html>
