<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_Compatibility_MethodsInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_Compatibility_MethodsInterface ) {
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

/**
 * Return the one TTFMAKE_CSS object.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMAKE_CSS    The one TTFMAKE_CSS object.
 */
function ttfmake_get_css() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->get_module( \'style\' )->css()', $backtrace[0] );
	return Make()->get_module( 'style' )->css();
}

/**
 * Build the CSS rules for the color scheme.
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_css_background() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Build the CSS rules for the color scheme.
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_css_color() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Convert a hex string into a comma separated RGB string.
 *
 * @link http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 *
 * @param  $value
 * @return bool|string
 */
function ttfmake_hex_to_rgb( $value ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return Make()->get_module( 'style' )->hex_to_rgb( $value );
}

/**
 * Load the customizer files and enqueue scripts
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_customizer_init() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Register autoloaders for Customizer-related classes.
 *
 * This function is hooked to customize_register so that it is only registered within the Customizer.
 *
 * @since 1.6.3.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_customizer_register_autoload() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Autoloader callback for loading Make's custom Customizer control classes.
 *
 * @since 1.6.3.
 * @deprecated 1.7.0.
 *
 * @param string    $class    The name of the class that is attempting to load.
 *
 * @return void
 */
function ttfmake_customizer_control_autoload( $class ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Return an array of panel definitions.
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @return array    The array of panel definitions.
 */
function ttfmake_customizer_get_panels() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Register Customizer panels
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @param  WP_Customize_Manager    $wp_customize    Customizer object.
 * @return void
 */
function ttfmake_customizer_add_panels( $wp_customize ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Return the master array of Customizer sections
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @return array    The master array of Customizer sections
 */
function ttfmake_customizer_get_sections() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Add sections and controls to the customizer.
 *
 * Hooked to 'customize_register' via ttfmake_customizer_init().
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  WP_Customize_Manager    $wp_customize    Theme Customizer object.
 * @return void
 */
function ttfmake_customizer_add_sections( $wp_customize ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Register settings and controls for a section.
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $section             Section ID
 * @param  array     $args                Array of setting and control definitions
 * @param  int       $initial_priority    The initial priority to use for controls
 * @return int                            The last priority value assigned
 */
function ttfmake_customizer_add_section_options( $section, $args, $initial_priority = 100 ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Add postMessage support for certain built-in settings in the Theme Customizer.
 *
 * Allows these settings to update asynchronously in the Preview pane.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  WP_Customize_Manager    $wp_customize    Theme Customizer object.
 * @return void
 */
function ttfmake_customizer_set_transport( $wp_customize ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Enqueue customizer preview script
 *
 * Hooked to 'customize_preview_init' via ttfmake_customizer_init()
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_customizer_preview_script() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Enqueue customizer sections script
 *
 * Hooked to 'customize_controls_enqueue_scripts' via ttfmake_customizer_init()
 *
 * @since  1.5.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_customizer_scripts() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Configure settings and controls for the Background section.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_customizer_background() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Configure settings and controls for the Navigation section.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_customizer_navigation() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Configure settings and controls for the Site Title & Tagline section.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_customizer_sitetitletagline() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Configure settings and controls for the Static Front Page section.
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_customizer_staticfrontpage() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Define the sections and settings for the Background Images panel
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 *
 * @param  array    $sections    The master array of Customizer sections
 * @return array                 The augmented master array
 */
function ttfmake_customizer_define_background_images_sections( $sections ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return $sections;
}

/**
 * Generate an array of Customizer option definitions for a particular HTML element.
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 *
 * @param  $region
 * @return array
 */
function ttfmake_customizer_background_image_group_definitions( $region ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Define the sections and settings for the Color panel
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @param  array    $sections    The master array of Customizer sections
 * @return array                 The augmented master array
 */
function ttfmake_customizer_define_colorscheme_sections( $sections ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Define the sections and settings for the General panel
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @param  array    $sections    The master array of Customizer sections
 * @return array                 The augmented master array
 */
function ttfmake_customizer_define_general_sections( $sections ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}


/**
 * Define the sections and settings for the Content & Layout panel
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @param  array    $sections    The master array of Customizer sections
 * @return array                 The augmented master array
 */
function ttfmake_customizer_define_contentlayout_sections( $sections ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Generate an array of Customizer option definitions for a particular view.
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $view
 * @return array
 */
function ttfmake_customizer_layout_region_group_definitions( $view ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Generate an array of Customizer option definitions for a particular view.
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $view
 * @return array
 */
function ttfmake_customizer_layout_featured_image_group_definitions( $view ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Generate an array of Customizer option definitions for a particular view.
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $view
 * @return array
 */
function ttfmake_customizer_layout_post_date_group_definitions( $view ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Generate an array of Customizer option definitions for a particular view.
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $view
 * @return array
 */
function ttfmake_customizer_layout_post_author_group_definitions( $view ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Generate an array of Customizer option definitions for a particular view.
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $view
 * @return array
 */
function ttfmake_customizer_layout_comment_count_group_definitions( $view ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Generate an array of Customizer option definitions for a particular view.
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $view
 * @return array
 */
function ttfmake_customizer_layout_post_meta_group_definitions( $view ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Generate an array of Customizer option definitions for a particular view.
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $view
 * @return array
 */
function ttfmake_customizer_layout_content_group_definitions( $view ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Generate an array of Customizer option definitions for a particular view.
 *
 * @since 1.6.4.
 * @deprecated 1.7.0.
 *
 * @param  string    $view
 *
 * @return array
 */
function ttfmake_customizer_layout_breadcrumb_group_definitions( $view ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Filter to add a new Customizer section
 *
 * This function takes the main array of Customizer sections and adds a new one
 * right before the first panel.
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @param  array    $sections    The array of sections to add to the Customizer.
 * @return array                 The modified array of sections.
 */
function ttfmake_customizer_stylekit( $sections ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Sanitize a font choice.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $value    The font choice.
 * @return string              The sanitized font choice.
 */
function ttfmake_sanitize_font_choice( $value ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->get_module( \'font\' )->sanitize_font_choice', $backtrace[0] );
	return Make()->get_module( 'font' )->sanitize_font_choice( $value );
}

/**
 * Sanitize the Character Subset choice.
 *
 * @since  1.0.0
 * @deprecated 1.7.0.
 *
 * @param  string    $value    The value to sanitize.
 * @return array               The sanitized value.
 */
function ttfmake_sanitize_font_subset( $value ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->get_module( \'font\' )->get_source( \'google\' )->sanitize_subset', $backtrace[0] );
	return Make()->get_module( 'font' )->get_source( 'google' )->sanitize_subset( $value, make_thememod_get_default( 'font-subset' ) );
}

/**
 * Compile font options from different sources.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return array    All available fonts.
 */
function ttfmake_get_all_fonts() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

/**
 * Packages the font choices into value/label pairs for use with the customizer.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return array    The fonts in value/label pairs.
 */
function ttfmake_all_font_choices() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->get_module( \'font\' )->get_font_choices', $backtrace[0] );
	return Make()->get_module( 'font' )->get_font_choices();
}

/**
 * Return an array of standard websafe fonts.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return array    Standard websafe fonts.
 */
function ttfmake_get_standard_fonts() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->get_module( \'font\' )->get_source( \'generic\' )->get_font_data', $backtrace[0] );
	return Make()->get_module( 'font' )->get_source( 'generic' )->get_font_data();
}

/**
 * Return an array of all available Google Fonts.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return array    All Google Fonts.
 */
function ttfmake_get_google_fonts() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->get_module( \'font\' )->get_source( \'google\' )->get_font_data', $backtrace[0] );
	return Make()->get_module( 'font' )->get_source( 'google' )->get_font_data();
}

/**
 * Given a font, chose the variants to load for the theme.
 *
 * Attempts to load regular, italic, and 700. If regular is not found, the first variant in the family is chosen. italic
 * and 700 are only loaded if found. No fallbacks are loaded for those fonts.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $font        The font to load variants for.
 * @param  array     $variants    The variants for the font.
 * @return array                  The chosen variants.
 */
function ttfmake_choose_google_font_variants( $font, $variants = array() ) {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->get_module( \'font\' )->get_source( \'google\' )->choose_font_variants', $backtrace[0] );
	return Make()->get_module( 'font' )->get_source( 'google' )->choose_font_variants( $font, $variants );
}

/**
 * Retrieve the list of available Google font subsets.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return array    The available subsets.
 */
function ttfmake_get_google_font_subsets() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->get_module( \'font\' )->get_source( \'google\' )->get_subsets', $backtrace[0] );
	return Make()->get_module( 'font' )->get_source( 'google' )->get_subsets();
}

/**
 * Build the HTTP request URL for Google Fonts.
 *
 * The wp_enqueue_style function escapes the stylesheet URL, so no escaping is done here. If
 * this function is used in a different context, make sure the output is escaped!
 *
 * @since  1.0.0.
 * @deprecate 1.7.0.
 *
 * @return string    The URL for including Google Fonts.
 */
function ttfmake_get_google_font_uri() {
	$backtrace = debug_backtrace();
	Make()->get_module( 'compatibility' )->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}