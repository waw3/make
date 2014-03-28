<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_customizer_header' ) ) :
/**
 * Configure settings and controls for the Header section
 *
 * @since 1.0
 *
 * @param object $wp_customize
 * @param string $section
 */
function ttf_one_customizer_header( $wp_customize, $section ) {
	$priority = new TTF_One_Prioritizer( 10, 5 );
	$prefix = 'ttf-one_';

	// Header Text color
	$setting_id = 'header-text-color';
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
				'label'    => __( 'Header Text Color', 'ttf-one' ),
				'priority' => $priority->add()
			)
		)
	);

	// Header Background Color
	$setting_id = 'header-background-color';
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
				'label'    => __( 'Header Background Color', 'ttf-one' ),
				'priority' => $priority->add()
			)
		)
	);

	// Background Image
	$setting_id = 'header-background-image';
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
				'label'    => __( 'Header Background Image', 'ttf-one' ),
				'priority' => $priority->add(),
				'context'  => $prefix . $setting_id
			)
		)
	);

	// Background Repeat
	$setting_id = 'header-background-repeat';
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
			'choices'  => array(
				'no-repeat' => __( 'No Repeat', 'ttf-one' ),
				'repeat'    => __( 'Tile', 'ttf-one' ),
				'repeat-x'  => __( 'Tile Horizontally', 'ttf-one' ),
				'repeat-y'  => __( 'Tile Vertically', 'ttf-one' )
			),
			'priority' => $priority->add()
		)
	);

	// Background Position
	$setting_id = 'header-background-position';
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
			'choices'  => array(
				'left'   => __( 'Left', 'ttf-one' ),
				'center' => __( 'Center', 'ttf-one' ),
				'right'  => __( 'Right', 'ttf-one' )
			),
			'priority' => $priority->add()
		)
	);

	// Background Size
	$setting_id = 'header-background-size';
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
			'choices'  => array(
				'auto'  => __( 'Auto', 'ttf-one' ),
				'cover'   => __( 'Cover', 'ttf-one' ),
				'contain' => __( 'Contain', 'ttf-one' )
			),
			'priority' => $priority->add()
		)
	);

	// Sub Header Text color
	$setting_id = 'header-subheader-text-color';
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
				'label'    => __( 'Sub Header Text Color', 'ttf-one' ),
				'priority' => $priority->add()
			)
		)
	);

	// Sub Header Border color
	$setting_id = 'header-subheader-border-color';
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
				'label'    => __( 'Sub Header Border Color', 'ttf-one' ),
				'priority' => $priority->add()
			)
		)
	);

	// Sub Header Background color
	$setting_id = 'header-subheader-background-color';
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
				'label'    => __( 'Sub Header Background Color', 'ttf-one' ),
				'priority' => $priority->add()
			)
		)
	);

	// Header text
	$setting_id = 'header-text';
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
			'label'    => __( 'Sub Header Text', 'ttf-one' ),
			'type'     => 'text',
			'priority' => $priority->add()
		)
	);

	// Header options heading
	$setting_id = 'header-options-heading';
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'heading',
				'label' => __( 'Header Options', 'ttf-one' ),
				'priority'    => $priority->add()
			)
		)
	);

	// Show social icons
	$setting_id = 'header-show-social';
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
			'label'    => __( 'Show Social Icons In Header', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Show search field
	$setting_id = 'header-show-search';
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
			'label'    => __( 'Show Search Field In Header', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Sub Header content layout
	$setting_id = 'header-subheader-content-layout';
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
			'label'    => __( 'Sub Header Content Layout', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => array(
				'default' => __( 'Default', 'ttf-one' ),
				'flipped' => __( 'Flipped', 'ttf-one' )
			),
			'priority' => $priority->add()
		)
	);

	// Header layout
	$setting_id = 'header-layout';
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
			'label'    => __( 'Header Layout', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => array(
				1  => __( 'Layout 1', 'ttf-one' ),
				2  => __( 'Layout 2', 'ttf-one' ),
				3  => __( 'Layout 3', 'ttf-one' ),
			),
			'priority' => $priority->add()
		)
	);

	// Branding position (Layouts 1 & 3 only)
	$setting_id = 'header-branding-position';
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
			'label'    => __( 'Show Title/Logo On', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => array(
				'left'  => __( 'Left', 'ttf-one' ),
				'right' => __( 'Right', 'ttf-one' )
			),
			'priority' => $priority->add()
		)
	);
}
endif;