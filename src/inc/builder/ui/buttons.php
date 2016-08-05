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
		'label'      => '',
		'action'     => false,
		'overlay'    => false,
		'open'       => true,
		'attributes' => array(),
	);

	/**
	 * Render a section button.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $button_id
	 * @param array  $args
	 *
	 * @return void
	 */
	public function render_sectionbutton( $button_id, array $args ) {
		$button_atts = new MAKE_Util_HTMLAttributes( array(
			'class' => array(
				'make-sectionbutton',
				'make-sectionbutton-' . $button_id,
			),
			'data'  => array(
				'type'      => 'sectionbutton',
				'button-id' => $button_id,
			),
			'type'  => 'button'
		) );

		// Action
		if ( $args['action'] ) {
			$button_atts->add_data( 'action', $args['action'] );
		}

		// Overlay
		if ( $args['overlay'] ) {
			$button_atts->add_data( 'overlay', $args['overlay'] );
		}

		// Other attributes
		$button_atts->add( $args['attributes'] );

		// Begin output
		?>
		<button<?php echo $button_atts->render(); ?>>
			<span class="screen-reader-text"><?php echo esc_html( $args['label'] ); ?></span>
			<span class="make-sectionbutton-icon" aria-hidden="true"></span>
		</button>
	<?php
	}

	/**
	 * Render a section toggle button.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $button_id
	 * @param array  $args
	 *
	 * @return void
	 */
	public function render_sectiontoggle( $button_id, array $args ) {
		$button_atts = new MAKE_Util_HTMLAttributes( array(
			'class'         => array(
				'make-sectiontoggle',
				'make-sectiontoggle-' . $button_id,
			),
			'data'          => array(
				'type'      => 'sectiontoggle',
				'button-id' => $button_id,
				'action'    => 'toggleSection',
			),
			'type'          => 'button',
			'aria-expanded' => 'true',
		) );

		// Label
		if ( ! $args['label'] ) {
			$args['label'] = esc_html__( 'Click to toggle section', 'make' );
		}

		// State
		if ( ! $args['open'] ) {
			$button_atts->add_one( 'aria-expanded', 'false' );
		}

		// Other attributes
		$button_atts->add( $args['attributes'] );

		// Begin output
		?>
		<button<?php echo $button_atts->render(); ?>>
			<span class="screen-reader-text"><?php echo esc_html( $args['label'] ); ?></span>
			<span class="toggle-indicator" aria-hidden="true"></span>
		</button>
	<?php
	}
}