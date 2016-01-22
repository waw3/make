<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Style_DataHelper
 *
 * @since x.x.x.
 */
final class MAKE_Style_DataHelper extends MAKE_Util_Modules {
	/**
	 * An associative array of required modules.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'compatibility' => 'MAKE_Compatibility_MethodsInterface',
		'font'          => 'MAKE_Font_ManagerInterface',
		'thememod'      => 'MAKE_Settings_ThemeModInterface',
	);

	/**
	 * Cycle through the font options for the given element and collect an array
	 * of option values that are non-default.
	 *
	 * @since  1.3.0.
	 *
	 * @param  string    $element    The element to parse the options for.
	 * @param  bool      $force      True to include properties that have default values.
	 *
	 * @return array                 An array of non-default CSS declarations.
	 */
	public function parse_font_properties( $element, $force = false ) {
		// Font properties.
		$properties = array(
			'font-family',
			'font-size',
			'font-weight',
			'font-style',
			'text-transform',
			'line-height',
			'letter-spacing',
			'word-spacing',
		);

		// Check for deprecated filter.
		if ( has_filter( 'make_css_font_properties' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_css_font_properties',
				'1.7.0',
				__( 'To add dynamic CSS rules, hook into make_style_loaded instead.', 'make' )
			);
		}

		$declarations = array();

		foreach ( $properties as $property ) {
			$setting_id = $property . '-' . $element;

			if ( $this->thememod()->setting_exists( $setting_id ) ) {
				$sanitized_value = $this->thememod()->get_value( $setting_id, 'style' );

				if ( true === $force || ( ! $this->thememod()->is_default( $setting_id ) ) ) {
					switch ( $property ) {
						case 'font-family' :
							$declarations[ $property ] = $this->font()->get_font_stack( $sanitized_value );
							break;
						case 'font-size' :
							$declarations[ $property . '-px' ]  = $sanitized_value . 'px';
							$declarations[ $property . '-rem' ] = ttfmake_convert_px_to_rem( $sanitized_value ) . 'rem';
							break;
						case 'letter-spacing' :
						case 'word-spacing' :
							$declarations[ $property ] = $sanitized_value . 'px';
							break;
						default :
							$declarations[ $property ] = $sanitized_value;
							break;
					}
				}
			}
		}

		return $declarations;
	}

	/**
	 * Generate a CSS rule definition array for an element's link underline property.
	 *
	 * @since 1.5.0.
	 *
	 * @param  string    $element      The element to look up in the theme options.
	 * @param  array     $selectors    The base selectors to use for the rule.
	 *
	 * @return array                   A CSS rule definition array.
	 */
	public function parse_link_underline( $element, $selectors ) {
		$setting_id = 'link-underline-' . $element;
		$sanitized_value = $this->thememod()->get_value( $setting_id, 'style' );

		if ( ! $this->thememod()->is_default( $setting_id ) ) {
			// Declarations
			$declarations = array( 'text-decoration' => 'underline' );
			if ( 'never' === $sanitized_value ) {
				$declarations['text-decoration'] = 'none';
			}

			// Selectors
			$parsed_selectors = $selectors;
			if ( 'hover' === $sanitized_value ) {
				foreach ( $selectors as $key => $selector ) {
					$parsed_selectors[ $key ] = $selector . ':hover';
					$parsed_selectors[] = $selector . ':focus';
				}
			}

			// Return CSS rule array
			return array(
				'selectors' => $parsed_selectors,
				'declarations' => $declarations,
			);
		}

		return array();
	}

	/**
	 * Convert a hex string into a comma separated RGB string.
	 *
	 * @link http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
	 *
	 * @since 1.5.0.
	 *
	 * @param  $value
	 * @return bool|string
	 */
	public function hex_to_rgb( $value ) {
		$hex = sanitize_hex_color_no_hash( $value );

		if ( 6 === strlen( $hex ) ) {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		} else if ( 3 === strlen( $hex ) ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			return false;
		}

		return "$r, $g, $b";
	}

	/**
	 * Return the percentage to use when calculating certain font sizes.
	 *
	 * TODO stop using this.
	 *
	 * @since  1.3.0.
	 *
	 * @return array    The percentage value relative to another specific size
	 */
	public function get_relative_size( $key ) {
		/**
		 * Filter the array of relative font sizes.
		 *
		 * Each array item defines a percentage by which to scale a font size compared
		 * to some other font size. Most of these were deprecated in version 1.3.0.
		 *
		 * @since 1.0.0.
		 *
		 * @param array    $sizes    The array of relative sizes.
		 */
		$sizes = apply_filters( 'make_font_relative_size', array(
			// Relative to Header Bar icon size
			'header-bar-icon' => 85,
			'footer-icon'     => 85,
			// Relative to header font size
			'post-title'      => 74,
			// Relative to body font size
			'comments'        => 88,
			'comment-date'    => 82,
		) );

		if ( isset( $sizes[ $key ] ) ) {
			return $sizes[ $key ];
		}

		return 100;
	}

	/**
	 * Convert a font size to a relative size based on a starting value and percentage.
	 *
	 * @since  1.0.0.
	 *
	 * @param  mixed    $value         The value to base the final value on.
	 * @param  mixed    $percentage    The percentage of change.
	 *
	 * @return float                   The converted value.
	 */
	public function get_relative_font_size( $value, $percentage ) {
		return round( (float) $value * ( $percentage / 100 ) );
	}

	/**
	 * Given a px value, return a rem value.
	 *
	 * @since  1.0.0.
	 *
	 * @param  mixed    $px      The value to convert.
	 *
	 * @return float             The converted value.
	 */
	public function convert_px_to_rem( $px ) {
		return (float) $px / 10;
	}
}