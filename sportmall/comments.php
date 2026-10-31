<?php
/**
 * Comments template.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$count = get_comments_number();
			echo esc_html( sprintf(
				/* translators: %s: comment count. */
				_n( '%s دیدگاه', '%s دیدگاه', $count, 'sportmall' ),
				sportmall_fa_digits( $count )
			) );
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 52,
			) );
			?>
		</ol>

		<?php
		the_comments_navigation( array(
			'prev_text' => sportmall_icon( 'chevron-right' ) . '<span>' . esc_html__( 'دیدگاه‌های قبلی', 'sportmall' ) . '</span>',
			'next_text' => '<span>' . esc_html__( 'دیدگاه‌های بعدی', 'sportmall' ) . '</span>' . sportmall_icon( 'chevron-left' ),
		) );
		?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'دیدگاه‌ها بسته شده‌اند.', 'sportmall' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form( array(
		'title_reply'         => __( 'دیدگاهت را بنویس', 'sportmall' ),
		'title_reply_before'  => '<h3 class="comment-reply-title">',
		'title_reply_after'   => '</h3>',
		'class_submit'        => 'accent-button',
		'comment_notes_before' => '<p class="comment-notes">' . esc_html__( 'ایمیل تو منتشر نمی‌شود. بخش‌های ضروری با ستاره مشخص شده‌اند.', 'sportmall' ) . '</p>',
		'comment_field'       => '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'دیدگاه', 'sportmall' ) . '</label><textarea id="comment" name="comment" cols="45" rows="6" required></textarea></p>',
		'label_submit'        => __( 'ارسال دیدگاه', 'sportmall' ),
	) );
	?>
</div>
