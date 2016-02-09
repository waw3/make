<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_Compatibility_MethodsInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_Compatibility_MethodsInterface ) {
	return;
}

if ( ! function_exists( 'ttfmake_setup' ) ) :
/**
 * Sets up text domain, theme support, menus, and editor styles
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttfmake_setup() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', __( 'a separate setup function', 'make' ), $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_setup', '1.7.0', __( 'a separate setup function', 'make' ) );
endif;

if ( ! function_exists( 'ttfmake_content_width' ) ) :
/**
 * Set the content width based on current layout
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttfmake_content_width() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_content_width', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_widgets_init' ) ) :
/**
 * Register widget areas
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_widgets_init() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'register_sidebar / unregister_sidebar', $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_widgets_init', '1.7.0', 'register_sidebar / unregister_sidebar' );
endif;

if ( ! function_exists( 'ttfmake_scripts' ) ) :
/**
 * Enqueue styles and scripts.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_scripts() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'wp_enqueue_script / wp_dequeue_script', $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_scripts', '1.7.0', 'wp_enqueue_script / wp_dequeue_script' );
endif;

if ( ! function_exists( 'ttfmake_cycle2_script_setup' ) ) :
/**
 * Enqueue Cycle2 scripts
 *
 * If the environment is set up for minified scripts, load one concatenated, minified
 * Cycle 2 script. Otherwise, load each module separately.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  array    $script_dependencies    Scripts that Cycle2 depends on.
 *
 * @return void
 */
function ttfmake_cycle2_script_setup( $script_dependencies ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'wp_register_script / wp_deregister_script', $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_cycle2_script_setup', '1.7.0', 'wp_register_script / wp_deregister_script' );
endif;

if ( ! function_exists( 'ttfmake_is_preview' ) ) :
/**
 * Check if the current view is rendering in the Customizer preview pane.
 *
 * @since 1.2.0.
 * @deprecated 1.7.0.
 *
 * @return bool    True if in the preview pane.
 */
function ttfmake_is_preview() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'is_customize_preview', $backtrace[0] );
	return is_customize_preview();
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_is_preview', '1.7.0', 'is_customize_preview' );
endif;

/**
 * Determine if the companion plugin is installed.
 *
 * @since  1.0.4.
 * @deprecated 1.7.0.
 *
 * @return bool    Whether or not the companion plugin is installed.
 */
function ttfmake_is_plus() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'make_is_plus', $backtrace[0] );
	return make_is_plus();
}

/**
 * Generate a link to the Make info page.
 *
 * @since  1.0.6.
 * @deprecated 1.7.0.
 *
 * @param  string    $deprecated    This parameter is no longer used.
 * @return string                   The link.
 */
function ttfmake_get_plus_link( $deprecated = '' ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->plus()->get_plus_link', $backtrace[0] );
	return Make()->plus()->get_plus_link();
}

/**
 * Add styles to admin head for Make Plus
 *
 * @since 1.0.6.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_plus_styles() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

if ( ! function_exists( 'ttfmake_page_menu_args' ) ) :
/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0
 *
 * @param  array    $args    Configuration arguments.
 * @return array             Modified page menu args.
 */
function ttfmake_page_menu_args( $args ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return $args;
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_page_menu_args', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_wp_title' ) ) :
/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $title    Default title text for current view.
 * @param  string    $sep      Optional separator.
 *
 * @return string              The filtered title.
 */
