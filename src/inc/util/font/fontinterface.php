<?php
/**
 * @package Make
 */


interface TTFMAKE_Util_Font_FontsInterface extends TTFMAKE_Util_LoadInterface {
	public function get_font_data();

	public function get_font_choices();
}