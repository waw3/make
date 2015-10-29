<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_Customizer_ControlsInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_Customizer_ControlsInterface ) {
	return;
}

// Panel ID
$panel = $this->prefix . 'background-images';

$regions = array(
	'header' => __( 'Header', 'make' ),
	'main'   => __( 'Main Column', 'make' ),
	'footer' => __( 'Footer', 'make' ),
);

foreach ( $regions as $prefix => $title ) {
	$this->add_section_definitions( $prefix . '-background', array(
		'panel' => $panel,
		'title' => $title,
		'controls' => array(
			$prefix . '-background-image'    => array(
				'setting' => array(),
				'control' => array(
					'control_type' => 'MAKE_Customizer_Control_Image',
					'label'        => __( 'Background Image', 'make' ),
				),
			),
			$prefix . '-background-repeat'   => array(
				'setting' => array(),
				'control' => array(
					'label'   => __( 'Repeat', 'make' ),
					'type'    => 'radio',
					'choices' => $this->thememod->get_choice_set( $prefix . '-background-repeat' ),
				),
			),
			$prefix . '-background-position' => array(
				'setting' => array(),
				'control' => array(
					'control_type' => 'MAKE_Customizer_Control_BackgroundPosition',
					'label'   => __( 'Position', 'make' ),
					'type'    => 'radio',
					'choices' => $this->thememod->get_choice_set( $prefix . '-background-position' ),
				),
			),
			$prefix . '-background-attachment'     => array(
				'setting' => array(),
				'control' => array(
					'control_type' => 'MAKE_Customizer_Control_Radio',
					'label'   => __( 'Attachment', 'make' ),
					'type'    => 'radio',
					'mode'    => 'buttonset',
					'choices' => $this->thememod->get_choice_set( $prefix . '-background-attachment' ),
				),
			),
			$prefix . '-background-size'     => array(
				'setting' => array(),
				'control' => array(
					'control_type' => 'MAKE_Customizer_Control_Radio',
					'label'   => __( 'Size', 'make' ),
					'type'    => 'radio',
					'mode'    => 'buttonset',
					'choices' => $this->thememod->get_choice_set( $prefix . '-background-size' ),
				),
			),
		)
	) );
}

// Check for deprecated filters
foreach ( array( 'make_customizer_background_sections', 'make_customizer_background_image_group_definitions' ) as $filter ) {
	if ( has_filter( $filter ) ) {
		$this->compatibility->deprecated_hook(
			$filter,
			'1.7.0',
			__( 'To add or modify Customizer sections and controls, use the make_customizer_sections hook instead, or the core $wp_customize methods.', 'make' )
		);
	}
}