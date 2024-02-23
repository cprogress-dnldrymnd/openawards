<?php
if (function_exists('vc_map')) {
    vc_map(array(
        "name" => "Team Slider",
        "base" => "team_slider",
        "category" => "Open Awards",
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => "Category",
                "param_name" => "category",
                "value" => array(

                ),
                "description" => "Select the team category you want to display."
            ),
        )

    ));
}

function action_team_slider($atts) {
    extract(shortcode_atts(array(
       'button_text' => 'Click Me',
       'button_color' => '#ff9900',
    ), $atts));
 
    $output = 'xxxxxxxxxxxxxxxxx';
    return $output;
 }
 add_shortcode('team_slider', 'action_team_slider');