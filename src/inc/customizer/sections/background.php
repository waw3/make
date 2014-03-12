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
	$priority = new TTF_One_Prioritizer();
	$prefix = 'ttf-one_';

	// Background Color
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
				'priority' => $priority->add()
			)
		)
	);

	// Background Image
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
				'priority' => $priority->add(),
				'context'  => $prefix . $setting_id
			)
		)
	);

	// Background Size
	$setting_id = 'background-size';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => 'actual',
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
			'type'     => 'select',
			'choices'  => array(
				'actual'  => __( 'Actual Size', 'ttf-one' ),
				'cover'   => __( 'Cover', 'ttf-one' ),
				'contain' => __( 'Contain', 'ttf-one' )
			),
			'priority' => $priority->add()
		)
	);

	// Background Repeat
	$setting_id = 'background-repeat';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => 'no-repeat',
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
			'type'     => 'select',
			'choices'  => array(
				'no-repeat' => __( 'No Repeat', 'ttf-one' ),
				'tile'      => __( 'Tile', 'ttf-one' ),
				'tile-h'    => __( 'Tile Horizontally', 'ttf-one' ),
				'tile-v'    => __( 'Tile Vertically', 'ttf-one' )
			),
			'priority' => $priority->add()
		)
	);

	// Background Position
	$setting_id = 'background-position';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => 'center',
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
			'type'     => 'select',
			'choices'  => array(
				'left'   => __( 'Left', 'ttf-one' ),
				'center' => __( 'Center', 'ttf-one' ),
				'right'  => __( 'Right', 'ttf-one' )
			),
			'priority' => $priority->add()
		)
	);

	// Background Attachment
	$setting_id = 'background-attachment';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => 'fixed',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Background Attachment', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => array(
				'fixed'  => __( 'Fixed', 'ttf-one' ),
				'scroll' => __( 'Scroll', 'ttf-one' )
			),
			'priority' => $priority->add()
		)
	);
}
endif;