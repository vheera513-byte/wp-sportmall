<?php
/**
 * Blog archive card.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$cats = get_the_category();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'journal-card post-card' ); ?>>
	<a class="journal-image" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'خواندن %s', 'sportmall' ), get_the_title() ) ); ?>">
		<?php echo wp_kses_post( sportmall_post_image( get_the_ID(), 'sportmall-wide', array( 'loading' => 'lazy' ) ) ); ?>
	</a>
	<div class="journal-meta">
		<span><?php echo esc_html( $cats ? $cats[0]->name : __( 'ژورنال', 'sportmall' ) ); ?></span>
		<span><?php echo esc_html( sportmall_reading_time( get_the_ID() ) ); ?></span>
	</div>
	<h2 class="post-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<div class="post-card-excerpt"><?php the_excerpt(); ?></div>
	<a class="journal-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'بیشتر بخوان', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
</article>
