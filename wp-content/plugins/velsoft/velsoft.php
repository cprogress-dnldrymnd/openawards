<?php

require "hawk/vendor/autoload.php";

/***
 * Plugin Name: Velsoft Custom Functions
 * Description: .
 * Author: Brandon Lewis / Ian Taylor
 * Version: 1.0
 ***/

session_start();

add_filter('woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args');

function custom_woocommerce_get_catalog_ordering_args($args)
{
	$orderby_value = isset($_GET['orderby']) ? woocommerce_clean($_GET['orderby']) : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby'));

	if ('random_list' == $orderby_value) {
		$args['orderby']  = 'rand';
		$args['order']    = '';
		$args['meta_key'] = '';
	}
	return $args;
}

add_filter('woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby');
add_filter('woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby');

function custom_woocommerce_catalog_orderby($sortby)
{
	$sortby['random_list'] = 'Random';
	return $sortby;
}

function _znanja_request($url, $method, $payload = array())
{

	$api_key     = "447a1568-1711-4f76-9517-229d402002ad";
	$api_id      = "public_api:membership:527699:14381";
	$credentials = new Dflydev\Hawk\Credentials\Credentials(
		$api_key,
		'sha256',
		$api_id
	);

	// Create a Hawk client
	$client = Dflydev\Hawk\Client\ClientBuilder::create()->build();

	$pay = array(
		'payload'      => json_encode($payload),
		'content_type' => 'application/json',
	);

	$request = $client->createRequest(
		$credentials,
		$url,
		$method,
		$pay
	);

	$args = array(
		'body'    => json_encode($payload),
		'headers' => array(
			$request->header()->fieldName() => $request->header()->fieldValue(),
		),
	);

	if ($method == "GET") {
		$response = wp_remote_get($url, $args);
	}

	if ($method == "POST") {
		$response = wp_remote_post($url, $args);
	}

	if ($method == "PUT") {
		$args['method'] = 'PUT';
		$response       = wp_remote_post($url, $args);
	}

	$result = wp_remote_retrieve_body($response);

	return json_decode($result);
}

function sync_lms($order_id)
{
	$order = new WC_Order($order_id);

	$downloadable = 0;
	foreach ($order->get_items() as $item) {
		$product = new WC_Product($item['product_id']);

		if ($product->is_downloadable() or $product->get_sku() == "") {
			$downloadable++;
		}
	}

	if ($downloadable == count($order->get_items())) {
		return;
	}

	$email      = $order->billing_email;
	$first_name = $order->billing_first_name;
	$last_name  = $order->billing_last_name;

	$existing_user = _znanja_request("https://api.znanja.com/api/hawk/v1/users?search=$email&inactive=true&sysadmins=true", "GET");

	if (count($existing_user) > 0) {
		// Existing user exists so no need to create another
		// You can only have 1 user per email so we can safely use the first index in this case
		$json = $existing_user[0];

		_znanja_request("https://api.znanja.com/api/hawk/v1/user/" . $json->id, "PUT");

	} else {
		// No user, create a new one.
		$payload = array(
			"first_name" => $first_name,
			"last_name"  => $last_name,
			"is_active"  => true,
			"email"      => $email,
			"notify"     => false,
		);

		foreach ($order->get_items() as $item) {
			$product = new WC_Product($item['product_id']);
			if ($product->get_sku() == 'fullpackage') {
				// Assign the user to the full library group
				$payload['expiry'] = date('Y-m-d', strtotime("+6 months"));
			}
		}

		$json = _znanja_request("https://api.znanja.com/api/hawk/v1/user", "PUT", $payload);

		$password   = $json->password;
		$user_email = $json->email;
		$user_name  = $json->first_name;
		$site_url   = get_site_url();

		$message = <<<MESSAGE
Hi $user_name,<br /><br />

You are receiving this message because an eLearning account has
been created for you.<br />

Your log-in information is:<br /><br />

Username: $user_email <br />
Password: $password <br />

To login:<br /><br />

1. Browse to $site_url <br />
2. Click login in the menu.<br />

MESSAGE;

		$headers = array('Content-Type: text/html; charset=UTF-8');
		wp_mail($user_email, 'Online Learning: Account Login', $message, $headers);
		//wp_mail('brandon@velsoft.com', 'Online Learning: Account Login', $message);

	}

	$totalProducts = $order->get_item_count();
	$expiry        = date('Y-m-d', strtotime("+12 months"));

	foreach ($order->get_items() as $item) {

		$product = new WC_Product($item['product_id']);

		_znanja_request('https://api.znanja.com/api/hawk/v1/' . $json->id . '-' . $product->get_sku() . '/enroll', "PUT", array(
			'granted' => array('view'),
			'expiry'  => $expiry,
		));

	}
}

add_filter('woocommerce_payment_complete_order_status', 'wc_skip_processing');
function wc_skip_processing($status)
{
	return 'completed';
}

add_action('woocommerce_order_status_completed', 'sync_lms');
function custom_woocommerce_auto_complete_order($order_id)
{
	if (!$order_id) {
		return;
	}
	$order = new WC_Order($order_id);
	$order->update_status('completed');
}
add_action('woocommerce_thankyou', 'custom_woocommerce_auto_complete_order');
