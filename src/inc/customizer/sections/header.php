<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_customizer_define_header_sections' ) ) :
/**
 * Define the sections and settings for the General panel
 *
 * @since  1.3.0.
 *
 * @param  array    $sections    The master array of Customizer sections
 * @return array                 The augmented master array
 */
function ttfmake_customizer_define_header_sections( $sections ) {
	$theme_prefix = 'ttfmake_';
	$panel = 'ttfmake_header';
	$header_sections = array();

	/**
	 * Navigation
	 *
	 * This is a built-in section.
	 */

	/**
	 * Layout
	 */
	$header_sections['header'] = array(
		'panel'   => $panel,
		'title'   => __( 'Layout', 'make' ),
		'options' => array(
			'header-layout'             => array(
				'setting' => array(
					'sanitize_callback' => 'ttfmake_sanitize_choice',
				),
				'control' => array(
					'label'   => __( 'Header Layout', 'make' ),
					'type'    => 'select',
					'choices' => ttfmake_get_choices( 'header-layout' ),
				),
			),
			'header-branding-position'  => array(
				'setting' => array(
					'sanitize_callback' => 'ttfmake_sanitize_choice',
				),
				'control' => array(
					'label'   => __( 'Show Title/Logo On', 'make' ),
					'type'    => 'select',
					'choices' => ttfmake_get_choices( 'header-branding-position' ),
				),
			),
			'header-layout-line'        => array(
				'control' => array(
					'control_type' => 'TTFMAKE_Customize_Misc_Control',
					'type'         => 'line',
				),
			),
			'header-bar-content-layout' => array(
				'setting' => array(
					'sanitize_callback' => 'ttfmake_sanitize_choice',
				),
				'control' => array(
					'label'   => __( 'Header Bar Content Layout', 'make' ),
					'type'    => 'select',
					'choices' => ttfmake_get_choices( 'header-bar-content-layout' ),
				),
			),
			'header-text'               => array(
				'setting' => array(
					'sanitize_callback' => 'ttfmake_sanitize_text',
					'transport'         => 'postMessage',
				),
				'control' => array(
					'label'       => __( 'Header Bar Text', 'make' ),
					'description' => __( 'This text only appears if a custom menu has not been assigned to the Header Bar Menu location in the Navigation section.', 'make' ),
					'type'        => 'text',
				),
			),
			'header-options-heading'    => array(
				'control' => array(
					'control_type' => 'TTFMAKE_Customize_Misc_Control',
					'type'         => 'heading',
					'label'        => __( 'Header Options', 'make' ),
				),
			),
			'header-show-social'        => array(
				'setting' => array(
					'sanitize_callback' => 'absint',
				),
				'control' => array(
					'label' => __( 'Show social icons in Header Bar', 'make' ),
					'type'  => 'checkbox',
				),
			),
			'header-show-search'        => array(
				'setting' => array(
					'sanitize_callback' => 'absint',
				),
				'control' => array(
					'label' => __( 'Show search field in Header Bar', 'make' ),
					'type'  => 'checkbox',
				),
			),
		),
	);

	/**
	 * Filter the definitions for the controls in the Header panel of the Customizer.
	 *
	 * @since 1.3.0.
	 *
	 * @param array    $header_sections    The array of definitions.
	 */
	$header_sections = apply_filters( 'make_customizer_header_sections', $header_sections );

	// Merge with master array
	return array_merge( $sections, $header_sections );
}
endif;

add_filter( 'make_customizer_sections', 'ttfmake_customizer_define_header_sections' );