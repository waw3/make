<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_Compatibility_CompatibilityInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_Compatibility_CompatibilityInterface ) {
	return;
}

/**
 * Detect support for Customizer panels.
 *
 * This feature was introduced in WP 4.0. The WP_Customize_Manager class is not loaded
 * outside of the Customizer, so this also looks for wp_validate_boolean(), another
 * function added in WP 4.0.
 *
 * This function has been deprecated, as Make no longer supports WordPress versions that don't support panels.
 *
 * @since  1.3.0.
 * @deprecated 1.6.0.
 *
 * @return bool    Whether or not panels are supported.
 */
function ttfmake_customizer_supports_panels() {
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.6.0' );
	return ( class_exists( 'WP_Customize_Manager' ) && method_exists( 'WP_Customize_Manager', 'add_panel' ) ) || function_exists( 'wp_validate_boolean' );
}

/**
 * Add the old sections and controls to the customizer for WP installations with no panel support.
 *
 * This function has been deprecated, as Make no longer supports WordPress versions that don't support panels.
 *
 * @since  1.3.0.
 * @deprecated 1.6.0.
 *
 * @param  WP_Customize_Manager    $wp_customize    Theme Customizer object.
 * @return void
 */
function ttfmake_customizer_add_legacy_sections( $wp_customize ) {
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.6.0' );
}

/**
 * Build the CSS rules for the custom fonts.
 *
 * This function has been deprecated, as Make no longer supports WordPress versions that don't support panels.
 *
 * @since  1.0.0.
 * @deprecated 1.6.0.
 *
 * @return void
 */
function ttfmake_css_legacy_fonts() {
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.6.0' );
}