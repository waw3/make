<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_Customizer_ControlsInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_Customizer_ControlsInterface ) {
	return;
}

$this->add_section_definitions( 'stylekit', array(
	'title' => __( 'Style Kits', 'make' ),
	'description' => sprintf(
		__( '%s to quickly apply designer-picked style choices (fonts, layout, colors) to your website.', 'make' ),
		sprintf(
			'<a href="%1$s" target="_blank">%2$s</a>',
			esc_url( ttfmake_get_plus_link( 'style-kits' ) ),
			__( 'Upgrade to Make Plus', 'make' )
		)
	),
	'controls' => array(
		'stylekit-heading' => array(
			'control' => array(
				'control_type'		=> 'MAKE_Customizer_Control_Misc',
				'label'				=> __( 'Kits', 'make' ),
				'type'				=> 'heading',
			),
		),
		'stylekit-dropdown' => array(
			'control' => array(
				'control_type'		=> 'MAKE_Customizer_Control_Misc',
				'type'				=> 'text',
				'description'		=> '
						<select>
							<option selected="selected" disabled="disabled">--- ' . __( "Choose a kit", "make" ) . ' ---</option>
							<option disabled="disabled">' . __( "Default", "make" ) . '</option>
							<option disabled="disabled">' . __( "Hello", "make" ) . '</option>
							<option disabled="disabled">' . __( "Light", "make" ) . '</option>
							<option disabled="disabled">' . __( "Dark", "make" ) . '</option>
							<option disabled="disabled">' . __( "Modern", "make" ) . '</option>
							<option disabled="disabled">' . __( "Creative", "make" ) . '</option>
							<option disabled="disabled">' . __( "Vintage", "make" ) . '</option>
						</select>
					',
			),
		),
	),
) );