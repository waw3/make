<?php
/**
 * @package Make
 */


class MAKE_Util_API {

	public function __construct(
		MAKE_Util_Compatibility_CompatibilityInterface $compatibility = null,
		MAKE_Util_Admin_NoticeInterface $notice = null,
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

		// Theme mods
		//$this->thememod_instance = ( is_null( $thememod ) ) ? new MAKE_Util_Settings_ThemeMod : $thememod;

		// Choices
		//$this->choices_instance = ( is_null( $choices ) ) ? new MAKE_Util_Choices_Base : $choices;

		// Font
		//$this->font_instance = ( is_null( $font ) ) ? new MAKE_Util_Font_Base : $font;
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


function make_get_thememod_value( $setting_id ) {
	return make_get_utils()->get_module( 'thememod' )->get_value( $setting_id );
}


function make_get_thememod_default( $setting_id ) {
	return make_get_utils()->get_module( 'thememod' )->get_default( $setting_id );
}


function make_get_thememod_choices( $setting_id ) {
	$choice_set = make_get_utils()->get_module( 'thememod' )->get_choice_set( $setting_id );
	return make_get_utils()->get_module( 'choices' )->get_choice_set( $choice_set );
}


function make_sanitize_thememod_choice( $value, $setting_id ) {
	$choice_set_id = make_get_utils()->get_module( 'thememod' )->get_choice_set( $setting_id );
	$default    = make_get_utils()->get_module( 'thememod' )->get_default( $setting_id );

	return make_get_utils()->get_module( 'choices' )->sanitize_choice( $value, $choice_set_id, $default );
}


function make_sanitize_font_choice( $value ) {
	return make_get_utils()->get_module( 'font' )->sanitize_font_choice( $value );
}


function make_is_plus() {
	return make_get_utils()->get_module( 'compatibility' )->is_plus();
}