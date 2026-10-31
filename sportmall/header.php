<?php
/**
 * Site header.
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
	<meta name="theme-color" content="#101111">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body id="top" <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main-content"><?php esc_html_e( 'رفتن به محتوای اصلی', 'sportmall' ); ?></a>

<?php get_template_part( 'template-parts/header/announcement' ); ?>

<?php
if ( empty( $GLOBALS['sportmall_header_in_hero'] ) ) {
	get_template_part( 'template-parts/header/site-header', null, array( 'variant' => 'solid' ) );
}
?>
