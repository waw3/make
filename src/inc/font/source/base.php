<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Font_Source_Base
 *
 * @since x.x.x.
 */
abstract class MAKE_Font_Source_Base extends MAKE_Util_Modules implements MAKE_Font_Source_BaseInterface {

	protected $id = '';


	protected $label = '';


	protected $priority = 10;


	protected $data = array();


	public function get_label() {
		return $this->label;
	}


	public function get_priority() {
		return $this->priority;
	}


	public function get_font_data( $font = null ) {
		// Return data for a specific font.
		if ( ! is_null( $font ) ) {
			$data = array();

			if ( isset( $this->data[ $font ] ) ) {
				$data = $this->data[ $font ];
			}

			return $data;
		}

		/**
		 * Filter: Modify the font data from a particular source.
		 *
		 * @since x.x.x.
		 *
		 * @param array    $font_data
		 */
		return apply_filters( "make_font_data_{$this->id}", $this->data );
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