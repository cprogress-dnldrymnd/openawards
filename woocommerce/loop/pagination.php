<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}
?>
<hr class="separator" />
<nav class="woocommerce-pagination">
	<?php
	if($current != 1) {
		echo '<a class="page-number" href="'.esc_url( get_pagenum_link( 1 ) ).'">First</a>';
		echo '<a class="next page-number" href="'.esc_url( get_pagenum_link( $current - 1 ) ).'"><i class="fas fa-arrow-left"></i></a>';
	} else {
		echo '<a class="page-number disabled" href="'.esc_url( get_pagenum_link( 1 ) ).'">First</a>';
		echo '<a class="next page-number disabled" href="'.esc_url( get_pagenum_link( $current - 1 ) ).'"><i class="fas fa-arrow-left"></i></a>';
	}
	echo paginate_links(
		apply_filters(
			'woocommerce_pagination_args',
			array( // WPCS: XSS ok.
				'base'      => $base,
				'format'    => $format,
				'add_args'  => false,
				'current'   => max( 1, $current ),
				'total'     => $total,
				'prev_next' => FALSE,
				'type'      => 'list',
				'end_size'  => 3,
				'mid_size'  => 3,
			)
		)
	);
	if($current != $total) {
		echo '<a class="next page-number" href="'.esc_url( get_pagenum_link( $current + 1 ) ).'"><i class="fas fa-arrow-right"></i></a>';
		echo '<a class="page-number" href="'.esc_url( get_pagenum_link( $total ) ).'">Last</a>';
	} else {
		echo '<a class="next page-number disabled" href="'.esc_url( get_pagenum_link( $current + 1 ) ).'"><i class="fas fa-arrow-right"></i></a>';
		echo '<a class="page-number disabled" href="'.esc_url( get_pagenum_link( $total ) ).'">Last</a>';
	}
	?>
</nav>
