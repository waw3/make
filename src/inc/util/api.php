<?php
/**
 * @package Make
 */


class TTFMAKE_Util_API {

	public function __construct(
		TTFMAKE_Util_Choices_ChoicesInterface $choices = null,
		TTFMAKE_Util_Settings_SettingsInterface $thememod = null
	) {
		// Choices
		$this->choices_instance = ( is_null( $choices ) ) ? new TTFMAKE_Util_Choices_Base : $choices;

		// Theme mods
		$this->thememod_instance = ( is_null( $thememod ) ) ? new TTFMAKE_Util_Settings_ThemeMod : $thememod;
	}


	public function get_module( $module_name ) {
		$property_name = $module_name . '_instance';

		if ( isset( $this->$property_name ) ) {
			$this->maybe_run_load( $this->$property_name );
			return $this->$property_name;
		} else {
			return new WP_Error( 'make_util_module_not_valid', sprintf( __( 'The %s module doesn\'t exist.', 'make' ), $module_name ) );
		}
	}


	protected function maybe_run_load( TTFMAKE_Util_LoadInterface $module ) {
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

	if ( ! $make_utils instanceof TTFMAKE_Util_API ) {
		$make_utils = new TTFMAKE_Util_API;
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