<?php

defined( 'ABSPATH' ) || exit;

Redux::set_section(
	$opt_name,
	array(
		'title'            => esc_html__( 'Header', 'your-textdomain-here' ),
		'id'               => 'basic-header',
		'subsection'       => true,
		'customizer_width' => '450px',
		'fields'           => array(
			array(
				'id'       => 'opt-logo',
				'type'     => 'media',
				'title'    => esc_html__( 'Site Logo', 'your-textdomain-here' ),
			),
		),
	)
);

Redux::set_section(
	$opt_name,
	array(
		'title'            => esc_html__( 'Footer', 'your-textdomain-here' ),
		'id'               => 'basic-footer',
		'subsection'       => true,
		'customizer_width' => '450px',
		'fields'           => array(
			array(
				'id'       => 'opt-logo-white',
				'type'     => 'media',
				'title'    => esc_html__( 'Site Logo Dark', 'your-textdomain-here' ),
			),
			array(
				'id'       => 'opt-location',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Location', 'your-textdomain-here' ),
			),
			array(
				'id'       => 'opt-phone',
				'type'     => 'text',
				'title'    => esc_html__( 'Phone Number', 'your-textdomain-here' ),
			),
			array(
				'id'       => 'opt-email',
				'type'     => 'text',
				'title'    => esc_html__( 'Email Address', 'your-textdomain-here' ),
			),
			array(
				'id'       => 'opt-button-text',
				'type'     => 'text',
				'title'    => esc_html__( 'Footer Button text', 'your-textdomain-here' ),
			),
			array(
				'id'       => 'opt-button-link',
				'type'     => 'text',
				'title'    => esc_html__( 'Footer Button link', 'your-textdomain-here' ),
			),
			array(
				'id'       => 'opt-copyright',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Copyright text', 'your-textdomain-here' ),
			),
			array(
				'id'       => 'opt-cookies',
				'type'     => 'text',
				'title'    => esc_html__( 'Cookies Page link', 'your-textdomain-here' ),
			),
			array(
				'id'       => 'opt-privacy',
				'type'     => 'text',
				'title'    => esc_html__( 'Privacy Page link', 'your-textdomain-here' ),
			),
		),
	)
);
// -> START Theme Options
Redux::set_section(
	$opt_name,
	array(
		'title'            => esc_html__( 'Theme Options', 'your-textdomain-here' ),
		'id'               => 'theme_options',
		'desc'             => esc_html__( 'Theme Optios for your site', 'your-textdomain-here' ),
		'customizer_width' => '400px',
		'icon'             => 'el el-cogs',
		'fields'           => array(
			array(
				'id'       => 'theme_option_address',
				'type'     => 'text',
				'title'    => esc_html__( 'Site Address', 'your-textdomain-here' ),
				'default'  => 'Default Text',
			),
			array(
				'id'       => 'theme_option_phone',
				'type'     => 'text',
				'title'    => esc_html__( 'Site Phone Number', 'your-textdomain-here' ),
				'default'  => 'Default Text',
			),
			array(
				'id'       => 'theme_option_email',
				'type'     => 'text',
				'title'    => esc_html__( 'Site Email', 'your-textdomain-here' ),
				'default'  => 'Default Text',
			),
		)
	)
);