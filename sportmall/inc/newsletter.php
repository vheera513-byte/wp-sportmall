<?php
/**
 * Lightweight newsletter form. Stores addresses locally and exposes a hook for
 * real newsletter services (Mailchimp, MailerLite, etc.).
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

/**
 * Handle the newsletter submission.
 */
function sportmall_handle_newsletter() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );

	if ( ! isset( $_POST['sportmall_newsletter_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['sportmall_newsletter_nonce'] ) ), 'sportmall_newsletter' ) ) {
		wp_safe_redirect( add_query_arg( 'sportmall_newsletter', 'invalid', $redirect ) );
		exit;
	}

	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	if ( ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'sportmall_newsletter', 'invalid', $redirect ) );
		exit;
	}

	$subscribers = get_option( 'sportmall_newsletter_subscribers', array() );
	if ( ! is_array( $subscribers ) ) {
		$subscribers = array();
	}

	$exists = false;
	foreach ( $subscribers as $subscriber ) {
		if ( isset( $subscriber['email'] ) && strtolower( $subscriber['email'] ) === strtolower( $email ) ) {
			$exists = true;
			break;
		}
	}

	if ( ! $exists ) {
		$subscribers[] = array(
			'email' => $email,
			'time'  => current_time( 'mysql' ),
		);
		update_option( 'sportmall_newsletter_subscribers', $subscribers, false );

		/**
		 * Fires after a visitor subscribes to the newsletter.
		 *
		 * @param string $email Subscriber email.
		 */
		do_action( 'sportmall_newsletter_subscribed', $email );

		$admin_email = get_option( 'admin_email' );
		if ( $admin_email ) {
			wp_mail(
				$admin_email,
				__( 'عضویت تازه در خبرنامه اسپرت‌مال', 'sportmall' ),
				sprintf(
					/* translators: %s: subscriber email. */
					__( 'ایمیل تازه در خبرنامه ثبت شد: %s', 'sportmall' ),
					$email
				)
			);
		}
	}

	wp_safe_redirect( add_query_arg( 'sportmall_newsletter', 'ok', $redirect ) );
	exit;
}
add_action( 'admin_post_sportmall_newsletter', 'sportmall_handle_newsletter' );
add_action( 'admin_post_nopriv_sportmall_newsletter', 'sportmall_handle_newsletter' );

/**
 * Return a status message for the newsletter form.
 *
 * @return array{type:string,message:string}|null
 */
function sportmall_newsletter_status() {
	if ( empty( $_GET['sportmall_newsletter'] ) ) {
		return null;
	}
	$state = sanitize_key( wp_unslash( $_GET['sportmall_newsletter'] ) );
	if ( 'ok' === $state ) {
		return array(
			'type'    => 'success',
			'message' => __( 'عضویت تو ثبت شد. خبرهای خوب به‌زودی می‌رسند.', 'sportmall' ),
		);
	}
	if ( 'invalid' === $state ) {
		return array(
			'type'    => 'error',
			'message' => __( 'ایمیل معتبر نیست یا اعتبار فرم تمام شده است. دوباره تلاش کن.', 'sportmall' ),
		);
	}
	return null;
}

/**
 * Add a subscribers page under Appearance.
 */
function sportmall_newsletter_admin_menu() {
	add_theme_page(
		__( 'خبرنامه اسپرت‌مال', 'sportmall' ),
		__( 'خبرنامه', 'sportmall' ),
		'manage_options',
		'sportmall-newsletter',
		'sportmall_newsletter_admin_page'
	);
}
add_action( 'admin_menu', 'sportmall_newsletter_admin_menu' );

/**
 * Render the subscribers page.
 */
function sportmall_newsletter_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$subscribers = get_option( 'sportmall_newsletter_subscribers', array() );
	if ( ! is_array( $subscribers ) ) {
		$subscribers = array();
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'خبرنامه اسپرت‌مال', 'sportmall' ); ?></h1>
		<p><?php esc_html_e( 'ایمیل‌هایی که از فرم خبرنامه ثبت شده‌اند. برای اتصال به سرویس حرفه‌ای، از اکشن sportmall_newsletter_subscribed استفاده کنید.', 'sportmall' ); ?></p>
		<?php if ( empty( $subscribers ) ) : ?>
			<p><strong><?php esc_html_e( 'هنوز عضوی ثبت نشده است.', 'sportmall' ); ?></strong></p>
		<?php else : ?>
			<table class="widefat striped">
				<thead><tr><th><?php esc_html_e( 'ایمیل', 'sportmall' ); ?></th><th><?php esc_html_e( 'زمان', 'sportmall' ); ?></th></tr></thead>
				<tbody>
					<?php foreach ( $subscribers as $subscriber ) : ?>
						<tr>
							<td><?php echo esc_html( isset( $subscriber['email'] ) ? $subscriber['email'] : '' ); ?></td>
							<td><?php echo esc_html( isset( $subscriber['time'] ) ? $subscriber['time'] : '' ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin-top:16px">
				<input type="hidden" name="action" value="sportmall_export_newsletter">
				<?php wp_nonce_field( 'sportmall_export_newsletter', 'sportmall_export_nonce' ); ?>
				<button class="button"><?php esc_html_e( 'دریافت فایل CSV', 'sportmall' ); ?></button>
			</form>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Export subscribers to CSV.
 */
function sportmall_export_newsletter() {
	if ( ! current_user_can( 'manage_options' ) || ! isset( $_POST['sportmall_export_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['sportmall_export_nonce'] ) ), 'sportmall_export_newsletter' ) ) {
		wp_die( esc_html__( 'دسترسی مجاز نیست.', 'sportmall' ) );
	}
	$subscribers = get_option( 'sportmall_newsletter_subscribers', array() );
	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=sportmall-newsletter.csv' );
	$output = fopen( 'php://output', 'w' );
	fwrite( $output, "\xEF\xBB\xBF" );
	fputcsv( $output, array( 'email', 'time' ) );
	foreach ( (array) $subscribers as $subscriber ) {
		fputcsv( $output, array( $subscriber['email'], $subscriber['time'] ) );
	}
	fclose( $output );
	exit;
}
add_action( 'admin_post_sportmall_export_newsletter', 'sportmall_export_newsletter' );
