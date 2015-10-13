<?php
/**
 * @package Make
 */


class TTFMAKE_Util_Font_Module_Google implements TTFMAKE_Util_Font_Module_FontModuleInterface {

	public $label = '';


	public $priority = 20;


	private $data = array();


	private $subsets = array();


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
		$file = dirname( __FILE__ ) . '/google-data.php';
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


	public function build_url( array $fonts, array $subsets ) {
		$url = '';
		$fonts = array_unique( $fonts );
		$family = array();

		foreach ( $fonts as $font ) {
			$font_data = $this->get_font_data( trim( $font ) );

			// Verify that the font exists
			if ( ! empty( $font_data ) ) {
				// Build the family name and variant string (e.g., "Open+Sans:regular,italic,700")
				$family[] = urlencode(
					$font .
					':' .
					join( ',', $this->choose_font_variants( $font, $font_data['variants'] ) )
				);
			}
		}

		// Bail if there are no valid font families.
		if ( empty( $family ) ) {
			return $url;
		}

		// Start building the URL.
		$base_url = '//fonts.googleapis.com/css';

		// Add families
		$url = add_query_arg( 'family', implode( '|', $family ), $base_url );

		// Add subsets, if specified.
		if ( ! empty( $subsets ) ) {
			$subsets = array_map( 'sanitize_key', $subsets );
			$url = add_query_arg( 'subset', join( ',', $subsets ), $url );
		}

		/**
		 * Filter the Google Fonts URL.
		 *
		 * @since 1.2.3.
		 *
		 * @param string    $url    The URL to retrieve the Google Fonts.
		 */
		return apply_filters( 'make_get_google_font_uri', $url );
	}


	private function choose_font_variants( $font, array $available_variants = array() ) {
		$chosen_variants = array();

		if ( empty( $available_variants ) ) {
			$font_data = $this->get_font_data( $font );
			if ( ! empty( $font_data ) ) {
				$available_variants = $font_data['variants'];
			}
		}

		// If a "regular" variant is not found, get the first variant
		if ( ! in_array( 'regular', $available_variants ) ) {
			$chosen_variants[] = $available_variants[0];
		} else {
			$chosen_variants[] = 'regular';
		}

		// Only add "italic" if it exists
		if ( in_array( 'italic', $available_variants ) ) {
			$chosen_variants[] = 'italic';
		}

		// Only add "700" if it exists
		if ( in_array( '700', $available_variants ) ) {
			$chosen_variants[] = '700';
		}

		/**
		 * Allow developers to alter the font variant choice.
		 *
		 * @since 1.2.3.
		 *
		 * @param array     $variants    The list of variants for a font.
		 * @param string    $font        The font to load variants for.
		 * @param array     $variants    The variants for the font.
		 */
		return apply_filters( 'make_font_variants', array_unique( $chosen_variants ), $font, $available_variants );
	}


	public function get_subsets() {
		if ( empty( $this->subsets ) ) {
			$subsets = array();
			$data = $this->get_font_data();

			foreach ( $data as $font_data ) {
				if ( isset( $font_data['subsets'] ) ) {
					$subsets = $subsets + $font_data['subsets'];
				}
			}

			$subsets = array_unique( $subsets );
			$this->subsets = $subsets;
			return $subsets;
		}

		return $this->subsets;
	}
}