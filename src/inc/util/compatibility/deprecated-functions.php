<?php
/**
 * @package Make
 */

/**
 * Write the favicons to the head to implement the options.
 *
 * This function is deprecated. The functionality was moved to ttfmake_head_late().
 *
 * @since  1.0.0.
 * @deprecated 1.5.0.
 *
 * @return void
 */
function ttfmake_display_favicons() {
	_deprecated_function( __FUNCTION__, '1.5.0' );
}

/**
 * Add theme option body classes.
 *
 * This function is deprecated. The functionality was moved to ttfmake_body_classes().
 *
 * @since  1.0.0.
 * @deprecated 1.5.0.
 *
 * @param  array    $classes    Existing classes.
 * @return array                Modified classes.
 */
function ttfmake_body_layout_classes( $classes ) {
	_deprecated_function( __FUNCTION__, '1.5.0' );
	return $classes;
}

/**
 * Define the sections and settings for the Header panel.
 *
 * @since  1.3.0.
 * @deprecated 1.5.0.
 *
 * @param  array    $sections    The master array of Customizer sections
 * @return array                 The augmented master array
 */
function ttfmake_customizer_define_header_sections( $sections ) {
	_deprecated_function( __FUNCTION__, '1.5.0' );
	return $sections;
}

/**
 * Define the sections and settings for the Footer panel
 *
 * @since  1.3.0.
 *
 * @param  array    $sections    The master array of Customizer sections
 * @return array                 The augmented master array
 */
function ttfmake_customizer_define_footer_sections( $sections ) {
	_deprecated_function( __FUNCTION__, '1.5.0' );
	return $sections;
}

/**
 * Process user options to generate CSS needed to implement the choices.
 *
 * This function has been broken up into several files/functions in the inc/customizer/style directory.
 *
 * @since  1.0.0.
 * @deprecated 1.5.0.
 *
 * @return void
 */
function ttfmake_css_add_rules() {
	_deprecated_function( __FUNCTION__, '1.5.0' );
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
 *
 * @return bool    Whether or not panels are supported.
 */
function ttfmake_customizer_supports_panels() {
	_deprecated_function( __FUNCTION__, '1.6.0' );
	return ( class_exists( 'WP_Customize_Manager' ) && method_exists( 'WP_Customize_Manager', 'add_panel' ) ) || function_exists( 'wp_validate_boolean' );
}

/**
 * Add the old sections and controls to the customizer for WP installations with no panel support.
 *
 * This function has been deprecated, as Make no longer supports WordPress versions that don't support panels.
 *
 * @since  1.3.0.
 *
 * @param  WP_Customize_Manager    $wp_customize    Theme Customizer object.
 * @return void
 */
function ttfmake_customizer_add_legacy_sections( $wp_customize ) {
	_deprecated_function( __FUNCTION__, '1.6.0' );
}

/**
 * Build the CSS rules for the custom fonts.
 *
 * This function has been deprecated, as Make no longer supports WordPress versions that don't support panels.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttfmake_css_legacy_fonts() {
	_deprecated_function( __FUNCTION__, '1.6.0' );
}