function ttfmake_wp_title( $title, $sep ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return $title;
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_wp_title', '1.7.0' );
endif;

/**
 * Sanitize a string to ensure that it is a float number.
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 *
 * @param  string|float    $value    The value to sanitize.
 * @return float                     The sanitized value.
 */
function ttfmake_sanitize_float( $value ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->thememod()->sanitize_float', $backtrace[0] );
	return Make()->thememod()->sanitize_float( $value );
}

if ( ! function_exists( 'ttfmake_sanitize_text' ) ) :
/**
 * Allow only certain tags and attributes in a string.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $string    The unsanitized string.
 * @return string               The sanitized string.
 */
function ttfmake_sanitize_text( $string ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->thememod()->sanitize_text', $backtrace[0] );
	return Make()->thememod()->sanitize_text( $string );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_sanitize_text', '1.7.0', 'Make()->thememod()->sanitize_text' );
endif;

if ( ! function_exists( 'ttfmake_get_view' ) ) :
/**
 * Determine the current view.
 *
 * For use with view-related theme options.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return string    The string representing the current view.
 */
function ttfmake_get_view() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'make_get_current_view', $backtrace[0] );
	return make_get_current_view();
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_get_view', '1.7.0', 'make_get_current_view' );
endif;

if ( ! function_exists( 'ttfmake_has_sidebar' ) ) :
/**
 * Determine if the current view should show a sidebar in the given location.
 *
 * @since  1.0.0.
 *
 * @param  string    $location    The location to test for.
 * @return bool                   Whether or not the location has a sidebar.
 */
function ttfmake_has_sidebar( $location ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'make_has_sidebar', $backtrace[0] );
	return make_has_sidebar( $location );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_has_sidebar', '1.7.0', 'make_has_sidebar' );
endif;

if ( ! function_exists( 'ttfmake_sidebar_description' ) ) :
/**
 * Output a sidebar description that reflects its current status.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $sidebar_id    The sidebar to look up the description for.
 * @return string                   The description.
 */
function ttfmake_sidebar_description( $sidebar_id ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return '';
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_sidebar_description', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_sidebar_list_enabled' ) ) :
/**
 * Compile a list of views where a particular sidebar is enabled.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $location    The sidebar to look up.
 * @return array                  The sidebar's current locations.
 */
function ttfmake_sidebar_list_enabled( $location ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return '';
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_sidebar_list_enabled', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_get_social_links' ) ) :
/**
 * Get the social links from options.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return array    Keys are service names and the values are links.
 */
function ttfmake_get_social_links() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_get_social_links', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_pre_wp_nav_menu_social' ) ) :
/**
 * Alternative output for wp_nav_menu for the 'social' menu location.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $output    Output for the menu.
 * @param  object    $args      wp_nav_menu arguments.
 * @return string               Modified menu.
 */
function ttfmake_pre_wp_nav_menu_social( $output, $args ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return $output;
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_pre_wp_nav_menu_social', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_maybe_show_social_links' ) ) :
/**
 * Show the social links markup if the theme options and/or menus are configured for it.
 *
 * @since 1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $region    The site region (header or footer).
 * @return void
 */
function ttfmake_maybe_show_social_links( $region ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'make_socialicons', $backtrace[0] );
	make_socialicons( $region );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_maybe_show_social_links', '1.7.0', 'make_socialicons' );
endif;

