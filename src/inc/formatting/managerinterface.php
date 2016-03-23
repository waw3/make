<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Formatting_ManagerInterface
 *
 * @since x.x.x.
 */
interface MAKE_Formatting_ManagerInterface extends MAKE_Util_ModulesInterface {
	public function add_format( $format_name, $script_uri, $script_version = '' );

	public function remove_format( $format_name );
}