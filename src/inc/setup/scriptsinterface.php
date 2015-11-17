<?php
/**
 * @package Make
 */


interface MAKE_Setup_ScriptsInterface extends MAKE_Util_ModulesInterface {
	public function get_located_file_url( $file_names );

	public function style_is_registered( $style_id );

	public function add_style_dependency( $style_id, $dependency_id );

	public function remove_style_dependency( $style_id, $dependency_id );

	public function update_style_version( $style_id, $version );

	public function get_style_url( $style_id );

	public function script_is_registered( $script_id );

	public function add_script_dependency( $script_id, $dependency_id );

	public function remove_script_dependency( $script_id, $dependency_id );

	public function update_script_version( $script_id, $version );

	public function get_script_url( $script_id );
}