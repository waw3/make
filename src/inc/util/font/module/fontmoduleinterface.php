<?php
/**
 * @package Make
 */


interface TTFMAKE_Util_Font_Module_FontModuleInterface {
	public function get_font_data( $font = null );

	public function get_font_choices();

	public function get_font_stack( $font, $default_stack = 'sans-serif' );
}