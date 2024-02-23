<?php 
/*-----------------------------------------------------------------------------------*/
/* Number of rows on product listing
/*-----------------------------------------------------------------------------------*/
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}

/*-----------------------------------------------------------------------------------*/
/* Custom sort
/*-----------------------------------------------------------------------------------*/
add_filter( 'woocommerce_get_catalog_ordering_args', 'custom_get_catalog_ordering_args' );
function custom_get_catalog_ordering_args( $args ) {
	if ( isset( $_GET['orderby'] ) ) {
        // Sort by "menu_order" DESC (the default option)
		if ( 'title_desc' === $_GET['orderby'] ) {
			$args = array( 'orderby' => 'title', 'order' => 'DESC' );
		}
        // Sort by "menu_order" ASC
		elseif ( 'title_asc' == $_GET['orderby'] ) {
			$args = array( 'orderby'  => 'title', 'order' => 'ASC' );
		}
	}
	return $args;
}

add_filter( 'woocommerce_catalog_orderby', 'custom_catalog_orderby' );
function custom_catalog_orderby( $orderby ) {
    // Insert "Sort alphabetically (desc.)" and the clone of "menu_order" adding after others sorting options
	return array(
        'title_desc'    => __('Sort alphabetically Z-A', 'woocommerce'), // default
        'title_asc'     => __('Sort alphabetically A-Z', 'woocommerce')
    ) + $orderby ;

	return $orderby ;
}

add_action( 'woocommerce_product_query', 'product_query_sort_alphabetically' );
function product_query_sort_alphabetically( $q ) {
	if ( ! isset( $_GET['orderby'] ) && ! is_admin() ) {
		$q->set( 'orderby', 'title' );
		$q->set( 'order', 'DESC' );
	}
}

/*-----------------------------------------------------------------------------------*/
/* Woocommerce Breadcrumb Customizations
/*-----------------------------------------------------------------------------------*/
add_filter( 'woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs' );
function jk_woocommerce_breadcrumbs() {
	return array(
		'delimiter'   => '<i class="fas fa-chevron-right"></i>',
		'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb"><div class="container">',
		'wrap_after'  => '</div></nav>',
		'before'      => '<span>',
		'after'       => '</span>',
		'home'        => _x( 'eShop', 'breadcrumb', 'woocommerce' ),
	);
}

function your_prefix_wc_remove_uncategorized_from_breadcrumb( $crumbs ) {
	$category 	= get_option( 'default_product_cat' );
	$caregory_link 	= get_category_link( $category );

	foreach ( $crumbs as $key => $crumb ) {
		if ( in_array( $caregory_link, $crumb ) ) {
			unset( $crumbs[ $key ] );
		}
	}

	return array_values( $crumbs );
}

add_filter( 'woocommerce_get_breadcrumb', 'your_prefix_wc_remove_uncategorized_from_breadcrumb' );

/*-----------------------------------------------------------------------------------*/
/* Single Product Rearrange
/*-----------------------------------------------------------------------------------*/

/*Move short description*/
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 50 );

/*Move price*/
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 60 );

/*Move bundle*/
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 50 );

/*Remove description title */
add_filter( 'woocommerce_product_description_heading', '__return_null' );



/*-----------------------------------------------------------------------------------*/
/* Registration Fields
/*-----------------------------------------------------------------------------------*/

//////////////////////////////
// 1. VALIDATE FIELDS

add_filter( 'woocommerce_registration_errors', 'bbloomer_validate_name_fields', 10, 3 );

function bbloomer_validate_name_fields( $errors, $username, $email ) {
	if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
		$errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
	}
	if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
		$errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
	}

	if ( isset( $_POST['provider_name'] ) && empty( $_POST['provider_name'] ) ) {
		$errors->add( 'provider_name_error', __( '<strong>Error</strong>: Provider name is required!.', 'woocommerce' ) );
	}

	if ( isset( $_POST['pluc'] ) && !empty( $_POST['pluc'] ) ){
		if(!pluc_is_valid($_POST['pluc'])) {
			$errors->add( 'pluc_error', __( 'PLUC is invalid!', 'woocommerce' ) );
		}
	}
	return $errors;
}

///////////////////////////////
// 2. SAVE FIELDS

add_action( 'woocommerce_created_customer', 'bbloomer_save_name_fields' );

