<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Util_Settings_ThemeModInterface
 *
 * @since x.x.x.
 */
interface MAKE_Util_Settings_ThemeModInterface extends MAKE_Util_Settings_SettingsInterface {
	public function get_choice_set( $setting_id, $id_only = false );

	public function sanitize_choice( $value, $setting_id );
}