<?php
/**
 * Scrolling announcement bar.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$text = sportmall_mod( 'announcement_text' );
$link = sportmall_mod( 'announcement_link' );
if ( ! $text ) {
	return;
}
?>
<div class="announcement-bar" role="region" aria-label="<?php esc_attr_e( 'اعلان فروشگاه', 'sportmall' ); ?>">
	<div class="announcement-viewport">
		<div class="announcement-track" data-sm-marquee>
			<div class="announcement-group">
				<?php for ( $i = 0; $i < 4; $i++ ) : ?>
					<?php if ( $link ) : ?>
						<a class="announcement-item" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $text ); ?></a>
					<?php else : ?>
						<span class="announcement-item"><?php echo esc_html( $text ); ?></span>
					<?php endif; ?>
					<span class="announcement-separator" aria-hidden="true"></span>
				<?php endfor; ?>
			</div>
		</div>
	</div>
</div>
