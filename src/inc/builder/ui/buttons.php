<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Builder_UI_Buttons
 *
 * Methods for rendering buttons in the Builder UI.
 *
 * @since 1.8.0.
 */
class MAKE_Builder_UI_Buttons {
	/**
	 * Render a section button.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $button_id
	 * @param array  $args
	 *
	 * @return string
	 */
	public function render_button( $button_id, array $args = array() ) {
		$button_atts = new MAKE_Util_HTMLAttributes( array(
			'class' => array(
				'make-builder-section-button',
				'make-builder-section-button-' . $button_id,
			),
			'type'  => 'button'
		) );

		// Action
		if ( isset( $args['action'] ) ) {
			$button_atts->add_data( 'action', $args['action'] );
		}

		// Overlay
		if ( isset( $args['overlay'] ) ) {
			$button_atts->add_data( 'overlay', $args['overlay'] );
		}

		// Other attributes
		if ( isset( $args['atts'] ) ) {
			$button_atts->add( $args['atts'] );
		}

		// Begin rendering
		$output = '<button' . $button_atts->render() . '>';
		if ( isset( $args['label'] ) ){
			$output .= '<span class="screen-reader-text">' . esc_html( $args['label'] ) . '</span>';
		}
		$output .= '<span class="make-builder-section-button-icon" aria-hidden="true">' . esc_html( $args['label'] ) . '</span>';
		$output .= '</button>';

		return $output;
	}

	/**
	 * Render the section toggle button.
	 *
	 * @since 1.8.0.
	 *
	 * @param bool $open
	 *
	 * @return string
	 */
	public function render_section_toggle( $open = true ) {
		$button_atts = new MAKE_Util_HTMLAttributes( array(
			'class'         => array(
				'make-builder-section-toggle',
			),
			'type'          => 'button',
			'aria-expanded' => 'true',
		) );

		// State
		if ( ! $open ) {
			$button_atts->add_one( 'aria-expanded', 'false' );
		}

		// Begin rendering
		$output = '<button' . $button_atts->render() . '>';
		$output .= '<span class="screen-reader-text">' . esc_html__( 'Click to toggle section', 'make' ) . '</span>';
		$output .= '<span class="toggle-indicator" aria-hidden="true"></span>';
		$output .= '</button>';

		return $output;
	}
}