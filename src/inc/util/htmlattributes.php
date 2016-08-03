<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Util_HTMLAttributes
 *
 * Utility to handle HTML attribute name/value pairs as structured data and render them for use in valid HTML.
 *
 * @since 1.8.0.
 */
class MAKE_Util_HTMLAttributes {
	/**
	 * Attribute name/value storage.
	 *
	 * @since 1.8.0.
	 *
	 * @var array
	 */
	protected $attributes = array();

	/**
	 * MAKE_Util_HTMLAttributes constructor.
	 *
	 * @since 1.8.0.
	 *
	 * @param array $attributes
	 */
	public function __construct( array $attributes = array() ) {
		return $this->add( $attributes );
	}

	/**
	 * Add an attribute to storage.
	 *
	 * If the attribute name is `class`, `style`, `data`, or begins with `data-`, this will attempt to merge the new value with
	 * any existing values. For all other attribute names, this will replace any existing value.
	 *
	 * Note that attributes prefixed with `data-` are stored in a `data` sub array with names that don't have the prefix.
	 *
	 * @since 1.8.0.
	 *
	 * @param string       $name     The attribute name.
	 * @param string|array $value    The attribute value.
	 *
	 * @return $this    Make the method chainable.
	 */
	public function add_one( $name, $value ) {
		switch ( true ) {
			case 'class' === $name :
				$this->initialize_att( 'class' );
				$value = explode( ' ', $value );
				if ( $value ) {
					$value = array_map( 'strval', $value );
					$value = array_map( 'trim', $value );
					$this->attributes['class'] = array_merge( $this->attributes['class'], $value );
					$this->attributes['class'] = array_unique( $this->attributes['class'] );
				}
				break;

			case 'style' === $name :
				$this->initialize_att( 'style' );
				$this->attributes['style'] = array_merge_recursive( $this->attributes['style'], $this->parse_style( $value ) );
				break;

			case 'data' === $name :
				if ( is_array( $value ) ) {
					$this->initialize_att( 'data' );
					$keys = array_map( array( $this, 'trim_data_name' ), array_keys( $value ) );
					$value = array_map( 'strval', $value );
					$this->attributes['data'] = array_merge_recursive( $this->attributes['data'], array_combine( $keys, $value ) );
				}
				break;

			case preg_match( '/^data\-/', $name ) :
				$this->initialize_att( 'data' );
				$this->add_data( $name, $value );
				break;

			case is_string( $name ) :
				$this->attributes[ $name ] = strval( $value );
				break;
		}

		return $this;
	}

	/**
	 * Add a data attribute to storage.
	 *
	 * This is a convenience method for handling a data attribute.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $name     The attribute name, with or without the `data-` prefix.
	 * @param string $value    The attribute value.
	 *
	 * @return $this    Make the method chainable.
	 */
	public function add_data( $name, $value ) {
		return $this->add_one( 'data', array( $name => $value ) );
	}

	/**
	 * Add multiple attributes at once.
	 *
	 * @uses add_one()
	 *
	 * @since 1.8.0.
	 *
	 * @param array $attributes    An associative array of name => value pairs.
	 *
	 * @return $this    Make the method chainable.
	 */
	public function add( array $attributes ) {
		foreach ( $attributes as $name => $value ) {
			$this->add_one( $name, $value );
		}

		return $this;
	}

	/**
	 * Ensure an attribute name exists in storage and contains an appropriate initial value.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $name     The attribute name.
	 * @param bool   $array    True if the initial value should be an array.
	 *
	 * @return $this    Make the method chainable.
	 */
	protected function initialize_att( $name, $array = true ) {
		if ( ! $this->has_att( $name ) ) {
			if ( $array ) {
				$this->attributes[ $name ] = array();
			} else {
				$this->attributes[ $name ] = '';
			}
		}

		return $this;
	}

