<?php
/**
 * @package Make
 */

/**
 * Class TTFMAKE_ThemeMod_Settings
 *
 * A child class of TTFMAKE_Utils_Settings for defining and managing Customizer settings and their values
 *
 * @since x.x.x.
 */
class TTFMAKE_ThemeMod_Settings extends TTFMAKE_Utils_Settings {
	/**
	 * The type of settings.
	 *
	 * @since x.x.x.
	 *
	 * @var string
	 */
	protected $type = 'theme_mod';


	public function load() {
		// Load the setting definitions
		$file = basename( __FILE__ ) . '/definitions.php';
		if ( is_readable( $file ) ) {
			require_once $file;
		}

		//
		if ( ! has_filter( 'make_settings_theme_mod_sanitize_callback_parameters', array( $this, 'sanitize_choice_parameters' ) ) ) {
			add_filter( 'make_settings_theme_mod_sanitize_callback_parameters', array( $this, 'sanitize_choice_parameters' ), 10, 3 );
		}

		/**
		 * Action: Fires at the end of the ThemeMod settings object's load method.
		 *
		 * This action gives a developer the opportunity to add or modify choice sets
		 * and run additional load routines.
		 *
		 * @since x.x.x.
		 *
		 * @param TTFMAKE_ThemeMod_Settings    $settings     The settings object that has just finished loading.
		 */
		do_action( 'make_settings_theme_mod_loaded', $this );
	}

	/**
	 * Set a new value for a particular theme_mod setting.
	 *
	 * @since x.x.x.
	 *
	 * @param  string    $setting_id    The name of the theme_mod to set.
	 * @param  mixed     $value         The value to assign to the theme_mod.
	 *
	 * @return bool                     True if value was successfully set.
	 */
	public function set_value( $setting_id, $value ) {
		if ( isset( $this->settings[ $setting_id ] ) ) {
			// Sanitize the value before saving it.
			$sanitized_value = $this->sanitize_value( $value, $setting_id, 'database' );
			if ( ! is_wp_error( $sanitized_value ) && $this->undefined !== $sanitized_value ) {
				// This function doesn't return anything, so we assume success here.
				set_theme_mod( $setting_id, $sanitized_value );
				return true;
			}
		}

		return false;
	}

	/**
	 * Remove a particular theme_mod setting.
	 *
	 * @since x.x.x.
	 *
	 * @param  string    $setting_id    The name of the theme_mod to remove.
	 *
	 * @return bool                     True if the theme_mod was successfully removed.
	 */
	public function unset_value( $setting_id ) {
		if ( isset( $this->settings[ $setting_id ] ) ) {
			// This function doesn't return anything, so we assume success here.
			remove_theme_mod( $setting_id );
			return true;
		}

		return false;
	}

	/**
	 * Get the stored value of a theme_mod, unaltered.
	 *
	 * @since x.x.x.
	 *
	 * @param  string    $setting_id    The name of the theme_mod to retrieve.
	 *
	 * @return mixed|null               The value of the theme_mod as it is in the database, or undefined if the theme_mod isn't set.
	 */
	public function get_raw_value( $setting_id ) {
		$value = $this->undefined;

		if ( isset( $this->settings[ $setting_id ] ) ) {
			$value = get_theme_mod( $setting_id, $this->undefined );
		}

		return $value;
	}

	/**
	 * Filter: Add items to the array of parameters to feed into the sanitize_choice callback.
	 *
	 * @since x.x.x.
	 *
	 * @param $value
	 * @param $callback
	 * @param $setting_id
	 *
	 * @return array
	 */
	public function sanitize_choice_parameters( $value, $callback, $setting_id ) {
		if ( 'ttfmake_sanitize_choice' === $callback ) {
			$value = (array) $value;
			$value[] = $setting_id;
			$value[] = $this->undefined;
		}

		return $value;
	}
}