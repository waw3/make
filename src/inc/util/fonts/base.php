<?php
/**
 * @package Make
 */


class TTFMAKE_Util_Fonts_Base implements TTFMAKE_Util_Fonts_FontsInterface {
	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	protected $loaded = false;

	/**
	 * Load font data and other data into the object.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function load() {}

	/**
	 * Check if the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @return bool
	 */
	public function is_loaded() {
		return $this->loaded;
	}


	public function get_font_data() {}


	public function get_font_choices() {}
}