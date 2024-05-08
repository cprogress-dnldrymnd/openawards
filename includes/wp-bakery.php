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
            $student_array[$student->post_id] = $student->post_title;
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


?>
    <div class="student-slider <?= $style ?>">
        <div class="heading-box text-center">
            <h2>
                <?= $heading ?>
            </h2>
        </div>
        <div class="swiper student-swiper swiper-button-style-1">
            <div class="swiper-wrapper">
                <?php foreach ($students as $student) { ?>
                    <?php
                    $position = carbon_get_post_meta($student->ID, 'position');
                    $linked_in = carbon_get_post_meta($student->ID, 'linked_in');
                    $short_description = carbon_get_post_meta($student->ID, 'short_description');
                    ?>
                    <div class="swiper-slide">
                        <div class="inner">
                            <div class="image-box">
                                <img src="<?= wp_get_attachment_image_url(get_post_thumbnail_id($student->ID), 'Medium') ?>" alt="<?= $student->post_title ?>">
                                <?php if ($style == 'style-3') { ?>
                                    <button class="button-trigger student-modal-trigger" position="<?= $position ?>" linkedin="<?= $linked_in ?>" image="<?= wp_get_attachment_image_url(get_post_thumbnail_id($student->ID), 'Medium') ?>" student_name="<?= $student->post_title ?>" content="<?= wpautop($student->post_content) ?>" data-bs-toggle="modal" data-bs-target="#studentModal">
                                    </button>
                                <?php } ?>
                            </div>
                            <div class="content-box">
                                <?php if ($style != 'style-3') { ?>
                                    <button class="button-trigger student-modal-trigger" position="<?= $position ?>" linkedin="<?= $linked_in ?>" image="<?= wp_get_attachment_image_url(get_post_thumbnail_id($student->ID), 'Medium') ?>" student_name="<?= $student->post_title ?>" content="<?= wpautop($student->post_content) ?>" data-bs-toggle="modal" data-bs-target="#studentModal">
                                    </button>
                                <?php } ?>

                                <div class="name">
                                    <?= $student->post_title ?>
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
add_shortcode('student', 'action_student');
