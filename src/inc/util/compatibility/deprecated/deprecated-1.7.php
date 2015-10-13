<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a TTFMAKE_Util_Compatibility_CompatibilityInterface.
if ( ! isset( $this ) || ! $this instanceof TTFMAKE_Util_Compatibility_CompatibilityInterface ) {
	return;
}

/**
 * Add notice if Make Plus is installed as a theme.
 *
 * @since  1.1.2.
 * @deprecated 1.7.0.
 *
 * @param  string         $source           File source location.
 * @param  string         $remote_source    Remove file source location.
 * @param  WP_Upgrader    $upgrader         WP_Upgrader instance.
 * @return WP_Error                         Error or source on success.
 */
function ttfmake_check_package( $source, $remote_source, $upgrader ) {
	make_get_utils()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0' );
	return $source;
}

/**
 * Adds back compat for filters with changed names.
 *
 * In Make 1.2.3, filters were all changed from "ttfmake_" to "make_". In order to maintain back compatibility, the old
 * version of the filter needs to still be called. This function collects all of those changed filters and mirrors the
 * new filter so that the old filter name will still work.
 *
 * @since  1.2.3.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_filter_backcompat() {
	make_get_utils()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0' );
}

/**
 * Prepends "ttf" to a filter name and calls that new filter variant.
 *
 * @since  1.2.3.
 * @deprecated 1.7.0.
 *
 * @return mixed    The result of the filter.
 */
function ttfmake_backcompat_filter() {
	make_get_utils()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0' );

	$filter = 'ttf' . current_filter();
	$args   = func_get_args();
	return apply_filters_ref_array( $filter, $args );
}

/**
 * Adds back compat for actions with changed names.
 *
 * In Make 1.2.3, actions were all changed from "ttfmake_" to "make_". In order to maintain back compatibility, the old
 * version of the action needs to still be called. This function collects all of those changed actions and mirrors the
 * new filter so that the old filter name will still work.
 *
 * @since  1.2.3.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_action_backcompat() {
	make_get_utils()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0' );
}

/**
 * Prepends "ttf" to a filter name and calls that new filter variant.
 *
 * @since  1.2.3.
 * @deprecated 1.7.0.
 *
 * @return mixed    The result of the filter.
 */
function ttfmake_backcompat_action() {
	make_get_utils()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0' );

	$action = 'ttf' . current_filter();
	$args   = func_get_args();
	do_action_ref_array( $action, $args );
}

/**
 * Return an array of option key migration sets.
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @return array    The list of key migration sets.
 */
function ttfmake_customizer_get_key_conversions() {
	make_get_utils()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0' );
}

/**
 * Convert old theme mod values to their newer equivalents.
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_customizer_set_up_theme_mod_conversions() {
	make_get_utils()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0' );
}

/**
 * Convert a new theme mod value from an old one.
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @param  mixed    $value    The current value.
 * @return mixed              The modified value.
 */
function ttfmake_customizer_convert_theme_mods_filter( $value ) {
	make_get_utils()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0' );
	return $value;
}

/**
 * This function converts values from old mods to values for new mods.
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $old_key    The old mod key.
 * @param  string    $new_key    The new mod key.
 * @param  mixed     $value      The value of the mod.
 * @return mixed                 The convert mod value.
 */
function ttfmake_customizer_convert_theme_mods_values( $old_key, $new_key, $value ) {
	make_get_utils()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0' );
	return $value;
}

/**
 * Instantiate or return the one TTFMAKE_Admin_Notice instance.
 *
 * @since  1.4.9.
 * @deprecated 1.7.0.
 *
 * @return TTFMAKE_Admin_Notice
 */
function ttfmake_admin_notice() {
	make_get_utils()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0' );
	return make_get_utils()->get_module( 'notice' );
}

/**
 * Wrapper function to register an admin notice.
 *
 * @since 1.4.9.
 * @deprecated 1.7.0.
 *
 * @param string    $id         A unique ID string for the admin notice.
 * @param string    $message    The content of the admin notice.
 * @param array     $args       Array of configuration parameters for the admin notice.
 * @return void
 */
function ttfmake_register_admin_notice( $id, $message, $args ) {
	make_get_utils()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0' );
	make_get_utils()->get_module( 'notice' )->register_admin_notice( $id, $message, $args );
}

/**
 * Upgrade notices related to Make.
 *
 * @since 1.4.9.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_upgrade_notices() {
	make_get_utils()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0' );
}

/**
 * Upgrade notices related to Make Plus.
 *
 * @since 1.4.9.
 *
 * @return void
 */
function ttfmake_plus_upgrade_notices() {
	make_get_utils()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0' );
}