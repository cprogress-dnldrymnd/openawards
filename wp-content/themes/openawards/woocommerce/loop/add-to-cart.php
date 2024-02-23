<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
$downloads = $product->get_downloads();
?>
<div class="more-information">
	<div class="time">
		<img src="/wp-content/uploads/2021/05/Icon-ionic-ios-timer.svg" />
		<?php if( get_field('estimated_time') ): ?>
			<span><?php the_field('estimated_time'); ?></span>
		<?php endif; ?>
	</div>
	<div class="type">
		<img src="/wp-content/uploads/2021/05/Icon-feather-award.svg" />
		<?php if( get_field('type_of_course') ): ?>
			<span><?php the_field('type_of_course'); ?></span>
		<?php endif; ?>
	</div>
	<div class="price">
		<?php echo $product->get_price_html(); ?>
		<span class="small-text">
			<?= do_shortcode( '[product_custom_field]' ); ?>
		</span>
	</div>

</div>
<?php if(is_account_page()) { ?>
	<?php if($downloads) { ?>

		<?php foreach( $downloads as $key => $each_download ) { ?>
			<?php 
			$file = $each_download["file"];
			$name = $each_download['name'];
			?>
			<a href="<?= $file ?>" download="<?= $name ?>" class="btn btn-outline-primary">Download</a>
		<?php } ?>
		
	<?php } else { ?>
		<a href="https://openawardslearn.znanja.com/login" class="btn btn-outline-primary">Log in to Learn</a>
	<?php } ?>
<?php } else { ?>
	<a href="<?php echo the_permalink();?>" class="btn btn-outline-primary">View course</a>
<?php } ?>

<?php /*echo apply_filters(
	'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
	sprintf(
		'<a href="'.the_permalink().'" data-quantity="%s" class="%s btn btn-outline-primary"View course</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
		''
	),
	$product,
	$args
);*/
?>

<script>
	
</script>