<?php
/**
 * @package Make
 */


interface MAKE_Setup_ScriptsInterface extends MAKE_Util_ModulesInterface {
	public function get_located_file_url( $file_names );

	public function is_registered( $style_id, $type );

	public function add_dependency( $style_id, $dependency_id, $type );

	public function remove_dependency( $recipient_id, $dependency_id, $type );

	public function update_version( $recipient_id, $version, $type );

	public function get_url( $dep_id, $type );
}