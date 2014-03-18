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
	$priority = new TTF_One_Prioritizer();
	$prefix   = 'ttf-one_';

	// Regular Logo
	$setting_id = 'logo-regular';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
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
				'priority' => $priority->add(),
				'context'  => $prefix . $setting_id
			)
		)
	);

	// Retina Logo
	$setting_id = 'logo-retina';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
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
				'priority' => $priority->add(),
				'context'  => $prefix . $setting_id
			)
		)
	);

	// Retina info
	$setting_id = 'logo-retina-info';
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'text',
				'description' => __( 'The Retina Logo should be twice as big as the Regular Logo. So, if the regular version is 320px x 240px, the retina version should be 640px x 480px.', 'ttf-one' ),
				'priority'    => $priority->add()
			)
		)
	);

	// Favicon
	$setting_id = 'logo-favicon';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new TTF_One_Customize_Image_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'settings'   => $setting_id,
				'section'    => $section,
				'label'      => __( 'Favicon', 'ttf-one' ),
				'priority'   => $priority->add(),
				'context'    => $prefix . $setting_id,
				'extensions' => array( 'png', 'ico' )
			)
		)
	);

	// Favicon info
	$setting_id = 'logo-favicon-info';
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'text',
				'description' => __( 'The Favicon must be <strong>.png</strong> or <strong>.ico</strong> format. The optimal dimensions are <strong>32px x 32px</strong>.', 'ttf-one' ),
				'priority'    => $priority->add()
			)
		)
	);

	// Apple Touch Icon
	$setting_id = 'logo-apple-touch';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new TTF_One_Customize_Image_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'settings'   => $setting_id,
				'section'    => $section,
				'label'      => __( 'Apple Touch Icon', 'ttf-one' ),
				'priority'   => $priority->add(),
				'context'    => $prefix . $setting_id,
				'extensions' => array( 'png' )
			)
		)
	);

	// Apple Touch Icon info
	$setting_id = 'logo-apple-touch-info';
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'text',
				'description' => __( 'The Apple Touch Icon must be <strong>.png</strong> format. The optimal dimensions are <strong>152px x 152px</strong>.', 'ttf-one' ),
				'priority'    => $priority->add()
			)
		)
	);
}
endif;