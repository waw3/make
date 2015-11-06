<?php
/**
 * @package Make
 */


interface MAKE_Font_ManagerInterface extends MAKE_Util_ModulesInterface {
	public function get_font_choices( $source_id = null, $headings = true );

	public function sanitize_font_choice( $value, $source = null, $default = '' );
}