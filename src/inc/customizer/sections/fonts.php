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
	$priority = new TTF_One_Prioritizer();
	$prefix = 'ttf-one_';

	// Site title font
	$setting_id = 'font-site-title';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => 'Montserrat',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_font_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Site Title', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => ttf_one_google_font_choices(),
			'priority' => $priority->add()
		)
	);

	// Site title font size
	$setting_id = 'font-site-title-size';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '34',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Site Title Font Size (in px)', 'ttf-one' ),
			'type'     => 'text',
			'priority' => $priority->add()
		)
	);

	// Header font
	$setting_id = 'font-header';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => 'Montserrat',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_font_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Header', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => ttf_one_google_font_choices(),
			'priority' => $priority->add()
		)
	);

	// Header font size
	$setting_id = 'font-header-size';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '50',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Header Font Size (in px)', 'ttf-one' ),
			'type'     => 'text',
			'priority' => $priority->add()
		)
	);

	// Body font
	$setting_id = 'font-body';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => 'Open Sans',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_font_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Body', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => ttf_one_google_font_choices(),
			'priority' => $priority->add()
		)
	);

	// Body font size
	$setting_id = 'font-body-size';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '24',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Body Font Size (in px)', 'ttf-one' ),
			'type'     => 'text',
			'priority' => $priority->add()
		)
	);

	// Subset
	$setting_id = 'font-subset';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => 'latin',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_font_subset',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Subset', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => ttf_one_get_google_font_subsets(),
			'priority' => $priority->add()
		)
	);
}
endif;