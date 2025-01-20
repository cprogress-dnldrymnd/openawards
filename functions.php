<?php
/*-----------------------------------------------------------------------------------*/
/* This file will be referenced every time a template/page loads on your Wordpress site
	/* This is the place to define custom fxns and specialty code
	/*-----------------------------------------------------------------------------------*/

// Define the version so we can easily replace it throughout the theme
define('NAKED_VERSION', 1.0);

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
		'primary' => __('Primary Menu', 'naked'), // Register the Primary menu
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
	} else if ($resource_type == 'Technical Data') {

		$thumb = '<img src="' . get_stylesheet_directory_uri() . '/assets/images/thumb-1.jpg"/>';
	} else {
		$thumb = '<img src="' . get_stylesheet_directory_uri() . '/assets/images/thumb-2.jpg"/>';
	}

	if ($resource_thumbnail) {

		$return = '<img src="' . wp_get_attachment_image_url($resource_thumbnail, 'large') . '"/>';
	} else {
		$return = $thumb;
	}


	return $return;
}


/*-----------------------------------------------------------------------------------*/
/* Register Carbofields
/*-----------------------------------------------------------------------------------*/
add_action('carbon_fields_register_fields', 'tissue_paper_register_custom_fields');
function tissue_paper_register_custom_fields()
{
	require_once('includes/post-meta.php');
}


require_once('includes/post-types.php');
require_once('includes/shortcodes.php');
require_once('includes/woocommerce.php');
require_once('includes/ajax.php');
require_once('includes/quba.php');
require_once('includes/wp-bakery.php');

/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/

