<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_customizer_colors' ) ) :
/**
 * Configure settings and controls for the Colors section.
 *
 * @since  1.0
 *
 * @param  object    $wp_customize    The global customizer object.
 * @param  string    $section         The section name.
 * @return void
 */
function ttf_one_customizer_colors( $wp_customize, $section ) {
	$priority = new TTF_One_Prioritizer();
	$prefix = 'ttf-one_';

	// Primary Color
	$setting_id = 'color-primary';
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
				'label'    => __( 'Primary Color', 'ttf-one' ),
				'priority' => $priority->add()
			)
		)
	);

	// Secondary Color
	$setting_id = 'color-secondary';
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
				'label'    => __( 'Secondary Color', 'ttf-one' ),
				'priority' => $priority->add()
			)
		)
	);

	// Text Color
	$setting_id = 'color-text';
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
				'label'    => __( 'Text Color', 'ttf-one' ),
				'priority' => $priority->add()
			)
		)
	);

	// Accent Color
	$setting_id = 'color-accent';
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
				'label'    => __( 'Accent Color', 'ttf-one' ),
				'priority' => $priority->add()
			)
		)
	);
}
endif;