function bbloomer_save_name_fields( $customer_id ) {
	if ( isset( $_POST['billing_first_name'] ) ) {
		update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
		update_user_meta( $customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']) );
	}
	if ( isset( $_POST['billing_last_name'] ) ) {
		update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
		update_user_meta( $customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']) );
	}

	if ( isset( $_POST['provider_name'] ) ) {
		update_user_meta( $customer_id, 'provider_name', sanitize_text_field( $_POST['provider_name'] ) );
	}

	if ( isset( $_POST['pluc'] ) ) {
		update_user_meta( $customer_id, 'pluc', sanitize_text_field( $_POST['pluc'] ) );
	}

}

/*-----------------------------------------------------------------------------------*/
/* Redirect after login
/*-----------------------------------------------------------------------------------*/
function open_awards_login_redirect() {
	$redirect_page_id = $_GET['redirect'];
	if( $redirect_page_id ) {
		return $redirect_page_id;
	} else {
		return '/my-account/';
	}
}

add_filter( 'woocommerce_login_redirect', 'open_awards_login_redirect' );

/**
* @snippet       Hide Edit Address Tab @ My Account
* @how-to        Get CustomizeWoo.com FREE
* @author        Rodolfo Melogli
* @testedwith    WooCommerce 5.0
* @donate $9     https://businessbloomer.com/bloomer-armada/
*/

add_filter( 'woocommerce_account_menu_items', 'bbloomer_remove_address_my_account', 9999 );

function bbloomer_remove_address_my_account( $items ) {
	unset( $items['orders'] );
	unset( $items['downloads'] );
	unset( $items['edit-address'] );
	return $items;
}

/**
* @snippet       Rename Edit Address Tab @ My Account
* @how-to        Get CustomizeWoo.com FREE
* @author        Rodolfo Melogli
* @testedwith    WooCommerce 5.0
* @donate $9     https://businessbloomer.com/bloomer-armada/
*/

add_filter( 'woocommerce_account_menu_items', 'bbloomer_rename_address_my_account', 9999 );

function bbloomer_rename_address_my_account( $items ) {
	$items['dashboard'] = 'Overview';
	$items['edit-account'] = 'Personal Details';
	$items['payment-methods'] = 'Payment Methods';

	return $items;
}

/**
 * @snippet       WooCommerce Add New Tab @ My Account
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 5.0
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

// ------------------
// 1. Register new endpoint (URL) for My Account page
// Note: Re-save Permalinks or it will give 404 error

function bbloomer_add_my_courses_endpoint() {
	add_rewrite_endpoint( 'my-courses', EP_ROOT | EP_PAGES );
}

add_action( 'init', 'bbloomer_add_my_courses_endpoint' );

// ------------------
// 2. Add new query var

function bbloomer_my_courses_query_vars( $vars ) {
	$vars[] = 'my-courses';
	return $vars;
}

add_filter( 'query_vars', 'bbloomer_my_courses_query_vars', 0 );

// ------------------
// 3. Insert the new endpoint into the My Account menu

function bbloomer_add_my_courses_link_my_account( $items ) {
	$items['my-courses'] = 'My Courses';
	return $items;
}

add_filter( 'woocommerce_account_menu_items', 'bbloomer_add_my_courses_link_my_account' );

// ------------------
// 4. Add content to the new tab

function bbloomer_my_courses_content() {
	?>
	<div class="my-account-container">
		<div class="row no-gutters">
			<div class="col-lg-4">
				<div class="column-holder">
					<?php get_template_part('woocommerce/myaccount/dashboard', 'sidebar') ?>
				</div>
			</div>
			<div class="col-lg-8">
				<div class="column-holder column-content">
					<?php get_template_part('woocommerce/myaccount/dashboard', 'courses') ?>
				</div>
			</div>
		</div>
	</div>
	<?php
}

add_action( 'woocommerce_account_my-courses_endpoint', 'bbloomer_my_courses_content' );
// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format

// ------------------
// 1. Register new endpoint (URL) for My Account page
// Note: Re-save Permalinks or it will give 404 error

function bbloomer_add_my_certificates_endpoint() {
	add_rewrite_endpoint( 'my-certificates', EP_ROOT | EP_PAGES );
}

add_action( 'init', 'bbloomer_add_my_certificates_endpoint' );

// ------------------
// 2. Add new query var

function bbloomer_my_certificates_query_vars( $vars ) {
	$vars[] = 'my-certificates';
	return $vars;
}

add_filter( 'query_vars', 'bbloomer_my_certificates_query_vars', 0 );

// ------------------
// 3. Insert the new endpoint into the My Account menu

function bbloomer_add_my_certificates_link_my_account( $items ) {
	$items['my-certificates'] = 'My Certificates';
	return $items;
}

add_filter( 'woocommerce_account_menu_items', 'bbloomer_add_my_certificates_link_my_account' );

// ------------------
// 4. Add content to the new tab

function bbloomer_my_certificates_content() {
	?>
	<div class="my-account-container">
		<div class="row no-gutters">
			<div class="col-lg-4">
				<div class="column-holder">
					<?php get_template_part('woocommerce/myaccount/dashboard', 'sidebar') ?>

				</div>
			</div>
		</div>
	</div>
	<?php
}

add_action( 'woocommerce_account_my-certificates_endpoint', 'bbloomer_my_certificates_content' );
// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format




// Rename, re-order my account menu items
function fwuk_reorder_my_account_menu() {
	$neworder = array(
		'dashboard'			=> __( 'Overview', 'woocommerce' ),
		'edit-account'		=> __( 'Personal Details', 'woocommerce' ),
		'my-courses'		=> __( 'My Courses', 'woocommerce' ),
		//'my-certificates'	=> __( 'My Certificates', 'woocommerce' ),
		'payment-methods'	=> __( 'Payment Details', 'woocommerce' ),
		'customer-logout'	=> __( 'Logout', 'woocommerce' ),


	);
	return $neworder;
}
add_filter ( 'woocommerce_account_menu_items', 'fwuk_reorder_my_account_menu' );


/*-----------------------------------------------------------------------------------*/
/* Edit Account
/*-----------------------------------------------------------------------------------*/
add_action( 'woocommerce_edit_account_form', 'add_favorite_color_to_edit_account_form' );
function add_favorite_color_to_edit_account_form() {
	$user = wp_get_current_user();
	?>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="provider_name"><?php esc_html_e( 'Provider Name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<select name="provider_name" id="provider_name" class="woocommerce-Input woocommerce-Input--select input-select">
			<option value="">Select Provider</option>
			<?= provider_options() ?>
		</select>

	</p>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="pluc"><?php esc_html_e( 'PLUC', 'woocommerce' ); ?></label>
		<input placeholder="PLUC" type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="pluc" id="pluc"  value="<?= $user->pluc ?>"/>
	</p>

	<?php
}

// Save the custom field 
add_action( 'woocommerce_save_account_details', 'save_provider_name_account_details', 12, 1 );
function save_provider_name_account_details( $user_id ) {
	if( isset( $_POST['provider_name'] ) ) {
		update_user_meta( $user_id, 'provider_name', sanitize_text_field( $_POST['provider_name'] ) );
	}

	if( isset( $_POST['pluc'] ) ) {
		update_user_meta( $user_id, 'pluc', sanitize_text_field( $_POST['pluc'] ) );
	}

	wp_redirect('/my-account/edit-account/');
	exit();

}

//add_action( 'user_profile_update_errors','wooc_validate_custom_field', 10, 1 );

// or

add_action( 'woocommerce_save_account_details_errors','wooc_validate_custom_field', 10, 1 );

// with something like:

function wooc_validate_custom_field( $args ) {

	if ( isset( $_POST['pluc'] ) && !empty( $_POST['pluc'] ) ){
		if(!pluc_is_valid($_POST['pluc'])) {
			$args->add( 'pluc_error', __( 'PLUC is invalid!', 'woocommerce' ) );
		}
	}
	return $args;
}



/**
 * @snippet       Display & Save WP User Field @ Checkout - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @sourcecode    https://businessbloomer.com/?p=21737
 * @author        Rodolfo Melogli
 * @compatible    WC 3.5.1
 */


// ------------------------
// 1. Display field @ Checkout

add_action( 'woocommerce_after_checkout_billing_form', 'bbloomer_add_user_field_to_checkout');

function bbloomer_add_user_field_to_checkout( $checkout ) {
	if(!is_user_logged_in()) {
		$current_user = wp_get_current_user();
		$saved_provider_name = $current_user->provider_name;

		woocommerce_form_field( 'provider_name', array(        
			'type' => 'select',        
			'class' => array('provider_name form-row-wide'),        
			'label' => __('Provider Name'),
			'options' => provider_options(true),        
			'required' => true
		), 
		$saved_provider_name ); 
	}
}


// ------------------------
// 2. Save Field Into User Meta

add_action( 'woocommerce_checkout_update_user_meta', 'bbloomer_checkout_field_update_user_meta' );

function bbloomer_checkout_field_update_user_meta( $user_id ) { 

	if ( $user_id && $_POST['provider_name'] ) {

// once again, use "provider_name"

		$args = array(
			'ID' => $user_id,
			'provider_name' => esc_attr( $_POST['provider_name'] )
		);      

		wp_update_user( $args );
	}

}
/**
 * @desc Remove in all product type
 */
function wc_remove_all_quantity_fields( $return, $product ) {
	return true;
}
add_filter( 'woocommerce_is_sold_individually', 'wc_remove_all_quantity_fields', 10, 2 );

/*-----------------------------------------------------------------------------------*/
/* Change cart text
/*-----------------------------------------------------------------------------------*/
function change_update_cart_text( $translated, $text, $domain ) {
	if( is_cart() && $translated == 'Update cart' ){
		$translated = 'Update basket';
	}
	return $translated;
}
add_filter( 'gettext', 'change_update_cart_text', 20, 3 );

add_filter( 'gettext', 'change_cart_totals_text', 20, 3 );
function change_cart_totals_text( $translated, $text, $domain ) {
	if( is_cart() && $translated == 'Cart totals' ){
		$translated = 'Basket Totals';
	}
	return $translated;
}

add_filter( 'gettext', 'change_view_cart_text', 20, 3 );
function change_view_cart_text( $translated, $text, $domain ) {
	if( $translated == 'View cart' ){
		$translated = 'View basket';
	}
	return $translated;
}

add_filter( 'gettext', 'change_cart_text', 20, 3 );
function change_cart_text( $translated, $text, $domain ) {
	if( $translated == 'cart' ){
		$translated = 'basket';
	}
	return $translated;
}


// define the wc_add_to_cart_message_html callback 
function filter_wc_add_to_cart_message_html( $message, $products ) { 
	foreach($products as $key => $product) {
		$id = $key;
	}
	$message =  get_the_title($id).' has been added to your basket.';
	return $message;  
}; 

// add the filter 
add_filter( 'wc_add_to_cart_message_html', 'filter_wc_add_to_cart_message_html', 10, 2 ); 

remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
add_action( 'woocommerce_cart_is_empty', 'custom_empty_cart_message', 10 );

function custom_empty_cart_message() {
	$html = wp_kses_post( apply_filters( 'wc_empty_cart_message', __( '<p class="cart-empty woocommerce-info">Your basket is currently empty.</p>.', 'woocommerce' ) ) );
	echo $html;
}


/*-----------------------------------------------------------------------------------*/
/* Allow only elearning product to be purchase via coupon code
/*-----------------------------------------------------------------------------------*/
function elearning_provider_products($post_ids = array()) {
	$args = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'numberposts' => -1,
		'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => array( 'open-awards-coupon-training' )
			)
		)
	);
	$postslist = get_posts( $args );

	foreach($postslist as $post) {
		$post_ids[] = $post->ID;
	}

	return $post_ids;
}