	/**
	 * Take a string or array and convert it into an associative array of style components.
	 *
	 * Example:
	 *
	 *     font-size: 12px; font-weight: bold;
	 *
	 *     becomes
	 *
	 *     array(
	 *         'font-size'   => '12px',
	 *         'font-weight' => 'bold',
	 *     )
	 *
	 * @uses parse_rule()
	 *
	 * @since 1.8.0.
	 *
	 * @param string|array $style
	 *
	 * @return array
	 */
	public function parse_style( $style ) {
		$parsed_style = array();

		// Handle an associative array of style components or a numerical array of rules
		if ( is_array( $style ) ) {
			foreach ( $style as $key => $value ) {
				// Array item is already split into declaration => value
				if ( is_string( $key ) ) {
					$parsed_style[ $key ] = strval( $value );
				}
				// Array item is probably a full rule, i.e. font-weight: bold;
				else {
					$split = $this->parse_rule( $value );

					if ( $split ) {
						$parsed_style = array_merge( $parsed_style, $split );
					}
				}
			}
		}
		// Handle a string containing one or more rules.
		else {
			$rules = explode( ';', $style );
			foreach ( $rules as $rule ) {
				$split = $this->parse_rule( $rule );

				if ( $split ) {
					$parsed_style = array_merge( $parsed_style, $split );
				}
			}
		}

		return $parsed_style;
	}

	/**
	 * Take a style rule string and convert it into a one-item associative array of style components.
	 *
	 *     Example:
	 *
	 *     font-size: 12px;
	 *
	 *     becomes
	 *
	 *     array(
	 *         'font-size' => '12px'
	 *     )
	 *
	 * @since 1.8.0.
	 *
	 * @param string $rule    The style rule to parse.
	 *
	 * @return array|bool     An associative array of style components, or false if the string doesn't look like a style rule.
	 */
	protected function parse_rule( $rule ) {
		$split = array_map( 'trim', explode( ':', $rule, 2 ) );

		if ( 2 === count( $split ) ) {
			return array( $split[0] => str_replace( ';', '', $split[1] ) );
		} else {
			return false;
		}
	}

	/**
	 * Convenience method to remove the `data-` prefix from an attribute name.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $name    The attribute name.
	 *
	 * @return string    The attribute name without a `data-` prefix.
	 */
	protected function trim_data_name( $name ) {
		return preg_replace( '/^data\-/', '', $name );
	}

	/**
	 * Remove all data from the attribute storage.
	 *
	 * @since 1.8.0.
	 *
	 * @return $this    Make the method chainable.
	 */
	public function remove_all() {
		$this->attributes = array();

		return $this;
	}

	/**
	 * Remove the specified attribute from attribute storage.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $name    The attribute name.
	 *
	 * @return $this    Make the method chainable.
	 */
	public function remove_att( $name ) {
		if ( $this->has_att( $name ) ) {
			unset( $this->attributes[ $name ] );
		}

		return $this;
	}

	/**
	 * Remove the specified data attribute from the data sub array in attribute storage.
	 *
	 * If the $name parameter is not specified, the entire data sub array will be removed.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $name    The attribute name, with or without the `data-` prefix.
	 *
	 * @return $this    Make the method chainable.
	 */
	public function remove_data( $name = '' ) {
		if ( ! $name ) {
			return $this->remove_att( 'data' );
		}

		$name = $this->trim_data_name( $name );

		if ( $this->has_data( $name ) ) {
			unset( $this->attributes['data'][ $name ] );
		}

		return $this;
	}

	/**
	 * Remove a specific value from the specified attribute in attribute storage.
	 *
	 * For the `class` attribute, $value will be removed from the numeric array.
	 * For the `style` attribute, the item in the associative array with the $value key will be removed.
	 * For an attribute name prefixed with `data-`, the item in the data sub array with the non-prefixed $name key will be removed.
	 * For all other attributes, the entire attribute will be removed from attribute storage.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $name     The attribute name.
	 * @param string $value    The value to remove.
	 *
	 * @return $this    Make the method chainable.
	 */
	public function remove_one( $name, $value = '' ) {
		if ( $this->has_att( $name ) ) {
			switch ( true ) {
				case 'class' === $name && $value :
					if ( $key = array_search( $value, $this->get_att( 'class' ) ) ) {
						unset( $this->attributes['class'][ $key ] );
					}
					break;

				case 'style' === $name && $value :
					if ( isset( $this->attributes['style'][ $value ] ) ) {
						unset( $this->attributes['style'][ $value ] );
					}
					break;

				case preg_match( '/^data\-/', $name ) :
					$this->remove_data( $name );
					break;

				default :
					$this->remove_att( $name );
					break;
			}
		}

		return $this;
	}

