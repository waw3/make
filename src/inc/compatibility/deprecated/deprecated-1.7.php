<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_Compatibility_CompatibilityInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_Compatibility_CompatibilityInterface ) {
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
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
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
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
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
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );

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
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
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
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );

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
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
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
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
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
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
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
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
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
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->get_module( \'notice\' )', $backtrace[0] );
	return Make()->get_module( 'notice' );
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
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->get_module( \'notice\' )->register_admin_notice', $backtrace[0] );
	Make()->get_module( 'notice' )->register_admin_notice( $id, $message, $args );
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
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Upgrade notices related to Make Plus.
 *
 * @since 1.4.9.
 *
 * @return void
 */
function ttfmake_plus_upgrade_notices() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Wrapper function to instantiate the L10n class and call the method to load text domains.
 *
 * @since 1.6.2.
 * @deprecated 1.7.0.
 *
 * @return bool
 */
function ttfmake_load_textdomains() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->get_module( \'l10n\' )->load_textdomains', $backtrace[0] );
	return Make()->get_module( 'l10n' )->load_textdomains();
}

/**
 * The big array of global option defaults.
 *
 * @since  1.0.0
 * @deprecated 1.7.0.
 *
 * @return array    The default values for all theme options.
 */
function ttfmake_option_defaults() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->get_module( \'thememod\' )->get_settings( \'default\' )', $backtrace[0] );
	return Make()->get_module( 'thememod' )->get_settings( 'default' );
}

/**
 * Return a particular global option default.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $option    The key of the option to return.
 * @return mixed                Default value if found; false if not found.
 */
function ttfmake_get_default( $option ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', 'make_thememod_get_default', $backtrace[0] );
	return Make()->get_module( 'thememod' )->get_default( $option );
}

/**
 * Return the available choices for a given setting
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  string|object    $setting    The setting to get options for.
 * @return array                        The options for the setting.
 */
function ttfmake_get_choices( $setting ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->get_module( \'thememod\' )->get_choice_set', $backtrace[0] );
	return Make()->get_module( 'thememod' )->get_choice_set( $setting );
}

/**
 * Sanitize a value from a list of allowed values.
 *
 * @since 1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  mixed    $value      The value to sanitize.
 * @param  mixed    $setting    The setting for which the sanitizing is occurring.
 * @return mixed                The sanitized value.
 */
function ttfmake_sanitize_choice( $value, $setting ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->get_module( \'thememod\' )->sanitize_choice', $backtrace[0] );
	return Make()->get_module( 'thememod' )->sanitize_choice( $value, $setting );
}

/**
 * Enqueue scripts that run on the Edit Page screen
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_edit_page_script() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Jetpack compatibility.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_jetpack_setup() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Callback to render the special footer added by Infinite Scroll.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_jetpack_infinite_scroll_footer_callback() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Determine whether any footer widgets are actually showing.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return bool    Whether or not infinite scroll has footer widgets.
 */
function ttfmake_jetpack_infinite_scroll_has_footer_widgets() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Render the additional posts added by Infinite Scroll
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_jetpack_infinite_scroll_render() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Remove the Jetpack Sharing output from the end of the post content so it can be output elsewhere.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_jetpack_remove_sharing() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Add theme support and remove default action hooks so we can replace them with our own.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_woocommerce_init() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Markup to show before the main WooCommerce content.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_woocommerce_before_main_content() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Markup to show after the main WooCommerce content
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_woocommerce_after_main_content() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}