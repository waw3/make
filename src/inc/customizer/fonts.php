<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_customizer_font_property_definitions' ) ) :
/**
 * Generate an array of Customizer option definitions for a particular HTML element.
 *
 * @since 1.5.0.
 *
 * @param  string    $element
 * @param  string    $label
 * @param  string    $description
 * @return array
 */
function ttfmake_customizer_font_property_definitions( $element, $label, $description = '' ) {
	$definitions = array(
		'typography-group-' . $element => array(
			'control' => array(
				'control_type' => 'TTFMAKE_Customize_Misc_Control',
				'label'   => $label,
				'description' => $description,
				'type'  => 'group-title',
			),
		),
		'font-family-' . $element   => array(
			'setting' => array(
				'sanitize_callback' => 'ttfmake_sanitize_font_choice',
			),
			'control' => array(
				'label'   => __( 'Font Family', 'make' ),
				'type'    => 'select',
				'choices' => ttfmake_font_choices_placeholder(),
			),
		),
		'font-size-' . $element     => array(
			'setting' => array(
				'sanitize_callback' => 'absint',
			),
			'control' => array(
				'control_type' => 'TTFMAKE_Customize_Range_Control',
				'label'   => __( 'Font Size (px)', 'make' ),
				'type'  => 'range',
				'input_attrs' => array(
					'min'  => 6,
					'max'  => 100,
					'step' => 1,
				),
			),
		),
		'font-weight-' . $element => array(
			'setting' => array(
				'sanitize_callback' => 'ttfmake_sanitize_choice',
			),
			'control' => array(
				'control_type' => 'TTFMAKE_Customize_Radio_Control',
				'label'   => __( 'Font Weight', 'make' ),
				'type'  => 'radio',
				'mode'  => 'buttonset',
				'choices' => ttfmake_get_choices( 'font-weight-' . $element ),
			),
		),
		'font-style-' . $element => array(
			'setting' => array(
				'sanitize_callback' => 'ttfmake_sanitize_choice',
			),
			'control' => array(
				'control_type' => 'TTFMAKE_Customize_Radio_Control',
				'label'   => __( 'Font Style', 'make' ),
				'type'  => 'radio',
				'mode'  => 'buttonset',
				'choices' => ttfmake_get_choices( 'font-style-' . $element ),
			),
		),
		'text-transform-' . $element => array(
			'setting' => array(
				'sanitize_callback' => 'ttfmake_sanitize_choice',
			),
			'control' => array(
				'control_type' => 'TTFMAKE_Customize_Radio_Control',
				'label'   => __( 'Text Transform', 'make' ),
				'type'  => 'radio',
				'mode'  => 'buttonset',
				'choices' => ttfmake_get_choices( 'text-transform-' . $element ),
			),
		),
		'line-height-' . $element     => array(
			'setting' => array(
				'sanitize_callback' => 'ttfmake_sanitize_float',
			),
			'control' => array(
				'control_type' => 'TTFMAKE_Customize_Range_Control',
				'label'   => __( 'Line Height (em)', 'make' ),
				'type'  => 'range',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 5,
					'step' => 0.1,
				),
			),
		),
		'letter-spacing-' . $element     => array(
			'setting' => array(
				'sanitize_callback' => 'ttfmake_sanitize_float',
			),
			'control' => array(
				'control_type' => 'TTFMAKE_Customize_Range_Control',
				'label'   => __( 'Letter Spacing (px)', 'make' ),
				'type'  => 'range',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 10,
					'step' => 0.5,
				),
			),
		),
		'word-spacing-' . $element     => array(
			'setting' => array(
				'sanitize_callback' => 'ttfmake_sanitize_float',
			),
			'control' => array(
				'control_type' => 'TTFMAKE_Customize_Range_Control',
				'label'   => __( 'Word Spacing (px)', 'make' ),
				'type'  => 'range',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 20,
					'step' => 1,
				),
			),
		),
		'link-underline-' . $element => array(
			'setting' => array(
				'sanitize_callback' => 'ttfmake_sanitize_choice',
			),
			'control' => array(
				'control_type' => 'TTFMAKE_Customize_Radio_Control',
				'label'   => __( 'Link Underline', 'make' ),
				'type'  => 'radio',
				'mode'  => 'buttonset',
				'choices' => ttfmake_get_choices( 'link-underline-' . $element ),
			),
		),
	);

	/**
	 * Filter the Customizer's font control definitions.
	 *
	 * @since 1.5.0.
	 *
	 * @param array     $definitions    Array of Customizer options and their setting and control definitions.
	 * @param string    $element        The HTML element that the font properties will apply to.
	 */
	return apply_filters( 'make_customizer_font_property_definitions', $definitions, $element );
}
endif;

