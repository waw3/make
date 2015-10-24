<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Integration_IntegrationInterface
 *
 * @since x.x.x.
 */
interface MAKE_Integration_IntegrationInterface extends MAKE_Util_ModulesInterface {
	public function add_integration( $module_name, $module );

	public function is_plugin_active( $plugin_relative_path );
}