<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>

	<?php endif; ?>
	
	<div class="shortMeta">
		<div class="availability">
			<?php if( get_field('availability') ){
				echo '<span class="available">Available</span>';
			} else {
				echo '<span class="unavailable">Unavailable</span>';
			} ?>
		</div>
		<div class="duration">
			<?php if( get_field('estimated_time') ): ?>
				<img src="/wp-content/uploads/2021/05/Icon-ionic-ios-timer.svg">
				<span><?php the_field('estimated_time'); ?></span>
			<?php endif; ?>
		</div>
		<div class="type">
			<?php if( get_field('type_of_course') ): ?>
				<img src="/wp-content/uploads/2021/05/Icon-feather-award.svg">
				<span><?php the_field('type_of_course'); ?></span>
			<?php endif; ?>
		</div>
	</div>
	
	
	<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( '<h3>Course Category</h3>', '<h3>Course Categories</h3>', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php echo wc_get_product_tag_list( $product->get_id(), ' ', '<span class="tagged_as">' . _n( '<h3>Course Tag</h3>', '<h3>Course Tags</h3>', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
	
	<hr/>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
