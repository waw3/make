<?php
/**
 * @package Make
 */


class MAKE_Util_Font_Source_Generic implements MAKE_Util_Font_Source_FontSourceInterface {

	public $label = '';


	public $priority = 10;


	private $data = array();

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $loaded = false;


	public function __construct() {
		// Set the label
		$this->label = __( 'Generic Fonts', 'make' );
	}

	/**
	 * Load font data.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function load() {
		$this->data = array(
			'serif' => array(
				'label' => __( 'Serif', 'make' ),
				'stack' => 'Georgia,Times,"Times New Roman",serif'
			),
			'sans-serif' => array(
				'label' => __( 'Sans Serif', 'make' ),
				'stack' => '"Helvetica Neue",Helvetica,Arial,sans-serif'
			),
			'monospace' => array(
				'label' => __( 'Monospaced', 'make' ),
				'stack' => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace'
			)
		);

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


	public function get_font_data( $font = null ) {
		// Load the font data if necessary.
		if ( false === $this->is_loaded() ) {
			$this->load();
		}

		// Return data for a specific font.
		if ( ! is_null( $font ) ) {
			$data = array();

			if ( array_key_exists( $font, $this->data ) ) {
				$data = $this->data[ $font ];
			}

			return $data;
		}

		// Return all font data.
		return $this->data;
	}


	public function get_font_choices() {
		$choices = array();

		foreach ( $this->get_font_data() as $key => $data ) {
			if ( isset( $data['label'] ) ) {
				$choices[ $key ] = $data['label'];
			}
		}

		return $choices;
	}


	public function get_font_stack( $font, $default_stack = 'sans-serif' ) {
		$data = $this->get_font_data( $font );
		$stack = '';

		if ( isset( $data['stack'] ) ) {
			$stack = $data['stack'];
		} else {
			$stack = $default_stack;
		}

		return $stack;
	}
}