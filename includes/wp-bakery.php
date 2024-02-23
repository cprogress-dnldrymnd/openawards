<?php
if (function_exists('vc_map')) {

    add_action('vc_before_init', 'vc_map_team_slider');
    function vc_map_team_slider()
    {
        $terms = get_terms(array(
            'taxonomy'   => 'teams_category',
            'hide_empty' => false,
        ));

        $arr = array();

        foreach ($terms as $term) {
            $arr[$term->term_id] = $term->name;
        }

        vc_map(array(
            "name" => "Team Slider",
            "base" => "team_slider",
            "category" => "Open Awards",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => "Category",
                    "param_name" => "category",
                    "value" => $arr,
                    "description" => "Select the team category you want to display."
                ),
            )

        ));
    }
}

function action_team_slider($atts)
{
    extract(shortcode_atts(array(
        'button_text' => 'Click Me',
        'button_color' => '#ff9900',
    ), $atts));

    $output = 'xxxxxxxxxxxxxxxxx';
    return $output;
}
add_shortcode('team_slider', 'action_team_slider');
