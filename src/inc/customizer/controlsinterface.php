<?php
/**
 * @package Make
 */


interface MAKE_Customizer_ControlsInterface extends MAKE_Util_ModulesInterface {
	public function get_panel_definitions();

	public function add_section_definitions( $section_id, array $data, $overwrite = false );

	public function get_section_definitions();

	public function get_last_priority( $items );
}