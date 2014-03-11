<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_customizer_background' ) ) :
/**
 * Configure settings and controls for the Background section
 *
 * @since 1.0
 *
 * @param object $wp_customize
 * @param string $section
 */
function ttf_one_customizer_background( $wp_customize, $section ) {
	$priority = 10;
	$prefix = 'ttf-one_';

	// Background color
	$setting_id = 'background-color';
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
				'label'    => __( 'Background Color', 'ttf-one' ),
				'priority' => $priority
			)
		)
	);
	$priority += 10;

	// Background image
	$setting_id = 'background-image';
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
				'label'    => __( 'Background Image', 'ttf-one' ),
				'priority' => $priority,
				'context'  => $prefix . $setting_id
			)
		)
	);
	$priority += 10;


}
endif;