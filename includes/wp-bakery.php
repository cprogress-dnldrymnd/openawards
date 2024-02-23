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
    }


    $teams = get_posts($args);

?>
    <div class="team-slider <?= $style ?>">
        <div class="swiper team-swiper">
            <div class="swiper-wrapper">
                <?php foreach ($teams as $team) { ?>

                    <?php
                    $position = carbon_get_post_meta($team->ID, 'position');
                    $linked_in = carbon_get_post_meta($team->ID, 'linked_in');
                    ?>
                    <div class="swiper-slide">
                        <div class="inner">
                            <div class="content-box">
                                <div class="name">
                                    <?= $team->post_title ?>
                                </div>
                                <div class="desc">
                                    <?= wpautop($team->post_content) ?>
                                </div>
                            </div>
                            <div class="image-box">
                                <img src="<?= wp_get_attachment_image_url(get_post_thumbnail_id($team->ID), 'Medium') ?>" alt="<?= $team->post_title ?>">
                            </div>
                        </div>

                        <div class="position">
                            <?= $position ?>
                        </div>
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
