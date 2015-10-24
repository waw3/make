<?php
/**
 * @package Make
 */


abstract class MAKE_Font_Source_Base implements MAKE_Font_Source_FontSourceInterface {

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