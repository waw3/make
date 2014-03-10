<?php
/**
 * @package ttf-one
 */

/**
 * Configure settings and controls for the General section
 *
 * @since 1.0
 *
 * @param onject $wp_customize
 * @param string $section
 */
function ttf_one_customizer_general( $wp_customize, $section ) {
	$priority = 10;
	$prefix = 'ttf-one_';

	// Site Layout
	$setting_id = 'site-layout';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => 'full-width',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Site layout', 'ttf-one' ),
			'type'     => 'radio',
			'choices'  => array(
				'full-width' => __( 'Full-width', 'ttf-one' ),
				'boxed'      => __( 'Boxed', 'ttf-one' )
			),
			'priority' => $priority
		)
	);
	$priority += 10;


}