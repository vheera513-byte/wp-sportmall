<?php
/**
 * Inline SVG icon system.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

/**
 * Icon path definitions (24×24, stroke based unless marked).
 *
 * @return array<string,string>
 */
function sportmall_icon_paths() {
	return apply_filters( 'sportmall_icon_paths', array(
		'arrow'       => '<path d="M20 12H4m6-6-6 6 6 6"/>',
		'arrow-left'  => '<path d="M19 12H5m6-6-6 6 6 6"/>',
		'arrow-right' => '<path d="M5 12h14m-6-6 6 6-6 6"/>',
		'up'          => '<path d="M12 20V4m-6 6 6-6 6 6"/>',
		'down'        => '<path d="M12 4v16m6-6-6 6-6-6"/>',
		'chevron'     => '<path d="m6 9 6 6 6-6"/>',
		'chevron-left'=> '<path d="m15 18-6-6 6-6"/>',
		'chevron-right'=>'<path d="m9 18 6-6-6-6"/>',
		'heart'       => '<path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8L12 21l8.8-8.6a5.5 5.5 0 0 0 0-7.8Z"/>',
		'search'      => '<circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 4.5 4.5"/>',
		'user'        => '<circle cx="12" cy="7.5" r="3.5"/><path d="M5 21c.5-4 3-6 7-6s6.5 2 7 6"/>',
		'bag'         => '<path d="M5 8h14l1 13H4L5 8Z"/><path d="M9 9V6a3 3 0 0 1 6 0v3"/>',
		'cart'        => '<path d="M3 4h2l2.6 11.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.6L21 7H6"/><circle cx="10" cy="20" r="1"/><circle cx="18" cy="20" r="1"/>',
		'close'       => '<path d="m6 6 12 12M18 6 6 18"/>',
		'menu'        => '<path d="M3 6h18M3 12h18M3 18h18"/>',
		'plus'        => '<path d="M12 5v14M5 12h14"/>',
		'minus'       => '<path d="M5 12h14"/>',
		'check'       => '<path d="m5 12 4 4L19 6"/>',
		'shield'      => '<path d="m12 3 8 3v6c0 5-8 9-8 9s-8-4-8-9V6l8-3Z"/><path d="m8 12 3 3 5-6"/>',
		'truck'       => '<path d="M14 17V5H2v12h2m4 0h8m4 0h2v-5l-4-4h-4"/><circle cx="6" cy="17" r="2"/><circle cx="18" cy="17" r="2"/><path d="M18 8v5h4"/>',
		'return'      => '<path d="M4 10a8 8 0 1 1 1 8M4 4v6h6"/><path d="M12 8v5l3 2"/>',
		'headphones'  => '<path d="M4 14V10a8 8 0 0 1 16 0v4M20 17c0 4-4 5-7 5"/><rect x="2" y="11" width="4" height="7" rx="2"/><rect x="18" y="11" width="4" height="7" rx="2"/>',
		'copy'        => '<rect x="8" y="8" width="12" height="13" rx="2"/><path d="M16 8V3H3v13h5"/>',
		'globe'       => '<circle cx="12" cy="12" r="9"/><ellipse cx="12" cy="12" rx="4" ry="9"/><path d="M3 12h18"/>',
		'mail'        => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 6 9 7 9-7"/>',
		'pin'         => '<path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.6"/>',
		'phone'       => '<path d="M6 3h3l2 5-3 2a13 13 0 0 0 6 6l2-3 5 2v3a2 2 0 0 1-2 2A17 17 0 0 1 4 5a2 2 0 0 1 2-2Z"/>',
		'ruler'       => '<path d="m3 16 13-13 5 5L8 21 3 16Z"/><path d="m12 7 2 2m-6 2 2 2m-6 2 2 2"/>',
		'star'        => '<path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2L12 17.3 6.4 20.2l1.1-6.2L3 9.6l6.2-.9L12 3Z"/>',
		'star-fill'   => '<path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2L12 17.3 6.4 20.2l1.1-6.2L3 9.6l6.2-.9L12 3Z" fill="currentColor"/>',
		'trash'       => '<path d="M4 7h16M9 7V4h6v3m-8 0 1 14h8l1-14"/><path d="M10 11v6m4-6v6"/>',
		'edit'        => '<path d="m4 20 4-.8L20 7.2 16.8 4 4.8 16 4 20Z"/><path d="m14.5 6.3 3.2 3.2"/>',
		'eye'         => '<path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/>',
		'filter'      => '<path d="M3 5h18M6 12h12m-8 7h4"/>',
		'sort'        => '<path d="M8 5v14m0 0-4-4m4 4 4-4M16 19V5m0 0-4 4m4-4 4 4"/>',
		'box'         => '<path d="m12 3 8 4.5v9L12 21l-8-4.5v-9L12 3Z"/><path d="M4 7.5 12 12l8-4.5M12 12v9"/>',
		'chat'        => '<path d="M21 12a8 8 0 0 1-8 8H7l-4 3v-6.5A9 9 0 1 1 21 12Z"/><path d="M8 10h8m-8 4h5"/>',
		'credit-card' => '<rect x="2" y="5" width="20" height="14" rx="3"/><path d="M2 10h20"/>',
		'home'        => '<path d="m3 11 9-8 9 8"/><path d="M5 10v11h14V10"/><path d="M10 21v-6h4v6"/>',
		'logout'      => '<path d="M10 4H5v16h5"/><path d="M15 8l4 4-4 4m4-4H9"/>',
		'lock'        => '<rect x="4" y="10" width="16" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/>',
		'clock'       => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
		'calendar'    => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4m8-4v4M3 10h18"/>',
		'tag'         => '<path d="M20 13 13 20l-9-9V4h7l9 9Z"/><circle cx="8.5" cy="8.5" r="1.5"/>',
		'info'        => '<circle cx="12" cy="12" r="9"/><path d="M12 11v6m0-9v.1"/>',
		'play'        => '<path d="M8 5v14l11-7L8 5Z"/>',
		'pause'       => '<path d="M9 5v14M15 5v14"/>',
		'external'    => '<path d="M14 4h6v6M20 4 11 13"/><path d="M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/>',
		'instagram'   => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><path d="M17.5 6.5v.1"/>',
		'telegram'    => '<path d="m21 4-3 16-6-5-3 3v-5l8-7-10 5-4-2 18-5Z"/>',
		'whatsapp'    => '<path d="M20 11.7a8 8 0 0 1-11.8 7L3 20l1.4-5A8 8 0 1 1 20 11.7Z"/><path d="M9 8.5c.3 3 2 4.7 5 5.5"/>',
		'youtube'     => '<rect x="2" y="5" width="20" height="14" rx="4"/><path d="m10 9 5 3-5 3V9Z"/>',
		'spark'       => '<path d="M12 3v18M3 12h18M6 6l12 12M18 6 6 18"/>',
		'grid'        => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
		'gift'        => '<rect x="3" y="9" width="18" height="12" rx="2"/><path d="M3 13h18M12 9v12"/><path d="M12 9C10 9 7 8 7 5.5A2.5 2.5 0 0 1 12 5a2.5 2.5 0 0 1 5 .5C17 8 14 9 12 9Z"/>',
	) );
}

