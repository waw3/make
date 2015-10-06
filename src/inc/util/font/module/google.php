<?php
/**
 * @package Make
 */


class TTFMAKE_Util_Font_Module_Google implements TTFMAKE_Util_Font_Module_FontModuleInterface {

	public $label = '';


	private $data = array();


	private $stacks = array(
		'serif' => 'Georgia,Times,Times New Roman,serif',
		'sans-serif' => '"Helvetica Neue",Helvetica,Arial,sans-serif',
		'display' => 'Copperplate,Copperplate Gothic Light,fantasy',
		'handwriting' => 'Brush Script MT,cursive',
		'monospace' => 'Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace',
	);


	private $imported = false;


	public function __construct() {
		// Set the label
		$this->label = __( 'Google fonts', 'make' );
	}


	public function import_font_data( array $data ) {
		if ( true === $this->imported ) {
			return;
		}

		$this->data = $data;
	}


	public function get_font_data( $font = null ) {
		// Load the font data if it hasn't yet.
		if ( empty( $this->data ) && false === $this->imported ) {
			// Load the font data
			$file = basename( __FILE__ ) . '/google-data.php';
			if ( is_readable( $file ) ) {
				include_once $file;
			}
			$this->imported = true;
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