<?php

use Carbon_Fields\Container;
use Carbon_Fields\Complex_Container;
use Carbon_Fields\Field;

/*-----------------------------------------------------------------------------------*/
/* Slider
/*-----------------------------------------------------------------------------------*/

Container::make('post_meta', 'Slider Settings')
    ->set_priority('high')
    ->or_where('post_type', '=', 'slider')
    ->add_fields(
        array(
            Field::make('complex', 'slides', __('Slides'))
                ->add_fields(
                    array(
                        Field::make('image', 'image', __('Image'))->set_width(50),
                        Field::make('image', 'background_image', __('Background Image'))->set_width(50),
                        Field::make('text', 'title', __('Title'))->set_help_text('For labeling purposes only'),
                        Field::make('text', 'heading', __('Heading')),
                        Field::make('rich_text', 'description', __('Description')),
                        Field::make('text', 'button_text_1', __('Button Text[1]'))->set_width(50),
                        Field::make('text', 'button_link_1', __('Button Link[1]'))->set_width(50),
                        Field::make('text', 'button_text_2', __('Button Text[2]'))->set_width(50),
                        Field::make('text', 'button_link_2', __('Button Link[2]'))->set_width(50),
                    )
                )
                ->set_header_template('<%- title %>')
                ->set_layout('tabbed-vertical')
        )
    );




Container::make('post_meta', 'Product Data')
    ->where('post_type', '=', 'product')
    ->add_tab(
        'Resources',
        array(
            Field::make('complex', 'resources')
                ->add_fields(
                    array(
                        Field::make('radio', 'resource_type', __('Resource Type'))
                            ->set_options(
                                array(
                                    'Brochure'       => 'Brochure',
                                    'Videos'         => 'Video',
                                    'Videos Embed'   => 'Video Embed',
                                )
                            )->set_width(100),
                        Field::make('text', 'resource_title', __('Resource Title'))->set_width(25),
                        Field::make('image', 'resource_thumbnail', __('Resource Thumbnail'))->set_width(25),
                        Field::make('file', 'resource_file', __('Resource File'))->set_width(25)
                            ->set_conditional_logic(
                                array(
                                    array(
                                        'field'   => 'resource_type',
                                        'value'   => 'Videos Embed',
                                        // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
                                        'compare' => '!=',
                                        // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
                                    )
                                )
                            ),
                        Field::make('oembed', 'embed_video_url', __('Embed Video URL'))->set_width(25)
                            ->set_conditional_logic(
                                array(
                                    array(
                                        'field'   => 'resource_type',
                                        'value'   => 'Videos Embed',
                                        // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
                                        'compare' => '=',
                                        // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
                                    )
                                )
                            ),


                    )
                )
                ->set_header_template('<%- resource_title %>')
                ->set_layout('tabbed-vertical')
        )
    );


Container::make('theme_options', 'E-Campus')
    ->add_tab(
        'Staff Room',
        array(
            Field::make('text', 'staff_room_title', __('Title')),
            Field::make('text', 'staff_room_url', __('URL')),
        )
    )
    ->add_tab(
        'Learner Centre',
        array(
            Field::make('text', 'learner_centre_title', __('Title')),
            Field::make('text', 'learner_centre__url', __('URL')),
        )
    )
    ->add_tab(
        'Reception',
        array(
            Field::make('text', 'reception_title', __('Title')),
            Field::make('text', 'reception_url', __('URL')),
        )
    )
    ->add_tab(
        'Library',
        array(
            Field::make('text', 'library_title', __('Title')),
            Field::make('text', 'library_url', __('URL')),
        )
    )
    ->add_tab(
        'Shop',
        array(
            Field::make('text', 'shop_title', __('Title')),
            Field::make('text', 'shop_url', __('URL')),
        )
    )
    ->add_tab(
        'Newsroom',
        array(
            Field::make('text', 'newsroom_title', __('Title')),
            Field::make('text', 'newsroom_url', __('URL')),
        )
    );

//Teams
Container::make('post_meta', 'Team Settings')
    ->set_priority('high')
    ->or_where('post_type', '=', 'teams')
    ->add_fields(
        array(
            Field::make('text', 'position', __('Position')),
            Field::make('text', 'linked_in', __('Linked In')),
            Field::make('textarea', 'short_description', __('Short Description')),
        )
    );

//Post
Container::make('post_meta', 'Post Settings')
    ->set_priority('high')
    ->or_where('post_type', '=', 'post')
    ->add_tab(
        'CTA',
        array(
            Field::make('text', 'cta_heading', __('CTA Heading')),
            Field::make('text', 'button_text', __('Button Text')),
            Field::make('text', 'button_link', __('Button Link')),
        )
    )
    ->add_tab(
        'Bottom Text',
        array(
            Field::make('rich_text', 'bottom_text', __('Bottom Text')),
        )
    );

//Theme Settings 