/**
 * Add the Yoast SEO breadcrumb, if the plugin is activated.
 *
 * @since 1.6.4.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_yoast_seo_breadcrumb() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'make_breadcrumb', $backtrace[0] );
	make_breadcrumb();
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return $source;
}

if ( ! function_exists( 'ttfmake_filter_backcompat' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_filter_backcompat', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_backcompat_filter' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_backcompat_filter', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_action_backcompat' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_action_backcompat', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_backcompat_action' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_backcompat_action', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_customizer_get_key_conversions' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return array();
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_get_key_conversions', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_customizer_set_up_theme_mod_conversions' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_set_up_theme_mod_conversions', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_customizer_convert_theme_mods_filter' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return $value;
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_convert_theme_mods_filter', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_customizer_convert_theme_mods_values' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return $value;
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_convert_theme_mods_values', '1.7.0' );
endif;

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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->notice()', $backtrace[0] );
	return Make()->notice();
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->notice()->register_admin_notice', $backtrace[0] );
	Make()->notice()->register_admin_notice( $id, $message, $args );
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->l10n()->load_textdomains', $backtrace[0] );
	return Make()->l10n()->load_textdomains();
}

if ( ! function_exists( 'ttfmake_option_defaults' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->thememod()->get_settings( \'default\' )', $backtrace[0] );
	return Make()->thememod()->get_settings( 'default' );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_option_defaults', '1.7.0', 'Make()->thememod()->get_settings( \'default\' )' );
endif;

if ( ! function_exists( 'ttfmake_get_default' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'make_get_thememod_default', $backtrace[0] );
	return make_get_thememod_default( $option );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_get_default', '1.7.0', 'make_get_thememod_default' );
endif;

if ( ! function_exists( 'ttfmake_get_choices' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->thememod()->get_choice_set', $backtrace[0] );
	return Make()->thememod()->get_choice_set( $setting );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_get_choices', '1.7.0', 'Make()->thememod()->get_choice_set' );
endif;

if ( ! function_exists( 'ttfmake_sanitize_choice' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->thememod()->sanitize_choice', $backtrace[0] );
	return Make()->thememod()->sanitize_choice( $value, $setting );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_sanitize_choice', '1.7.0', 'Make()->thememod()->sanitize_choice' );
endif;

if ( ! function_exists( 'ttfmake_edit_page_script' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_edit_page_script', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_jetpack_setup' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_jetpack_setup', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_jetpack_infinite_scroll_footer_callback' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_jetpack_infinite_scroll_footer_callback', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_jetpack_infinite_scroll_has_footer_widgets' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return true;
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_jetpack_infinite_scroll_has_footer_widgets', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_jetpack_infinite_scroll_render' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_jetpack_infinite_scroll_render', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_jetpack_remove_sharing' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_jetpack_remove_sharing', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_woocommerce_init' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_woocommerce_init', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_woocommerce_before_main_content' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_woocommerce_before_main_content', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_woocommerce_after_main_content' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_woocommerce_after_main_content', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_get_css' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->style()->css()', $backtrace[0] );
	return Make()->style()->css();
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_get_css', '1.7.0', 'Make()->style()->css()' );
endif;

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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

if ( ! function_exists( 'ttfmake_css_layout' ) ) :
/**
 * Build the CSS rules for the custom layout options.
 *
 * @since  1.5.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_css_layout() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_css_layout', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_css_fonts' ) ) :
/**
 * Build the CSS rules for the custom fonts
 *
 * @since  1.0.0
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_css_fonts() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_css_fonts', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_get_font_stack' ) ) :
/**
 * Validate the font choice and get a font stack for it.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $font    The 1st font in the stack.
 * @return string             The full font stack.
 */
function ttfmake_get_font_stack( $font ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->font()->get_font_stack', $backtrace[0] );
	return Make()->font()->get_font_stack( $font );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_get_font_stack', '1.7.0', 'Make()->font()->get_font_stack' );
endif;

if ( ! function_exists( 'ttfmake_font_get_relative_sizes' ) ) :
/**
 * Return an array of percentages to use when calculating certain font sizes.
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @return array    The percentage value relative to another specific size
 */
function ttfmake_font_get_relative_sizes() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return array();
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_font_get_relative_sizes', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_parse_font_properties' ) ) :
/**
 * Cycle through the font options for the given element and collect an array
 * of option values that are non-default.
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $element    The element to parse the options for.
 * @param  bool      $force      True to include properties that have default values.
 * @return array                 An array of non-default CSS declarations.
 */
function ttfmake_parse_font_properties( $element, $force = false ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return array();
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_parse_font_properties', '1.7.0' );
endif;

/**
 * Generate a CSS rule definition array for an element's link underline property.
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $element      The element to look up in the theme options.
 * @param  array     $selectors    The base selectors to use for the rule.
 * @return array                   A CSS rule definition array.
 */
function ttfmake_parse_link_underline( $element, $selectors ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return array();
}

if ( ! function_exists( 'ttfmake_get_relative_font_size' ) ) :
/**
 * Convert a font size to a relative size based on a starting value and percentage.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  mixed    $value         The value to base the final value on.
 * @param  mixed    $percentage    The percentage of change.
 * @return float                   The converted value.
 */
function ttfmake_get_relative_font_size( $value, $percentage ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return round( (float) $value * ( $percentage / 100 ) );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_get_relative_font_size', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_convert_px_to_rem' ) ) :
/**
 * Given a px value, return a rem value.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  mixed    $px      The value to convert.
 * @param  mixed    $base    The font-size base for the rem conversion (deprecated).
 * @return float             The converted value.
 */
function ttfmake_convert_px_to_rem( $px, $base = 0 ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return (float) $px / 10;
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_convert_px_to_rem', '1.7.0' );
endif;

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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return '';
}

