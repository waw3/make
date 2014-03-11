<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_customizer_logo' ) ) :
/**
 * Configure settings and controls for the Logo section.
 *
 * @since  1.0
 *
 * @param  object    $wp_customize    The global customizer object.
 * @param  string    $section         The section name.
 * @return void
 */
function ttf_one_customizer_logo( $wp_customize, $section ) {
	$priority = 10;
	$prefix   = 'ttf-one_';

	// Regular Logo
	$setting_id = 'regular-logo';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new TTF_One_Customize_Image_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Regular Logo', 'ttf-one' ),
				'priority' => $priority,
				'context'  => $prefix . $setting_id
			)
		)
	);

	$priority += 10;

	// Retina Logo
	$setting_id = 'retina-logo';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new TTF_One_Customize_Image_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Retina Logo', 'ttf-one' ),
				'priority' => $priority,
				'context'  => $prefix . $setting_id
			)
		)
	);

	$priority += 10;

	// Favicon
	$setting_id = 'favicon';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new TTF_One_Customize_Image_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Favicon', 'ttf-one' ),
				'priority' => $priority,
				'context'  => $prefix . $setting_id
			)
		)
	);
}
endif;