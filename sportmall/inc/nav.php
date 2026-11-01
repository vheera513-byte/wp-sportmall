<?php
/**
 * Storefront navigation and mega menus.
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

/**
 * Print the main navigation. A classic WP menu can be assigned to the
 * "primary" location; otherwise the menu is built from store categories.
 */
function sportmall_primary_nav() {
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => 'nav',
			'container_class'=> 'main-nav main-nav--custom',
			'container_id'   => 'main-nav',
			'menu_class'     => 'main-nav-list',
			'depth'          => 2,
			'fallback_cb'    => false,
		) );
		return;
	}

	$items   = sportmall_nav_items();
	$shop    = sportmall_shop_url();
	$brands  = sportmall_get_brands( 8 );
	$new_url = add_query_arg( 'orderby', 'date', $shop );
	$sale_url = add_query_arg( 'on_sale', '1', $shop );

	echo '<nav class="main-nav" id="main-nav" aria-label="' . esc_attr__( 'دسته‌بندی‌های اصلی', 'sportmall' ) . '">';

	foreach ( $items as $item ) {
		$mega = $item['mega'];
		echo '<div class="nav-item' . ( $mega ? ' nav-item--mega' : '' ) . '" data-mega="' . esc_attr( $item['slug'] ) . '">';
		echo '<a class="nav-link' . ( $mega ? ' nav-link--mega' : '' ) . '" href="' . esc_url( $item['url'] ) . '"' . ( $mega ? ' aria-haspopup="true" aria-expanded="false"' : '' ) . '>';
		echo '<span class="nav-label">' . esc_html( $item['label'] ) . '</span>';
		if ( $mega ) {
			echo sportmall_icon( 'chevron', 'nav-chevron' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		echo '</a>';

		if ( $mega ) {
			sportmall_mega_panel( $item );
		}
		echo '</div>';
	}

	// Brands mega menu.
	if ( $brands ) {
		echo '<div class="nav-item nav-item--mega" data-mega="brands">';
		echo '<a class="nav-link nav-link--mega" href="' . esc_url( $shop ) . '" aria-haspopup="true" aria-expanded="false"><span class="nav-label">' . esc_html__( 'برندها', 'sportmall' ) . '</span>' . sportmall_icon( 'chevron', 'nav-chevron' ) . '</a>';
		echo '<div class="mega"><div class="mega-panel brands-mega-panel">';
		echo '<div class="brands-mega-heading"><p class="mega-title">' . esc_html__( 'برندهای اسپرت‌مال', 'sportmall' ) . '</p><p>' . esc_html__( 'انتخاب‌های شناخته‌شده برای هر شکل حرکت', 'sportmall' ) . '</p></div>';
		echo '<div class="brands-grid">';
		foreach ( $brands as $brand ) {
			echo '<a class="brand-tile" href="' . esc_url( $brand['url'] ) . '"><span class="brand-logo-frame"><img src="' . esc_url( $brand['logo'] ) . '" alt="' . esc_attr( $brand['name'] ) . '" loading="lazy"></span><span>' . esc_html( $brand['name'] ) . '</span></a>';
		}
		echo '</div>';
		echo '<a class="brands-all" href="' . esc_url( $shop ) . '">' . esc_html__( 'همهٔ محصولات فروشگاه', 'sportmall' ) . sportmall_icon( 'arrow' ) . '</a>';
		echo '</div></div></div>';
	}

	echo '<div class="nav-item"><a class="nav-link" href="' . esc_url( $new_url ) . '"><span class="nav-label">' . esc_html__( 'تازه‌رسیده‌ها', 'sportmall' ) . '</span></a></div>';
	echo '<div class="nav-item"><a class="nav-link" href="' . esc_url( $sale_url ) . '"><span class="nav-label">' . esc_html__( 'حراجی', 'sportmall' ) . '</span></a></div>';

	echo '</nav>';
}

/**
 * Primary navigation items built from product categories.
 *
 * @return array<int,array<string,mixed>>
 */
function sportmall_nav_items() {
	$items = array();
	$shop  = sportmall_shop_url();

	if ( taxonomy_exists( 'product_cat' ) ) {
		$slugs = array( 'women', 'men', 'shoes', 'accessories' );
		foreach ( $slugs as $slug ) {
			$term = get_term_by( 'slug', $slug, 'product_cat' );
			if ( ! $term || is_wp_error( $term ) ) {
				continue;
			}
			$items[] = array(
				'label' => $term->name,
				'slug'  => $term->slug,
				'url'   => get_term_link( $term ),
				'term'  => $term,
				'mega'  => true,
			);
		}

		if ( empty( $items ) ) {
			$terms = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => false, 'number' => 4 ) );
			if ( ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( 'uncategorized' === $term->slug ) {
						continue;
					}
					$items[] = array(
						'label' => $term->name,
						'slug'  => $term->slug,
						'url'   => get_term_link( $term ),
						'term'  => $term,
						'mega'  => true,
					);
				}
			}
		}
	}

	if ( empty( $items ) ) {
		$fallback = array(
			'women'       => __( 'زنانه', 'sportmall' ),
			'men'         => __( 'مردانه', 'sportmall' ),
			'shoes'       => __( 'کفش', 'sportmall' ),
			'accessories' => __( 'اکسسوری', 'sportmall' ),
		);
		foreach ( $fallback as $slug => $label ) {
			$items[] = array(
				'label' => $label,
				'slug'  => $slug,
				'url'   => add_query_arg( 'product_cat', $slug, $shop ),
				'term'  => null,
				'mega'  => true,
			);
		}
	}

	return apply_filters( 'sportmall_nav_items', $items );
}

