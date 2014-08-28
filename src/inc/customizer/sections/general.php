<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_customizer_define_general_sections' ) ) :
/**
 * Define the sections and settings for the General panel
 *
 * @since 1.3.0.
 *
 * @param  array    $sections    The master array of Customizer sections
 * @return array                 The augmented master array
 */
function ttfmake_customizer_define_general_sections( $sections ) {
	$panel = 'ttfmake_general';
	$general_sections = array();

	/**
	 * Static Front Page
	 *
	 * This is a built-in section
	 */

	/**
	 * Background Image
	 *
	 * This is a built-in section
	 */

	/**
	 * Social Profiles & RSS
	 */
	$general_sections['social'] = array(
		'panel' => $panel,
		'title' => __( 'Social Profiles &amp; RSS', 'make' ),
		'description' => __( 'Enter the complete URL to your profile for each service below that you would like to share.', 'make' ),
		'options' => array(
			'social-facebook' => array(
				'setting' => array(
					'default'			=> '',
					'sanitize_callback'	=> 'esc_url_raw',
				),
				'control' => array(
					'label'				=> 'Facebook', // brand names not translated
					'type'				=> 'text',
				),
			),
			'social-twitter' => array(
				'setting' => array(
					'default'			=> '',
					'sanitize_callback'	=> 'esc_url_raw',
				),
				'control' => array(
					'label'				=> 'Twitter', // brand names not translated
					'type'				=> 'text',
				),
			),
			'social-google-plus-square' => array(
				'setting' => array(
					'default'			=> '',
					'sanitize_callback'	=> 'esc_url_raw',
				),
				'control' => array(
					'label'				=> 'Google +', // brand names not translated
					'type'				=> 'text',
				),
			),
			'social-linkedin' => array(
				'setting' => array(
					'default'			=> '',
					'sanitize_callback'	=> 'esc_url_raw',
				),
				'control' => array(
					'label'				=> 'LinkedIn', // brand names not translated
					'type'				=> 'text',
				),
			),
			'social-instagram' => array(
				'setting' => array(
					'default'			=> '',
					'sanitize_callback'	=> 'esc_url_raw',
				),
				'control' => array(
					'label'				=> 'Instagram', // brand names not translated
					'type'				=> 'text',
				),
			),
			'social-flickr' => array(
				'setting' => array(
					'default'			=> '',
					'sanitize_callback'	=> 'esc_url_raw',
				),
				'control' => array(
					'label'				=> 'Flickr', // brand names not translated
					'type'				=> 'text',
				),
			),
			'social-youtube' => array(
				'setting' => array(
					'default'			=> '',
					'sanitize_callback'	=> 'esc_url_raw',
				),
				'control' => array(
					'label'				=> 'YouTube', // brand names not translated
					'type'				=> 'text',
				),
			),
			'social-vimeo-square' => array(
				'setting' => array(
					'default'			=> '',
					'sanitize_callback'	=> 'esc_url_raw',
				),
				'control' => array(
					'label'				=> 'Vimeo', // brand names not translated
					'type'				=> 'text',
				),
			),
			'social-pinterest' => array(
				'setting' => array(
					'default'			=> '',
					'sanitize_callback'	=> 'esc_url_raw',
				),
				'control' => array(
					'label'				=> 'Pinterest', // brand names not translated
					'type'				=> 'text',
				),
			),
			'social-custom-menu-text' => array(
				'control' => array(
					'control_type'		=> 'TTFMAKE_Customize_Misc_Control',
					'type'				=> 'text',
					'description'		=> sprintf(
						__( 'If you would like to add a social profile that is not listed above, or change the order of the icons, use %s.', 'make' ),
						sprintf(
							'<a href="' . esc_url( 'https://thethemefoundry.com/tutorials/make/#social-profiles-and-rss' ) . '">%s</a>',
							__( 'this alternate method', 'make' )
						)
					),
				),
			),
			'social-email' => array(
				'setting' => array(
					'default'			=> '',
					'sanitize_callback'	=> 'sanitize_email',
				),
				'control' => array(
					'label'				=> 'Email', // brand names not translated
					'type'				=> 'text',
				),
			),
			'social-rss-heading' => array(
				'control' => array(
					'control_type'		=> 'TTFMAKE_Customize_Misc_Control',
					'type'				=> 'heading',
					'label'				=> __( 'Default RSS', 'make' ),
				),
			),
			'social-hide-rss' => array(
				'setting' => array(
					'default'			=> 0,
					'sanitize_callback'	=> 'absint',
				),
				'control' => array(
					'label'				=> __( 'Hide default RSS feed link', 'make' ),
					'type'				=> 'checkbox',
				),
			),
			'social-custom-rss' => array(
				'setting' => array(
					'default'			=> '',
					'sanitize_callback'	=> 'esc_url_raw',
				),
				'control' => array(
					'label'				=> __( 'Custom RSS URL (replaces default)', 'make' ),
					'type'				=> 'text',
				),
			),
		),
	);

	// Filter the definitions
	$general_sections = apply_filters( 'make_customizer_general_sections', $general_sections );

	// Merge with master array
	return array_merge( $sections, $general_sections );
}
endif;

add_filter( 'make_customizer_sections', 'ttfmake_customizer_define_general_sections' );