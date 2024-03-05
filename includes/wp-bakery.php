<?php
if (function_exists('vc_map')) {
    add_action('vc_before_init', 'vc_map_team_slider');
    function vc_map_team_slider()
    {
        $terms = get_terms(array(
            'taxonomy'   => 'teams_category',
            'hide_empty' => false,
        ));

        $category = array();

        $category['All'] = 'all';

        foreach ($terms as $term) {
            $category[$term->name] = $term->term_id;
        }

        $style = array(
            'Style 1' => 'style-1',
            'Style 2' => 'style-2',
            'Style 3' => 'style-3',
        );

        vc_map(array(
            "name" => "Team Slider",
            "base" => "team_slider",
            "category" => "Open Awards",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => "Category",
                    "param_name" => "category",
                    "value" => $category,
                    "description" => "Select the team category you want to display."
                ),

                array(
                    "type" => "dropdown",
                    "heading" => "Style",
                    "param_name" => "style",
                    "value" => $style,
                    "description" => "Select the team category style."
                ),
            )

        ));
    }
}

function action_team_slider($atts)
{
    ob_start();
    extract(shortcode_atts(array(
        'category' => 'all',
        'style' => 'style-1',
    ), $atts));

    $args['post_type'] = 'teams';
    $args['posts_per_page'] = -1;

    if ($category != 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'teams_category',
                'field'    => 'term_id',
                'terms'    => $category
            )
        );


        $term = get_term($category, 'teams_category');



        $heading = $term->name;
    } else {
        $heading = 'Teams';
    }


    $teams = get_posts($args);

?>
    <div class="team-slider <?= $style ?>">
        <div class="heading-box text-center">
            <h2>
                <?= $heading ?>
            </h2>
        </div>
        <div class="swiper team-swiper">
            <div class="swiper-wrapper">
                <?php foreach ($teams as $team) { ?>
                    <?php
                    $position = carbon_get_post_meta($team->ID, 'position');
                    $linked_in = carbon_get_post_meta($team->ID, 'linked_in');
                    ?>
                    <div class="swiper-slide">
                        <div class="inner">
                            <div class="image-box">
                                <img src="<?= wp_get_attachment_image_url(get_post_thumbnail_id($team->ID), 'Medium') ?>" alt="<?= $team->post_title ?>">
                            </div>
                            <div class="content-box">
                                <div class="name">
                                    <?= $team->post_title ?>
                                </div>
                                <?php if ($style == 'style-3' && $position) { ?>
                                    <div class="position">
                                        <?= $position ?>
                                    </div>
                                <?php } ?>
                                <div class="desc">
                                    <?= wpautop($team->post_content) ?>
                                </div>
                                <div class="socials">
                                    <?php if ($linked_in) { ?>
                                        <a href="<?= $linked_in ?>" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30">
                                                <path id="Icon_akar-linkedin-fill" data-name="Icon akar-linkedin-fill" d="M14.144,13.453h5.571v2.775c.8-1.6,2.861-3.03,5.952-3.03C31.593,13.2,33,16.375,33,22.2V33H27V23.532c0-3.319-.8-5.191-2.846-5.191-2.833,0-4.011,2.017-4.011,5.19V33h-6V13.453ZM3.855,32.745h6V13.2h-6V32.745Zm6.86-25.92a3.8,3.8,0,0,1-1.13,2.7A3.856,3.856,0,0,1,3,6.825a3.8,3.8,0,0,1,1.129-2.7,3.88,3.88,0,0,1,5.456,0A3.807,3.807,0,0,1,10.715,6.825Z" transform="translate(-3 -3)" fill="#b57cff" />
                                            </svg>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                        <?php if ($style != 'style-3' && $position) { ?>
                            <div class="position">
                                <?= $position ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('team_slider', 'action_team_slider');


//Icon Box
if (function_exists('vc_map')) {
    add_action('vc_before_init', 'vc_map_icon_box');
    function vc_map_icon_box()
    {
        vc_map(
            array(
                "name" => __("Icon Box", "my-text-domain"), // Element name
                "base" => "icon_box", // Element shortcode
                "class" => "box-repeater",
                "category" => "Open Awards",
                'params' => array(
                    array(
                        'type' => 'param_group',
                        'param_name' => 'icon_box_items',
                        'params' => array(
                            array(
                                "type" => "attach_image",
                                "holder" => "img",
                                "class" => "",
                                "heading" => __("Image", "my-text-domain"),
                                "param_name" => "icon_box_items_img",
                                "value" => __("", "my-text-domain"),
                            ),
                            array(
                                "type" => "textfield",
                                "holder" => "div",
                                "class" => "",
                                "admin_label" => true,
                                "heading" => __("Heading", "my-text-domain"),
                                "param_name" => "icon_box_items_heading",
                                "value" => __("", "my-text-domain"),
                            ),
                            array(
                                "type" => "textarea",
                                "class" => "",
                                "admin_label" => false,
                                "heading" => __("Description", "my-text-domain"),
                                "param_name" => "icon_box_items_description",
                                "value" => __("", "my-text-domain"),
                            ),
                        )
                    ),
                )
            )
        );
    }
}

function action_icon_box($atts)
{
    ob_start();
    extract(shortcode_atts(array(
        'icon_box_items' => '',
    ), $atts));

?>
    <?php if ($icon_box_items) { ?>
        <div class="icon-box-wrapper">
            <div class="container">
                <div class="row">
                    <?php  var_dump($icon_box_items); ?>
                    <?php foreach ($icon_box_items as $items) { ?>
                        <?php
                        $icon_box_items_img = $items['icon_box_items_img'];
                        $icon_box_items_heading = $items['icon_box_items_heading'];
                        $icon_box_items_description = $items['icon_box_items_description'];
                        ?>
                        <div class="col-lg-4">
                            <div class="icon-box-holder">
                                <?php if ($icon_box_items_img) { ?>
                                    <div class="icon-box">
                                        <img src="<?= wp_get_attachment_image_url($icon_box_items_img, 'large') ?>" alt="<?= $icon_box_items_heading ?>">
                                    </div>
                                <?php } ?>
                                <?php if ($icon_box_items_heading) { ?>
                                    <div class="heading-box">
                                        <h4><?= $icon_box_items_heading ?></h4>
                                    </div>
                                <?php } ?>
                                <?php if ($icon_box_items_description) { ?>
                                    <div class="description-box">
                                        <?= wpautop($icon_box_items_description) ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    <?php } ?>

<?php
    return ob_get_clean();
}
add_shortcode('icon_box', 'action_icon_box');
