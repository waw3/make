<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_customizer_background' ) ) :
/**
 * Configure settings and controls for the Background section.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttfmake_customizer_background() {
	global $wp_customize;
	$theme_prefix = 'ttfmake_';
	$section_id = 'background_image';
	$section = $wp_customize->get_section( $section_id );
	$priority = new TTFMAKE_Prioritizer( 10, 5 );

	// Move Background Image section to General panel
	$section->panel = $theme_prefix . 'general';

	// Set Background Image section priority
	$social_priority = $wp_customize->get_section( $theme_prefix . 'social' )->priority;
	$section->priority = $social_priority - 5;

	// Rename Background Image section
	$section->title = __( 'Site Background Image', 'make' );

	// Adjust section title if no panel support
	if ( ! ttfmake_customizer_supports_panels() ) {
		$panels = ttfmake_customizer_get_panels();
		if ( isset( $panels['general']['title'] ) ) {
			$section->title = $panels['general']['title'] . ': ' . $section->title;
		}
	}

	// Reset priorities on existing controls
	$wp_customize->get_control( 'background_image' )->priority = $priority->add();
	$wp_customize->get_control( 'background_repeat' )->priority = $priority->add();
	$wp_customize->get_control( 'background_position_x' )->priority = $priority->add();
	$wp_customize->get_control( 'background_attachment' )->priority = $priority->add();

	// Add new options
	$options = array(
		'background_size' => array(
			'setting' => array(
				'sanitize_callback'	=> 'ttfmake_sanitize_choice',
			),
			'control' => array(
				'label'				=> __( 'Background Size', 'make' ),
				'type'				=> 'radio',
				'choices'			=> ttfmake_get_choices( 'background_size' ),
			),
		),
	);
	$new_priority = ttfmake_customizer_add_section_options( $section_id, $options, $priority->add() );
	$priority->set( $new_priority );
}
endif;

add_action( 'customize_register', 'ttfmake_customizer_background', 20 );