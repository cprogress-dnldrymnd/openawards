<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
global $theme_settings;
?>
<input id="darkLogo" type="hidden" value="<?php echo $theme_settings['alt_logo_url'] ?>"/>
<header class="woocommerce-products-header <?php if( get_field('dark_header', 140)) { echo 'dark'; } ?>">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<div class="page-shop-banner">
			<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
			<?php if( get_field('banner_subtext', 140) ): ?>
				<h3><?php the_field('banner_subtext', 140); ?></h3>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>
<div class="shop-holder">
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-sm-8">
				<?php
					if ( woocommerce_product_loop() ) { ?>
						<div class="productFilters">
							<?php 
							/**
							 * Hook: woocommerce_before_shop_loop.
							 *
							 * @hooked woocommerce_output_all_notices - 10
							 * @hooked woocommerce_result_count - 20
							 * @hooked woocommerce_catalog_ordering - 30
							 */
							do_action( 'woocommerce_before_shop_loop' ); ?>
						</div>
						<hr class="productSeparator"/>
						<?php
						woocommerce_product_loop_start();

						if ( wc_get_loop_prop( 'total' ) ) {
							while ( have_posts() ) {
								the_post();

								/**
								 * Hook: woocommerce_shop_loop.
								 */
								do_action( 'woocommerce_shop_loop' );

								wc_get_template_part( 'content', 'product' );
							}
						}

						woocommerce_product_loop_end();

						/**
						 * Hook: woocommerce_after_shop_loop.
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action( 'woocommerce_after_shop_loop' );
					} else {
						/**
						 * Hook: woocommerce_no_products_found.
						 *
						 * @hooked wc_no_products_found - 10
						 */
						do_action( 'woocommerce_no_products_found' );
					}
				?>
			</div>
			<div class="col-md-3 col-sm-4">
				<div class="shop-sidebar">
					<?php				
						/**
						 * Hook: woocommerce_sidebar.
						 *
						 * @hooked woocommerce_get_sidebar - 10
						 */
						do_action( 'woocommerce_sidebar' ); 
					?>
				</div>
			</div>
			<?php do_action( 'woocommerce_after_main_content' ); ?>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function() {
		if (jQuery('.woocommerce-products-header ').hasClass('dark')) {
			jQuery('body > header').addClass('darkHeader');
			var darkLogo = jQuery('#darkLogo').val();
			jQuery('body > header .logo img').attr("src", darkLogo);
		} else {
			jQuery('body > header').removeClass('darkHeader');
		}
	});
</script>
<?php get_footer( 'shop' );
