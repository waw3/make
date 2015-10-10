<?php
/**
 * @package Make
 */


class TTFMAKE_Util_Font_Module_Google implements TTFMAKE_Util_Font_Module_FontModuleInterface {

	public $label = '';


	public $priority = 20;


	private $data = array();


	private $stacks = array(
		'serif' => 'Georgia,Times,"Times New Roman",serif',
		'sans-serif' => '"Helvetica Neue",Helvetica,Arial,sans-serif',
		'display' => 'Copperplate,Copperplate Gothic Light,fantasy',
		'handwriting' => 'Brush Script MT,cursive',
		'monospace' => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace',
	);

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
		$this->label = __( 'Google Fonts', 'make' );
	}

	/**
	 * Load font data.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function load() {
		// Load the font data file.
		$file = basename( __FILE__ ) . '/google-data.php';
		if ( is_readable( $file ) ) {
			include_once $file;
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


	public function load_font_data( array $data ) {
		$this->data = $data;
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

		if ( isset( $data['category'] ) && isset( $this->stacks[ $data['category'] ] ) ) {
			$stack = "\"$font\"," . $this->stacks[ $data['category'] ];
		} else {
			$stack = $default_stack;
		}

		return $stack;
	}
}