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
	$typography_sections['font-main-menu'] = array(
		'panel' => $panel,
		'title' => __( 'Main Menu', 'make' ),
		'options' => array(
			'font-nav-family' => array(
				'setting' => array(
					'sanitize_callback'	=> 'ttfmake_sanitize_font_choice',
				),
				'control' => array(
					'label'				=> __( 'Menu Item Font Family', 'make' ),
					'type'				=> 'select',
					'choices'			=> ttfmake_all_font_choices(),
				),
			),
			'font-nav-size' => array(
				'setting' => array(
					'sanitize_callback'	=> 'absint',
				),
				'control' => array(
					'label'				=> __( 'Menu Item Font Size (in px)', 'make' ),
					'type'				=> ( ttfmake_customizer_supports_panels() ) ? 'number' : 'text',
				),
			),
			'font-subnav-family' => array(
				'setting' => array(
					'sanitize_callback'	=> 'ttfmake_sanitize_font_choice',
				),
				'control' => array(
					'label'				=> __( 'Sub-Menu Item Font Family', 'make' ),
					'type'				=> 'select',
					'choices'			=> ttfmake_all_font_choices(),
				),
			),
			'font-subnav-size' => array(
				'setting' => array(
					'sanitize_callback'	=> 'absint',
				),
				'control' => array(
					'label'				=> __( 'Sub-Menu Item Font Size (in px)', 'make' ),
					'type'				=> ( ttfmake_customizer_supports_panels() ) ? 'number' : 'text',
				),
			),
		),
	);

	/**
	 * Headers
	 */
	$typography_sections['font-headers'] = array(
		'panel' => $panel,
		'title' => __( 'Headers (H1 - H6)', 'make' ),
		'options' => array(
			'font-h1-family' => array(
				'setting' => array(
					'sanitize_callback'	=> 'ttfmake_sanitize_font_choice',
				),
				'control' => array(
					'label'				=> __( 'H1 Font Family', 'make' ),
					'type'				=> 'select',
					'choices'			=> ttfmake_all_font_choices(),
				),
			),
			'font-h1-size' => array(
				'setting' => array(
					'sanitize_callback'	=> 'absint',
				),
				'control' => array(
					'label'				=> __( 'H1 Font Size (in px)', 'make' ),
					'type'				=> ( ttfmake_customizer_supports_panels() ) ? 'number' : 'text',
				),
			),
			'font-h2-family' => array(
				'setting' => array(
					'sanitize_callback'	=> 'ttfmake_sanitize_font_choice',
				),
				'control' => array(
					'label'				=> __( 'H2 Font Family', 'make' ),
					'type'				=> 'select',
					'choices'			=> ttfmake_all_font_choices(),
				),
			),
			'font-h2-size' => array(
				'setting' => array(
					'sanitize_callback'	=> 'absint',
				),
				'control' => array(
					'label'				=> __( 'H2 Font Size (in px)', 'make' ),
					'type'				=> ( ttfmake_customizer_supports_panels() ) ? 'number' : 'text',
				),
			),
			'font-h3-family' => array(
				'setting' => array(
					'sanitize_callback'	=> 'ttfmake_sanitize_font_choice',
				),
				'control' => array(
					'label'				=> __( 'H3 Font Family', 'make' ),
					'type'				=> 'select',
					'choices'			=> ttfmake_all_font_choices(),
				),
			),
			'font-h3-size' => array(
				'setting' => array(
					'sanitize_callback'	=> 'absint',
				),
				'control' => array(
					'label'				=> __( 'H3 Font Size (in px)', 'make' ),
					'type'				=> ( ttfmake_customizer_supports_panels() ) ? 'number' : 'text',
				),
			),
			'font-h4-family' => array(
				'setting' => array(
					'sanitize_callback'	=> 'ttfmake_sanitize_font_choice',
				),
				'control' => array(
					'label'				=> __( 'H4 Font Family', 'make' ),
					'type'				=> 'select',
					'choices'			=> ttfmake_all_font_choices(),
				),
			),
			'font-h4-size' => array(
				'setting' => array(
					'sanitize_callback'	=> 'absint',
				),
				'control' => array(
					'label'				=> __( 'H4 Font Size (in px)', 'make' ),
					'type'				=> ( ttfmake_customizer_supports_panels() ) ? 'number' : 'text',
				),
			),
			'font-h5-family' => array(
				'setting' => array(
					'sanitize_callback'	=> 'ttfmake_sanitize_font_choice',
				),
				'control' => array(
					'label'				=> __( 'H5 Font Family', 'make' ),
					'type'				=> 'select',
					'choices'			=> ttfmake_all_font_choices(),
				),
			),
			'font-h5-size' => array(
				'setting' => array(
					'sanitize_callback'	=> 'absint',
				),
				'control' => array(
					'label'				=> __( 'H5 Font Size (in px)', 'make' ),
					'type'				=> ( ttfmake_customizer_supports_panels() ) ? 'number' : 'text',
				),
			),
			'font-h6-family' => array(
				'setting' => array(
					'sanitize_callback'	=> 'ttfmake_sanitize_font_choice',
				),
				'control' => array(
					'label'				=> __( 'H6 Font Family', 'make' ),
					'type'				=> 'select',
					'choices'			=> ttfmake_all_font_choices(),
				),
			),
			'font-h6-size' => array(
				'setting' => array(
					'sanitize_callback'	=> 'absint',
				),
				'control' => array(
					'label'				=> __( 'H6 Font Size (in px)', 'make' ),
					'type'				=> ( ttfmake_customizer_supports_panels() ) ? 'number' : 'text',
				),
			),
		),
	);

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