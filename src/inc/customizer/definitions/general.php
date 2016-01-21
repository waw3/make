<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_Customizer_ControlsInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_Customizer_ControlsInterface ) {
	return;
}

// Panel ID
$panel = $this->prefix . 'general';

// Logo
$this->add_section_definitions( 'logo', array(
	'panel'    => $panel,
	'title'    => __( 'Logo', 'make' ),
	'controls' => array(
		'logo-regular' => array(
			'setting' => true,
			'control' => array(
				'control_type' => 'WP_Customize_Image_Control',
				'label'        => __( 'Regular Logo', 'make' ),
				'context'      => $this->prefix . 'logo-regular',
			),
		),
		'logo-retina'  => array(
			'setting' => true,
			'control' => array(
				'control_type' => 'WP_Customize_Image_Control',
				'label'        => __( 'Retina Logo (2x)', 'make' ),
				'description'  => __( 'The Retina Logo should be twice the size of the Regular Logo.', 'make' ),
				'context'      => $this->prefix . 'logo-retina',
			),
		),
	),
) );

// Deprecated Site Icon controls
if ( function_exists( 'has_site_icon' ) ) {
	$this->add_section_definitions( 'logo', array(
		'controls' => array(
			'logo-icons-notice' => array(
				'control' => array(
					'control_type' => 'MAKE_Customizer_Control_Html',
					'label'        => __( 'Favicon & Apple Touch Icon', 'make' ),
					'description'  => __( 'These options have been deprecated in favor of the Site Icon setting in WordPress core. Please visit the Site Identity section to configure your site icon.', 'make' ),
				),
			),
		)
	), true ); // Overwrite to add additional controls to the section
} else {
	$this->add_section_definitions( 'logo', array(
		'controls' => array(
			'logo-favicon'     => array(
				'setting' => true,
				'control' => array(
					'control_type' => 'WP_Customize_Image_Control',
					'label'        => __( 'Favicon', 'make' ),
					'description'  => __( 'File must be <strong>.png</strong> or <strong>.ico</strong> format. Optimal dimensions: <strong>32px x 32px</strong>.', 'make' ),
					'context'      => $this->prefix . 'logo-favicon',
					'extensions'   => array( 'png', 'ico' ),
				),
			),
			'logo-apple-touch' => array(
				'setting' => true,
				'control' => array(
					'control_type' => 'WP_Customize_Image_Control',
					'label'        => __( 'Apple Touch Icon', 'make' ),
					'description'  => __( 'File must be <strong>.png</strong> format. Optimal dimensions: <strong>152px x 152px</strong>.', 'make' ),
					'context'      => $this->prefix . 'logo-apple-touch',
					'extensions'   => array( 'png' ),
				),
			),
		)
	), true ); // Overwrite to add additional controls to the section
}

// Labels
$this->add_section_definitions( 'labels', array(
	'panel'    => $panel,
	'title'    => __( 'Labels', 'make' ),
	'controls' => array(
		'label-search-field'      => array(
			'setting' => array(
				'transport' => 'postMessage',
			),
			'control' => array(
				'label' => __( 'Search Field Label', 'make' ),
				'type'  => 'text',
			),
		),
		'navigation-mobile-label' => array(
			'setting' => array(
				'theme_supports' => 'menus',
				'transport'      => 'postMessage',
			),
			'control' => array(
				'label'       => __( 'Mobile Menu Label', 'make' ),
				'description' => __( 'Resize your browser window to preview the mobile menu label.', 'make' ),
				'type'        => 'text',
			),
		),
		'general-sticky-label'    => array(
			'setting' => array(
				'transport' => 'postMessage',
			),
			'control' => array(
				'label' => __( 'Sticky Label', 'make' ),
				'type'  => 'text',
			),
		),
	),
) );

// Only show the Read More label option if no filters have been added to the deprecated filter hook.
// has_filter() can't be used here because of the hook-prefixing filters added for back compatibility.
/** This filter is documented in inc/template-tags.php */
if ( false === apply_filters( 'make_read_more_text', false ) ) {
	$this->add_section_definitions( 'labels', array(
		'controls' => array(
			'label-read-more' => array(
				'setting' => array(
					'transport' => 'postMessage',
				),
				'control' => array(
					'label' => __( 'Read More Label', 'make' ),
					'type'  => 'text',
				),
			)
		)
	), true ); // Overwrite to add additional controls to the section
}

