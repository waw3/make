<?php
/**
 * @package Make
 */


final class TTFMAKE_Util_Compatibility_Base {

	private $mode = array(
		'full' => array(
			'deprecated-functions' => true,
		),
		'current' => array(
			'deprecated-functions' => false,
		),
	);


	private $plus = false;

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $loaded = false;


	public function __construct() {
		// Set the compatibility mode.
		$mode = apply_filters( 'make_compatibility_mode', 'full' );
		if ( isset( $this->mode[ $mode ] ) ) {
			$this->mode = $this->mode[ $mode ];
		} else {
			$this->mode = $this->mode['full'];
		}

		// is_plus
	}


	public function load() {
		// Bail if the load routine has already been run.
		if ( true === $this->is_loaded() ) {
			return;
		}

		// Load the deprecated functions file.
		if ( true === $this->mode['deprecated-functions'] ) {
			$file = basename( __FILE__ ) . '/deprecated-functions.php';
			if ( is_readable( $file ) ) {
				require_once $file;
			}
		}

		// Loading has occurred.
		$this->loaded = true;
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


	public function deprecated_function() {

	}


	public function deprecated_filter() {

	}
}