Container::make('theme_options', 'Theme Options')
    ->add_tab(
        'General Settings',
        array(
            Field::make('image', 'logo', __('Logo')),
            Field::make('image', 'alt_logo', __('Alt Logo')),
        )
    )
    ->add_tab(
        'Brand Details',
        array(
            Field::make('text', 'contact_number', __('Contact Number')),
            Field::make('text', 'email_address', __('Email Address')),
            Field::make('textarea', 'address', __('Address')),
        )
    )
    ->add_tab(
        'Footer',
        array(
            Field::make('text', 'footer_button_text', __('Footer Button Text')),
            Field::make('text', 'footer_button_url', __('Footer Button URL')),
            Field::make('textarea', 'footer_copyright', __('Footer Copyright')),
            Field::make('media_gallery', 'footer_logos', __('Footer Logos')),
        )
    );





function theme_settings()
{
    global $theme_settings;

    $theme_settings['contact_number'] = carbon_get_theme_option('contact_number');
    $theme_settings['email_address'] = carbon_get_theme_option('email_address');
    $theme_settings['address'] = carbon_get_theme_option('address');
    $theme_settings['logo_url'] = wp_get_attachment_image_url(carbon_get_theme_option('logo'), 'medium');
    $theme_settings['alt_logo_url'] = wp_get_attachment_image_url(carbon_get_theme_option('alt_logo'), 'medium');
    $theme_settings['footer_button_text'] = carbon_get_theme_option('footer_button_text');
    $theme_settings['footer_button_url'] = carbon_get_theme_option('footer_button_url');
    $theme_settings['footer_copyright'] = carbon_get_theme_option('footer_copyright');
    $theme_settings['footer_logos'] = carbon_get_theme_option('footer_logos');
}

add_action('init', 'theme_settings');



Container::make('term_meta', __('FAQs Category Properties'))
    ->where('term_taxonomy', '=', 'faqs_category')
    ->add_fields(array(
        Field::make('color', 'color', __('Color')),
        Field::make('image', 'icon', __('Icon')),
    ));


Container::make('term_meta', __('Success Stories'))
    ->where('term_taxonomy', '=', 'success_stories_location')
    ->add_fields(array(
        Field::make('textarea', 'flag_svg', __('Flag SVG')),
    ));


//Events
Container::make('post_meta', 'Event Settings')
    ->set_priority('high')
    ->or_where('post_type', '=', 'event')
    ->add_fields(
        array(
            Field::make('text', 'event_code', __('Event Code')),
            Field::make('text', 'eventbrite_event_url', __('Eventbrite Event URL')),
        )
    );


//Events
Container::make('post_meta', 'Qualifications Settings')
    ->set_priority('high')
    ->or_where('post_type', '=', 'qualifications')
    ->or_where('post_type', '=', 'units')
    ->add_fields(
        array(
            Field::make('text', 'id', __('ID')),
            Field::make('text', 'level', __('Level')),
            Field::make('text', 'type', __('Type')),
            Field::make('text', 'regulationstartdate', __('Regulation start date')),
            Field::make('text', 'operationalstartdate', __('Operational start date')),
            Field::make('text', 'regulationenddate', __('Regulation end date')),
            Field::make('text', 'reviewdate', __('Review date')),
            Field::make('text', 'totalcreditsrequired', __('Total credits required')),
            Field::make('text', 'minimumcreditsatorabove', __('Minimum credits at or above')),
            Field::make('text', 'qualificationreferencenumber', __('Qualification reference number')),
            Field::make('text', 'contactdetails', __('Contact details')),
            Field::make('text', 'minage', __('Min age')),
            Field::make('text', 'tqt', __('TQT')),
            Field::make('text', 'glh', __('GLH')),
            Field::make('text', 'alternativequalificationtitle', __('Alternative qualification Title')),
            Field::make('text', 'classification1', __('Classification 1')),
        )
    );

Container::make('theme_options', 'Blog Settings')
    ->set_page_parent('edit.php')
    ->add_fields(
        array(
            Field::make('text', 'post_page_heading', __('Blog Page Heading')),
            Field::make('textarea', 'post_page_description', __('Blog Page Description')),
        )
    );


Container::make('theme_options', 'Success Stories Settings')
    ->set_page_parent('edit.php?post_type=successstories')
    ->add_fields(
        array(
            Field::make('text', 'successstories_page_heading', __('Success Stories Page Heading')),
            Field::make('textarea', 'successstories_page_description', __('Success Stories Description')),
        )
    );


Container::make('theme_options', 'FAQs Settings')
    ->set_page_parent('edit.php?post_type=faqs')
    ->add_fields(
        array(
            Field::make('image', 'faqs_image', __('FAQs Image')),
            Field::make('text', 'faqs_page_heading', __('FAQs Page Heading')),
            Field::make('textarea', 'faqs_page_description', __('FAQs Page Description')),
        )
    );