if ( ! function_exists( 'ttfmake_font_choices_placeholder' ) ) :
/**
 * Add a placeholder for the large font choices array, which will be loaded
 * in via JavaScript.
 *
 * @since 1.3.0.
 *
 * @return array
 */
function ttfmake_font_choices_placeholder() {
	return array( 'placeholder' => __( 'Loading&hellip;', 'make' ) );
}
endif;

if ( ! function_exists( 'ttfmake_get_font_property_option_keys' ) ) :
/**
 * Return all the option keys for the specified font property.
 *
 * @since  1.3.0.
 *
 * @param  string    $property    The font property to search for.
 * @return array                  Array of matching font option keys.
 */
function ttfmake_get_font_property_option_keys( $property ) {
	$all_keys = array_keys( ttfmake_option_defaults() );

	$font_keys = array();
	foreach ( $all_keys as $key ) {
		if ( preg_match( '/^' . $property . '-/', $key ) ) {
			$font_keys[] = $key;
		}
	}

	return $font_keys;
}
endif;

if ( ! function_exists( 'ttfmake_get_standard_fonts' ) ) :
/**
 * Return an array of standard websafe fonts.
 *
 * @since  1.0.0.
 *
 * @return array    Standard websafe fonts.
 */
function ttfmake_get_standard_fonts() {
	/**
	 * Allow for developers to modify the standard fonts.
	 *
	 * @since 1.2.3.
	 *
	 * @param array    $fonts    The list of standard fonts.
	 */
	return apply_filters( 'make_get_standard_fonts', array(
		'serif' => array(
			'label' => _x( 'Serif', 'font style', 'make' ),
			'stack' => 'Georgia,Times,"Times New Roman",serif'
		),
		'sans-serif' => array(
			'label' => _x( 'Sans Serif', 'font style', 'make' ),
			'stack' => '"Helvetica Neue",Helvetica,Arial,sans-serif'
		),
		'monospace' => array(
			'label' => _x( 'Monospaced', 'font style', 'make' ),
			'stack' => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace'
		)
	) );
}
endif;

if ( ! function_exists( 'ttfmake_get_google_font_uri' ) ) :
/**
 * Build the HTTP request URL for Google Fonts.
 *
 * @since  1.0.0.
 *
 * @return string    The URL for including Google Fonts.
 */
