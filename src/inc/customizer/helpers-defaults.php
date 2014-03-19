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
		'background_color' => '#b9bcbf',
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
		// Colors
		'color-primary' => '#0094c5',
		'color-secondary' => '#eaecee',
		'color-text' => '#171717',
		'color-detail' => '#b9bcbf',
		// Header
		'header-background-color' => '#ffffff',
		'header-background-image' => '',
		'header-background-repeat' => 'no-repeat',
		'header-background-position' => 'center',
		'header-background-size' => 'cover',
		'header-subheader-background-color' => '#ffffff',
		'header-subheader-text-color' => '#171717',
		'header-text' => '',
		'header-show-social' => 0,
		'header-show-search' => 1,
		'header-layout' => 'header-layout-1',
		'header-primary-nav-position' => 'right',
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