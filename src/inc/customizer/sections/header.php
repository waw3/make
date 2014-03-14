<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_customizer_header' ) ) :
/**
 * Configure settings and controls for the Header section
 *
 * @since 1.0
 *
 * @param object $wp_customize
 * @param string $section
 */
function ttf_one_customizer_header( $wp_customize, $section ) {
	$priority = new TTF_One_Prioritizer( 10, 5 );
	$prefix = 'ttf-one_';

	// Header Background Color
	$setting_id = 'header-background-color';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '#ffffff',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'maybe_hash_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Header Background Color', 'ttf-one' ),
				'priority' => $priority->add()
			)
		)
	);

	// Sub Header Background color
	$setting_id = 'header-subheader-background-color';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '#171717',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'maybe_hash_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Sub Header Background Color', 'ttf-one' ),
				'priority' => $priority->add()
			)
		)
	);

	// Sub Header Text color
	$setting_id = 'header-subheader-text-color';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '#ffffff',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'maybe_hash_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Sub Header Text Color', 'ttf-one' ),
				'priority' => $priority->add()
			)
		)
	);

	// Sub Header text
	$setting_id = 'header-subheader-text';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_text',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Sub Header Text', 'ttf-one' ),
			'type'     => 'text',
			'priority' => $priority->add()
		)
	);

	// Hide social icons
	$setting_id = 'header-hide-social';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => 1,
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Show Social Icons In Sub Header', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Header layout
	$setting_id = 'header-layout';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => 'header-layout-1',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Layout', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => array(
				'header-layout-1'  => __( 'Layout 1', 'ttf-one' ),
				'header-layout-2'  => __( 'Layout 2', 'ttf-one' )
			),
			'priority' => $priority->add()
		)
	);
}
endif;