<?php
/**
 * @package Make
 */


interface MAKE_Util_Font_Source_FontSourceInterface extends MAKE_Util_LoadInterface {
	public function get_font_data( $font = null );

	public function get_font_choices();

	public function get_font_stack( $font, $default_stack = 'sans-serif' );
}