<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_customizer_footer' ) ) :
/**
 * Configure settings and controls for the Footer section
 *
 * @since 1.0.0
 *
 * @param  object    $wp_customize    The global customizer object.
 * @param  string    $section         The section name.
 *
 * @return void
 */
function ttf_one_customizer_footer( $wp_customize, $section ) {
	$priority = new TTF_One_Prioritizer();
	$prefix = 'ttf-one_';

	// Footer text color
	$setting_id = 'footer-text-color';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
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
				'label'    => __( 'Footer Text Color', 'ttf-one' ),
				'priority' => $priority->add()
			)
		)
	);

	// Footer border color
	$setting_id = 'footer-border-color';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
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
				'label'    => __( 'Footer Border Color', 'ttf-one' ),
				'priority' => $priority->add()
			)
		)
	);

	// Background color
	$setting_id = 'footer-background-color';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
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
				'label'    => __( 'Footer Background Color', 'ttf-one' ),
				'priority' => $priority->add()
			)
		)
	);

	// Background Image
	$setting_id = 'footer-background-image';
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
				'label'    => __( 'Footer Background Image', 'ttf-one' ),
				'priority' => $priority->add(),
				'context'  => $prefix . $setting_id
			)
		)
	);

	// Background Repeat
	$setting_id = 'footer-background-repeat';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Background Repeat', 'ttf-one' ),
			'type'     => 'radio',
			'choices'  => ttf_one_get_choices( $setting_id ),
			'priority' => $priority->add()
		)
	);

	// Background Position
	$setting_id = 'footer-background-position';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Background Position', 'ttf-one' ),
			'type'     => 'radio',
			'choices'  => ttf_one_get_choices( $setting_id ),
			'priority' => $priority->add()
		)
	);

	// Background Size
	$setting_id = 'footer-background-size';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Background Size', 'ttf-one' ),
			'type'     => 'radio',
			'choices'  => ttf_one_get_choices( $setting_id ),
			'priority' => $priority->add()
		)
	);

	// Footer widget areas
	$setting_id = 'footer-widget-areas';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Footer Widget Areas', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => ttf_one_get_choices( $setting_id ),
			'priority' => $priority->add()
		)
	);

	// Footer text
	$setting_id = 'footer-text';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_text',
			'transport'         => 'postMessage' // Asynchronous preview
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

	// Footer options heading
	$setting_id = 'footer-options-heading';
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'heading',
				'label' => __( 'Footer Options', 'ttf-one' ),
				'priority'    => $priority->add()
			)
		)
	);

	// Show social icons
	$setting_id = 'footer-show-social';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Show Social Icons', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Footer layout
	$setting_id = 'footer-layout';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Footer Layout', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => ttf_one_get_choices( $setting_id ),
			'priority' => $priority->add()
		)
	);
}
endif;