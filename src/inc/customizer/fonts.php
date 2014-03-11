<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_customizer_fonts' ) ) :
/**
 * Configure settings and controls for the Fonts section.
 *
 * @since  1.0
 *
 * @param  object    $wp_customize    The global customizer object.
 * @param  string    $section         The section name.
 * @return void
 */
function ttf_one_customizer_fonts( $wp_customize, $section ) {
	$priority = 10;
	$prefix = 'ttf-one_';

	// Site title font
	$setting_id = 'font-site-title';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '1',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Site Title', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => array(
				'1' => __( 'Choice 1', 'ttf-one' ),
				'2' => __( 'Choice 2', 'ttf-one' ),
				'3' => __( 'Choice 3', 'ttf-one' )
			),
			'priority' => $priority
		)
	);
	$priority += 10;

	// Header font title
	$setting_id = 'font-header';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '1',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Header', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => array(
				'1' => __( 'Choice 1', 'ttf-one' ),
				'2' => __( 'Choice 2', 'ttf-one' ),
				'3' => __( 'Choice 3', 'ttf-one' )
			),
			'priority' => $priority
		)
	);
	$priority += 10;

	// Background Size
	$setting_id = 'font-body';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '1',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Body', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => array(
				'1' => __( 'Choice 1', 'ttf-one' ),
				'2' => __( 'Choice 2', 'ttf-one' ),
				'3' => __( 'Choice 3', 'ttf-one' )
			),
			'priority' => $priority
		)
	);
}
endif;