/**
 * Render a mega menu panel.
 *
 * @param array $item Nav item.
 */
function sportmall_mega_panel( $item ) {
	$term = isset( $item['term'] ) ? $item['term'] : null;
	$url  = $item['url'];

	$children = array();
	if ( $term ) {
		$children = get_terms( array(
			'taxonomy'   => 'product_cat',
			'parent'     => $term->term_id,
			'hide_empty' => false,
			'orderby'    => 'menu_order',
			'order'      => 'ASC',
			'number'     => 8,
		) );
		if ( is_wp_error( $children ) ) {
			$children = array();
		}
	}

	$image = $term ? sportmall_category_image( $term ) : sportmall_asset( 'images/category-shoes.jpg' );
	$label = __( 'کالکشن تازه', 'sportmall' );
	?>
	<div class="mega">
		<div class="mega-panel">
			<div class="mega-col">
				<p class="mega-title"><?php esc_html_e( 'دسته‌بندی‌ها', 'sportmall' ); ?></p>
				<ul class="mega-list">
					<?php if ( $children ) : ?>
						<?php foreach ( $children as $child ) : ?>
							<li><a href="<?php echo esc_url( get_term_link( $child ) ); ?>"><?php echo esc_html( $child->name ); ?></a></li>
						<?php endforeach; ?>
					<?php else : ?>
						<li><a href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( 'مشاهده همه محصولات', 'sportmall' ); ?></a></li>
						<li><a href="<?php echo esc_url( add_query_arg( 'orderby', 'date', sportmall_shop_url() ) ); ?>"><?php esc_html_e( 'تازه‌رسیده‌ها', 'sportmall' ); ?></a></li>
						<li><a href="<?php echo esc_url( add_query_arg( 'on_sale', '1', sportmall_shop_url() ) ); ?>"><?php esc_html_e( 'پیشنهادهای ویژه', 'sportmall' ); ?></a></li>
					<?php endif; ?>
				</ul>
			</div>

			<div class="mega-col">
				<p class="mega-title"><?php esc_html_e( 'انتخاب بهتر', 'sportmall' ); ?></p>
				<ul class="mega-list">
					<li><a href="<?php echo esc_url( add_query_arg( 'orderby', 'date', sportmall_shop_url() ) ); ?>"><?php esc_html_e( 'تازه‌رسیده‌ها', 'sportmall' ); ?> <em class="mega-tag"><?php esc_html_e( 'جدید', 'sportmall' ); ?></em></a></li>
					<li><a href="<?php echo esc_url( add_query_arg( 'orderby', 'popularity', sportmall_shop_url() ) ); ?>"><?php esc_html_e( 'پرفروش‌ترین‌ها', 'sportmall' ); ?></a></li>
					<li><a href="<?php echo esc_url( add_query_arg( 'on_sale', '1', sportmall_shop_url() ) ); ?>"><?php esc_html_e( 'حراجی و تخفیف‌ها', 'sportmall' ); ?></a></li>
					<li><a href="<?php echo esc_url( sportmall_journal_url() ); ?>"><?php esc_html_e( 'راهنمای انتخاب', 'sportmall' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/size-guide/' ) ); ?>"><?php esc_html_e( 'راهنمای سایز', 'sportmall' ); ?></a></li>
				</ul>
			</div>

			<div class="mega-col">
				<p class="mega-title"><?php esc_html_e( 'از اسپرت‌مال', 'sportmall' ); ?></p>
				<ul class="mega-list">
					<li><a href="<?php echo esc_url( sportmall_stories_url() ); ?>"><?php esc_html_e( 'استوری مشتریان', 'sportmall' ); ?></a></li>
					<li><a href="<?php echo esc_url( get_post_type_archive_link( 'sm_outfit' ) ?: sportmall_shop_url() ); ?>"><?php esc_html_e( 'ست‌های ورزشی', 'sportmall' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'درباره ما', 'sportmall' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'تماس با ما', 'sportmall' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/shipping/' ) ); ?>"><?php esc_html_e( 'ارسال و تحویل', 'sportmall' ); ?></a></li>
				</ul>
			</div>

			<a class="mega-card" href="<?php echo esc_url( $url ); ?>">
				<span class="mega-card-img" style="background-image:url('<?php echo esc_url( $image ); ?>')" aria-hidden="true"></span>
				<span class="mega-card-label"><?php echo esc_html( $label ); ?></span>
				<span class="mega-card-title"><?php echo esc_html( sprintf( __( 'انتخاب‌های تازه %s', 'sportmall' ), $item['label'] ) ); ?></span>
				<span class="mega-card-cta"><?php esc_html_e( 'مشاهده مجموعه', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></span>
			</a>
		</div>
	</div>
	<?php
}
