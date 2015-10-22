<?php
/**
 * @package Make
 */


class MAKE_Util_Style_Base {
	/**
	 * @var array
	 */
	private $style_sets = array();

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	protected $loaded = false;


	public function __construct(
		MAKE_Util_Error_ErrorInterface $error
	) {
		// Errors
		$this->error = $error;
	}

	/**
	 *
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function load() {

	}

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


	public function get_style_types() {
		return array_keys( $this->styles );
	}


	public function get_styles_object( $settings, $type = 'all' ) {
		// $settings is associative, so has preview values
		if ( $this->is_assoc( $settings ) ) {

		}
		// $settings is numeric, so only has setting IDs
		else {

		}
	}

	/**
	 * @link http://stackoverflow.com/a/5969617
	 *
	 * @param array $array
	 *
	 * @return bool
	 */
	private function is_assoc( array $array ) {
		for ( reset( $array ); is_int( key( $array ) ); next( $array ) );
		return ! is_null( key( $array ) );
	}


	public function get_styles_as_inline() {}


	public function get_styles_as_file() {}


	public function get_styles_as_json() {}
}