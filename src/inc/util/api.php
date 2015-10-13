<?php
/**
 * @package Make
 */


class MAKE_Util_API {

	public function __construct(
		MAKE_Util_Compatibility_CompatibilityInterface $compatibility = null,
		MAKE_Util_Admin_NoticeInterface $notice = null,
		MAKE_Util_L10n_L10nInterface $l10n = null,
		MAKE_Util_Settings_SettingsInterface $thememod = null,
		MAKE_Util_Choices_ChoicesInterface $choices = null,
		MAKE_Util_Font_FontInterface $font = null
	) {
		// Compatibility (load right away)
		$this->compatibility_instance = ( is_null( $compatibility ) ) ? new MAKE_Util_Compatibility_Base : $compatibility;
		$this->compatibility_instance->load();

		// Admin notices (load right away)
		if ( is_admin() ) {
			$this->notice_instance = ( is_null( $notice ) ) ? new MAKE_Util_Admin_Notice : $notice;
			$this->notice_instance->load();
		}

		// Localization
		$this->l10n_instance = ( is_null( $l10n ) ) ? new MAKE_Util_L10n_Base : $l10n;

		// Choices
		$this->choices_instance = ( is_null( $choices ) ) ? new MAKE_Util_Choices_Base : $choices;

		// Font
		//$this->font_instance = ( is_null( $font ) ) ? new MAKE_Util_Font_Base : $font;

		// Theme mods
		$this->thememod_instance = ( is_null( $thememod ) ) ? new MAKE_Util_Settings_ThemeMod( $this->choices_instance, $this->compatibility_instance ) : $thememod;
	}

	/**
	 * Return the specified Util module, if it exists.
	 *
	 * @since x.x.x.
	 *
	 * @param  string    $module_name
	 *
	 * @return object
	 */
	public function get_module( $module_name ) {
		$property_name = $module_name . '_instance';

		if ( isset( $this->$property_name ) ) {
			$this->maybe_run_load( $this->$property_name );
			return $this->$property_name;
		} else {
			return new WP_Error( 'make_util_module_not_valid', sprintf( __( 'The "%s" module doesn\'t exist.', 'make' ), $module_name ) );
		}
	}

	/**
	 * Check if a module's load function has run yet, and if not, run it.
	 *
	 * @since x.x.x.
	 *
	 * @param MAKE_Util_LoadInterface $module
	 *
	 * @return void
	 */
	protected function maybe_run_load( MAKE_Util_LoadInterface $module ) {
		if ( false === $module->is_loaded() ) {
			$module->load();
		}
	}
}


/**
 * Global functions
 */


function make_get_utils() {
	global $make_utils;

	if ( ! $make_utils instanceof MAKE_Util_API ) {
		$make_utils = new MAKE_Util_API;
	}

	return $make_utils;
}


function make_is_plus() {
	return make_get_utils()->get_module( 'compatibility' )->is_plus();
}


function make_thememod_update_settings( $settings, MAKE_Util_Settings_SettingsInterface $instance ) {
	// Make sure we're not doing it wrong.
	if ( 'make_settings_thememod_loaded' !== current_action() ) {
		make_get_utils()->get_module( 'compatibility' )->doing_it_wrong(
			__FUNCTION__,
			__( 'This function should only be called during the make_settings_thememod_loaded action.', 'make' )
		);

		return false;
	}

	return $instance->add_settings( $settings, array(), true );
}


function make_choices_update_choices( $choice_sets, MAKE_Util_Choices_ChoicesInterface $instance ) {
	// Make sure we're not doing it wrong.
	if ( 'make_choices_loaded' !== current_action() ) {
		make_get_utils()->get_module( 'compatibility' )->doing_it_wrong(
			__FUNCTION__,
			__( 'This function should only be called during the make_choices_loaded action.', 'make' )
		);

		return false;
	}

	return $instance->add_choice_sets( $choice_sets, true );
}


function make_thememod_get_value( $setting_id ) {
	return make_get_utils()->get_module( 'thememod' )->get_value( $setting_id );
}


function make_thememod_get_default( $setting_id ) {
	return make_get_utils()->get_module( 'thememod' )->get_default( $setting_id );
}


function make_font_sanitize_choice( $value ) {
	return make_get_utils()->get_module( 'font' )->sanitize_font_choice( $value );
}