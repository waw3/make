<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_Customizer_ControlsInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_Customizer_ControlsInterface ) {
	return;
}

// Section ID
$section_id = 'title_tagline';

// Section object
$section = $wp_customize->get_section( $section_id );

$priority = new MAKE_Util_Priority( 10, 5 );

// Move Site Title & Tagline section to General panel
$section->panel = $this->prefix . 'general';

// Set Site Title & Tagline section priority
//$section->priority = $wp_customize->get_section( $this->prefix . 'logo' )->priority - 5;

// Reset priorities on Site Title control
$wp_customize->get_control( 'blogname' )->priority = $priority->add();

// Hide Site Title option
$controls = array(
	'hide-site-title' => array(
		'setting' => array(
			'transport'         => 'postMessage',
		),
		'control' => array(
			'label' => __( 'Hide Site Title', 'make' ),
			'type'  => 'checkbox',
		),
	),
);
$new_priority = $this->add_section_controls( $wp_customize, $section_id, $controls, $priority->add() );
$priority->set( $new_priority );

// Reset priorities on Tagline control
$wp_customize->get_control( 'blogdescription' )->priority = $priority->add();

// Hide Tagline option
$controls = array(
	'hide-tagline' => array(
		'setting' => array(
			'transport'         => 'postMessage',
		),
		'control' => array(
			'label' => __( 'Hide Tagline', 'make' ),
			'type'  => 'checkbox',
		),
	),
);
$new_priority = $this->add_section_controls( $wp_customize, $section_id, $controls, $priority->add() );
$priority->set( $new_priority );