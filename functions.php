<?php
/*-----------------------------------------------------------------------------------*/
/* This file will be referenced every time a template/page loads on your Wordpress site
	/* This is the place to define custom fxns and specialty code
	/*-----------------------------------------------------------------------------------*/

// Define the version so we can easily replace it throughout the theme
define('NAKED_VERSION', 1.0);

/*-----------------------------------------------------------------------------------*/
/*  Set the maximum allowed width for any content in the theme
/*-----------------------------------------------------------------------------------*/
require_once(dirname(__FILE__) . '/redux/barebones-config.php');

if (!isset($content_width)) $content_width = 900;

/*-----------------------------------------------------------------------------------*/
/* Add Rss feed support to Head section
/*-----------------------------------------------------------------------------------*/
add_theme_support('automatic-feed-links');

/*-----------------------------------------------------------------------------------*/
/* Add post thumbnail/featured image support
/*-----------------------------------------------------------------------------------*/
add_theme_support('post-thumbnails');

add_theme_support('woocommerce');

/*-----------------------------------------------------------------------------------*/
/* Register main menu for Wordpress use
/*-----------------------------------------------------------------------------------*/
register_nav_menus(
	array(
		'primary'	=>	__('Primary Menu', 'naked'), // Register the Primary menu
		'footer-1'	=>	__('Footer Menu 1', 'naked'),
		'footer2'	=>	__('Footer Menu 2', 'naked'),
		'footer3'	=>	__('Footer Menu 3', 'naked'),
		// Copy and paste the line above right here if you want to make another menu, 
		// just change the 'primary' to another name
	)
);


/*-----------------------------------------------------------------------------------*/
/* Get resources image
/*-----------------------------------------------------------------------------------*/

function get_resource_image($resource_type, $resource_thumbnail)
{


	if ($resource_type == 'Brochure') {

		$thumb = '<img src="' . get_stylesheet_directory_uri() . '/assets/images/thumb-3.jpg"/>';
	}
	else if ($resource_type == 'Technical Data') {

		$thumb = '<img src="' . get_stylesheet_directory_uri() . '/assets/images/thumb-1.jpg"/>';
	}
	else {
		$thumb = '<img src="' . get_stylesheet_directory_uri() . '/assets/images/thumb-2.jpg"/>';
	}

	if ($resource_thumbnail) {

		$return = '<img src="' . wp_get_attachment_image_url($resource_thumbnail, 'large') . '"/>';
	}
	else {
		$return = $thumb;
	}


	return $return;
}
require_once('includes/post-types.php');
require_once('includes/shortcodes.php');
require_once('includes/woocommerce.php');
require_once('includes/ajax.php');

/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/