/**
 * Return the hidden SVG sprite.
 *
 * @return string
 */
function sportmall_get_icon_sprite() {
	$icons = sportmall_icon_paths();
	$svg   = '<svg xmlns="http://www.w3.org/2000/svg" class="sportmall-sprite" style="position:absolute;width:0;height:0;overflow:hidden" aria-hidden="true" focusable="false"><defs>';
	foreach ( $icons as $name => $paths ) {
		$svg .= '<symbol id="i-' . esc_attr( $name ) . '" viewBox="0 0 24 24">' . $paths . '</symbol>';
	}
	$svg .= '</defs></svg>';
	return $svg;
}

/**
 * Render an icon.
 *
 * @param string $name  Icon name.
 * @param string $class Extra classes.
 * @param array  $attrs Extra attributes.
 * @return string
 */
function sportmall_icon( $name, $class = '', $attrs = array() ) {
	$name = preg_replace( '/[^a-z0-9\-]/', '', strtolower( (string) $name ) );
	if ( ! $name ) {
		return '';
	}
	$classes = trim( 'icon icon-' . $name . ' ' . $class );
	$extra   = '';
	foreach ( $attrs as $key => $value ) {
		$extra .= ' ' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
	}
	return '<svg class="' . esc_attr( $classes ) . '" aria-hidden="true" focusable="false"' . $extra . '><use href="#i-' . esc_attr( $name ) . '"></use></svg>';
}

/**
 * Print an icon.
 *
 * @param string $name  Icon name.
 * @param string $class Extra classes.
 * @param array  $attrs Extra attributes.
 */
function sportmall_the_icon( $name, $class = '', $attrs = array() ) {
	echo sportmall_icon( $name, $class, $attrs ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in helper.
}
