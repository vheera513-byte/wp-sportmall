<?php
/**
 * Inner page hero.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$title    = isset( $args['title'] ) ? $args['title'] : get_the_title();
$eyebrow  = isset( $args['eyebrow'] ) ? $args['eyebrow'] : '';
$subtitle = isset( $args['subtitle'] ) ? $args['subtitle'] : '';
$classes  = isset( $args['class'] ) ? $args['class'] : '';
$compact  = ! empty( $args['compact'] );
?>
<section class="page-hero <?php echo esc_attr( $classes ); ?><?php echo $compact ? ' page-hero--compact' : ''; ?>">
	<div class="shell page-hero-inner">
		<?php sportmall_breadcrumbs(); ?>
		<?php if ( $eyebrow ) : ?>
			<p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>
		<h1 class="page-title"><?php echo wp_kses_post( $title ); ?></h1>
		<?php if ( $subtitle ) : ?>
			<div class="page-subtitle"><?php echo wp_kses_post( $subtitle ); ?></div>
		<?php endif; ?>
	</div>
	<span class="page-hero-mark" aria-hidden="true">SPORTMALL</span>
</section>
