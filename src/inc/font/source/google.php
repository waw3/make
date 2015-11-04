<?php
/**
 * @package Make
 */


final class MAKE_Font_Source_Google extends MAKE_Font_Source_Base implements MAKE_Util_LoadInterface {

	private $compatibility = null;


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


	public function __construct(
		MAKE_Compatibility_MethodsInterface $compatibility
	) {
		// Compatibility
		$this->compatibility = $compatibility;

		// Set the ID.
		$this->id = 'google';

		// Set the label.
		$this->label = __( 'Google Fonts', 'make' );

		// Set the priority.
		$this->priority = 20;
	}

	/**
	 * Load data files.
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
		if ( ! $this->is_loaded() ) {
			$this->load();
		}

		return parent::get_font_data( $font );
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


	private function collect_subsets( $font_data ) {
		$subsets = array();

		foreach ( $font_data as $font => $data ) {
			if ( isset( $data['subsets'] ) ) {
				$subsets = array_merge( $subsets, (array) $data['subsets'] );
			}
		}

		$subsets = array_unique( $subsets );
		sort( $subsets );

		return $subsets;
	}


	public function get_subsets() {
		if ( empty( $this->subsets ) ) {
			$this->subsets = $this->collect_subsets( $this->get_font_data() );
		}

		// Check for deprecated filter
		if ( has_filter( 'make_get_google_font_subsets' ) ) {
			$this->compatibility->deprecated_hook(
				'make_get_google_font_subsets',
				'1.7.0',
				__( 'To modify the list of available Google Fonts subsets, use the make_font_data_google hook instead.', 'make' )
			);

			return apply_filters( 'make_get_google_font_subsets', $this->subsets );
		}

		return $this->subsets;
	}


	public function sanitize_subset( $value, $default = 'latin' ) {
		$subsets = $this->get_subsets();

		// Check for deprecated filter
		if ( has_filter( 'make_sanitize_font_subset' ) ) {
			$this->compatibility->deprecated_hook(
				'make_sanitize_font_subset',
				'1.7.0'
			);
		}

		if ( in_array( $value, $subsets[ $value ] ) ) {
			return $value;
		}

		return $default;
	}
}