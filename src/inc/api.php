<?php
/**
 * @package Make
 */


class MAKE_API extends MAKE_Util_Modules {

	public function __construct(
		MAKE_Error_ErrorInterface $error = null,
		MAKE_Compatibility_CompatibilityInterface $compatibility = null,
		MAKE_Admin_NoticeInterface $notice = null,
		MAKE_L10n_L10nInterface $l10n = null,
		MAKE_Choices_ChoicesInterface $choices = null,
		MAKE_Font_FontInterface $font = null,
		MAKE_Settings_ThemeModInterface $thememod = null,
		MAKE_Style_StyleInterface $style = null,
		MAKE_Customizer_CustomizerInterface $customizer_base = null,
		MAKE_Customizer_SectionsInterface $customizer_sections = null,
		MAKE_Integration_IntegrationInterface $integration = null
	) {
		// Errors
		$this->add_module( 'error', ( is_null( $error ) ) ? new MAKE_Error_Base : $error );

		// Compatibility
		$this->add_module( 'compatibility', ( is_null( $compatibility ) ) ? new MAKE_Compatibility_Base( $this->inject_module( 'error' ) ) : $compatibility );

		// Admin notices
		if ( is_admin() ) {
			$this->add_module( 'notice', ( is_null( $notice ) ) ? new MAKE_Admin_Notice : $notice );
		}

		// Localization
		$this->add_module( 'l10n', ( is_null( $l10n ) ) ? new MAKE_L10n_Base : $l10n );

		// Choices
		$this->add_module( 'choices', ( is_null( $choices ) ) ? new MAKE_Choices_Base( $this->inject_module( 'error' ) ) : $choices );

		// Font
		$this->add_module( 'font', ( is_null( $font ) ) ? new MAKE_Font_Base( $this->inject_module( 'error' ), $this->inject_module( 'compatibility' ) ) : $font );

		// Theme mods
		$this->add_module( 'thememod', ( is_null( $thememod ) ) ? new MAKE_Settings_ThemeMod( $this->inject_module( 'error' ), $this->inject_module( 'compatibility' ), $this->inject_module( 'choices' ) ) : $thememod );

		// Style
		$this->add_module( 'style', ( is_null( $style ) ) ? new MAKE_Style_Base( $this->inject_module( 'compatibility' ), $this->inject_module( 'thememod' ) ) : $style );

		// Customizer
		if ( is_admin() ) {
			// Base
			$this->add_module( 'customizer-base', ( is_null( $customizer_base ) ) ? new MAKE_Customizer_Base : $customizer_base );
			// Sections
			$this->add_module( 'customizer-sections', ( is_null( $customizer_sections ) ) ? new MAKE_Customizer_Sections( $this->inject_module( 'error' ), $this->inject_module( 'compatibility' ), $this->inject_module( 'thememod' ) ) : $customizer_sections );
		}

		// Integrations
		$this->add_module( 'integration', ( is_null( $integration ) ) ? new MAKE_Integration_Base : $integration );
	}
}


function Make() {
	global $Make;

	if ( ! $Make instanceof MAKE_API ) {
		$Make = new MAKE_API;
	}

	return $Make;
}


function make_is_plus() {
	return Make()->get_module( 'compatibility' )->is_plus();
}


function make_thememod_update_settings( $settings, MAKE_Settings_SettingsInterface $instance ) {
	// Make sure we're not doing it wrong.
	if ( 'make_settings_thememod_loaded' !== current_action() ) {
		$backtrace = debug_backtrace();

		Make()->get_module( 'compatibility' )->doing_it_wrong(
			__FUNCTION__,
			__( 'This function should only be called during the make_settings_thememod_loaded action.', 'make' ),
			null,
			$backtrace[0]
		);

		return false;
	}

	return $instance->add_settings( $settings, array(), true );
}


function make_choices_update_choices( $choice_sets, MAKE_Choices_ChoicesInterface $instance ) {
	// Make sure we're not doing it wrong.
	if ( 'make_choices_loaded' !== current_action() ) {
		$backtrace = debug_backtrace();

		Make()->get_module( 'compatibility' )->doing_it_wrong(
			__FUNCTION__,
			__( 'This function should only be called during the make_choices_loaded action.', 'make' ),
			null,
			$backtrace[0]
		);

		return false;
	}

	return $instance->add_choice_sets( $choice_sets, true );
}


function make_thememod_get_value( $setting_id ) {
	return Make()->get_module( 'thememod' )->get_value( $setting_id );
}


function make_thememod_get_default( $setting_id ) {
	return Make()->get_module( 'thememod' )->get_default( $setting_id );
}


function make_font_sanitize_choice( $value ) {
	return Make()->get_module( 'font' )->sanitize_font_choice( $value );
}