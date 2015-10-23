<?php
/**
 * @package Make
 */


class MAKE_Util_API {
	/**
	 * Container for module objects.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	protected $modules = array();


	public function __construct(
		MAKE_Util_Error_ErrorInterface $error = null,
		MAKE_Util_Compatibility_CompatibilityInterface $compatibility = null,
		MAKE_Util_Admin_NoticeInterface $notice = null,
		MAKE_Util_L10n_L10nInterface $l10n = null,
		MAKE_Util_Choices_ChoicesInterface $choices = null,
		MAKE_Util_Font_FontInterface $font = null,
		MAKE_Util_Settings_ThemeModInterface $thememod = null
	) {
		// Errors
		$this->add_module( 'error', ( is_null( $error ) ) ? new MAKE_Util_Error_Base : $error );

		// Compatibility
		$this->add_module( 'compatibility', ( is_null( $compatibility ) ) ? new MAKE_Util_Compatibility_Base( $this->get_module( 'error' ) ) : $compatibility );

		// Admin notices
		if ( is_admin() ) {
			$this->add_module( 'notice', ( is_null( $notice ) ) ? new MAKE_Util_Admin_Notice : $notice );
		}

		// Localization
		$this->add_module( 'l10n', ( is_null( $l10n ) ) ? new MAKE_Util_L10n_Base : $l10n );

		// Choices
		$this->add_module( 'choices', ( is_null( $choices ) ) ? new MAKE_Util_Choices_Base( $this->get_module( 'error' ) ) : $choices );

		// Font
		//$this->add_module( 'font', ( is_null( $font ) ) ? new MAKE_Util_Font_Base : $font );

		// Theme mods
		$this->add_module( 'thememod', ( is_null( $thememod ) ) ? new MAKE_Util_Settings_ThemeMod( $this->get_module( 'error' ), $this->get_module( 'compatibility' ), $this->modules['choices'] ) : $thememod );
	}

	/**
	 * Add a Util module, if it doesn't exist yet.
	 *
	 * @since x.x.x.
	 *
	 * @param  string    $module_name
	 * @param  object    $module
	 *
	 * @return bool
	 */
	protected function add_module( $module_name, $module ) {
		// Module doesn't exist yet.
		if ( ! isset( $this->modules[ $module_name ] ) ) {
			$this->modules[ $module_name ] = $module;
			if ( $this->modules[ $module_name ] instanceof MAKE_Util_HookInterface ) {
				if ( ! $this->modules[ $module_name ]->is_hooked() ) {
					$this->modules[ $module_name ]->hook();
				}
			}
			return true;
		}

		// Module already exists. Generate an error if possible.
		else if ( isset( $this->modules['error'] ) && $this->modules['error'] instanceof MAKE_Util_Error_ErrorInterface ) {
			$this->modules['error']->add_error( 'make_util_module_already_exists', sprintf( __( 'The "%s" module already exists.', 'make' ), $module_name ) );
		}

		return false;
	}

	/**
	 * Return the specified Util module, if it exists.
	 *
	 * @since x.x.x.
	 *
	 * @param  string    $module_name
	 *
	 * @return mixed
	 */
	public function get_module( $module_name ) {
		// Module exists.
		if ( isset( $this->modules[ $module_name ] ) ) {
			if ( $this->modules[ $module_name ] instanceof MAKE_Util_LoadInterface ) {
				if ( ! $this->modules[ $module_name ]->is_loaded() ) {
					$this->modules[ $module_name ]->load();
				}
			}
			return $this->modules[ $module_name ];
		}

		// Module doesn't exist. Generate an error if possible.
		else if ( isset( $this->modules['error'] ) && $this->modules['error'] instanceof MAKE_Util_Error_ErrorInterface ) {
			$this->modules['error']->add_error( 'make_util_module_not_valid', sprintf( __( 'The "%s" module doesn\'t exist.', 'make' ), $module_name ) );
		}

		return null;
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
		$backtrace = debug_backtrace();

		make_get_utils()->get_module( 'compatibility' )->doing_it_wrong(
			__FUNCTION__,
			__( 'This function should only be called during the make_settings_thememod_loaded action.', 'make' ),
			null,
			$backtrace[0]
		);

		return false;
	}

	return $instance->add_settings( $settings, array(), true );
}


function make_choices_update_choices( $choice_sets, MAKE_Util_Choices_ChoicesInterface $instance ) {
	// Make sure we're not doing it wrong.
	if ( 'make_choices_loaded' !== current_action() ) {
		$backtrace = debug_backtrace();

		make_get_utils()->get_module( 'compatibility' )->doing_it_wrong(
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
	return make_get_utils()->get_module( 'thememod' )->get_value( $setting_id );
}


function make_thememod_get_default( $setting_id ) {
	return make_get_utils()->get_module( 'thememod' )->get_default( $setting_id );
}


function make_font_sanitize_choice( $value ) {
	return make_get_utils()->get_module( 'font' )->sanitize_font_choice( $value );
}