	/**
	 * Get the array of attribute name/value pairs from storage.
	 *
	 * @since 1.8.0.
	 *
	 * @return array
	 */
	public function get() {
		return $this->attributes;
	}

	/**
	 * Get a particular attribute from storage.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $name    The attribute name.
	 *
	 * @return string|array|bool    False if the attribute doesn't exist in storage.
	 */
	public function get_att( $name ) {
		if ( $this->has_att( $name ) ) {
			return $this->attributes[ $name ];
		}

		return false;
	}

	/**
	 * Get a particular data attribute from storage.
	 *
	 * If the attribute name is not specified, the whole data sub array will be returned.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $name    The attribute name, with or without the `data-` prefix.
	 *
	 * @return string|array|bool    False if the data attribute doesn't exist in storage.
	 */
	public function get_data( $name = '' ) {
		if ( ! $name ) {
			return $this->get_att( 'data' );
		}

		$name = $this->trim_data_name( $name );

		if ( $this->has_data( $name ) ) {
			return $this->attributes['data'][ $name ];
		}

		return false;
	}

	/**
	 * Check to see if an attribute exists in storage.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $name    The attribute name.
	 *
	 * @return bool
	 */
	public function has_att( $name ) {
		return isset( $this->attributes[ $name ] );
	}

	/**
	 * Check to see if a data attribute exists in storage.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $name    The attribute name, with or without the `data-` prefix.
	 *
	 * @return bool
	 */
	public function has_data( $name ) {
		if ( isset( $this->attributes['data'] ) ) {
			$name = $this->trim_data_name( $name );

			return isset( $this->attributes['data'][ $name ] );
		}

		return false;
	}

	/**
	 * Retrieve an attribute name/value pair from storage and render it into an HTML attribute string.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $name    The attribute name.
	 *
	 * @return string
	 */
	public function render_att( $name ) {
		$value = '';

		// Data attribute
		if ( preg_match( '/^data\-/', $name ) ) {
			if ( $this->has_data( $name ) ) {
				$value = $this->get_data( $name );
			}
		}
		// Other attribute
		else if ( $this->has_att( $name ) ) {
			$att = $this->get_att( $name );

			switch ( true ) {
				case 'class' === $name :
					$value = implode( ' ', $att );
					break;

				case 'style' === $name :
					$rules = array();
					foreach ( $att as $declaration => $val ) {
						$rules[] = "$declaration: $val";
					}
					$value = implode( '; ', $rules ) . ';';
					break;

				case 'data' === $name :
					return $this->render_data();
					break;

				default :
					$value = $att;
					break;
			}
		}

		if ( $value ) {
			return $name . '="' . $value . '"';
		}

		return '';
	}

	/**
	 * Retrieve a data attribute name/value pair from storage and render it into an HTML attribute string.
	 *
	 * If the attribute name isn't specified, all data attributes will be rendered as one string.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $name    The attribute name, with or without the `data-` prefix.
	 *
	 * @return string
	 */
	public function render_data( $name = '' ) {
		if ( ! $name ) {
			$rendered_atts = array();

			foreach ( array_keys( $this->get_data() ) as $dname ) {
				$rendered_atts[] = $this->render_att( 'data-' . $dname );
			}

			return implode( ' ', $rendered_atts );
		}

		if ( ! preg_match( '/^data\-/', $name ) ) {
			$name = 'data-' . $name;
		}

		return $this->render_att( $name );
	}

	/**
	 * Take all attribute name/value pairs from storage and render them into a string of HTML attributes.
	 *
	 * @since 1.8.0.
	 *
	 * @return string
	 */
	public function render() {
		$rendered_atts = array();

		foreach ( array_keys( $this->get() ) as $name ) {
			$rendered_atts[] = $this->render_att( $name );
		}

		return implode( ' ', $rendered_atts );
	}
}