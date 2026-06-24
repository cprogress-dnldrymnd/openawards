<?php

/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

get_header('shop'); ?>

<?php
global $theme_settings;
?>
<input id="darkLogo" type="hidden" value="<?php echo $theme_settings['alt_logo_url']; ?>" />
<header class="woocommerce-products-header dark">
	<?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
		<div class="page-shop-banner">
			<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
			<?php if (get_field('banner_subtext', 140)) : ?>
				<h3><?php the_field('banner_subtext', 140); ?></h3>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</header>
<div class="product-holder">
	<?php
	/**
	 * woocommerce_before_main_content hook.
	 *
	 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
	 * @hooked woocommerce_breadcrumb - 20
	 */
	do_action('woocommerce_before_main_content');
	?>


	<?php while (have_posts()) : ?>
		<?php the_post(); ?>

		<?php wc_get_template_part('content', 'single-product'); ?>

	<?php endwhile; // end of the loop. 
	?>

	<?php
	/**
	 * woocommerce_after_main_content hook.
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action('woocommerce_after_main_content');
	?>

	<?php
	/**
	 * woocommerce_sidebar hook.
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
	//do_action( 'woocommerce_sidebar' );
	?>

</div>
<script>
	jQuery(document).ready(function() {
		jQuery('body > header').addClass('darkHeader');
		var darkLogo = jQuery('#darkLogo').val();
		jQuery('body > header .logo img').attr("src", darkLogo);
	});
</script>
<?php
get_footer('shop');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
