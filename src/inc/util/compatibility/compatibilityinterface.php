<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Util_Compatibility_CompatibilityInterface
 *
 * @since x.x.x.
 */
interface MAKE_Util_Compatibility_CompatibilityInterface extends MAKE_Util_LoadInterface {
	public function deprecated_function( $function, $version, $replacement = null );

	public function deprecated_hook( $hook, $version, $message = null );

	public function is_plus();

	public function get_plus_version();
}