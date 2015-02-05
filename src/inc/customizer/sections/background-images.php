<?php
/**
 * @package Make
 */

/**
 * Define the sections and settings for the Background Images panel
 *
 * @since 1.5.0.
 *
 * @param  array    $sections    The master array of Customizer sections
 * @return array                 The augmented master array
 */
function ttfmake_customizer_define_background_images_sections( $sections ) {
	$theme_prefix = 'ttfmake_';
	$panel = 'ttfmake_background-images';
	$background_sections = array();

	/**
	 * Header
	 */
	$background_sections['header-background'] = array(
		'panel'   => $panel,
		'title'   => __( 'Header', 'make' ),
		'options' => array(
			'header-background-image'    => array(
				'setting' => array(
					'sanitize_callback' => 'esc_url_raw',
				),
				'control' => array(
					'control_type' => 'TTFMAKE_Customize_Image_Control',
					'label'        => __( 'Background Image', 'make' ),
					'context'      => $theme_prefix . 'header-background-image',
				),
			),
			'header-background-repeat'   => array(
				'setting' => array(
					'sanitize_callback' => 'ttfmake_sanitize_choice',
				),
				'control' => array(
					'label'   => __( 'Repeat', 'make' ),
					'type'    => 'radio',
					'choices' => ttfmake_get_choices( 'header-background-repeat' ),
				),
			),
			'header-background-position' => array(
				'setting' => array(
					'sanitize_callback' => 'ttfmake_sanitize_choice',
				),
				'control' => array(
					'control_type' => 'TTFMAKE_Customize_Background_Position_Control',
					'label'   => __( 'Position', 'make' ),
					'type'    => 'radio',
					'choices' => ttfmake_get_choices( 'header-background-position' ),
				),
			),
			'header-background-size'     => array(
				'setting' => array(
					'sanitize_callback' => 'ttfmake_sanitize_choice',
				),
				'control' => array(
					'control_type' => 'TTFMAKE_Customize_Radio_Control',
					'label'   => __( 'Size', 'make' ),
					'type'    => 'radio',
					'mode'    => 'buttonset',
					'choices' => ttfmake_get_choices( 'header-background-size' ),
				),
			),
		),
	);

	/**
	 * Filter the definitions for the controls in the Background Images panel of the Customizer.
	 *
	 * @since 1.3.0.
	 *
	 * @param array    $header_sections    The array of definitions.
	 */
	$background_sections = apply_filters( 'make_customizer_background_sections', $background_sections );

	// Merge with master array
	return array_merge( $sections, $background_sections );
}

add_filter( 'make_customizer_sections', 'ttfmake_customizer_define_background_images_sections' );