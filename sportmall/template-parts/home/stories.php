<?php
/**
 * Customer stories strip.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

$query = new WP_Query( array(
	'post_type'      => 'sm_story',
	'post_status'    => 'publish',
	'posts_per_page' => 4,
) );

if ( ! $query->have_posts() ) {
	return;
}
?>
<section class="section stories-section shell" id="stories" aria-labelledby="stories-title">
	<div class="section-heading">
		<div>
			<p class="eyebrow"><?php echo esc_html( sportmall_mod( 'stories_eyebrow' ) ); ?></p>
			<h2 class="section-title" id="stories-title"><?php echo esc_html( sportmall_mod( 'stories_title' ) ); ?></h2>
			<p class="section-description"><?php echo esc_html( sportmall_mod( 'stories_text' ) ); ?></p>
		</div>
		<div class="stories-note">
			<span class="story-spark" aria-hidden="true">✳</span>
			<span>
				<?php esc_html_e( 'تجربهٔ خرید، به روایت مشتریان', 'sportmall' ); ?>
				<small><?php esc_html_e( 'روایت‌های واقعی انتخاب و حرکت', 'sportmall' ); ?></small>
			</span>
		</div>
	</div>

	<div class="stories-grid" id="stories-grid">
		<?php
		$index = 0;
		while ( $query->have_posts() ) :
			$query->the_post();
			$index++;
			$name     = get_post_meta( get_the_ID(), '_sm_name', true ) ?: get_the_title();
			$activity = get_post_meta( get_the_ID(), '_sm_activity', true );
			$initial  = get_post_meta( get_the_ID(), '_sm_initial', true );
			$category = get_post_meta( get_the_ID(), '_sm_category', true );
			$position = get_post_meta( get_the_ID(), '_sm_position', true ) ?: '50% 35%';
			$image    = get_the_post_thumbnail_url( get_the_ID(), 'sportmall-portrait' );
			if ( ! $image ) {
				$image = sportmall_asset( 'images/category-women.jpg' );
			}
			if ( ! $initial ) {
				$initial = sportmall_first_char( $name );
			}
			?>
			<a class="story-card" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'خواندن داستان %s', 'sportmall' ), $name ) ); ?>">
				<img src="<?php echo esc_url( $image ); ?>" alt="" style="object-position:<?php echo esc_attr( $position ); ?>" loading="lazy" width="310" height="390">
				<span class="story-person">
					<span class="story-avatar"><?php echo esc_html( $initial ); ?></span>
					<span><?php echo esc_html( $name ); ?><?php if ( $activity ) : ?><small><?php echo esc_html( $activity ); ?></small><?php endif; ?></span>
				</span>
				<span class="story-card-content">
					<?php if ( $category ) : ?>
						<span class="story-category"><?php echo esc_html( $category ); ?></span>
					<?php endif; ?>
					<h3><?php echo wp_kses_post( nl2br( get_the_title() ) ); ?></h3>
					<span class="story-card-foot">
						<span><?php esc_html_e( 'دیدن داستان', 'sportmall' ); ?></span>
						<?php sportmall_the_icon( 'arrow' ); ?>
					</span>
				</span>
			</a>
		<?php endwhile; ?>
	</div>

	<div class="stories-bottom">
		<span><?php esc_html_e( 'از باز کردن جعبه تا اولین تمرین؛ جای داستان تو اینجاست.', 'sportmall' ); ?></span>
		<span dir="ltr">YOUR MOVE. YOUR STORY.</span>
	</div>
</section>
<?php wp_reset_postdata(); ?>
