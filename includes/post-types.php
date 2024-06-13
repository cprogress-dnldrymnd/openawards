<?php

class newPostType
{
    public $name;
    public $singular_name;
    public $icon;
    public $supports;
    public $rewrite;
    public $show_in_rest = false;
    public $exclude_from_search = false;
    public $publicly_queryable = true;
    public $show_in_admin_bar = true;
    public $has_archive = true;
    public $hierarchical = false;

    function __construct()
    {

        add_action('init', array($this, 'create_post_type'));
    }


    function create_post_type()
    {
        register_post_type(
            strtolower($this->name),
            array(
                'labels'              => array(
                    'name'               => _x($this->name, 'post type general name'),
                    'singular_name'      => _x($this->singular_name, 'post type singular name'),
                    'menu_name'          => _x($this->name, 'admin menu'),
                    'name_admin_bar'     => _x($this->singular_name, 'add new on admin bar'),
                    'add_new'            => _x('Add New', strtolower($this->name)),
                    'add_new_item'       => __('Add New ' . $this->singular_name),
                    'new_item'           => __('New ' . $this->singular_name),
                    'edit_item'          => __('Edit ' . $this->singular_name),
                    'view_item'          => __('View ' . $this->singular_name),
                    'all_items'          => __('All ' . $this->name),
                    'search_items'       => __('Search ' . $this->name),
                    'parent_item_colon'  => __('Parent :' . $this->name),
                    'not_found'          => __('No ' . strtolower($this->name) . ' found.'),
                    'not_found_in_trash' => __('No ' . strtolower($this->name) . ' found in Trash.')
                ),
                'show_in_rest'        => $this->show_in_rest,
                'supports'            => $this->supports,
                'public'              => true,
                'has_archive'         => $this->has_archive,
                'hierarchical'        => $this->hierarchical,
                'rewrite'             => $this->rewrite,
                'menu_icon'           => $this->icon,
                'capability_type'     => 'page',
                'exclude_from_search' => $this->exclude_from_search,
                'publicly_queryable'  => $this->publicly_queryable,
                'show_in_admin_bar'   => $this->show_in_admin_bar,
            )
        );
    }
}

/*-----------------------------------------------------------------------------------*/
/* Taxonomy
/*-----------------------------------------------------------------------------------*/
class newTaxonomy
{
    public $taxonomy;
    public $post_type;
    public $args;

    function __construct()
    {
        add_action('init', array($this, 'create_taxonomy'));
        add_action('restrict_manage_posts', array($this, 'filter_by_taxonomy'), 10, 2);
        add_filter('manage_' . $this->post_type . '_posts_columns', array($this, 'change_table_column_titles'));
        add_filter('manage_' . $this->post_type . '_posts_custom_column', array($this, 'change_column_rows'), 10, 2);
        add_filter('manage_edit-' . $this->post_type . '_sortable_columns', array($this, 'change_sortable_columns'));
    }

    function create_taxonomy()
    {
        register_taxonomy($this->taxonomy, $this->post_type, $this->args);
    }

    function filter_by_taxonomy($post_type, $which)
    {
        // Apply this only on a specific post type
        if ($this->post_type !== $post_type)
            return;

        // A list of taxonomy slugs to filter by
        $taxonomies = array($this->taxonomy);

        foreach ($taxonomies as $taxonomy_slug) {

            // Retrieve taxonomy data
            $taxonomy_obj = get_taxonomy($taxonomy_slug);
            $taxonomy_name = $taxonomy_obj->labels->name;

            // Retrieve taxonomy terms
            $terms = get_terms($taxonomy_slug);

            // Display filter HTML
            echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
            echo '<option value="">' . sprintf(esc_html__('Show All %s', 'text_domain'), $taxonomy_name) . '</option>';
            foreach ($terms as $term) {
                printf(
                    '<option value="%1$s" %2$s>%3$s (%4$s)</option>',
                    $term->slug,
                    ((isset($_GET[$taxonomy_slug]) && ($_GET[$taxonomy_slug] == $term->slug)) ? ' selected="selected"' : ''),
                    $term->name,
                    $term->count
                );
            }
            echo '</select>';
        }
    }
    function change_table_column_titles($columns)
    {
        unset($columns['date']); // temporarily remove, to have custom column before date column
        $columns[$this->taxonomy] = $this->args['label'];
        $columns['date'] = 'Date'; // readd the date column
        return $columns;
    }

