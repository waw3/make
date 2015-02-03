<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_customizer_define_typography_sections' ) ) :
/**
 * Define the sections and settings for the General panel
 *
 * @since  1.3.0.
 *
 * @param  array    $sections    The master array of Customizer sections
 * @return array                 The augmented master array
 */
function ttfmake_customizer_define_typography_sections( $sections ) {
	$panel = 'ttfmake_typography';
	$typography_sections = array();

	/**
	 * Global
	 */
	$typography_sections['font'] = array(
		'panel'   => $panel,
		'title'   => __( 'Global', 'make' ),
		'options' => array_merge(
			ttfmake_customizer_font_property_definitions( 'body', __( 'Default', 'make' ) ),
			array(
				'body-link-group' => array(
					'control' => array(
						'control_type' => 'TTFMAKE_Customize_Misc_Control',
						'label'   => __( 'Links', 'make' ),
						'type'  => 'group-title',
					),
				),
				'font-weight-body-link' => array(
					'setting' => array(
						'sanitize_callback' => 'ttfmake_sanitize_choice',
					),
					'control' => array(
						'control_type' => 'TTFMAKE_Customize_Radio_Control',
						'label'   => __( 'Font Weight', 'make' ),
						'type'  => 'radio',
						'mode'  => 'buttonset',
						'choices' => ttfmake_get_choices( 'font-weight-body-link' ),
					),
				),
			)
		),
	);

	/**
	 * Headers
	 */
	$typography_sections['font-headers'] = array(
		'panel'   => $panel,
		'title'   => __( 'Headers', 'make' ),
		'options' => array_merge(
			ttfmake_customizer_font_property_definitions( 'h1', __( 'H1', 'make' ) ),
			ttfmake_customizer_font_property_definitions( 'h2', __( 'H2', 'make' ) ),
			ttfmake_customizer_font_property_definitions( 'h3', __( 'H3', 'make' ) ),
			ttfmake_customizer_font_property_definitions( 'h4', __( 'H4', 'make' ) ),
			ttfmake_customizer_font_property_definitions( 'h5', __( 'H5', 'make' ) ),
			ttfmake_customizer_font_property_definitions( 'h6', __( 'H6', 'make' ) )
		),
	);

	/**
	 * Site Title & Tagline
	 */
	$typography_sections['font-site-title-tagline'] = array(
		'panel'   => $panel,
		'title'   => __( 'Site Title &amp; Tagline', 'make' ),
		'options' => array_merge(
			ttfmake_customizer_font_property_definitions( 'site-title', __( 'Site Title', 'make' ) ),
			ttfmake_customizer_font_property_definitions( 'site-tagline', __( 'Tagline', 'make' ) )
		),
	);

	/**
	 * Main Navigation
	 */
	$typography_sections['font-main-menu'] = array(
		'panel'   => $panel,
		'title'   => __( 'Main Menu', 'make' ),
		'options' => array_merge(
			ttfmake_customizer_font_property_definitions( 'nav', __( 'Menu Items', 'make' ) ),
			ttfmake_customizer_font_property_definitions( 'subnav', __( 'Sub-Menu Items', 'make' ) ),
			array(
				'font-subnav-option-heading' => array(
					'control' => array(
						'control_type' => 'TTFMAKE_Customize_Misc_Control',
						'type'         => 'heading',
						'label'        => __( 'Sub-Menu Item Options', 'make' ),
					),
				),
				'font-subnav-mobile'         => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
					),
					'control' => array(
						'label' => __( 'Use Menu Item styles in mobile view', 'make' ),
						'type'  => 'checkbox',
					),
				),
			)
		),
	);

	/**
	 * Header Bar
	 */
	$typography_sections['font-header-bar'] = array(
		'panel'   => $panel,
		'title'   => __( 'Header Bar', 'make' ),
		'options' => array_merge(
			ttfmake_customizer_font_property_definitions(
				'header-bar-text',
				__( 'Header Bar Text', 'make' ),
				__( 'Includes Header Text, Header Bar Menu items, and the search field.', 'make' )
			),
			array(
				'header-bar-icon-group' => array(
					'control' => array(
						'control_type' => 'TTFMAKE_Customize_Misc_Control',
						'label'   => __( 'Social Icons', 'make' ),
						'type'  => 'group-title',
					),
				),
				'font-size-header-bar-icon'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
					),
					'control' => array(
						'control_type' => 'TTFMAKE_Customize_Range_Control',
						'label'   => __( 'Icon Size (px)', 'make' ),
						'type'  => 'range',
						'input_attrs' => array(
							'min'  => 6,
							'max'  => 100,
							'step' => 1,
						),
					),
				),
			)
		),
	);

	/**
	 * Widgets
	 */
	$typography_sections['font-widget'] = array(
		'panel'   => $panel,
		'title'   => __( 'Widgets', 'make' ),
		'options' => array_merge(
			ttfmake_customizer_font_property_definitions( 'widget-title', __( 'Widget Title', 'make' ) ),
			ttfmake_customizer_font_property_definitions( 'widget', __( 'Widget Body', 'make' ) )
		),
	);

	/**
	 * Footer
	 */
	$typography_sections['font-footer'] = array(
		'panel'   => $panel,
		'title'   => __( 'Footer', 'make' ),
		'options' => array_merge(
			ttfmake_customizer_font_property_definitions( 'footer-text', __( 'Footer Text', 'make' ) ),
			array(
				'footer-icon-group' => array(
					'control' => array(
						'control_type' => 'TTFMAKE_Customize_Misc_Control',
						'label'   => __( 'Social Icons', 'make' ),
						'type'  => 'group-title',
					),
				),
				'font-size-footer-icon'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
					),
					'control' => array(
						'control_type' => 'TTFMAKE_Customize_Range_Control',
						'label'   => __( 'Icon Size (px)', 'make' ),
						'type'  => 'range',
						'input_attrs' => array(
							'min'  => 6,
							'max'  => 100,
							'step' => 1,
						),
					),
				),
			)
		),
	);

	/**
	 * Google Web Fonts
	 */
	$typography_sections['font-google'] = array(
		'panel'   => $panel,
		'title'   => __( 'Google Web Fonts', 'make' ),
		'options' => array(
			'font-subset'      => array(
				'setting' => array(
					'sanitize_callback' => 'ttfmake_sanitize_font_subset',
				),
				'control' => array(
					'label'   => __( 'Character Subset', 'make' ),
					'type'    => 'select',
					'choices' => ttfmake_get_google_font_subsets(),
				),
			),
			'font-subset-text' => array(
				'control' => array(
					'control_type' => 'TTFMAKE_Customize_Misc_Control',
					'type'         => 'text',
					'description'  => __( 'Not all fonts provide each of these subsets.', 'make' ),
				),
			),
		),
	);

	/**
	 * Typekit
	 */
	if ( ! ttfmake_is_plus() ) {
		$typography_sections['font-typekit'] = array(
			'panel'       => $panel,
			'title'       => __( 'Typekit', 'make' ),
			'description' => __( 'Looking to add premium fonts from Typekit to your website?', 'make' ),
			'options'     => array(
				'font-typekit-update-text' => array(
					'control' => array(
						'control_type' => 'TTFMAKE_Customize_Misc_Control',
						'type'         => 'text',
						'description'  => sprintf(
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
	 * Filter the definitions for the controls in the Typography panel of the Customizer.
	 *
	 * @since 1.3.0.
	 *
	 * @param array    $typography_sections    The array of definitions.
	 */
	$typography_sections = apply_filters( 'make_customizer_typography_sections', $typography_sections );

	// Merge with master array
	return array_merge( $sections, $typography_sections );
}
endif;

add_filter( 'make_customizer_sections', 'ttfmake_customizer_define_typography_sections' );