function naked_scripts()
{

	// get the theme directory style.css and link to it in the header
	wp_enqueue_style('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
	wp_enqueue_style('fontawesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
	wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css');
	wp_enqueue_style('fancybox-css', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');
	wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
	wp_enqueue_style('main.css', get_template_directory_uri() . '/style.css');
	// add theme scripts
	//wp_enqueue_script( 'jQuery', '//code.jquery.com/jquery-3.2.1.slim.min.js');
	wp_enqueue_script('jQuery');
	wp_enqueue_script('bootstrap-js', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js');
	wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js');
	wp_enqueue_script('fancybox-js', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js');
	wp_enqueue_script('naked', get_template_directory_uri() . '/js/theme.min.js', array(), NAKED_VERSION, true);
}
add_action('wp_enqueue_scripts', 'naked_scripts'); // Register this fxn and allow Wordpress to call it automatcally in the header



/*-----------------------------------------------------------------------------------*/
/* Activate sidebar for Wordpress use
/*-----------------------------------------------------------------------------------*/
function naked_register_sidebars()
{
	register_sidebar(array(				// Start a series of sidebars to register
		'id' => 'sidebar', 					// Make an ID
		'name' => 'Sidebar',				// Name it
		'description' => 'Take it on the side...', // Dumb description for the admin side
		'before_widget' => '<div>',	// What to display before each widget
		'after_widget' => '</div>',	// What to display following each widget
		'before_title' => '<h3 class="side-title">',	// What to display before each widget's title
		'after_title' => '</h3>',		// What to display following each widget's title
		'empty_title' => '',					// What to display in the case of no title defined for a widget
		// Copy and paste the lines above right here if you want to make another sidebar, 
		// just change the values of id and name to another word/name
	));
	register_sidebar(array(				// Start a series of sidebars to register
		'id' => 'footer1', 					// Make an ID
		'name' => 'Footer 1',				// Name it
		'description' => 'What do you want to put on the first column of the footer', // Dumb description for the admin side
		'before_widget' => '<div class="col-lg-2 col-md-2">',	// What to display before each widget
		'after_widget' => '</div>',	// What to display following each widget
		'before_title' => '<h5 class="widget-title">',	// What to display before each widget's title
		'after_title' => '</h5>',		// What to display following each widget's title
		'empty_title' => '',					// What to display in the case of no title defined for a widget
	));

	register_sidebar(array(				// Start a series of sidebars to register
		'id' => 'footer2', 					// Make an ID
		'name' => 'Footer 2',				// Name it
		'description' => 'What do you want to put on the first column of the footer', // Dumb description for the admin side
		'before_widget' => '<div class="col-lg-2 col-md-2">',	// What to display before each widget
		'after_widget' => '</div>',	// What to display following each widget
		'before_title' => '<h5 class="widget-title">',	// What to display before each widget's title
		'after_title' => '</h5>',		// What to display following each widget's title
		'empty_title' => '',					// What to display in the case of no title defined for a widget
	));

	register_sidebar(array(				// Start a series of sidebars to register
		'id' => 'footer3', 					// Make an ID
		'name' => 'Footer 3',				// Name it
		'description' => 'What do you want to put on the first column of the footer', // Dumb description for the admin side
		'before_widget' => '<div class="col-lg-2 col-md-2">',	// What to display before each widget
		'after_widget' => '</div>',	// What to display following each widget
		'before_title' => '<h5 class="widget-title">',	// What to display before each widget's title
		'after_title' => '</h5>',		// What to display following each widget's title
		'empty_title' => '',					// What to display in the case of no title defined for a widget
	));

	register_sidebar(array(				// Start a series of sidebars to register
		'id' => 'footer4', 					// Make an ID
		'name' => 'Footer Opening Hours',				// Name it
		'description' => 'What do you want to put on the first column of the footer', // Dumb description for the admin side
		'before_widget' => '',	// What to display before each widget
		'after_widget' => '',	// What to display following each widget
		'before_title' => '<h5 class="widget-title">',	// What to display before each widget's title
		'after_title' => '</h5>',		// What to display following each widget's title
		'empty_title' => '',					// What to display in the case of no title defined for a widget
	));
}
// adding sidebars to Wordpress (these are created in functions.php)
add_action('widgets_init', 'naked_register_sidebars');



/*-----------------------------------------------------------------------------------*/
/* Search title only
/*-----------------------------------------------------------------------------------*/
function __search_by_title_only($search, $wp_query)
{
	global $wpdb;
	if (empty($search))
		return $search; // skip processing - no search term in query
	$q = $wp_query->query_vars;
	$n = !empty($q['exact']) ? '' : '%';
	$search =
		$searchand = '';
	foreach ((array) $q['search_terms'] as $term) {
		$term = esc_sql(like_escape($term));
		$search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
		$searchand = ' AND ';
	}
	if (!empty($search)) {
		$search = " AND ({$search}) ";
		if (!is_user_logged_in())
			$search .= " AND ($wpdb->posts.post_password = '') ";
	}
	return $search;
}
add_filter('posts_search', '__search_by_title_only', 500, 2);

/*-----------------------------------------------------------------------------------*/
/* Disable Gutenberg Editor
/*-----------------------------------------------------------------------------------*/
add_filter('use_block_editor_for_post', '__return_false');

/*-----------------------------------------------------------------------------------*/
/* Header Class
/*-----------------------------------------------------------------------------------*/
function header_class()
{
	$page_template = get_page_template_slug(get_the_ID());
	$post_type = get_post_type();
	if ($post_type == 'location' || $post_type == 'event' || $page_template == 'templates/page-with-dark-header.php' || $page_template == 'templates/page-event.php' || $post_type == 'discussion-topics' || $page_template == 'templates/page-community.php') {
		echo 'class="darkHeader"';
	}
	/*if(is_account_page()) {
		if(is_user_logged_in()) {
			echo 'class="darkHeader"';
		}
	} else {
		if($post_type == 'location' || $post_type == 'event' || $page_template == 'templates/page-with-dark-header.php' || $page_template == 'templates/page-event.php' || $post_type == 'discussion-topics') {
			echo 'class="darkHeader"';
		} 
	}*/
	return;
}
function logo()
{
	global $redux_demo;
	$page_template = get_page_template_slug(get_the_ID());
	$post_type = get_post_type();
	if ($post_type == 'location' || $post_type == 'event' || $page_template == 'templates/page-with-dark-header.php' || $page_template == 'templates/page-event.php' || $post_type == 'discussion-topics' || $page_template == 'templates/page-community.php') {
		echo $redux_demo['opt-logo-white']['url'];
	} else {
		echo $redux_demo['opt-logo']['url'];
	}
	/*if(is_account_page()) {
		if(is_user_logged_in()) {
			echo $redux_demo['opt-logo-white']['url'];
		} else {
			echo $redux_demo['opt-logo']['url'];
		}
	} else {
		if($post_type == 'location' || $post_type == 'event' || $page_template == 'templates/page-with-dark-header.php' || $page_template == 'templates/page-event.php' || $post_type == 'discussion-topics') {
			echo $redux_demo['opt-logo-white']['url'];
		} else {
			echo $redux_demo['opt-logo']['url'];
		}
	}
	*/
	return;
}

/*-----------------------------------------------------------------------------------*/
/* Add class to body
/*-----------------------------------------------------------------------------------*/
function wp_body_classes($classes)
{
	$page_template = get_page_template_slug(get_the_ID());
	$post_type = get_post_type();

	if (!is_user_logged_in()) {
		$classes[] = 'not-logged-in';
	}

	if ($post_type == 'location' || $post_type == 'event' || $page_template == 'templates/page-with-dark-header.php' || $page_template == 'templates/page-event.php' || $page_template == 'templates/page-small-page-banner.php' || $post_type == 'discussion-topics' || $page_template == 'templates/page-community.php') {
		$classes[] = 'page-is-dark-header';
	}
	return $classes;
}
add_filter('body_class', 'wp_body_classes');

/*-----------------------------------------------------------------------------------*/
/* Discussion View
/*-----------------------------------------------------------------------------------*/
function gt_get_post_view()
{
	$count = get_post_meta(get_the_ID(), 'post_views_count', true);
	$count_val = $count ? $count : 0;
	return "<span>$count_val</span> <span>views</span>";
}
function gt_set_post_view()
{
	$key = 'post_views_count';
	$post_id = get_the_ID();
	$count = (int) get_post_meta($post_id, $key, true);
	$count++;
	update_post_meta($post_id, $key, $count);
}
function gt_posts_column_views($columns)
{
	$columns['post_views'] = 'Views';
	return $columns;
}
function gt_posts_custom_column_views($column)
{
	if ($column === 'post_views') {
		echo gt_get_post_view();
	}
}
add_filter('manage_posts_columns', 'gt_posts_column_views');
add_action('manage_posts_custom_column', 'gt_posts_custom_column_views');


/*-----------------------------------------------------------------------------------*/
/* Pagination
/*-----------------------------------------------------------------------------------*/

function open_awards_pagination($custom_query)
{
	$total_pages = $custom_query->max_num_pages;
	$big = 999999999; // need an unlikely integer

	if ($total_pages > 1) {
		$current_page = max(1, get_query_var('paged'));

		echo paginate_links(array(
			'prev_text' => '<i class="fas fa-arrow-left"></i>',
			'next_text' => '<i class="fas fa-arrow-right"></i>',
			'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
			'format' => '?paged=%#%',
			'current' => $current_page,
			'total' => $total_pages,

		));
	}
}

/*-----------------------------------------------------------------------------------*/
/* Selected Value of select
/*-----------------------------------------------------------------------------------*/
function selected_option($val1, $val2)
{
	if ($val1 == $val2) {
		return 'selected';
	}
}

/*-----------------------------------------------------------------------------------*/
/* WP Head
/*-----------------------------------------------------------------------------------*/
function open_awards_wp_head()
{
	$background_color = get_field('background_color') ? get_field('background_color') : 'transparent';
	if ($background_color) {
?>
		<style>
			html body {
				background-color: <?= $background_color  ?> !important;
			}
		</style>
<?php
	}
}
add_action('wp_head', 'open_awards_wp_head');


/*-----------------------------------------------------------------------------------*/
/* Get Container Width
/*-----------------------------------------------------------------------------------*/
function container_width()
{
	$container_width = get_field('container_width');
	if ($container_width != 'default') {
		return ' ' . $container_width;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Admin Scripts
/*-----------------------------------------------------------------------------------*/
function wpdocs_selectively_enqueue_admin_script($hook)
{
	wp_enqueue_script(
		'admin-scripts', //unique handle
		get_template_directory_uri() . '/js/admin-scripts.js', //location
		array('jquery')  //dependencies
	);
}
add_action('admin_enqueue_scripts', 'wpdocs_selectively_enqueue_admin_script');


/*-----------------------------------------------------------------------------------*/
/* Provider Options
/*-----------------------------------------------------------------------------------*/
function provider_options($array = false, $option = '', $option_arr = array())
{

	$user = wp_get_current_user();

	$args = array(
		'numberposts' => -1,
		'post_type'   => 'providers'
	);

	$providers = get_posts($args);

	foreach ($providers as $provider) {

		$provider_number = get_field('provider_number', $provider->ID);

		if ($user->provider_name == $provider->ID) {
			$selected = 'selected';
		} else {
			$selected = '';
		}
		$option_arr[$provider->ID] = $provider->post_title . ' - ' . $provider_number;

		$provider_title = ($provider_number != 0) ? $provider->post_title . ' - ' . $provider_number : $provider->post_title;

		$option .= "<option $selected value='$provider->ID'>$provider_title</option>";
	}
	if ($array) {
		return $option_arr;
	} else {
		return $option;
	}
}


// Register Custom Post Type
function cpt_slider()
{

	$labels = array(
		'name'                  => _x('Sliders', 'Post Type General Name', 'text_domain'),
		'singular_name'         => _x('Slider', 'Post Type Singular Name', 'text_domain'),
		'menu_name'             => __('Slider', 'text_domain'),
		'name_admin_bar'        => __('Slider', 'text_domain'),
		'archives'              => __('Item Archives', 'text_domain'),
		'attributes'            => __('Item Attributes', 'text_domain'),
		'parent_item_colon'     => __('Parent Item:', 'text_domain'),
		'all_items'             => __('All Items', 'text_domain'),
		'add_new_item'          => __('Add New Item', 'text_domain'),
		'add_new'               => __('Add New', 'text_domain'),
		'new_item'              => __('New Item', 'text_domain'),
		'edit_item'             => __('Edit Item', 'text_domain'),
		'update_item'           => __('Update Item', 'text_domain'),
		'view_item'             => __('View Item', 'text_domain'),
		'view_items'            => __('View Items', 'text_domain'),
		'search_items'          => __('Search Item', 'text_domain'),
		'not_found'             => __('Not found', 'text_domain'),
		'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
		'featured_image'        => __('Featured Image', 'text_domain'),
		'set_featured_image'    => __('Set featured image', 'text_domain'),
		'remove_featured_image' => __('Remove featured image', 'text_domain'),
		'use_featured_image'    => __('Use as featured image', 'text_domain'),
		'insert_into_item'      => __('Insert into item', 'text_domain'),
		'uploaded_to_this_item' => __('Uploaded to this item', 'text_domain'),
		'items_list'            => __('Items list', 'text_domain'),
		'items_list_navigation' => __('Items list navigation', 'text_domain'),
		'filter_items_list'     => __('Filter items list', 'text_domain'),
	);
	$args = array(
		'label'                 => __('Slider', 'text_domain'),
		'description'           => __('Post Type Description', 'text_domain'),
		'labels'                => $labels,
		'supports'              => array('title'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'rewrite'               => false,
		'capability_type'       => 'page',
		'show_in_rest'          => false,
	);
	register_post_type('slider', $args);
}
add_action('init', 'cpt_slider', 0);

/*-----------------------------------------------------------------------------------*/
/* Register Carbofields
/*-----------------------------------------------------------------------------------*/
add_action('carbon_fields_register_fields', 'tissue_paper_register_custom_fields');
function tissue_paper_register_custom_fields()
{
	require_once('includes/post-meta.php');
}