    function change_column_rows($column_name, $post_id)
    {
        if ($column_name == $this->taxonomy) {
            echo get_the_term_list($post_id, $this->taxonomy, '', ', ', '') . PHP_EOL;
        }
    }

    function change_sortable_columns($columns)
    {
        $columns[$this->taxonomy] = $this->taxonomy;
        return $columns;
    }
}

$Providers = new newPostType();
$Providers->name = 'Providers';
$Providers->singular_name = 'Provider';
$Providers->icon = 'dashicons-menu-alt3';
$Providers->supports = array('title', 'revisions');
$Providers->exclude_from_search = true;
$Providers->publicly_queryable = false;
$Providers->show_in_admin_bar = false;



add_action('restrict_manage_posts', 'filter_by_taxonomy', 10, 2);

function filter_by_taxonomy($post_type, $which)
{

    // Apply this only on a specific post type
    if ('resources' !== $post_type)
        return;

    // A list of taxonomy slugs to filter by
    $taxonomies = array('industry_category');

    foreach ($taxonomies as $taxonomy_slug) {

        // Retrieve taxonomy data
        $taxonomy_obj = get_taxonomy($taxonomy_slug);
        $taxonomy_name = $taxonomy_obj->labels->name;

        // Retrieve taxonomy terms
        $terms = get_terms($taxonomy_slug);

        // Display filter HTML
        echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
        echo '<option value="">' . sprintf(esc_html__('Show All %s', 'text_domain'), $taxonomy_name) . '</option>';
        foreach ($terms as $term) {
            printf(
                '<option value="%1$s" %2$s>%3$s (%4$s)</option>',
                $term->slug,
                ((isset($_GET[$taxonomy_slug]) && ($_GET[$taxonomy_slug] == $term->slug)) ? ' selected="selected"' : ''),
                $term->name,
                $term->count
            );
        }
        echo '</select>';
    }
}
add_filter('manage_resources_posts_columns', 'change_table_column_titles');
add_filter('manage_resources_posts_custom_column', 'change_column_rows', 10, 2);
add_filter('manage_edit-resources_sortable_columns', 'change_sortable_columns');
function change_table_column_titles($columns)
{
    unset($columns['date']); // temporarily remove, to have custom column before date column
    $columns['industry_category'] = 'Industry Categories';
    $columns['date'] = 'Date'; // readd the date column
    return $columns;
}

function change_column_rows($column_name, $post_id)
{
    if ($column_name == 'industry_category') {
        echo get_the_term_list($post_id, 'industry_category', '', ', ', '') . PHP_EOL;
    }
}

function change_sortable_columns($columns)
{
    $columns['industry_category'] = 'industry_category';
    return $columns;
}



$Team = new newPostType();
$Team->name = 'Slider';
$Team->singular_name = 'Slider';
$Team->icon = 'dashicons-slides';
$Team->supports = array('title');
$Team->exclude_from_search = true;
$Team->publicly_queryable = false;
$Team->show_in_admin_bar = false;
$Team->has_archive = false;



$Team = new newPostType();
$Team->name = 'Teams';
$Team->singular_name = 'Team';
$Team->icon = 'dashicons-groups';
$Team->supports = array('title', 'revisions', 'thumbnail', 'editor');
$Team->exclude_from_search = true;
$Team->publicly_queryable = false;
$Team->show_in_admin_bar = false;
$Team->has_archive = false;




$Teams_Category = new newTaxonomy();
$Teams_Category->taxonomy = 'teams_category';
$Teams_Category->post_type = 'teams';
$Teams_Category->args = array(
    'label'        => 'Teams Categories',
    'rewrite'      => array('slug' => 'teams-category'),
    'hierarchical' => true,
    'query_var'    => false,
    'has_archive'  => false,
    'show_in_rest' => false,
);


$Templates = new newPostType();
$Templates->name = 'Templates';
$Templates->singular_name = 'Template';
$Templates->icon = 'dashicons-format-aside';
$Templates->supports = array('title', 'editor', 'revisions');
$Templates->exclude_from_search = true;
$Templates->publicly_queryable = true;
$Templates->show_in_admin_bar = true;
$Templates->has_archive = false;


