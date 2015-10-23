<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Util_SettingsInterface
 *
 * @since x.x.x.
 */
interface MAKE_Util_Settings_SettingsInterface {
	public function add_settings( $settings, $default_props = array(), $overwrite = false );

	public function remove_settings( $setting_ids );

	public function get_settings( $property = 'all' );

	public function set_value( $setting_id, $value );

	public function unset_value( $setting_id );

	public function get_raw_value( $setting_id );

	public function get_value( $setting_id, $context = '' );

	public function get_default( $setting_id );

	public function is_default( $setting_id, $value = null );

	public function get_sanitize_callback( $setting_id, $context = '' );

	public function sanitize_value( $value, $setting_id, $context = '' );
}