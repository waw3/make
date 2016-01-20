<?php
/**
 * @package Make
 */

/**
 * Class MAKE_API
 *
 * @since x.x.x.
 */
class MAKE_API extends MAKE_Util_Modules {
	/**
	 * Inject dependencies.
	 *
	 * @since x.x.x.
	 */
	public function __construct(
		MAKE_Setup_L10nInterface $l10n = null,
		MAKE_Error_CollectorInterface $error = null,
		MAKE_Compatibility_MethodsInterface $compatibility = null,
		MAKE_Plus_MethodsInterface $plus = null,
		MAKE_Admin_NoticeInterface $notice = null,
		MAKE_Choices_ManagerInterface $choices = null,
		MAKE_Font_ManagerInterface $font = null,
		MAKE_Settings_ThemeModInterface $thememod = null,
		MAKE_View_ManagerInterface $view = null,
		MAKE_Setup_WidgetsInterface $widgets = null,
		MAKE_Setup_ScriptsInterface $scripts = null,
		MAKE_Style_ManagerInterface $style = null,
		MAKE_Customizer_ControlsInterface $customizer_controls = null,
		MAKE_Customizer_PreviewInterface $customizer_preview = null,
		MAKE_Integration_ManagerInterface $integration = null
	) {
		// Localization
		$this->add_module( 'l10n', ( is_null( $l10n ) ) ? new MAKE_Setup_L10n : $l10n );

		// Errors
		$this->add_module( 'error', ( is_null( $error ) ) ? new MAKE_Error_Collector : $error );

		// Compatibility
		$this->add_module( 'compatibility', ( is_null( $compatibility ) ) ? new MAKE_Compatibility_Methods( $this->inject_module( 'error' ) ) : $compatibility );

		// Plus
		$this->add_module( 'plus', ( is_null( $plus ) ) ? new MAKE_Plus_Methods() : $plus );

		// Admin notices
		if ( is_admin() ) {
			$this->add_module( 'notice', ( is_null( $notice ) ) ? new MAKE_Admin_Notice : $notice );
		}

		// Choices
		$this->add_module( 'choices', ( is_null( $choices ) ) ? new MAKE_Choices_Manager( $this->inject_module( 'error' ), $this->inject_module( 'compatibility' ) ) : $choices );

		// Font
		$this->add_module( 'font', ( is_null( $font ) ) ? new MAKE_Font_Manager( $this->inject_module( 'error' ), $this->inject_module( 'compatibility' ) ) : $font );

		// Theme mods
		$this->add_module( 'thememod', ( is_null( $thememod ) ) ? new MAKE_Settings_ThemeMod( $this->inject_module( 'error' ), $this->inject_module( 'compatibility' ), $this->inject_module( 'choices' ), $this->inject_module( 'font' ) ) : $thememod );

		// View
		$this->add_module( 'view', ( is_null( $view ) ) ? new MAKE_View_Manager( $this->inject_module( 'error' ), $this->inject_module( 'compatibility' ) ) : $view );

		// Widgets
		$this->add_module( 'widgets', ( is_null( $widgets ) ) ? new MAKE_Setup_Widgets( $this->inject_module( 'error' ), $this->inject_module( 'compatibility' ), $this->inject_module( 'thememod' ), $this->inject_module( 'view' ) ) : $widgets );

		// Scripts
		$this->add_module( 'scripts', ( is_null( $scripts ) ) ? new MAKE_Setup_Scripts( $this->inject_module( 'compatibility' ), $this->inject_module( 'font' ), $this->inject_module( 'thememod' ) ) : $scripts );

		// Style
		$this->add_module( 'style', ( is_null( $style ) ) ? new MAKE_Style_Manager( $this->inject_module( 'compatibility' ), $this->inject_module( 'font' ), $this->inject_module( 'thememod' ) ) : $style );

		// Customizer
		if ( is_admin() || is_customize_preview() ) {
			// Sections
			$this->add_module( 'customizer_controls', ( is_null( $customizer_controls ) ) ? new MAKE_Customizer_Controls( $this->inject_module( 'error' ), $this->inject_module( 'compatibility' ), $this->inject_module( 'font' ), $this->inject_module( 'thememod' ), $this->inject_module( 'scripts' ) ) : $customizer_controls );
			// Preview
			$this->add_module( 'customizer_preview', ( is_null( $customizer_preview ) ) ? new MAKE_Customizer_Preview( $this->inject_module( 'thememod' ), $this->inject_module( 'scripts' ) ) : $customizer_preview );
		}

		// Integrations
		$this->add_module( 'integration', ( is_null( $integration ) ) ? new MAKE_Integration_Manager( $this ) : $integration );
	}
}

