<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Util_Settings_ThemeMod
 *
 * A child class of MAKE_Util_Settings_Base for defining and managing theme mod settings and their values.
 *
 * @since x.x.x.
 */
final class MAKE_Util_Settings_ThemeMod extends MAKE_Util_Settings_Base {
	/**
	 * The type of settings.
	 *
	 * @since x.x.x.
	 *
	 * @var string
	 */
	protected $type = 'thememod';

	/**
	 * Inject dependencies.
	 *
	 * @since x.x.x.
	 *
	 * @param MAKE_Util_Choices_ChoicesInterface             $choices
	 * @param MAKE_Util_Compatibility_CompatibilityInterface $compatibility
	 */
	public function __construct(
		MAKE_Util_Choices_ChoicesInterface $choices,
		MAKE_Util_Compatibility_CompatibilityInterface $compatibility
	) {
		// Choices
		$this->choices = $choices;

		// Compatibility
		$this->compatibility = $compatibility;
	}

	/**
	 * Load the settings definitions and hook into WordPress.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function load() {
		// Load the default setting definitions
		$file = dirname( __FILE__ ) . '/thememod-definitions.php';
		if ( is_readable( $file ) ) {
			include_once $file;
		}

		// Add filter to give the sanitize_choice callback the parameters it needs.
		add_filter( 'make_settings_thememod_sanitize_callback_parameters', array( $this, 'add_sanitize_choice_parameters' ), 10, 3 );

		// Loading has occurred.
		$this->loaded = true;

		/**
		 * Action: Fires at the end of the ThemeMod settings object's load method.
		 *
		 * This action gives a developer the opportunity to add or modify setting definitions
		 * and run additional load routines.
		 *
		 * @since x.x.x.
		 *
		 * @param MAKE_ThemeMod_Settings    $settings     The settings object that has just finished loading.
		 */
		do_action( "make_settings_{$this->type}_loaded", $this );
	}

	/**
	 * Extension of the parent class's get_settings method to account for a deprecated filter.
	 *
	 * @since x.x.x.
	 *
	 * @param string $property
	 *
	 * @return array|mixed|void
	 */
	public function get_settings( $property = 'all' ) {
		$settings = parent::get_settings( $property );

		// Check for deprecated filter.
		if ( 'default' === $property && has_filter( 'make_setting_defaults' ) ) {
			$this->compatibility->deprecated_hook(
				'make_setting_defaults',
				'1.7.0',
				__( 'To add or modify theme options, use the function make_thememod_update_settings() instead.', 'make' )
			);

			/**
			 * Deprecated: Filter the default values for the settings.
			 *
			 * @since 1.2.3.
			 * @deprecated 1.7.0.
			 *
			 * @param array    $defaults    The list of default settings.
			 */
			$settings = apply_filters( 'make_setting_defaults', $settings );
		}

		return $settings;
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
	 * Extension of the parent class's get_default method to account for a deprecated filter.
	 *
	 * @since x.x.x.
	 *
	 * @param string $setting_id
	 *
	 * @return mixed|null|void
	 */
	public function get_default( $setting_id ) {
		$default_value = parent::get_default( $setting_id );

		// Check for deprecated filter.
		if ( has_filter( 'make_get_default' ) ) {
			$this->compatibility->deprecated_hook(
				'make_get_default',
				'1.7.0',
				__( 'Use make_settings_thememod_default_value instead.', 'make' )
			);

			/**
			 * Deprecated: Filter the retrieved default value.
			 *
			 * @since 1.2.3.
			 * @deprecated 1.7.0.
			 *
			 * @param mixed     $default    The default value.
			 * @param string    $option     The name of the default value.
			 */
			$default_value = apply_filters( 'make_get_default', $default_value, $setting_id );
		}

		return $default_value;
	}

	/**
	 * Extension of the parent class's sanitize_value method to account for how the Customizer handles sanitize callbacks.
	 *
	 * @since x.x.x.
	 *
	 * @param  mixed     $value         The value to sanitize.
	 * @param  string    $setting_id    The ID of the setting to retrieve.
	 * @param  string    $context       Optional. The context in which a setting needs to be sanitized.
	 *
	 * @return mixed|WP_Error
	 */
	public function sanitize_value( $value, $setting_id, $context = '' ) {
		// Is this being called by the Customizer?
		if ( $setting_id instanceof WP_Customize_Setting ) {
			$setting_id = $setting_id->id;
			$context = 'customizer';
		}

		return parent::sanitize_value( $value, $setting_id, $context );
	}

	/**
	 * Get the choice set for a particular setting.
	 *
	 * This can either return the set (an array of choices) or simply the ID of the choice set.
	 *
	 * @param string    $setting_id
	 * @param bool      $id_only
	 *
	 * @return mixed|void
	 */
	public function get_choice_set( $setting_id, $id_only = false ) {
		$choice_set_id = $this->undefined;
		$choice_set = $this->undefined;

		$choice_sets = $this->get_settings( 'choice_set_id' );
		if ( isset( $choice_sets[ $setting_id ] ) ) {
			$choice_set_id = $choice_sets[ $setting_id ];
		}

		/**
		 * Filter: Modify the choice set ID for a particular setting.
		 *
		 * @since x.x.x.
		 *
		 * @param array     $choice_set_id    The choice set for the setting.
		 * @param string    $setting_id       The id of the setting.
		 */
		$choice_set_id = apply_filters( "make_settings_{$this->type}_choice_set_id", $choice_set_id, $setting_id );

		// Return just the ID.
		if ( true === $id_only ) {
			return sanitize_key( $choice_set_id );
		}

		// Get the choice set array.
		$choice_set = $this->choices->get_choice_set( $choice_set_id );

		// Check for deprecated filter.
		if ( has_filter( 'make_setting_choices' ) ) {
			$this->compatibility->deprecated_hook(
				'make_setting_choices',
				'1.7.0',
				__( 'To add or modify theme option choices, use the function make_choices_update_choices() instead.', 'make' )
			);

			/**
			 * Deprecated: Filter the setting choices.
			 *
			 * @since 1.2.3.
			 *
			 * @param array     $choices    The choices for the setting.
			 * @param string    $setting    The setting name.
			 */
			$choice_set = apply_filters( 'make_setting_choices', $choice_set, $setting_id );
		}

		// Return the array of choices.
		return $choice_set;
	}

	/**
	 * Sanitize the value of a theme mod that has a choice set.
	 *
	 * @since x.x.x.
	 *
	 * @param  mixed     $value      The value given to sanitize.
	 * @param $setting_id
	 *
	 * @return mixed|void
	 */
	public function sanitize_choice( $value, $setting_id ) {
		$choice_set_id = $this->get_choice_set( $setting_id, true );
		$default_value = $this->get_default( $setting_id );

		// Sanitize the value.
		$sanitized_value = $this->choices->sanitize_choice( $value, $choice_set_id, $default_value );

		// Check for deprecated filter.
		if ( has_filter( 'make_sanitize_choice' ) ) {
			$this->compatibility->deprecated_hook(
				'make_sanitize_choice',
				'1.7.0',
				__( 'Use make_settings_thememod_current_value instead.', 'make' )
			);

			/**
			 * Deprecated: Filter the sanitized value.
			 *
			 * @since 1.2.3.
			 * @deprecated 1.7.0.
			 *
			 * @param mixed     $value      The sanitized value.
			 * @param string    $setting    The key for the setting.
			 */
			$sanitized_value = apply_filters( 'make_sanitize_choice', $sanitized_value, $setting_id );
		}

		return $sanitized_value;
	}

	/**
	 * Add items to the array of parameters to feed into the sanitize_choice callback.
	 *
	 * @since x.x.x.
	 *
	 * @param  mixed     $value
	 * @param  string    $callback
	 * @param  string    $setting_id
	 *
	 * @return array
	 */
	public function add_sanitize_choice_parameters( $value, $callback, $setting_id ) {
		// Only run this in the proper hook context.
		if ( "make_settings_{$this->type}_sanitize_callback_parameters" !== current_filter() ) {
			return $value;
		}

		if ( is_array( $callback ) && $callback[0] instanceof $this && 'sanitize_choice' === $callback[1] ) {
			$value = (array) $value;
			$value[] = $setting_id;
		}

		return $value;
	}
}