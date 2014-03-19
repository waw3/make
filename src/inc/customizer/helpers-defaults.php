<?php
/**
 * @package ttf-one
 */

/**
 *
 */
function ttf_one_option_defaults() {
	$defaults = array(
		// Site Title & Tagline
		'hide-site-title' => 0,
		'hide-tagline' => 0,
		// Navigation
		'navigation-mobile-label' => __( 'Menu', 'ttf-one' ),
		// General
		'general-layout' => 'full-width',
		'general-sticky-label' => __( 'Featured', 'ttf-one' ),
		// Logo
		'logo-regular' => '',
		'logo-retina' => '',
		'logo-favicon' => '',
		'logo-apple-touch' => '',
		// Background
		'background_color' => '#ffffff',
		'background_image' => '',
		'background_repeat' => 'repeat',
		'background_position_x' => 'left',
		'background_attachment' => 'scroll',
		'background_size' => 'auto',
		// Fonts
		'font-site-title' => 'Montserrat',
		'font-site-title-size' => 34,
		'font-header' => 'Montserrat',
		'font-header-size' => 50,
		'font-body' => 'Open Sans',
		'font-body-size' => 16,
		'font-subset' => 'latin',
		//
	);

	return apply_filters( 'ttf_one_option_defaults', $defaults );
}

/**
 *
 */
function ttf_one_get_default( $option ) {
	$defaults = ttf_one_option_defaults();
	return ( isset( $defaults[$option] ) ) ? $defaults[$option] : false;
}