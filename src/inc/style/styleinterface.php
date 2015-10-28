<?php
/**
 * @package Make
 */


interface MAKE_Style_StyleInterface extends MAKE_Util_ModulesInterface {
	public function thememod();

	public function css();

	public function get_styles_as_inline();
}