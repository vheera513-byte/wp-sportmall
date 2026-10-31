<?php
/**
 * Template Name: صفحهٔ خالی (بدون هدر و فوتر)
 * Description: A bare canvas for landing pages and campaign pages.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?><?php echo is_rtl() ? '' : ' dir="rtl"'; ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'sportmall-blank' ); ?>>
<?php wp_body_open(); ?>

<main id="main-content" class="sportmall-blank-main">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'sportmall-blank-entry' ); ?>>
			<?php the_content(); ?>
		</article>
		<?php
	endwhile;
	?>
</main>

<?php wp_footer(); ?>
</body>
</html>
