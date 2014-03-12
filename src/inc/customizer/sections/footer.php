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

	// Footer text
	$setting_id = 'footer-text';
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
			'label'    => __( 'Footer Text', 'ttf-one' ),
			'type'     => 'text',
			'priority' => $priority->add()
		)
	);

	// Footer layout
	$setting_id = 'footer-layout';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => 'layout-1',
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
				'layout-1'  => __( 'Layout 1', 'ttf-one' ),
				'layout-2'  => __( 'Layout 2', 'ttf-one' ),
				'layout-3'  => __( 'Layout 3', 'ttf-one' ),
				'layout-4'  => __( 'Layout 4', 'ttf-one' )
			),
			'priority' => $priority->add()
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

	// Hide credit line
	$setting_id = 'footer-hide-credit';
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
			'label'    => __( 'Hide Credit Line', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);
}
endif;