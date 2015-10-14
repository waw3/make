<?php
/**
 * @package Make
 */


interface MAKE_Util_Font_FontInterface extends MAKE_Util_LoadInterface {
	public function add_font_source( $source_id, MAKE_Util_Font_Source_FontSourceInterface $source );

	public function remove_font_source( $source_id );

	public function has_font_source( $source_id );

	public function get_font_source( $source_id );

	public function get_font_source_label( $source_id );

	public function get_font_choices( $source_id = null, $headings = true );
}