add_action( 'woocommerce_check_cart_items', 'mandatory_coupon_for_specific_items' );
function mandatory_coupon_for_specific_items() {
	if(is_checkout()) {
    	$targeted_ids   = elearning_provider_products(); // The targeted product ids (in this array)

    //$coupon_applied = in_array( strtolower($coupon_code), WC()->cart->get_applied_coupons() );

    	$coupons_applied = WC()->cart->get_applied_coupons();

    	$coupons_applied_is_pluc = '';

    	foreach($coupons_applied as $coupon) {
    		if(substr( $coupon, 0, 4 ) === "pluc") {
    			$coupons_applied_is_pluc .= 'true';
    		} 
    	}

    	$product_need_coupon = '';
    	$product_need_coupon_notice = '';
    // Loop through cart items
    	foreach(WC()->cart->get_cart() as $cart_item ) {
        // Check cart item for defined product Ids and applied coupon
    		if( in_array( $cart_item['product_id'], $targeted_ids ) && ! $coupons_applied_is_pluc ) {
    			$product_need_coupon .= 'true';

    			$product_need_coupon_notice .= sprintf( '<li>The product "%s" requires a coupon for checkout.</li>', $cart_item['data']->get_name() );
    		}  
    	}

    	if($product_need_coupon) {
    		echo '<style> .checkout  { pointer-events: none; opacity: 0.5 } </style>';
    		echo "<script> jQuery(document).ready(function($) {
    			jQuery('.checkout').hide();
    		}); </script>";
    		echo '<div class="checkout-notice coupon-required"> <div class="wrapper"> <i class="fas fa-exclamation-triangle"></i></div> <div class="wrapper"> <p>Please apply your PLUC Code to receive your provider discount. Don’t have a PLUC code?  Then speak to your Quality Contact or Administrator at your centre or contact our Customer Service Team on <a href="mailto: customerservices@openawards.org.uk">customerservices@openawards.org.uk</a>.</p> <ul>'.$product_need_coupon_notice.'</ul></div></div>';
    	}
    }


}


