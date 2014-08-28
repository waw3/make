<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_customizer_define_typography_sections' ) ) :
/**
 * Define the sections and settings for the General panel
 *
 * @since 1.3.0.
 *
 * @param  array    $sections    The master array of Customizer sections
 * @return array                 The augmented master array
 */
function ttfmake_customizer_define_typography_sections( $sections ) {
	$panel = 'ttfmake_typography';
	$typography_sections = array();

	/**
	 * Typekit
	 */
	if ( ! ttfmake_is_plus() ) {
		$typography_sections['typekit'] = array(
			'panel' => $panel,
			'title' => __( 'Typekit', 'make' ),
			'description' => __( 'Looking to add premium fonts from Typekit to your website?', 'make' ),
			'options' => array(
				'font-typekit-update-text' => array(
					'control' => array(
						'control_type'		=> 'TTFMAKE_Customize_Misc_Control',
						'type'				=> 'text',
						'description'		=> sprintf(
							'<a href="%1$s" target="_blank">%2$s</a>',
							esc_url( ttfmake_get_plus_link( 'typekit' ) ),
							sprintf(
								__( 'Upgrade to %1$s', 'make' ),
								'Make Plus'
							)
						),
					),
				)
			)
		);
	}

	/**
	 * Header Bar
	 */

	/**
	 * Site Title & Tagline
	 */
	$typography_sections['font-site-title-tagline'] = array(
		'panel' => $panel,
		'title' => __( 'Site Title &amp; Tagline', 'make' ),
		'options' => array(
			'font-site-title-family' => array(
				'setting' => array(
					'sanitize_callback'	=> 'ttfmake_sanitize_font_choice',
				),
				'control' => array(
					'label'				=> __( 'Site Title Font Family', 'make' ),
					'type'				=> 'select',
					'choices'			=> ttfmake_all_font_choices(),
				),
			),
			'font-site-title-size' => array(
				'setting' => array(
					'sanitize_callback'	=> 'absint',
				),
				'control' => array(
					'label'				=> __( 'Site Title Font Size (in px)', 'make' ),
					'type'				=> ( ttfmake_customizer_supports_panels() ) ? 'number' : 'text',
				),
			),
			'font-site-tagline-family' => array(
				'setting' => array(
					'sanitize_callback'	=> 'ttfmake_sanitize_font_choice',
				),
				'control' => array(
					'label'				=> __( 'Site Tagline Font Family', 'make' ),
					'type'				=> 'select',
					'choices'			=> ttfmake_all_font_choices(),
				),
			),
			'font-site-tagline-size' => array(
				'setting' => array(
					'sanitize_callback'	=> 'absint',
				),
				'control' => array(
					'label'				=> __( 'Site Tagline Font Size (in px)', 'make' ),
					'type'				=> ( ttfmake_customizer_supports_panels() ) ? 'number' : 'text',
				),
			),
		)
	);

	/**
	 * Main Navigation
	 */

	/**
	 * Headers
	 */

	/**
	 * Body Text
	 */

	/**
	 * Widgets
	 */

	/**
	 * Footer
	 */

	// Filter the definitions
	$typography_sections = apply_filters( 'make_customizer_general_sections', $typography_sections );

	// Merge with master array
	return array_merge( $sections, $typography_sections );
}
endif;

add_filter( 'make_customizer_sections', 'ttfmake_customizer_define_typography_sections' );