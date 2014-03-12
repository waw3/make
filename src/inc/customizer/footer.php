<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_customizer_footer' ) ) :
/**
 * Configure settings and controls for the Footer section
 *
 * @since 1.0
 *
 * @param object $wp_customize
 * @param string $section
 */
function ttf_one_customizer_footer( $wp_customize, $section ) {
	$priority = new TTF_One_Prioritizer();
	$prefix = 'ttf-one_';

	// Background color
	$setting_id = 'footer-bg-color';
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
				'priority' => $priority->add()
			)
		)
	);

	// Hide social icons
	$setting_id = 'footer-hide-social';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => 0,
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Hide Social Icons', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);
}
endif;