add_action('wp_head', 'action_wp_head', 50);

function action_wp_head(){
	?>
	<style>
	
	.checkout-notice {
		padding: 10px 20px;
		margin-bottom: 20px;
		border-radius: 15px;
		display: flex;
		align-items: center;
	}
	.checkout-notice:not(.coupon-required) {
		background-color: #e5effa;
		border: 1px solid #007aff;
	}
	
	.checkout-notice:not(.coupon-required) i {
		color: #007aff;
	}
	.checkout-notice.coupon-required i {
		color: #eb4e2c;
	}
	.checkout-notice i {
		font-size: 30px;
		margin-right: 20px;
	}
	.checkout-notice.coupon-required{
		background-color: #fcedea;
		border: 1px solid #eb4e2c;
	}
	.checkout-notice p,	.checkout-notice li {
		font-size: 15px !important; 
	}
	.checkout-notice ul {
		margin-bottom: 0;
	}
	.checkout-notice p:last-child {
		margin-bottom: 0; 
	}
</style>
<?php
}

add_action('wp_footer', 'woocommerce_custom_update_checkout', 50);

function woocommerce_custom_update_checkout(){
	if (is_checkout()) {
		?>
		<script type="text/javascript">
			jQuery( document.body ).on( 'applied_coupon_in_checkout removed_coupon_in_checkout', function () {
				location.reload();
			} );

		</script>
		<?php
	}
}

