<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_option_defaults' ) ) :
/**
 * The big array of global option defaults.
 *
 * @since 1.0.0
 *
 * @return array
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
		'font-site-title' => 'sans-serif',
		'font-site-title-size' => 34,
		'font-header' => 'sans-serif',
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
		'header-text-color' => '#171717',
		'header-background-color' => '#ffffff',
		'header-background-image' => '',
		'header-background-repeat' => 'no-repeat',
		'header-background-position' => 'center',
		'header-background-size' => 'cover',
		'header-subheader-background-color' => '#ffffff',
		'header-subheader-text-color' => '#171717',
		'header-subheader-border-color' => '#eaecee',
		'header-text' => '',
		'header-show-social' => 0,
		'header-show-search' => 1,
		'header-layout' => 1,
		'header-primary-nav-position' => 'right',
		// Main
		'main-background-color' => '#ffffff',
		'main-background-image' => '',
		'main-background-repeat' => 'repeat',
		'main-background-position' => 'left',
		'main-background-size' => 'auto',
		'main-sidebar-left-posts' => 0,
		'main-sidebar-left-pages' => 0,
		'main-sidebar-left-archives' => 0,
		'main-sidebar-left-search' => 0,
		'main-sidebar-right-posts' => 1,
		'main-sidebar-right-pages' => 1,
		'main-sidebar-right-archives' => 1,
		'main-sidebar-right-search' => 1,
		// Footer
		'footer-text-color' => '#464849',
		'footer-border-color' => '#b9bcbf',
		'footer-background-color' => '#eaecee',
		'footer-background-image' => '',
		'footer-background-repeat' => 'no-repeat',
		'footer-background-position' => 'center',
		'footer-background-size' => 'cover',
		'footer-widget-areas' => 3,
		'footer-text' => '',
		'footer-show-social' => 1,
		'footer-show-credit' => 1,
		'footer-layout' => 1,
		// Social
		'social-facebook' => '',
		'social-twitter' => '',
		'social-google' => '',
		'social-linkedin' => '',
		'social-instagram' => '',
		'social-flickr' => '',
		'social-youtube' => '',
		'social-vimeo' => '',
		'social-pinterest' => '',
		'social-email' => '',
		'social-hide-rss' => 0,
		'social-custom-rss' => '',
	);

	return apply_filters( 'ttf_one_option_defaults', $defaults );
}
endif;

if ( ! function_exists( 'ttf_one_get_default' ) ) :
/**
 * Return a particular global option default.
 *
 * @since 1.0.0
 *
 * @param string $option The key of the option to return.
 *
 * @return mixed
 */
function ttf_one_get_default( $option ) {
	$defaults = ttf_one_option_defaults();
	return ( isset( $defaults[$option] ) ) ? $defaults[$option] : false;
}
endif;
