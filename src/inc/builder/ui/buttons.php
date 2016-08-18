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
class MAKE_Builder_UI_Buttons extends MAKE_Builder_UI_Base {
	/**
	 * Default args that will be parsed into the $args parameter when a render method is called.
	 *
	 * @since 1.8.0.
	 *
	 * @var array
	 */
	protected $default_args = array(
		'icon'       => '',
		'label'      => '',
		'attributes' => array(),
		'action'     => false,
		'overlay'    => false,
		'open'       => true,
	);

	/**
	 * Render a button.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $button_id
	 * @param array  $args
	 *
	 * @return $this
	 */
	protected function render_button( $button_id, array $args ) {
		$button_atts = new MAKE_Util_HTMLAttributes( array(
			'class' => array(
				'make-button',
				'make-button-' . $button_id,
			),
			'data'  => array(
				'button-id' => $button_id,
			),
			'type'  => 'button'
		) );

		// Action
		if ( $args['action'] ) {
			$button_args['attributes']['data']['action'] = $args['action'];
		}

		// Overlay
		if ( $args['overlay'] ) {
			$button_args['attributes']['data']['overlay'] = $args['overlay'];

			// Default action for a button connected to an overlay
			if ( ! $args['action'] ) {
				$button_args['attributes']['data']['action'] = 'click:openOverlay';
			}
		}

		// Other attributes
		$button_atts->add( $args['attributes'] );

		// Icon
		$icon = '';
		if ( $args['icon'] ) {
			$icon_atts = new MAKE_Util_HTMLAttributes( array(
				'class'       => array(
					'make-button-icon',
				),
				'data'        => array(
					'icon' => $args['icon'],
				),
				'aria-hidden' => 'true'
			) );

			if ( isset( $args['icon_class'] ) ) {
				$icon_atts->add_class( $args['icon_class'] );
			}

			$icon = '<span' . $icon_atts->render() . '></span>';
		}

		// Label
		$label = '';
		if ( $args['label'] ) {
			$label_atts = new MAKE_Util_HTMLAttributes( array(
				'class' => array(
					'make-button-label',
				),
			) );

			if ( isset( $args['label_class'] ) ) {
				$label_atts->add_class( $args['label_class'] );
			}

			$label = '<span' . $label_atts->render() . '>' . esc_html( $args['label'] ) . '</span>';
		}

		// Begin output
		?>
		<button<?php echo $button_atts->render(); ?>>
			<?php echo $icon; ?><?php echo $label; ?>
		</button>
	<?php

		return $this;
	}

	/**
	 * Render a section button.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $button_id
	 * @param array  $args
	 *
	 * @return $this
	 */
	protected function render_sectionbutton( $button_id, array $args ) {
		// Initial attributes
		$button_atts = new MAKE_Util_HTMLAttributes( array(
			'class' => array(
				'make-button-sectionbutton',
			),
			'data'  => array(
				'button-type' => 'sectionbutton',
			),
		) );

		// Merge with submitted attributes
		$button_atts->add( $args['attributes'] );
		unset( $args['attributes'] );

		// Compile the args
		$button_args = wp_parse_args(
			array_diff_assoc( $args, $this->default_args ),
			array(
				'attributes'  => $button_atts,
				'label_class' => 'screen-reader-text',
			)
		);

		// Begin output
		$this->render( 'button', $button_id, $button_args );

		return $this;
	}

	/**
	 * Render a section toggle button.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $button_id
	 * @param array  $args
	 *
	 * @return $this
	 */
	protected function render_sectiontoggle( $button_id, array $args = array() ) {
		// Initial attributes
		$button_atts = new MAKE_Util_HTMLAttributes( array(
			'class'         => array(
				'make-button-sectiontoggle',
			),
			'data'          => array(
				'button-type' => 'sectiontoggle',
			),
			'aria-expanded' => 'true',
		) );

		// Merge with submitted attributes
		$button_atts->add( $args['attributes'] );
		unset( $args['attributes'] );

		// Compile the args
		$button_args = wp_parse_args(
			array_diff_assoc( $args, $this->default_args ),
			array(
				'icon'        => 'toggle-indicator',
				'label'       => esc_html__( 'Click to toggle section', 'make' ),
				'action'      => 'click:toggleSection',
				'attributes'  => $button_atts,
				'label_class' => 'screen-reader-text',
			)
		);

		// State
		if ( ! $args['open'] ) {
			$button_args['attributes']->add_one( 'aria-expanded', 'false' );
		}

		// Begin output
		$this->render( 'button', $button_id, $button_args );

		return $this;
	}

	/**
	 * Render a button for an overlay header.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $button_id
	 * @param array  $args
	 *
	 * @return $this
	 */
	protected function render_overlaybutton( $button_id, array $args = array() ) {
		// Initial attributes
		$button_atts = new MAKE_Util_HTMLAttributes( array(
			'class' => array(
				'make-button-overlaybutton',
			),
			'data'  => array(
				'button-type' => 'overlaybutton',
			),
		) );

		// Merge with submitted attributes
		$button_atts->add( $args['attributes'] );
		unset( $args['attributes'] );

		// Compile the args
		$button_args = wp_parse_args(
			array_diff_assoc( $args, $this->default_args ),
			array(
				'label'      => esc_html__( 'Done', 'make' ),
				'attributes' => $button_atts,
			)
		);

		// Begin output
		$this->render( 'button', $button_id, $button_args );

		return $this;
	}
}