function woocommerce_checkout_top_notice() {
	return '<div class="checkout-notice">
	<div class="wrapper">
	<i class="fas fa-info-circle"></i>
	</div>
	<div class="wrapper">
	<p>Remember to apply your PLUC code, in the coupon code box at the checkout, to get the courses for FREE. Don’t have a PLUC code? Then speak to your Quality Contact or Administrator at your centre or contact our Customer Service Team on <a href="mailto: customerservices@openawards.org.uk">customerservices@openawards.org.uk</a>.</p>
	</div>
	</div>';
}

add_shortcode('woocommerce_checkout_top_notice', 'woocommerce_checkout_top_notice');


/*-----------------------------------------------------------------------------------*/
/* Check if enter pluc is valid
/*-----------------------------------------------------------------------------------*/
function pluc_is_valid($pluc) {
	$pluc = strtolower($pluc);
	$coupon = new WC_Coupon($pluc);
	if($coupon->id == 0 || substr( $pluc, 0, 4 ) != "pluc" ) {
		return false;
	} else {
		return true;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Allow users to view pages if they only have valid pluc 
/*-----------------------------------------------------------------------------------*/
function restrict_page_to_user_with_pluc() {
	$restrict_page_to_users_with_valid_pluc_code = get_field('restrict_page_to_users_with_valid_pluc_code');
	$message = '<div class="container" style="padding-top: 50px; padding-bottom: 50px"> <p> The Open Awards Community discussion forums are only available to Open Awards Providers with valid PLUC code added to their account.  Need Help?  Contact Customer Services Team on <a href="customerservices@openawards.org.uk"> customerservices@openawards.org.uk </a> </p> </div>';


	if($restrict_page_to_users_with_valid_pluc_code || get_post_type() == 'discussion-topics') {
		if(is_user_logged_in()) {
			$current_user = wp_get_current_user();
			$pluc = $current_user->pluc;
			if(!pluc_is_valid($pluc)) {
				get_template_part('template-parts/page', 'banner');
				get_template_part('template-parts/page', 'breadcrumbs');
				echo $message;
				get_footer();
				exit();
			} 
		} else {
			get_template_part('template-parts/page', 'banner');
			get_template_part('template-parts/page', 'breadcrumbs');
			echo $message;
			get_footer();
			exit();
		}
	}
}


/**
 * Apply Discount Coupon automatically to the cart 
 */
function apply_discount_to_cart() {
	$current_user = wp_get_current_user();
	$pluc = $current_user->pluc;

	if(pluc_is_valid($pluc) ) {
		echo '<style> .woocommerce-error {display: none} </style>';
		if ( !WC()->cart->add_discount( sanitize_text_field( $pluc ) ) ) {
			//WC()->show_messages();
		}
	}
}
add_action( 'woocommerce_before_cart_table', 'apply_discount_to_cart' );

add_action( 'woocommerce_before_checkout_form', 'apply_discount_to_cart' );
