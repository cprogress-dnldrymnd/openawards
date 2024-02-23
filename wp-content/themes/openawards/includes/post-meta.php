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
                        Field::make('text', 'heading', __('Heading')),
                        Field::make('rich_text', 'description', __('Description')),
                        Field::make('text', 'button_text_1', __('Button Text[1]'))->set_width(50),
                        Field::make('text', 'button_link_1', __('Button Link[1]'))->set_width(50),
                        Field::make('text', 'button_text_2', __('Button Text[2]'))->set_width(50),
                        Field::make('text', 'button_link_2', __('Button Link[2]'))->set_width(50),
                    )
                )
                ->set_header_template('<%- heading %>')
        )
    );


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
                        Field::make('text', 'heading', __('Heading')),
                        Field::make('rich_text', 'description', __('Description')),
                        Field::make('text', 'button_text_1', __('Button Text[1]'))->set_width(50),
                        Field::make('text', 'button_link_1', __('Button Link[1]'))->set_width(50),
                        Field::make('text', 'button_text_2', __('Button Text[2]'))->set_width(50),
                        Field::make('text', 'button_link_2', __('Button Link[2]'))->set_width(50),
                    )
                )
                ->set_header_template('<%- heading %>')
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