// Social Profiles
$this->add_section_definitions( 'social', array(
	'panel'       => $panel,
	'title'       => __( 'Social Profiles', 'make' ),
	'description' => __( 'Enter the complete URL to your profile for each service below that you would like to share.', 'make' ),
	'controls'    => array(
		'social-facebook-official'  => array(
			'setting' => true,
			'control' => array(
				'label' => __( 'Facebook', 'make' ),
				'type'  => 'url',
			),
		),
		'social-twitter'            => array(
			'setting' => true,
			'control' => array(
				'label' => __( 'Twitter', 'make' ),
				'type'  => 'url',
			),
		),
		'social-google-plus-square' => array(
			'setting' => true,
			'control' => array(
				'label' => __( 'Google +', 'make' ),
				'type'  => 'url',
			),
		),
		'social-linkedin'           => array(
			'setting' => true,
			'control' => array(
				'label' => __( 'LinkedIn', 'make' ),
				'type'  => 'url',
			),
		),
		'social-instagram'          => array(
			'setting' => true,
			'control' => array(
				'label' => __( 'Instagram', 'make' ),
				'type'  => 'url',
			),
		),
		'social-flickr'             => array(
			'setting' => true,
			'control' => array(
				'label' => __( 'Flickr', 'make' ),
				'type'  => 'url',
			),
		),
		'social-youtube'            => array(
			'setting' => true,
			'control' => array(
				'label' => __( 'YouTube', 'make' ),
				'type'  => 'url',
			),
		),
		'social-vimeo-square'       => array(
			'setting' => true,
			'control' => array(
				'label' => __( 'Vimeo', 'make' ),
				'type'  => 'url',
			),
		),
		'social-pinterest'          => array(
			'setting' => true,
			'control' => array(
				'label' => __( 'Pinterest', 'make' ),
				'type'  => 'url',
			),
		),
		'social-custom-menu-text'   => array(
			'control' => array(
				'control_type' => 'MAKE_Customizer_Control_Html',
				'description'  => sprintf(
					__( 'If you would like to add a social profile that is not listed above, or change the order of the icons, create a custom menu %s.', 'make' ),
					sprintf(
						'<a href="' . esc_url( 'https://thethemefoundry.com/docs/make-docs/tutorials/set-social-profile-links-using-custom-menu/' ) . '">%s</a>',
						__( 'as described here', 'make' )
					)
				),
			),
		),
	),
) );

// Email
$this->add_section_definitions( 'email', array(
	'panel'       => $panel,
	'title'       => __( 'Email', 'make' ),
	'description' => __( 'Enter an email address to add an email icon link to your social profile icons.', 'make' ),
	'controls'    => array(
		'social-email' => array(
			'setting' => true,
			'control' => array(
				'label' => __( 'Email', 'make' ),
				'type'  => 'email',
			),
		),
	),
) );

// RSS
$this->add_section_definitions( 'rss', array(
	'panel'       => $panel,
	'title'       => __( 'RSS', 'make' ),
	'description' => __( 'If configured, an RSS icon will appear with your social profile icons.', 'make' ),
	'controls'    => array(
		'social-rss-heading' => array(
			'control' => array(
				'control_type' => 'MAKE_Customizer_Control_Html',
				'label'        => __( 'Default RSS', 'make' ),
			),
		),
		'social-hide-rss'    => array(
			'setting' => true,
			'control' => array(
				'label' => __( 'Hide default RSS feed link', 'make' ),
				'type'  => 'checkbox',
			),
		),
		'social-custom-rss'  => array(
			'setting' => true,
			'control' => array(
				'label' => __( 'Custom RSS URL (replaces default)', 'make' ),
				'type'  => 'url',
			),
		),
	),
) );

// Check for deprecated filters
foreach ( array( 'make_customizer_general_sections' ) as $filter ) {
	if ( has_filter( $filter ) ) {
		$this->compatibility->deprecated_hook(
			$filter,
			'1.7.0',
			__( 'To add or modify Customizer sections and controls, use the make_customizer_sections hook instead, or the core $wp_customize methods.', 'make' )
		);
	}
}