function ttfmake_get_google_font_uri() {
	// Grab the font choices
	if ( ttfmake_customizer_supports_panels() ) {
		$all_keys = array_keys( ttfmake_option_defaults() );
		$font_keys = array();
		foreach ( $all_keys as $key ) {
			if ( false !== strpos( $key, 'font-family-' ) ) {
				$font_keys[] = $key;
			}
		}
	} else {
		$font_keys = array(
			'font-site-title',
			'font-header',
			'font-body',
		);
	}
	$fonts = array();
	foreach ( $font_keys as $key ) {
		$fonts[] = get_theme_mod( $key, ttfmake_get_default( $key ) );
	}

	// De-dupe the fonts
	$fonts         = array_unique( $fonts );
	$allowed_fonts = ttfmake_get_google_fonts();
	$family        = array();

	// Validate each font and convert to URL format
	foreach ( $fonts as $font ) {
		$font = trim( $font );

		// Verify that the font exists
		if ( array_key_exists( $font, $allowed_fonts ) ) {
			// Build the family name and variant string (e.g., "Open+Sans:regular,italic,700")
			$family[] = urlencode( $font . ':' . join( ',', ttfmake_choose_google_font_variants( $font, $allowed_fonts[ $font ]['variants'] ) ) );
		}
	}

	// Convert from array to string
	if ( empty( $family ) ) {
		return '';
	} else {
		$request = '//fonts.googleapis.com/css?family=' . implode( '|', $family );
	}

	// Load the font subset
	$subset = get_theme_mod( 'font-subset', ttfmake_get_default( 'font-subset' ) );

	if ( 'all' === $subset ) {
		$subsets_available = ttfmake_get_google_font_subsets();

		// Remove the all set
		unset( $subsets_available['all'] );

		// Build the array
		$subsets = array_keys( $subsets_available );
	} else {
		$subsets = array(
			'latin',
			$subset,
		);
	}

	// Append the subset string
	if ( ! empty( $subsets ) ) {
		$request .= urlencode( '&subset=' . join( ',', $subsets ) );
	}

	/**
	 * Filter the Google Fonts URL.
	 *
	 * @since 1.2.3.
	 *
	 * @param string    $url    The URL to retrieve the Google Fonts.
	 */
	return apply_filters( 'make_get_google_font_uri', esc_url( $request ) );
}
endif;

if ( ! function_exists( 'ttfmake_choose_google_font_variants' ) ) :
/**
 * Given a font, chose the variants to load for the theme.
 *
 * Attempts to load regular, italic, and 700. If regular is not found, the first variant in the family is chosen. italic
 * and 700 are only loaded if found. No fallbacks are loaded for those fonts.
 *
 * @since  1.0.0.
 *
 * @param  string    $font        The font to load variants for.
 * @param  array     $variants    The variants for the font.
 * @return array                  The chosen variants.
 */