if ( ! function_exists( 'ttfmake_customizer_init' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_init', '1.7.0' );
endif;

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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

if ( ! function_exists( 'ttfmake_customizer_get_panels' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->customizer_controls()->get_panel_definitions', $backtrace[0] );
	return Make()->customizer_controls()->get_panel_definitions();
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_get_panels', '1.7.0', 'Make()->customizer_controls()->get_panel_definitions' );
endif;

if ( ! function_exists( 'ttfmake_customizer_add_panels' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', '$wp_customize->add_panel', $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_add_panels', '1.7.0', '$wp_customize->add_panel' );
endif;

if ( ! function_exists( 'ttfmake_customizer_get_sections' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->customizer_controls()->get_section_definitions', $backtrace[0] );
	Make()->customizer_controls()->get_section_definitions();
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_get_sections', '1.7.0', 'Make()->customizer_controls()->get_section_definitions' );
endif;

if ( ! function_exists( 'ttfmake_customizer_add_sections' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', '$wp_customize->add_section', $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_add_sections', '1.7.0', '$wp_customize->add_section' );
endif;

if ( ! function_exists( 'ttfmake_customizer_add_section_options' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', '$wp_customize->add_setting / $wp_customize->add_control', $backtrace[0] );
	return $initial_priority;
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_add_section_options', '1.7.0', '$wp_customize->add_setting / $wp_customize->add_control' );
endif;

if ( ! function_exists( 'ttfmake_customizer_set_transport' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_set_transport', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_customizer_preview_script' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'wp_enqueue_script', $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_preview_script', '1.7.0', 'wp_enqueue_script' );
endif;

if ( ! function_exists( 'ttfmake_customizer_scripts' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'wp_enqueue_script', $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_scripts', '1.7.0', 'wp_enqueue_script' );
endif;

if ( ! function_exists( 'ttfmake_add_customizations' ) ) :
/**
 * Make sure the 'make_css' action only runs once.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttfmake_add_customizations() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_add_customizations', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_customizer_background' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_background', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_customizer_navigation' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_navigation', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_customizer_sitetitletagline' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_sitetitletagline', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_customizer_staticfrontpage' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_staticfrontpage', '1.7.0' );
endif;

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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return array();
}

if ( ! function_exists( 'ttfmake_customizer_define_colorscheme_sections' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return $sections;
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_define_colorscheme_sections', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_customizer_define_general_sections' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return $sections;
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_define_general_sections', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_customizer_define_contentlayout_sections' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return $sections;
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_define_contentlayout_sections', '1.7.0' );
endif;

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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return array();
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return array();
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return array();
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return array();
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return array();
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return array();
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return array();
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return array();
}

if ( ! function_exists( 'ttfmake_customizer_stylekit' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return $sections;
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_stylekit', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_customizer_define_typography_sections' ) ) :
/**
 * Define the sections and settings for the General panel
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @param  array    $sections    The master array of Customizer sections
 * @return array                 The augmented master array
 */
function ttfmake_customizer_define_typography_sections( $sections ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return $sections;
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_customizer_define_typography_sections', '1.7.0' );
endif;

/**
 * Generate an array of Customizer option definitions for a particular HTML element.
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $element
 * @param  string    $label
 * @param  string    $description
 * @return array
 */
function ttfmake_customizer_typography_group_definitions( $element, $label, $description = '' ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return array();
}

if ( ! function_exists( 'ttfmake_font_choices_placeholder' ) ) :
/**
 * Add a placeholder for the large font choices array, which will be loaded
 * in via JavaScript.
 *
 * @since 1.3.0.
 * @deprecated 1.7.0.
 *
 * @return array
 */
function ttfmake_font_choices_placeholder() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return array( 'placeholder' => __( 'Loading&hellip;', 'make' ) );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_font_choices_placeholder', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_sanitize_font_choice' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->font()->sanitize_font_choice', $backtrace[0] );
	return Make()->font()->sanitize_font_choice( $value );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_sanitize_font_choice', '1.7.0', 'Make()->font()->sanitize_font_choice' );
endif;

if ( ! function_exists( 'ttfmake_sanitize_font_subset' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->font()->get_source( \'google\' )->sanitize_subset', $backtrace[0] );
	return Make()->font()->get_source( 'google' )->sanitize_subset( $value, make_get_thememod_default( 'font-subset' ) );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_sanitize_font_subset', '1.7.0', 'Make()->font()->get_source( \'google\' )->sanitize_subset' );
endif;

if ( ! function_exists( 'ttfmake_get_all_fonts' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->font()->get_font_choices', $backtrace[0] );
	return Make()->font()->get_font_choices();
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_get_all_fonts', '1.7.0', 'Make()->font()->get_font_choices' );
endif;

if ( ! function_exists( 'ttfmake_all_font_choices' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->font()->get_font_choices', $backtrace[0] );
	return Make()->font()->get_font_choices();
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_all_font_choices', '1.7.0', 'Make()->font()->get_font_choices' );
endif;

if ( ! function_exists( 'ttfmake_all_font_choices_js' ) ) :
/**
 * Compile the font choices for better handling as a JSON object
 *
 * @since 1.3.0.
 * @deprecated 1.7.0.
 *
 * @return array
 */
function ttfmake_all_font_choices_js() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
	return array();
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_all_font_choices_js', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_get_font_property_option_keys' ) ) :
/**
 * Return all the option keys for the specified font property.
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $property    The font property to search for.
 * @return array                  Array of matching font option keys.
 */
function ttfmake_get_font_property_option_keys( $property ) {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );

	$all_keys = array_keys( ttfmake_option_defaults() );

	$font_keys = array();
	foreach ( $all_keys as $key ) {
		if ( preg_match( '/^' . $property . '-/', $key ) || preg_match( '/^font-' . $property . '-/', $key ) ) {
			$font_keys[] = $key;
		}
	}

	return $font_keys;
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_get_font_property_option_keys', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmake_get_standard_fonts' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->font()->get_source( \'generic\' )->get_font_data', $backtrace[0] );
	return Make()->font()->get_source( 'generic' )->get_font_data();
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_get_standard_fonts', '1.7.0', 'Make()->font()->get_source( \'generic\' )->get_font_data' );
endif;

if ( ! function_exists( 'ttfmake_get_google_fonts' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->font()->get_source( \'google\' )->get_font_data', $backtrace[0] );
	return Make()->font()->get_source( 'google' )->get_font_data();
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_get_google_fonts', '1.7.0', 'Make()->font()->get_source( \'google\' )->get_font_data' );
endif;

if ( ! function_exists( 'ttfmake_choose_google_font_variants' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->font()->get_source( \'google\' )->choose_font_variants', $backtrace[0] );
	return Make()->font()->get_source( 'google' )->choose_font_variants( $font, $variants );
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_choose_google_font_variants', '1.7.0', 'Make()->font()->get_source( \'google\' )->choose_font_variants' );
endif;

if ( ! function_exists( 'ttfmake_get_google_font_subsets' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->font()->get_source( \'google\' )->get_subsets', $backtrace[0] );
	return Make()->font()->get_source( 'google' )->get_subsets();
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_get_google_font_subsets', '1.7.0', 'Make()->font()->get_source( \'google\' )->get_subsets' );
endif;

if ( ! function_exists( 'ttfmake_get_google_font_uri' ) ) :
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
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->scripts()->get_google_url', $backtrace[0] );
	return Make()->scripts()->get_google_url();
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_get_google_font_uri', '1.7.0', 'Make()->scripts()->get_google_url' );
endif;

/**
 * Instantiate or return the one TTFMAKE_Formatting instance.
 *
 * @since  1.4.1.
 * @deprecated 1.7.0.
 *
 * @return TTFMAKE_Formatting
 */
function ttfmake_formatting() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->formatting()', $backtrace[0] );
	return Make()->formatting();
}

/**
 * Run the init function for the Format Builder
 *
 * @since 1.4.1.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmake_formatting_init() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', null, $backtrace[0] );
}

if ( ! function_exists( 'ttfmake_get_gallery_slider' ) ) :
/**
 * Return the one TTFMAKE_Gallery_Slider object.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMAKE_Gallery_Slider
 */
function ttfmake_get_gallery_slider() {
	$backtrace = debug_backtrace();
	Make()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'Make()->galleryslider()', $backtrace[0] );
	return Make()->galleryslider();
}
else :
	Make()->compatibility()->deprecated_function( 'ttfmake_get_gallery_slider', '1.7.0', 'Make()->galleryslider()' );
endif;

if ( class_exists( 'WP_Customize_Control' ) ) :
/**
 * Class TTFMAKE_Customize_Background_Position_Control
 *
 * Specialized radio control for choosing background image positioning.
 *
 * This control has been deprecated in favor of MAKE_Customizer_Control_BackgroundPosition.
 *
 * @since 1.5.0.
 */
class TTFMAKE_Customize_Background_Position_Control extends MAKE_Customizer_Control_BackgroundPosition {
	public function __construct( WP_Customize_Manager $manager, $id, array $args ) {
		parent::__construct( $manager, $id, $args );
		$this->type = 'make_backgroundposition';

		Make()->error()->add_error( 'make_customizer_control_deprecated', __( 'The TTFMAKE_Customize_Background_Position_Control control is deprecated. Use MAKE_Customizer_Control_BackgroundPosition instead.', 'make' ) );
	}
}

/**
 * Class TTFMAKE_Customize_Image_Control
 *
 * Extend WP_Customize_Image_Control allowing access to uploads made within the same context.
 *
 * @since 1.0.0.
 * @deprecated 1.7.0.
 */
class TTFMAKE_Customize_Image_Control extends WP_Customize_Image_Control {}

/**
 * Class TTFMAKE_Customize_Misc_Control
 *
 * Control for adding arbitrary HTML to a Customizer section.
 *
 * This control has been deprecated in favor of MAKE_Customizer_Control_Html.
 *
 * @since 1.0.0.
 * @deprecated 1.7.0.
 */
class TTFMAKE_Customize_Misc_Control extends MAKE_Customizer_Control_Html {
	/**
	 * Convert the ID and args for use with MAKE_Customizer_Control_Html.
	 *
	 * @since x.x.x.
	 *
	 * @param WP_Customize_Manager $manager
	 * @param string               $id
	 * @param array                $args
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {
		parent::__construct( $manager, $id, $args );

		$type = $this->type;
		$this->type = 'make_html';

		switch ( $type ) {
			case 'group-title' :
				$this->html = '<h4 class="make-group-title">' . esc_html( $this->label ) . '</h4>';
				if ( '' !== $this->description ) {
					$this->html .= '<span class="description customize-control-description">' . $this->description . '</span>';
				}
				$this->label = '';
				$this->description = '';
				break;
			case 'line' :
				$this->html = '<hr class="make-ruled-line" />';
				break;
		}

		Make()->error()->add_error( 'make_customizer_control_deprecated', __( 'The TTFMAKE_Customize_Misc_Control control is deprecated. Use MAKE_Customizer_Control_Html instead.', 'make' ) );
	}
}

/**
 * Class TTFMAKE_Customize_Radio_Control
 *
 * Specialized radio control to enable buttonset-style choices.
 *
 * Inspired by Kirki.
 * @link https://github.com/aristath/kirki/blob/0.5/includes/controls/class-Kirki_Customize_Radio_Control.php
 *
 * This control has been deprecated in favor of MAKE_Customizer_Control_Radio.
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 */
class TTFMAKE_Customize_Radio_Control extends MAKE_Customizer_Control_Radio {
	public function __construct( WP_Customize_Manager $manager, $id, array $args ) {
		parent::__construct( $manager, $id, $args );
		$this->type = 'make_radio';

		Make()->error()->add_error( 'make_customizer_control_deprecated', __( 'The TTFMAKE_Customize_Radio_Control control is deprecated. Use MAKE_Customizer_Control_Radio instead.', 'make' ) );
	}
}

/**
 * Class TTFMAKE_Customize_Range_Control
 *
 * Specialized range control to enable a slider with an accompanying number field.
 *
 * Inspired by Kirki.
 * @link https://github.com/aristath/kirki/blob/0.5/includes/controls/class-Kirki_Customize_Sliderui_Control.php
 *
 * This control has been deprecated in favor of MAKE_Customizer_Control_Range.
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 */
class TTFMAKE_Customize_Range_Control extends MAKE_Customizer_Control_Range {
	public function __construct( WP_Customize_Manager $manager, $id, array $args ) {
		parent::__construct( $manager, $id, $args );
		$this->type = 'make_range';

		Make()->error()->add_error( 'make_customizer_control_deprecated', __( 'The TTFMAKE_Customize_Range_Control control is deprecated. Use MAKE_Customizer_Control_Range instead.', 'make' ) );
	}
}
endif;