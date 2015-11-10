<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Settings_ThemeMod
 *
 * A child class of MAKE_Settings_Base for defining and managing theme mod settings and their values.
 *
 * @since x.x.x.
 */
final class MAKE_Settings_ThemeMod extends MAKE_Settings_Base implements MAKE_Settings_ThemeModInterface, MAKE_Util_HookInterface, MAKE_Util_LoadInterface {
	/**
	 * The type of settings.
	 *
	 * @since x.x.x.
	 *
	 * @var string
	 */
	protected $type = 'thememod';

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $hooked = false;

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $loaded = false;

	/**
	 * Inject dependencies.
	 *
	 * @since x.x.x.
	 *
	 * @param MAKE_Error_CollectorInterface                 $error
	 * @param MAKE_Compatibility_MethodsInterface $compatibility
	 * @param MAKE_Choices_ManagerInterface             $choices
	 */
	public function __construct(
		MAKE_Error_CollectorInterface $error,
		MAKE_Compatibility_MethodsInterface $compatibility,
		MAKE_Choices_ManagerInterface $choices,
		MAKE_Font_ManagerInterface $font
	) {
		parent::__construct( $error );

		// Compatibility
		$this->add_module( 'compatibility', $compatibility );

		// Choices
		$this->add_module( 'choices', $choices );

		// Font
		$this->add_module( 'font', $font );
	}

	/**
	 * Hook into WordPress.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		// Add filter to give the sanitize_choice callback the parameters it needs.
		add_filter( 'make_settings_thememod_sanitize_callback_parameters', array( $this, 'add_sanitize_choice_parameters' ), 10, 3 );

		// Hooking has occurred.
		$this->hooked = true;
	}

	/**
	 * Check if the hook routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @return bool
	 */
	public function is_hooked() {
		return $this->hooked;
	}

	/**
	 * Load data files.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function load() {
		if ( $this->is_loaded() ) {
			return;
		}

		// Load the default setting definitions
		$file = dirname( __FILE__ ) . '/thememod-definitions.php';
		if ( is_readable( $file ) ) {
			include $file;
		}

		/**
		 * Action: Fires at the end of the ThemeMod settings object's load method.
		 *
		 * This action gives a developer the opportunity to add or modify setting definitions
		 * and run additional load routines.
		 *
		 * @since x.x.x.
		 *
		 * @param MAKE_Settings_ThemeMod    $settings     The settings object that has just finished loading.
		 */
		do_action( "make_settings_{$this->type}_loaded", $this );

		// Loading has occurred.
		$this->loaded = true;
	}

	/**
	 * Check if the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @return bool
	 */
	public function is_loaded() {
		return $this->loaded;
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
		if ( false === $this->is_loaded() ) {
			$this->load();
		}

		$settings = parent::get_settings( $property );

		// Check for deprecated filter.
		if ( 'default' === $property && has_filter( 'make_setting_defaults' ) ) {
			$this->compatibility()->deprecated_hook(
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
		if ( $this->setting_exists( $setting_id ) ) {
			// Sanitize the value before saving it.
			$sanitized_value = $this->sanitize_value( $value, $setting_id, 'database' );
			if ( $this->undefined !== $sanitized_value ) {
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
		if ( $this->setting_exists( $setting_id ) ) {
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

		if ( $this->setting_exists( $setting_id ) ) {
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
			$this->compatibility()->deprecated_hook(
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
	 * @return mixed
	 */
	public function sanitize_value( $value, $setting_id, $context = '' ) {
		// Is this being called by the Customizer?
		if ( $setting_id instanceof WP_Customize_Setting ) {
			$setting_id = $setting_id->id;
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

		if ( $this->setting_exists( $setting_id, 'choice_set_id' ) ) {
			$setting = $this->get_setting( $setting_id );
			$choice_set_id = $setting['choice_set_id'];
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
		$choice_set = $this->choices()->get_choice_set( $choice_set_id );

		// Check for deprecated filter.
		if ( has_filter( 'make_setting_choices' ) ) {
			$this->compatibility()->deprecated_hook(
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
		// Sanitize the value.
		$sanitized_value = $this->choices()->sanitize_choice( $value, $this->get_choice_set( $setting_id, true ), $this->get_default( $setting_id ) );

		// Check for deprecated filter.
		if ( has_filter( 'make_sanitize_choice' ) ) {
			$this->compatibility()->deprecated_hook(
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
	 * Sanitize the value of a theme mod with a font family choice set.
	 *
	 * @since x.x.x.
	 *
	 * @param  string    $value
	 * @param  string    $setting_id
	 *
	 * @return mixed|void
	 */
	public function sanitize_font_choice( $value, $setting_id ) {
		// Sanitize the value.
		$sanitized_value = $this->font()->sanitize_font_choice( $value, null, $this->get_default( $setting_id ) );

		// Check for deprecated filter.
		if ( has_filter( 'make_sanitize_choice' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_sanitize_font_choice',
				'1.7.0',
				__( 'Use make_settings_thememod_current_value instead.', 'make' )
			);

			/**
			 * Deprecated: Filter the sanitized font choice.
			 *
			 * @since 1.2.3.
			 * @deprecated 1.7.0.
			 *
			 * @param string    $value    The chosen font value.
			 */
			$sanitized_value = apply_filters( 'make_sanitize_font_choice', $sanitized_value );
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

		if (
			is_array( $callback )
			&&
			$callback[0] instanceof $this
			&&
			in_array( $callback[1], array( 'sanitize_choice', 'sanitize_font_choice' ) )
		) {
			$value = (array) $value;
			$value[] = $setting_id;
		}

		return $value;
	}

	/**
	 * Sanitize the value of the font-subset setting.
	 *
	 * @since x.x.x.
	 *
	 * @param  string    $value
	 *
	 * @return mixed
	 */
	public function sanitize_google_font_subset( $value ) {
		// Check for deprecated filter
		if ( has_filter( 'make_sanitize_font_subset' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_sanitize_font_subset',
				'1.7.0'
			);
		}

		return $this->font()->get_source( 'google' )->sanitize_subset( $value, $this->get_default( 'font-subset' ) );
	}
}