function ttfmake_choose_google_font_variants( $font, $variants = array() ) {
	$chosen_variants = array();
	if ( empty( $variants ) ) {
		$fonts = ttfmake_get_google_fonts();

		if ( array_key_exists( $font, $fonts ) ) {
			$variants = $fonts[ $font ]['variants'];
		}
	}

	// If a "regular" variant is not found, get the first variant
	if ( ! in_array( 'regular', $variants ) ) {
		$chosen_variants[] = $variants[0];
	} else {
		$chosen_variants[] = 'regular';
	}

	// Only add "italic" if it exists
	if ( in_array( 'italic', $variants ) ) {
		$chosen_variants[] = 'italic';
	}

	// Only add "700" if it exists
	if ( in_array( '700', $variants ) ) {
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
	return apply_filters( 'make_font_variants', array_unique( $chosen_variants ), $font, $variants );
}
endif;

if ( ! function_exists( 'ttfmake_get_google_font_subsets' ) ) :
/**
 * Retrieve the list of available Google font subsets.
 *
 * @since  1.0.0.
 *
 * @return array    The available subsets.
 */
function ttfmake_get_google_font_subsets() {
	/**
	 * Filter the list of supported Google Font subsets.
	 *
	 * @since 1.2.3.
	 *
	 * @param array    $subsets    The list of subsets.
	 */
	return apply_filters( 'make_get_google_font_subsets', array(
		'all'          => __( 'All', 'make' ),
		'cyrillic'     => __( 'Cyrillic', 'make' ),
		'cyrillic-ext' => __( 'Cyrillic Extended', 'make' ),
		'devanagari'   => __( 'Devanagari', 'make' ),
		'greek'        => __( 'Greek', 'make' ),
		'greek-ext'    => __( 'Greek Extended', 'make' ),
		'khmer'        => __( 'Khmer', 'make' ),
		'latin'        => __( 'Latin', 'make' ),
		'latin-ext'    => __( 'Latin Extended', 'make' ),
		'telugu'       => __( 'Telugu', 'make' ),
		'vietnamese'   => __( 'Vietnamese', 'make' ),
	) );
}
endif;

if ( ! function_exists( 'ttfmake_sanitize_font_subset' ) ) :
/**
 * Sanitize the Character Subset choice.
 *
 * @since  1.0.0
 *
 * @param  string    $value    The value to sanitize.
 * @return array               The sanitized value.
 */
function ttfmake_sanitize_font_subset( $value ) {
	if ( ! array_key_exists( $value, ttfmake_get_google_font_subsets() ) ) {
		$value = ttfmake_get_default( 'font-subset' );
	}

	/**
	 * Filter the sanitized subset choice.
	 *
	 * @since 1.2.3.
	 *
	 * @param string    $value    The chosen subset value.
	 */
	return apply_filters( 'make_sanitize_font_subset', $value );
}
endif;

if ( ! function_exists( 'ttfmake_all_font_choices' ) ) :
/**
 * Packages the font choices into value/label pairs for use with the customizer.
 *
 * @since  1.0.0.
 *
 * @return array    The fonts in value/label pairs.
 */
function ttfmake_all_font_choices() {
	$fonts   = ttfmake_get_all_fonts();
	$choices = array();

	// Repackage the fonts into value/label pairs
	foreach ( $fonts as $key => $font ) {
		$choices[ $key ] = $font['label'];
	}

	/**
	 * Allow for developers to modify the full list of fonts.
	 *
	 * @since 1.2.3.
	 *
	 * @param array    $choices    The list of all fonts.
	 */
	return apply_filters( 'make_all_font_choices', $choices );
}
endif;

if ( ! function_exists( 'ttfmake_all_font_choices_js' ) ) :
/**
 * Compile the font choices for better handling as a JSON object
 *
 * @since 1.3.0.
 *
 * @return array
 */
function ttfmake_all_font_choices_js() {
	$fonts   = ttfmake_get_all_fonts();
	$choices = array();

	// Repackage the fonts into value/label pairs
	foreach ( $fonts as $key => $font ) {
		$choices[] = array( 'k' => $key, 'l' => $font['label'] );
	}

	return $choices;
}
endif;

if ( ! function_exists( 'ttfmake_sanitize_font_choice' ) ) :
/**
 * Sanitize a font choice.
 *
 * @since  1.0.0.
 *
 * @param  string    $value    The font choice.
 * @return string              The sanitized font choice.
 */
function ttfmake_sanitize_font_choice( $value ) {
	if ( ! is_string( $value ) ) {
		// The array key is not a string, so the chosen option is not a real choice
		return '';
	} else if ( array_key_exists( $value, ttfmake_all_font_choices() ) ) {
		return $value;
	} else {
		return '';
	}

	/**
	 * Filter the sanitized font choice.
	 *
	 * @since 1.2.3.
	 *
	 * @param string    $value    The chosen font value.
	 */
	return apply_filters( 'make_sanitize_font_choice', $return );
}
endif;

if ( ! function_exists( 'ttfmake_get_all_fonts' ) ) :
/**
 * Compile font options from different sources.
 *
 * @since  1.0.0.
 *
 * @return array    All available fonts.
 */
function ttfmake_get_all_fonts() {
	$heading1       = array( 1 => array( 'label' => sprintf( '--- %s ---', __( 'Standard Fonts', 'make' ) ) ) );
	$standard_fonts = ttfmake_get_standard_fonts();
	$heading2       = array( 2 => array( 'label' => sprintf( '--- %s ---', __( 'Google Fonts', 'make' ) ) ) );
	$google_fonts   = ttfmake_get_google_fonts();

	/**
	 * Allow for developers to modify the full list of fonts.
	 *
	 * @since 1.2.3.
	 *
	 * @param array    $fonts    The list of all fonts.
	 */
	return apply_filters( 'make_all_fonts', array_merge( $heading1, $standard_fonts, $heading2, $google_fonts ) );
}
endif;
