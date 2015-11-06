<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Settings_ThemeModInterface
 *
 * @since x.x.x.
 */
interface MAKE_Settings_ThemeModInterface extends MAKE_Settings_BaseInterface {
	public function get_choice_set( $setting_id, $id_only = false );

	public function sanitize_choice( $value, $setting_id );
}