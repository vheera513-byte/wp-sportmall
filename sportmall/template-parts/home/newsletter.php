<?php
/**
 * Newsletter form.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$status = sportmall_newsletter_status();
$email  = '';
if ( is_user_logged_in() ) {
	$user  = wp_get_current_user();
	$email = $user->user_email;
}
?>
<section class="newsletter" aria-labelledby="newsletter-title">
	<div>
		<div class="newsletter-eyebrow"><?php echo esc_html( sportmall_mod( 'newsletter_eyebrow' ) ); ?></div>
		<h2 id="newsletter-title" class="post-title"><?php echo esc_html( sportmall_mod( 'newsletter_title' ) ); ?></h2>
		<p><?php echo esc_html( sportmall_mod( 'newsletter_text' ) ); ?></p>
	</div>
	<form class="newsletter-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="sportmall_newsletter">
		<?php wp_nonce_field( 'sportmall_newsletter', 'sportmall_newsletter_nonce' ); ?>
		<div class="newsletter-form-field">
			<input id="newsletter-email" type="email" name="email" value="<?php echo esc_attr( $email ); ?>" placeholder="<?php esc_attr_e( 'ایمیل تو', 'sportmall' ); ?>" aria-label="<?php esc_attr_e( 'آدرس ایمیل برای خبرنامه', 'sportmall' ); ?>" required autocomplete="email" maxlength="254">
			<button type="submit"><?php esc_html_e( 'همراه می‌شوم', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></button>
		</div>
		<small><?php echo esc_html( sportmall_mod( 'newsletter_note' ) ); ?></small>
		<?php if ( $status ) : ?>
			<p class="newsletter-status is-<?php echo esc_attr( $status['type'] ); ?>" role="status"><?php echo esc_html( $status['message'] ); ?></p>
		<?php endif; ?>
	</form>
</section>
