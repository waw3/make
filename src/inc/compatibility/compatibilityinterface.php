<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Compatibility_CompatibilityInterface
 *
 * @since x.x.x.
 */
interface MAKE_Compatibility_CompatibilityInterface extends MAKE_Util_ModulesInterface {
	public function is_plus();

	public function get_plus_version();

	public function deprecated_function( $function, $version, $replacement = null );

	public function deprecated_hook( $hook, $version, $message = null );

	public function doing_it_wrong( $function, $message, $version = null, $backtrace = null );
}