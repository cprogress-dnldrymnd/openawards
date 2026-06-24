<?php

/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

global $product;
$hide_enquire_now = get_field('hide_enquire_now');
$hide_add_to_basket_button = get_field('hide_add_to_basket_button');
$custom_button_text = get_field('custom_button_text');
$custom_button_text_url = get_field('custom_button_text_url');
$custom_button_open_in_new_window = get_field('custom_button_open_in_new_window');
?>

<p class="<?php echo esc_attr(apply_filters('woocommerce_product_price_class', 'price')); ?>"><?php echo $product->get_price_html(); ?>
	<span class="single-meta">
		<?= do_shortcode('[product_custom_field]'); ?>
	</span>
</p>

<div class="button-group">
	<?php if (!$hide_enquire_now) { ?>
		<a id="enquire" class="btn btn-outline-primary" href="/contact-us/">Enquire Now</a>
	<?php } ?>
	<?php if (!$hide_add_to_basket_button) { ?>

		<a class="btn btn-secondary" href="<?php $add_to_cart = do_shortcode('[add_to_cart_url id="' . $product->get_id() . '"]');
											echo $add_to_cart; ?>">Add to Basket</a>
	<?php } ?>

	<?php if ($custom_button_text && $custom_button_text_url) { ?>
		<a class="btn btn-secondary" href="<?= $custom_button_text_url ?>" <?= $custom_button_open_in_new_window ? 'target="_blank"' : '' ?>>
			<?= $custom_button_text ?>
		</a>
	<?php } ?>

</div>