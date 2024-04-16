<?php
/*-----------------------------------------------------------------------------------*/
/* Course Free Field
/*-----------------------------------------------------------------------------------*/
function product_custom_field()
{
	ob_start();

	$days = get_field('number_of_days_course_is_available_from_date_of_purchase');
	$free = get_field('this_course_is_free_with_your_provider_coupon');
	$custom_availability_text = get_field('custom_availability_text');
	$custom_free_course_text = get_field('custom_free_course_text');
?>
	<?php if ($custom_free_course_text) { ?>
		<br>
		<span class="text"><?= $custom_availability_text ?></span>
	<?php } else { ?>
		<?php if ($days) { ?>
			<br>
			<span class="text">Course is available for <strong><?= get_field('number_of_days_course_is_available_from_date_of_purchase') ?> days</strong> from purchase</span>
		<?php } ?>
	<?php } ?>
	<?php if ($custom_free_course_text) { ?>
		<br>
		<span class="text"><?= $custom_free_course_text ?></span>
	<?php } else { ?>
		<?php if ($free) { ?>
			<br>
			<span class="text">This course is <strong>free</strong> with your provider coupon</span>
		<?php } ?>
	<?php } ?>

<?php
	return ob_get_clean();
}

add_shortcode('product_custom_field', 'product_custom_field');

/*-----------------------------------------------------------------------------------*/
/* Remove wocoommerce breadcrumbs
/*-----------------------------------------------------------------------------------*/
add_action('template_redirect', 'remove_shop_breadcrumbs');
function remove_shop_breadcrumbs()
{
	if (!is_product())
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
}

/*-----------------------------------------------------------------------------------*/
/* Custom my account shortcode
/*-----------------------------------------------------------------------------------*/
function open_awards_woocommerce_my_account()
{
	ob_start();
?>
	<?php if (is_user_logged_in()) { ?>
		<?= do_shortcode('[woocommerce_my_account]') ?>
	<?php } else { ?>
		<div class="row">
			<div class="col-md-6">
				<div class="column-holder">
					<img src="https://openawards.theprogressteam.com/wp-content/uploads/2021/04/undraw_book_lover_mkck.svg">
				</div>
			</div>
			<div class="col-md-6">
				<div class="column-holder">
					<?= do_shortcode('[woocommerce_my_account]') ?>
				</div>
			</div>
		</div>
	<?php } ?>

<?php
	return ob_get_clean();
}

add_shortcode('open_awards_woocommerce_my_account', 'open_awards_woocommerce_my_account');


function open_awards_discussion_topic()
{
	ob_start();
	get_template_part('template-parts/discussion-board', 'archive');
	return ob_get_clean();
}

add_shortcode('open_awards_discussion_topic', 'open_awards_discussion_topic');


function open_awards_discussion_board_form()
{
	ob_start();
?>
	<div class="new-topic-holder">
		<?php if (is_user_logged_in()) { ?>
			<?= do_shortcode('[discussion_board_form]'); ?>
		<?php } else { ?>
			<p>
				You must login before you can add topic.
			</p>
			<p class="text-center">
				<a type="button" class="btn btn-secondary" href="/my-account/?redirect=/topics/new-topic/">
					Login Here
				</a>
			</p>
		<?php } ?>
	</div>

	<?php
	return ob_get_clean();
}

add_shortcode('open_awards_discussion_board_form', 'open_awards_discussion_board_form');

function my_account_menu_label()
{
	if (is_user_logged_in()) {
		return '<i class="fas fa-user"></i> My account';
	} else {
		return '<i class="fas fa-door-open"></i> Sign in';
	}
}
add_shortcode('my_account_menu_label', 'my_account_menu_label');

add_filter('wp_nav_menu_items', 'do_shortcode');

function event_price($atts, $content = null)
{
	$val = shortcode_atts(array(
		'minvalue' => '',
		'maxvalue'  =>  ''
	), $atts);

	$return = '';

	if ($val['minvalue'] == '$0.00') {
		$return .= 'FREE';
	} else {
		$return .= $val['minvalue'];
	}

	if ($val['maxvalue'] != $val['minvalue']) {
		$return .= ' - ';
		$return .= $val['maxvalue'];
	}


	return $return;
}

add_shortcode('event_price', 'event_price');



function launch_modal()
{
	if ($_GET['book_ticket'] == 'yes') {
		ob_start();
	?>
		<script type="text/javascript">
			jQuery(window).on('load', function() {
				jQuery('#bookModal').modal('show');
			});
		</script>
<?php
		return ob_get_clean();
	}
}

add_shortcode('launch_modal', 'launch_modal');


/**
 * @snippet       Display All Products Purchased by User via Shortcode - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 5
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

add_shortcode('my_purchased_products', 'bbloomer_products_bought_by_curr_user');

function bbloomer_products_bought_by_curr_user($atts, $content = null)
{
	$val = shortcode_atts(array(
		'limit' => '-1',
	), $atts);

	$limit = $val['limit'];

	// GET CURR USER
	$current_user = wp_get_current_user();
	if (0 == $current_user->ID) return;

	// GET USER ORDERS (COMPLETED + PROCESSING)
	$customer_orders = get_posts(array(
		'numberposts' => -1,
		'meta_key'    => '_customer_user',
		'meta_value'  => $current_user->ID,
		'post_type'   => wc_get_order_types(),
		'post_status' => array_keys(wc_get_is_paid_statuses()),
	));

	// LOOP THROUGH ORDERS AND GET PRODUCT IDS
	if (!$customer_orders) return;
	$product_ids = array();
	foreach ($customer_orders as $customer_order) {
		$order = wc_get_order($customer_order->ID);
		$items = $order->get_items();
		foreach ($items as $item) {
			$product_id = $item->get_product_id();
			$product_ids[] = $product_id;
		}
	}
	$product_ids = array_unique($product_ids);
	$product_ids_str = implode(",", $product_ids);

	// PASS PRODUCT IDS TO PRODUCTS SHORTCODE
	return do_shortcode("[products ids='$product_ids_str' limit='$limit']");
}

function cfshortcode_author()
{
	return get_the_author_meta('display_name', $author_id);
}
add_shortcode('cfshortcode_author', 'cfshortcode_author');

function cfshortcode_page_link()
{
	return get_permalink();
}

add_shortcode('cfshortcode_page_link', 'cfshortcode_page_link');

function cfshortcode_post_title()
{
	return get_the_title();
}

add_shortcode('cfshortcode_post_title', 'cfshortcode_post_title');


function slider($atts)
{
	extract(
		shortcode_atts(
			array(
				'slider_id' => '',
			),
			$atts
		)
	);

	$args = array(
		'slider_id' => $slider_id
	);
	ob_start();
	get_template_part('template-parts/slider', null, $args);
	return ob_get_clean();
}

add_shortcode('slider', 'slider');

function template($atts)
{
	extract(
		shortcode_atts(
			array(
				'template_id' => '',
			),
			$atts
		)
	);

	$args = array(
		'post_type' => 'templates',
		'p' => $template_id

	);
	$query = new WP_Query($args);

	while ($query->have_posts()) {
		$query->the_post();
		return get_the_content();
	}
	
}

add_shortcode('template', 'template');


function e_campus()
{
	ob_start();
	get_template_part('template-parts/e-campus');
	return ob_get_clean();
}

add_shortcode('e_campus', 'e_campus');
