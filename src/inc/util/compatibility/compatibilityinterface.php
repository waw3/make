<?php
/**
 * @package Make
 */

/**
 * Interface TTFMAKE_Util_Compatibility_CompatibilityInterface
 *
 * @since x.x.x.
 */
interface TTFMAKE_Util_Compatibility_CompatibilityInterface extends TTFMAKE_Util_LoadInterface {
	public function deprecated_function( $function, $version, $replacement = null );

	public function deprecated_hook( $hook, $version, $message = null );

	public function is_plus();

	public function get_plus_version();
}