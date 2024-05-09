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
        <div class="swiper team-swiper swiper-button-style-1">
            <div class="swiper-wrapper">
                <?php foreach ($teams as $team) { ?>
                    <?php
                    $position = carbon_get_post_meta($team->ID, 'position');
                    $linked_in = carbon_get_post_meta($team->ID, 'linked_in');
                    $short_description = carbon_get_post_meta($team->ID, 'short_description');
                    ?>
                    <div class="swiper-slide">
                        <div class="inner">
                            <div class="image-box">
                                <img src="<?= wp_get_attachment_image_url(get_post_thumbnail_id($team->ID), 'Medium') ?>" alt="<?= $team->post_title ?>">
                                <?php if ($style == 'style-3') { ?>
                                    <button class="button-trigger team-modal-trigger" position="<?= $position ?>" linkedin="<?= $linked_in ?>" image="<?= wp_get_attachment_image_url(get_post_thumbnail_id($team->ID), 'Medium') ?>" team_name="<?= $team->post_title ?>" content="<?= wpautop($team->post_content) ?>" data-bs-toggle="modal" data-bs-target="#teamModal">
                                    </button>
                                <?php } ?>
                            </div>
                            <div class="content-box">
                                <?php if ($style != 'style-3') { ?>
                                    <button class="button-trigger team-modal-trigger" position="<?= $position ?>" linkedin="<?= $linked_in ?>" image="<?= wp_get_attachment_image_url(get_post_thumbnail_id($team->ID), 'Medium') ?>" team_name="<?= $team->post_title ?>" content="<?= wpautop($team->post_content) ?>" data-bs-toggle="modal" data-bs-target="#teamModal">
                                    </button>
                                <?php } ?>

                                <div class="name">
                                    <?= $team->post_title ?>
                                </div>
                                <?php if ($style == 'style-3' && $position) { ?>
                                    <div class="position">
                                        <?= $position ?>
                                    </div>
                                <?php } ?>
                                <div class="desc">
                                    <?= wpautop($short_description) ?>
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

    $items = vc_param_group_parse_atts($icon_box_items);

?>
    <?php if ($items) { ?>
        <div class="icon-box-wrapper">
            <div class="container">
                <div class="row">
                    <?php foreach ($items as $item) { ?>
                        <?php
                        $icon_box_items_img = $item['icon_box_items_img'];
                        $icon_box_items_heading = $item['icon_box_items_heading'];
                        $icon_box_items_description = $item['icon_box_items_description'];
                        ?>
                        <div class="col-md-4">
                            <div class="icon-box-holder">
                                <?php if ($icon_box_items_img) { ?>
                                    <div class="icon-box">
                                        <img src="<?= wp_get_attachment_image_url($icon_box_items_img, 'large') ?>" alt="<?= $icon_box_items_heading ?>">
                                    </div>
                                <?php } ?>
                                <div class="content-box">
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

//contact details
if (function_exists('vc_map')) {
    add_action('vc_before_init', 'vc_map_contact_details_box');
    function vc_map_contact_details_box()
    {
        vc_map(array(
            "name" => "Contact Details",
            "base" => "contact_details_box",
            "category" => "Open Awards",
            "params" => array(
                array(
                    "type" => "checkbox",
                    "heading" => "Contact number",
                    "param_name" => "display_contact_number",
                    "description" => "Display contact number"
                ),
                array(
                    "type" => "checkbox",
                    "heading" => "Email address",
                    "param_name" => "display_email_address",
                    "description" => "Display email address"
                ),
                array(
                    "type" => "checkbox",
                    "heading" => "Address",
                    "param_name" => "display_address",
                    "description" => "Display address"
                ),
            )

        ));
    }
}

function action_contact_details_box($atts)
{
    ob_start();
    extract(shortcode_atts(array(
        'display_contact_number' => '',
        'display_email_address' => '',
        'display_address' => '',
    ), $atts));

    global $theme_settings;


?>

    <div class="contact-details-wrapper">
        <?php if ($display_contact_number && $theme_settings['contact_number']) { ?>
            <div class="contact-details-box">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" id="phone" width="56.258" height="56.258" viewBox="0 0 56.258 56.258">
                        <path id="Path_2264" data-name="Path 2264" d="M0,0H56.258V56.258H0Z" fill="rgba(0,0,0,0)" />
                        <path id="Path_2265" data-name="Path 2265" d="M7.688,4h9.376l4.688,11.72-5.86,3.516a25.785,25.785,0,0,0,11.72,11.72l3.516-5.86,11.72,4.688v9.376a4.688,4.688,0,0,1-4.688,4.688A37.505,37.505,0,0,1,3,8.688,4.688,4.688,0,0,1,7.688,4" transform="translate(4.032 5.376)" fill="rgba(0,0,0,0)" stroke="#b57dff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </div>
                <div class="contact-detail">
                    <div class="label">Call us</div>
                    <a href="tel:<?= $theme_settings['contact_number'] ?>"> <?= $theme_settings['contact_number'] ?> </a>
                </div>
            </div>
        <?php } ?>

        <?php if ($display_address && $theme_settings['address']) { ?>
            <div class="contact-details-box">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" id="map-pin-bolt" width="54.121" height="54.121" viewBox="0 0 54.121 54.121">
                        <path id="Path_2266" data-name="Path 2266" d="M0,0H54.121V54.121H0Z" fill="none" />
                        <path id="Path_2267" data-name="Path 2267" d="M9,14.765A6.765,6.765,0,1,0,15.765,8,6.765,6.765,0,0,0,9,14.765" transform="translate(11.295 10.04)" fill="none" stroke="#b57dff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <path id="Path_2268" data-name="Path 2268" d="M25.229,43.366a4.51,4.51,0,0,1-6.375,0L9.283,33.8A18.04,18.04,0,1,1,39.932,23.359" transform="translate(5.02 3.765)" fill="none" stroke="#b57dff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <path id="Path_2269" data-name="Path 2269" d="M21.51,16,17,22.765h9.02L21.51,29.53" transform="translate(21.336 20.081)" fill="none" stroke="#b57dff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </div>
                <div class="contact-detail">
                    <div class="label">Location</div>
                    <span> <?= $theme_settings['address'] ?> </span>
                </div>
            </div>
        <?php } ?>
        <?php if ($display_email_address && $theme_settings['email_address']) { ?>
            <div class="contact-details-box">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" id="mail" width="59.818" height="59.818" viewBox="0 0 59.818 59.818">
                        <path id="Path_2270" data-name="Path 2270" d="M0,0H59.818V59.818H0Z" fill="none" />
                        <path id="Path_2271" data-name="Path 2271" d="M3,9.985A4.985,4.985,0,0,1,7.985,5H42.879a4.985,4.985,0,0,1,4.985,4.985V34.909a4.985,4.985,0,0,1-4.985,4.985H7.985A4.985,4.985,0,0,1,3,34.909Z" transform="translate(4.477 7.462)" fill="none" stroke="#b57dff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <path id="Path_2272" data-name="Path 2272" d="M3,7,25.432,21.955,47.864,7" transform="translate(4.477 10.447)" fill="none" stroke="#b57dff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </div>
                <div class="contact-detail">
                    <div class="label">Email us</div>
                    <a href="mailto:<?= $theme_settings['email_address'] ?>"> <?= $theme_settings['email_address'] ?> </a>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('contact_details_box', 'action_contact_details_box');


//Students
if (function_exists('vc_map')) {
    add_action('vc_before_init', 'vc_map_student');
    function vc_map_student()
    {


        $args = array(
            'post_type' => 'students',
            'numberposts' => -1,
        );



        $students = get_posts($args);

        $student_array = array();
        foreach ($students as $student) {
            $student_array[$student->post_title] = $student->ID;
        }


        vc_map(array(
            "name" => "student",
            "base" => "student",
            "category" => "Open Awards",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => "Student",
                    "param_name" => "student_id",
                    "value" => $student_array,
                    "description" => "Select the student you want to display."
                ),
            )
        ));
    }
}

function action_student($atts)
{
    ob_start();
    extract(shortcode_atts(array(
        'student_id' => '',
    ), $atts));

    if ($student_id) {
    ?>
        <div class="student">
            <div class="student-image">
                <img src="<?= get_the_post_thumbnail_url($student_id, 'large') ?>" alt="<?= get_the_title($student_id) ?>">
            </div>
            <div class="student-details">
                <div class="highlight"> Top Student </div>
                <div class="student-decs">
                    <?= get_the_content(NULL, false, $student_id) ?>
                </div>
                <div class="congrats">Congratulations! 🎉</div>
            </div>
            <div class="cert">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="76" viewBox="0 0 80 76">
                    <g id="medal-ribbons-star-svgrepo-com" transform="translate(-2 -2)">
                        <path id="Path_2313" data-name="Path 2313" d="M42,31.986,26.914,47.606c-2.16,2.237-3.241,3.356-4.156,3.743a4.3,4.3,0,0,1-5.494-1.793c-.481-.843-.631-2.363-.931-5.4a14.765,14.765,0,0,0-.511-3.294A5.732,5.732,0,0,0,12.484,37.4,13.4,13.4,0,0,0,9.3,36.873h0c-2.936-.31-4.4-.466-5.218-.964a4.621,4.621,0,0,1-1.732-5.688c.374-.947,1.454-2.066,3.615-4.3l9.855-10.2,4.953-4.953L42,31.986,63.224,10.762l4.953,4.953,9.855,10.2c2.161,2.237,3.241,3.355,3.615,4.3a4.621,4.621,0,0,1-1.732,5.688c-.814.5-2.282.654-5.218.964a13.405,13.405,0,0,0-3.181.529,5.732,5.732,0,0,0-3.339,3.457,14.772,14.772,0,0,0-.511,3.294h0c-.3,3.04-.45,4.56-.931,5.4a4.3,4.3,0,0,1-5.494,1.793c-.915-.387-1.995-1.506-4.155-3.743Z" transform="translate(0 26.285)" fill="#feb321" opacity="0.5" />
                        <path id="Path_2314" data-name="Path 2314" d="M33,58A28,28,0,1,0,5,30,28,28,0,0,0,33,58Zm0-40c-1.136,0-1.9,1.363-3.416,4.09l-.393.705a4.4,4.4,0,0,1-.984,1.418,4.1,4.1,0,0,1-1.595.54l-.764.173c-2.952.668-4.428,1-4.779,2.131s.655,2.306,2.667,4.659l.521.609a4.421,4.421,0,0,1,.986,1.417,4.613,4.613,0,0,1,0,1.752l-.079.812c-.3,3.14-.456,4.709.463,5.407s2.3.062,5.065-1.211l.715-.329A4.1,4.1,0,0,1,33,39.63a4.1,4.1,0,0,1,1.594.542l.715.329c2.764,1.272,4.145,1.908,5.065,1.211s.767-2.268.463-5.407l-.079-.812a4.613,4.613,0,0,1,0-1.752,4.423,4.423,0,0,1,.986-1.417l.521-.609c2.012-2.353,3.018-3.53,2.667-4.659s-1.827-1.463-4.779-2.131l-.764-.173a4.1,4.1,0,0,1-1.595-.54A4.4,4.4,0,0,1,36.81,22.8l-.393-.705C34.9,19.363,34.136,18,33,18Z" transform="translate(9)" fill="#feb321" fill-rule="evenodd" />
                    </g>
                </svg>
            </div>
        </div>
    <?php
        return ob_get_clean();
    }
}
add_shortcode('student', 'action_student');

//successstories
if (function_exists('vc_map')) {
    add_action('vc_before_init', 'vc_map_successstories');
    function vc_map_successstories()
    {


        $args = array(
            'post_type' => 'successstories',
            'numberposts' => -1,
        );



        $successstories = get_posts($args);

        $successstories_array = array();
        foreach ($successstories as $successstories) {
            $successstories_array[$successstories->post_title] = $successstories->ID;
        }


        vc_map(array(
            "name" => "successstories",
            "base" => "successstories",
            "category" => "Open Awards",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => "successstories",
                    "param_name" => "successstories_id",
                    "value" => $successstories_array,
                    "description" => "Select the Success Stories you want to display."
                ),

            )
        ));
    }
}

function action_successstories($atts)
{
    ob_start();
    extract(shortcode_atts(array(
        'successstories_id' => '',
        'readmore' => 'true',
        'hover_effect' => 'true',
    ), $atts));

    if ($successstories_id) {
    ?>
        <div class="successstories <?= $hover_effect ? 'hover-effect' : '' ?>">

            <div class="successstories-decs">
                <?= get_the_excerpt($successstories_id) ?>
            </div>
            <?php if ($readmore == 'true') { ?>
                <div class="button-box button-readmore">
                    <a href="<?= get_the_permalink($successstories_id) ?>">Read more</a>
                </div>
            <?php  } ?>
            <div class="successstories-image">
                <div class="image-box">
                    <img src="<?= get_the_post_thumbnail_url($successstories_id, 'large') ?>" alt="<?= get_the_title($successstories_id) ?>">
                </div>
                <div class="name-box">
                    <div class="name"><?= get_the_title($successstories_id) ?></div>
                    <div class="country">
                        <svg xmlns="http://www.w3.org/2000/svg" id="flag-for-flag-st-martin-svgrepo-com" width="18.692" height="13.5" viewBox="0 0 18.692 13.5">
                            <path id="Path_2285" data-name="Path 2285" d="M30.231,16.423A2.077,2.077,0,0,1,28.154,18.5H24V5h4.154a2.077,2.077,0,0,1,2.077,2.077Z" transform="translate(-11.538 -5)" fill="#ed2939" />
                            <path id="Path_2286" data-name="Path 2286" d="M2.077,5A2.077,2.077,0,0,0,0,7.077v9.346A2.077,2.077,0,0,0,2.077,18.5H6.231V5Z" transform="translate(0 -5)" fill="#002495" />
                            <path id="Path_2287" data-name="Path 2287" d="M12,5h6.231V18.5H12Z" transform="translate(-5.769 -5)" fill="#eee" />
                        </svg>
                        <span>France</span>
                    </div>
                </div>
            </div>

        </div>
<?php
        return ob_get_clean();
    }
}
add_shortcode('successstories', 'action_successstories');
