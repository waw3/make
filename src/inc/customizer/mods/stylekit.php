<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_Customizer_ControlsInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_Customizer_ControlsInterface ) {
	return;
}

$section = $wp_customize->get_section( $this->prefix . 'stylekit' );

// Move the Style Kits section above the General panel.
if ( $section instanceof WP_Customize_Section ) {
	$section->priority = $wp_customize->get_panel( $this->prefix . 'general' )->priority - 5;
}