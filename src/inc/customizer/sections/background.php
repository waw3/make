<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_customizer_background' ) ) :
/**
 * Configure settings and controls for the Background section.
 *
 * @since  1.0.0
 *
 * @return void
 */
function ttf_one_customizer_background() {
	global $wp_customize;

	$priority = new TTF_One_Prioritizer( 10, 5 );
	$prefix = 'ttf-one_';
	$section = 'background_image';

	// Rename Background Image section to Background
	$wp_customize->get_section( $section )->title = __( 'Background', 'ttf-one' );

	// Move Background Color to Background section
	$wp_customize->get_control( 'background_color' )->section = $section;

	// Background note
	$setting_id = 'background-info';
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'text',
				'description' => __( 'With the Site Layout option (under <em>General</em>) set to "Full Width", the background color and image will not be visible.', 'ttf-one' ),
				'priority'    => $priority->add()
			)
		)
	);

	// Reset priorities on existing controls
	$wp_customize->get_control( 'background_color' )->priority = $priority->add();
	$wp_customize->get_control( 'background_image' )->priority = $priority->add();
	$wp_customize->get_control( 'background_repeat' )->priority = $priority->add();
	$wp_customize->get_control( 'background_position_x' )->priority = $priority->add();
	$wp_customize->get_control( 'background_attachment' )->priority = $priority->add();

	// Background Size
	$setting_id = 'background_size';
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
}
endif;

add_action( 'customize_register', 'ttf_one_customizer_background', 20 );