$FAQs = new newPostType();
$FAQs->name = 'FAQs';
$FAQs->singular_name = 'FAQ';
$FAQs->icon = 'dashicons-editor-alignleft';
$FAQs->supports = array('title', 'revisions', 'editor');
$FAQs->exclude_from_search = false;
$FAQs->publicly_queryable = true;
$FAQs->show_in_admin_bar = true;
$FAQs->has_archive = true;



$FAQs_Category = new newTaxonomy();
$FAQs_Category->taxonomy = 'faqs_category';
$FAQs_Category->post_type = 'faqs';
$FAQs_Category->args = array(
    'label'        => 'FAQs Categories',
    'rewrite'      => array('slug' => 'faqs-category'),
    'hierarchical' => true,
    'query_var'    => false,
    'has_archive'  => false,
    'show_in_rest' => false,
);


$Success_Stories = new newPostType();
$Success_Stories->name = 'Success Stories';
$Success_Stories->singular_name = 'Success Story';
$Success_Stories->icon = 'dashicons-testimonial';
$Success_Stories->supports = array('title', 'revisions', 'editor', 'page-attributes', 'thumbnail', 'excerpt');
$Success_Stories->exclude_from_search = false;
$Success_Stories->publicly_queryable = true;
$Success_Stories->show_in_admin_bar = true;
$Success_Stories->has_archive = true;
$Success_Stories->rewrite = array(
    'slug'  => 'success-stories',
);

$FAQs_Category = new newTaxonomy();
$FAQs_Category->taxonomy = 'success_stories_location';
$FAQs_Category->post_type = 'successstories';
$FAQs_Category->args = array(
    'label'        => 'Success Stories Locations',
    'rewrite'      => array('slug' => 'success-stories-location'),
    'hierarchical' => true,
    'query_var'    => false,
    'has_archive'  => false,
    'show_in_rest' => false,
);



$Students = new newPostType();
$Students->name = 'Students';
$Students->singular_name = 'Students';
$Students->icon = 'dashicons-welcome-learn-more';
$Students->supports = array('title', 'revisions', 'editor', 'page-attributes', 'thumbnail');
$Students->exclude_from_search = false;
$Students->publicly_queryable = true;
$Students->show_in_admin_bar = true;
$Students->has_archive = true;


$Qualifications = new newPostType();
$Qualifications->name = 'Qualifications';
$Qualifications->singular_name = 'Qualification';
$Qualifications->icon = 'dashicons-welcome-learn-more';
$Qualifications->supports = array('title', 'revisions', 'editor', 'page-attributes', 'thumbnail');
$Qualifications->exclude_from_search = false;
$Students->publicly_queryable = true;
$Qualifications->show_in_admin_bar = true;
$Qualifications->has_archive = true;


// Add the custom columns to the slider post type:
add_filter('manage_slider_posts_columns', 'set_custom_edit_slider_columns');
function set_custom_edit_slider_columns($columns)
{
    unset($columns['author']);
    $columns['shortcode'] = __('Shortcode', 'your_text_domain');

    return $columns;
}

// Add the data to the custom columns for the slider post type:
add_action('manage_slider_posts_custom_column', 'custom_slider_column', 10, 2);
function custom_slider_column($column, $post_id)
{
    switch ($column) {

        case 'shortcode':
            echo '<input type="text" value="[slider slider_id=' . $post_id . ']" readonly/>';
            break;
    }
}


// Add the custom columns to the templates post type:
add_filter('manage_templates_posts_columns', 'set_custom_edit_templates_columns');
function set_custom_edit_templates_columns($columns)
{
    unset($columns['author']);
    $columns['shortcode'] = __('Shortcode', 'your_text_domain');

    return $columns;
}

// Add the data to the custom columns for the templates post type:
add_action('manage_templates_posts_custom_column', 'custom_templates_column', 10, 2);
function custom_templates_column($column, $post_id)
{
    switch ($column) {

        case 'shortcode':
            echo '<input type="text" value="[template template_id=' . $post_id . ']" readonly/>';
            break;
    }
}
