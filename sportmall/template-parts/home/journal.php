<?php
/**
 * Journal / editorial posts.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$query = new WP_Query( array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 3,
	'ignore_sticky_posts' => true,
) );

if ( ! $query->have_posts() ) {
	return;
}
?>
<section class="section journal-section shell" id="journal" aria-labelledby="journal-title">
	<div class="section-heading">
		<div>
			<p class="eyebrow"><?php echo esc_html( sportmall_mod( 'journal_eyebrow' ) ); ?></p>
			<h2 class="section-title" id="journal-title"><?php echo esc_html( sportmall_mod( 'journal_title' ) ); ?></h2>
		</div>
		<a class="text-link" href="<?php echo esc_url( sportmall_journal_url() ); ?>">
			<?php echo esc_html( sportmall_mod( 'journal_link_label' ) ); ?>
			<?php sportmall_the_icon( 'arrow' ); ?>
		</a>
	</div>

	<div class="journal-grid">
		<?php
		$index = 0;
		while ( $query->have_posts() ) :
			$query->the_post();
			$index++;
			$cats = get_the_category();
			?>
			<article class="journal-card">
				<a class="journal-image" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'خواندن %s', 'sportmall' ), get_the_title() ) ); ?>">
					<?php echo wp_kses_post( sportmall_post_image( get_the_ID(), 'sportmall-wide', array( 'loading' => 'lazy' ) ) ); ?>
					<span class="journal-number">GUIDE / <?php echo esc_html( sportmall_fa_digits( str_pad( $index, 2, '0', STR_PAD_LEFT ) ) ); ?></span>
				</a>
				<div class="journal-meta">
					<span><?php echo esc_html( $cats ? $cats[0]->name : __( 'ژورنال', 'sportmall' ) ); ?></span>
					<span><?php echo esc_html( sportmall_reading_time( get_the_ID() ) ); ?></span>
				</div>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<a class="journal-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'بیشتر بخوان', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
			</article>
		<?php endwhile; ?>
	</div>
</section>
<?php wp_reset_postdata(); ?>
