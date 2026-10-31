<?php
/**
 * Contact form handling.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

/**
 * Handle the contact form submission.
 */
function sportmall_handle_contact_form() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/contact/' );

	if (
		! isset( $_POST['sportmall_contact_nonce'] ) ||
		! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['sportmall_contact_nonce'] ) ), 'sportmall_contact' )
	) {
		wp_safe_redirect( add_query_arg( 'contact', 'error', remove_query_arg( 'contact', $redirect ) ) );
		exit;
	}

	// Honeypot: real visitors leave this empty.
	if ( ! empty( $_POST['sm_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'sent', remove_query_arg( 'contact', $redirect ) ) );
		exit;
	}

	$name    = isset( $_POST['sm_name'] ) ? sanitize_text_field( wp_unslash( $_POST['sm_name'] ) ) : '';
	$email   = isset( $_POST['sm_email'] ) ? sanitize_email( wp_unslash( $_POST['sm_email'] ) ) : '';
	$phone   = isset( $_POST['sm_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['sm_phone'] ) ) : '';
	$subject = isset( $_POST['sm_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['sm_subject'] ) ) : '';
	$order   = isset( $_POST['sm_order'] ) ? sanitize_text_field( wp_unslash( $_POST['sm_order'] ) ) : '';
	$message = isset( $_POST['sm_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['sm_message'] ) ) : '';

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'contact', 'invalid', remove_query_arg( 'contact', $redirect ) ) );
		exit;
	}

	$subject_labels = array(
		'order'   => __( 'پیگیری سفارش', 'sportmall' ),
		'size'    => __( 'راهنمای سایز', 'sportmall' ),
		'return'  => __( 'بازگشت یا تعویض', 'sportmall' ),
		'product' => __( 'انتخاب محصول', 'sportmall' ),
		'other'   => __( 'سایر', 'sportmall' ),
	);
	$subject_label = isset( $subject_labels[ $subject ] ) ? $subject_labels[ $subject ] : $subject_labels['other'];

	$body  = sprintf( "%s\n\n", __( 'پیام تازه از فرم تماس اسپرت‌مال', 'sportmall' ) );
	$body .= sprintf( "%s: %s\n", __( 'نام', 'sportmall' ), $name );
	$body .= sprintf( "%s: %s\n", __( 'ایمیل', 'sportmall' ), $email );
	if ( $phone ) {
		$body .= sprintf( "%s: %s\n", __( 'تلفن', 'sportmall' ), $phone );
	}
	$body .= sprintf( "%s: %s\n", __( 'موضوع', 'sportmall' ), $subject_label );
	if ( $order ) {
		$body .= sprintf( "%s: %s\n", __( 'شمارهٔ سفارش', 'sportmall' ), $order );
	}
	$body .= "\n" . $message . "\n";

	$sent = wp_mail(
		get_option( 'admin_email' ),
		sprintf( '[%s] %s', get_bloginfo( 'name' ), $subject_label ),
		$body,
		array( 'Reply-To: ' . $name . ' <' . $email . '>' )
	);

	wp_safe_redirect( add_query_arg( 'contact', $sent ? 'sent' : 'error', remove_query_arg( 'contact', $redirect ) ) );
	exit;
}
add_action( 'admin_post_sportmall_contact', 'sportmall_handle_contact_form' );
add_action( 'admin_post_nopriv_sportmall_contact', 'sportmall_handle_contact_form' );

/**
 * Print the contact form status message.
 */
function sportmall_contact_status() {
	$status = isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : '';
	if ( ! $status ) {
		return;
	}

	$messages = array(
		'sent'    => array( 'success', __( 'پیام تو رسید. در روزهای کاری، معمولاً در همان روز پاسخ می‌دهیم.', 'sportmall' ) ),
		'invalid' => array( 'error', __( 'نام، ایمیل و متن پیام را کامل وارد کن.', 'sportmall' ) ),
		'error'   => array( 'error', __( 'ارسال پیام انجام نشد. لطفاً دوباره تلاش کن یا مستقیم ایمیل بزن.', 'sportmall' ) ),
	);

	if ( ! isset( $messages[ $status ] ) ) {
		return;
	}

	printf(
		'<div class="contact-status is-%1$s" role="status">%2$s</div>',
		esc_attr( $messages[ $status ][0] ),
		esc_html( $messages[ $status ][1] )
	);
}