function naked_scripts()
{

	// get the theme directory style.css and link to it in the header
	wp_enqueue_style('fontawesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
	wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css');
	wp_enqueue_style('fancybox-css', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');
	wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
	wp_enqueue_style('main.css', get_template_directory_uri() . '/style.css');
	// add theme scripts
	//wp_enqueue_script( 'jQuery', '//code.jquery.com/jquery-3.2.1.slim.min.js');
	wp_enqueue_script('jQuery');
	wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js');
	wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js');
	wp_enqueue_script('fancybox-js', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js');
	//wp_enqueue_script('naked', get_template_directory_uri() . '/js/theme.min.js', array(), NAKED_VERSION, true);
	wp_enqueue_script('naked', get_template_directory_uri() . '/js/main.js');
}
add_action('wp_enqueue_scripts', 'naked_scripts'); // Register this fxn and allow Wordpress to call it automatcally in the header



/*-----------------------------------------------------------------------------------*/
/* Activate sidebar for Wordpress use
/*-----------------------------------------------------------------------------------*/
function naked_register_sidebars()
{
	register_sidebar(array(				// Start a series of sidebars to register
		'id'            => 'sidebar', 					// Make an ID
		'name'          => 'Sidebar',				// Name it
		'description'   => 'Take it on the side...', // Dumb description for the admin side
		'before_widget' => '<div>',	// What to display before each widget
		'after_widget'  => '</div>',	// What to display following each widget
		'before_title'  => '<h3 class="side-title">',	// What to display before each widget's title
		'after_title'   => '</h3>',		// What to display following each widget's title
		'empty_title'   => '',					// What to display in the case of no title defined for a widget
		// Copy and paste the lines above right here if you want to make another sidebar, 
		// just change the values of id and name to another word/name
	));
	register_sidebar(array(				// Start a series of sidebars to register
		'id'            => 'footer1', 					// Make an ID
		'name'          => 'Footer 1',				// Name it
		'before_widget' => '<div class="col-lg-2 col-md-2">',	// What to display before each widget
		'after_widget'  => '</div>',	// What to display following each widget
		'before_title'  => '<h5 class="widget-title">',	// What to display before each widget's title
		'after_title'   => '</h5>',		// What to display following each widget's title
		'empty_title'   => '',					// What to display in the case of no title defined for a widget
	));

	register_sidebar(array(				// Start a series of sidebars to register
		'id'            => 'footer2', 					// Make an ID
		'name'          => 'Footer 2',				// Name it
		'before_widget' => '<div class="col-lg-2 col-md-2">',	// What to display before each widget
		'after_widget'  => '</div>',	// What to display following each widget
		'before_title'  => '<h5 class="widget-title">',	// What to display before each widget's title
		'after_title'   => '</h5>',		// What to display following each widget's title
		'empty_title'   => '',					// What to display in the case of no title defined for a widget
	));

	register_sidebar(array(				// Start a series of sidebars to register
		'id'            => 'footer3', 					// Make an ID
		'name'          => 'Footer 3',				// Name it
		'before_widget' => '<div class="col-lg-2 col-md-2">',	// What to display before each widget
		'after_widget'  => '</div>',	// What to display following each widget
		'before_title'  => '<h5 class="widget-title">',	// What to display before each widget's title
		'after_title'   => '</h5>',		// What to display following each widget's title
		'empty_title'   => '',					// What to display in the case of no title defined for a widget
	));

	register_sidebar(array(				// Start a series of sidebars to register
		'id'            => 'footer4', 					// Make an ID
		'name'          => 'Footer Opening Hours',				// Name it
		'before_widget' => '',	// What to display before each widget
		'after_widget'  => '',	// What to display following each widget
		'before_title'  => '<h5 class="widget-title">',	// What to display before each widget's title
		'after_title'   => '</h5>',		// What to display following each widget's title
		'empty_title'   => '',					// What to display in the case of no title defined for a widget
	));
	register_sidebar(array(				// Start a series of sidebars to register
		'id'            => 'footer_bottom_links', 					// Make an ID
		'name'          => 'Footer Bottom Links',				// Name it
		'before_widget' => '',	// What to display before each widget
		'after_widget'  => '',	// What to display following each widget
		'before_title'  => '<h5 class="widget-title">',	// What to display before each widget's title
		'after_title'   => '</h5>',		// What to display following each widget's title
		'empty_title'   => '',					// What to display in the case of no title defined for a widget
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
	if ($post_type == 'location' || $page_template == 'templates/page-with-dark-header.php' || $post_type == 'discussion-topics' || $page_template == 'templates/page-community.php') {
		echo 'class="darkHeader"';
	}
	/*if(is_account_page()) {
		 if(is_user_logged_in()) {
			 echo 'class="darkHeader"';
		 }
	 } else {
		 if($post_type == 'location' || $post_type == 'event' || $page_template == 'templates/page-with-dark-header.php'  || $post_type == 'discussion-topics') {
			 echo 'class="darkHeader"';
		 } 
	 }*/
	return;
}
function logo()
{
	global $theme_settings;
	$page_template = get_page_template_slug(get_the_ID());
	$post_type = get_post_type();
	if ($post_type == 'location' || $page_template == 'templates/page-with-dark-header.php' || $post_type == 'discussion-topics' || $page_template == 'templates/page-community.php') {
		return $theme_settings['alt_logo_url'];
	} else {
		return $theme_settings['logo_url'];
	}
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

	if ($post_type == 'location' || $page_template == 'templates/page-with-dark-header.php' || $page_template == 'templates/page-small-page-banner.php' || $post_type == 'discussion-topics' || $page_template == 'templates/page-community.php') {
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
			'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
			'format'    => '?paged=%#%',
			'current'   => $current_page,
			'total'     => $total_pages,

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
				background-color:
					<?= $background_color ?> !important;
			}
		</style>
	<?php
	}
}
add_action('wp_head', 'open_awards_wp_head');




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




add_action('init', 'theme_settings');


function action_jobs_before_main_content()
{
	get_template_part('template-parts/page', 'breadcrumbs');
}

add_action('jobs_before_main_content', 'action_jobs_before_main_content');


function _date_format($string, $format = 'D M j Y')
{
	$date = strtotime($string);

	return date($format, $date);
}

function make_google_calendar_link($name, $begin, $end, $location, $details)
{
	$params = array('&dates=', '/', '&details=', '&location=', '&sf=true&output=xml');
	$url = 'https://www.google.com/calendar/render?action=TEMPLATE&text=';
	$arg_list = func_get_args();
	for ($i = 0; $i < count($arg_list); $i++) {
		$current = $arg_list[$i];
		if (is_int($current)) {
			$t = new DateTime('@' . $current, new DateTimeZone('UTC'));
			$current = $t->format('Ymd\THis\Z');
			unset($t);
		} else {
			$current = urlencode($current);
		}
		$url .= (string) $current . $params[$i];
	}
	return $url;
}


add_action('wp_ajax_insert_post_ajax', 'insert_post_ajax');
add_action('wp_ajax_nopriv_insert_post_ajax', 'insert_post_ajax');

function insert_post_ajax()
{
	$post_data = array();
	$post_id = $_POST['post_id'];
	$post_title = $_POST['post_title'];
	$post_content = $_POST['post_content'];
	$meta_input = $_POST['meta_input'];
	$post_type = $_POST['post_type'];

	$post_data['post_type'] = $post_type;
	$post_data['post_title'] = $post_title;
	$post_data['post_status'] = 'publish';
	$post_data['meta_input'] = json_decode(stripslashes($meta_input), true);
	if ($post_content) {
		$post_data['post_content'] = html_entity_decode($post_content);
	}
	echo '<tr>';
	echo '<td>';
	?>
	<div class="accordion" id="accordionQual-<?= clean($post_title) ?>-<?= clean($post_title) ?>">
		<div class="accordion-item">
			<h2 class="accordion-header" id="heading<?= clean($post_title) ?>-<?= clean($post_title) ?>">
				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
					data-bs-target="#collapse<?= clean($post_title) ?>-<?= clean($post_title) ?>" aria-expanded="false"
					aria-controls="collapse<?= clean($post_title) ?>-<?= clean($post_title) ?>">
					<?= $post_title ?>
				</button>
			</h2>
			<div id="collapse<?= clean($post_title) ?>-<?= clean($post_title) ?>" class="accordion-collapse collapse"
				aria-labelledby="heading<?= clean($post_title) ?>-<?= clean($post_title) ?>"
				data-bs-parent="#accordionQual-<?= clean($post_title) ?>-<?= clean($post_title) ?>">
				<div class="accordion-body">
					<pre>
						<?php var_dump($post_data); ?>
					</pre>
				</div>
			</div>
		</div>
	</div>
	<?php
	echo '</td>';
	if ($post_id == false) {
		// Insert the post into the database
		$insert = wp_insert_post($post_data);

		if ($insert) {
			echo '<td>';
			echo 'Inserted';
			echo '</td>';

			echo '<td>';
			echo '<a class="btn btn-primary" target="_blank" href="' . get_permalink($insert) . '"> Visit </a>';
			echo '</td>';
		}
	} else {
		$post_data['ID'] = $post_id;
		$update = wp_update_post($post_data);
		if ($update) {
			echo '<td>';
			echo 'Updated';
			echo '</td>';

			echo '<td>';
			echo '<a class="btn btn-primary" target="_blank" href="' . get_permalink($post_id) . '"> Visit </a>';
			echo '</td>';
		}
	}
	echo '</tr>';
	die();
}


function get_unique_meta_values($meta_key)
{
	global $wpdb;

	$query = $wpdb->prepare(
		"SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key = %s",
		$meta_key
	);

	$unique_values = $wpdb->get_col($query);

	return $unique_values;
}


function clean($string)
{
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}


add_post_type_support('page', 'excerpt');

function hero($title = 'default', $description = 'default', $bg_image = true, $section_class = '')
{
	ob_start();
	$hero_type = get_field('hero_type');
	$has_post_thumbnail = has_post_thumbnail();
	if ($has_post_thumbnail && $bg_image == true && $hero_type != 'image_on_right') {
		$background = get_the_post_thumbnail_url(get_the_ID(), 'full');
		$class = 'has-bg';
	} else {
		$background = '/wp-content/uploads/2024/12/qual-hero-bg.png';
		$class = 'no-bg';
	}
	if ($title == 'default') {
		if (get_field('alt_title')) {
			$title = get_field('alt_title');
		} else {
			$title = get_the_title();
		}
	}

	if ($description == 'default') {
		if (get_the_excerpt()) {
			$description = get_the_excerpt();
		} else {
			$description = false;
		}
	}


	?>
	<section class="hero-style-1 hero-style-padding <?= $class ?> <?= $section_class ?>"
		style="background-image: url(<?= $background ?>)">
		<div class="container position-relative">
			<div class="inner-container">
				<?php
				if ($hero_type == 'image_on_right' && $has_post_thumbnail) {
					echo '<div class="row align-items-center g-4">';
					echo '<div class="col-lg-7">';
				}
				?>
				<div class="title-box">
					<h1>
						<?= $title ?>
					</h1>
				</div>
				<?php if ($description) { ?>
					<div class="desc-box">
						<?= wpautop($description) ?>
					</div>
				<?php } ?>
				<?php
				if ($hero_type == 'image_on_right' && $has_post_thumbnail) {
					echo '</div>';

					echo '<div class="col-lg-5">';
					echo get_the_post_thumbnail(get_the_ID(), 'large');
					echo '</div>';
					echo '</div>';
				}
				?>
			</div>
		</div>
	</section>
<?php
	return ob_get_clean();
}
