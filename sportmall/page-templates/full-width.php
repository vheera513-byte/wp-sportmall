<?php
/**
 * Template Name: تمام‌عرض
 * Description: برگه‌ای بدون صفحهٔ عنوان و حاشیه، مناسب صفحه‌سازها.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="main-content" class="page-main page-main--full">
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-content page-entry page-entry--full' ); ?>>
			<?php the_content(); ?>
		</article>
	</main>
	<?php
endwhile;

get_footer();
