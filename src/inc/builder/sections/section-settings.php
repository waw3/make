<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Settings_Builder_Sections
 *
 *
 */
class MAKE_Settings_Builder_Sections extends MAKE_Settings {
	/**
	 * The type of settings.
	 *
	 * @since 1.6.0.
	 *
	 * @var string
	 */
	protected $type = 'builder_sections';

	/**
	 * TODO
	 */
	protected function load() {}

	/**
	 * Set a new value for a particular theme_mod setting.
	 *
	 * @since 1.6.0.
	 *
	 * @param  string    $setting_id    The name of the theme_mod to set.
	 * @param  mixed     $value         The value to assign to the theme_mod.
	 *
	 * @return bool                     True if value was successfully set.
	 */
	public function set_value( $setting_id, $value ) {
		if ( isset( $this->settings[ $setting_id ] ) ) {
			// Sanitize the value before saving it.
			$sanitized_value = $this->sanitize_value( $value, $setting_id );
			if ( $this->undefined !== $sanitized_value ) {
				//
			}
		}

		return false;
	}

	/**
	 * Remove a particular theme_mod setting.
	 *
	 * @since 1.6.0.
	 *
	 * @param  string    $setting_id    The name of the theme_mod to remove.
	 *
	 * @return bool                     True if the theme_mod was successfully removed.
	 */
	public function unset_value( $setting_id ) {
		if ( isset( $this->settings[ $setting_id ] ) ) {
			//
		}

		return false;
	}

	/**
	 * Get the stored value of a theme_mod, unaltered.
	 *
	 * @since 1.6.0.
	 *
	 * @param  string    $setting_id    The name of the theme_mod to retrieve.
	 *
	 * @return mixed|null               The value of the theme_mod as it is in the database, or undefined if the theme_mod isn't set.
	 */
	public function get_raw_value( $setting_id ) {
		$value = $this->undefined;

		if ( isset( $this->settings[ $setting_id ] ) ) {
			//
		}

		return $value;
	}
}