/**
 * Get the global Make object.
 *
 * @since x.x.x.
 *
 * @return MAKE_API
 */
function Make() {
	global $Make;

	if ( ! $Make instanceof MAKE_API ) {
		$Make = new MAKE_API;
	}

	return $Make;
}

/**
 * Check if Make Plus is active.
 *
 * @since x.x.x.
 *
 * @return bool
 */
function make_is_plus() {
	return Make()->plus()->is_plus();
}

/**
 * Add or modify a choice set.
 *
 * @since x.x.x.
 *
 * @param array                              $choice_sets
 * @param MAKE_Choices_ManagerInterface|null $instance
 *
 * @return mixed
 */
function make_update_choices( $choice_sets, MAKE_Choices_ManagerInterface $instance = null ) {
	if ( is_null( $instance ) ) {
		$instance = Make()->choices();
	}

	return $instance->add_choice_sets( $choice_sets, true );
}

/**
 * Add or modify a Theme Mod setting.
 *
 * @since x.x.x.
 *
 * @param array                                $settings
 * @param MAKE_Settings_ThemeModInterface|null $instance
 *
 * @return mixed
 */
function make_update_thememod_settings( $settings, MAKE_Settings_ThemeModInterface $instance = null ) {
	if ( is_null( $instance ) ) {
		$instance = Make()->thememod();
	}

	return $instance->add_settings( $settings, array(), true );
}

/**
 * Get a sanitized value for a Theme Mod setting.
 *
 * @since x.x.x.
 *
 * @param        $setting_id
 * @param string $context
 *
 * @return mixed
 */
function make_get_thememod_value( $setting_id, $context = '' ) {
	return Make()->thememod()->get_value( $setting_id, $context );
}

/**
 * Get the default value for a Theme Mod setting.
 *
 * @since x.x.x.
 *
 * @param $setting_id
 *
 * @return mixed
 */
function make_get_thememod_default( $setting_id ) {
	return Make()->thememod()->get_default( $setting_id );
}

/**
 *
 */
function make_add_view( $view_id, array $args = array(), $overwrite = false ) {
	return Make()->view()->add_view( $view_id, $args, $overwrite );
}

/**
 * Get the current view.
 *
 * @since x.x.x.
 *
 * @return mixed
 */
function make_get_current_view() {
	return Make()->view()->get_current_view();
}

/**
 * Check if a particular view is the current one.
 *
 * @since x.x.x.
 *
 * @param $view_id
 *
 * @return mixed
 */
function make_is_current_view( $view_id ) {
	return Make()->view()->is_current_view( $view_id );
}

/**
 * Check if the current view has a sidebar in the specified location (left or right).
 *
 * @since x.x.x.
 *
 * @param $location
 *
 * @return mixed
 */
function make_has_sidebar( $location ) {
	return Make()->widgets()->has_sidebar( $location );
}

/**
 * Display a breadcrumb.
 *
 * @since x.x.x.
 *
 * @param string $before
 * @param string $after
 *
 * @return void
 */
function make_breadcrumb( $before = '<p class="yoast-seo-breadcrumb">', $after = '</p>' ) {
	//
	if ( Make()->integration()->has_integration( 'yoastseo' ) ) {
		echo Make()->integration()->get_integration( 'yoastseo' )->maybe_render_breadcrumb( $before, $after );
	}
}