<?php
/**
 * Service promises.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$services = sportmall_services();
if ( empty( $services ) ) {
	return;
}
?>
<div class="service-strip shell" aria-label="<?php esc_attr_e( 'خدمات اسپرت‌مال', 'sportmall' ); ?>">
	<?php foreach ( $services as $service ) : ?>
		<a class="service-item" href="<?php echo esc_url( $service['url'] ); ?>">
			<?php sportmall_the_icon( $service['icon'] ); ?>
			<span>
				<strong><?php echo esc_html( $service['title'] ); ?></strong>
				<small><?php echo esc_html( $service['text'] ); ?></small>
			</span>
		</a>
	<?php endforeach; ?>
</div>
