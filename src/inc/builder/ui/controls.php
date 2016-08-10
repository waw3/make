<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Builder_UI_Controls
 *
 * Methods for rendering controls in the Builder UI.
 *
 * @since 1.8.0.
 */
class MAKE_Builder_UI_Controls extends MAKE_Builder_UI_Base {
	/**
	 * Default args that will be parsed into the $args parameter when a render method is called.
	 *
	 * @since 1.8.0.
	 *
	 * @var array
	 */
	protected $default_args = array(
		'label'       => '',
		'description' => '',
		'attributes'  => array(),
		'input_type'  => 'text',
		'setting'     => false,
	);

	/**
	 * Render an HTML input element with optional label and description.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $control_id
	 * @param array  $args
	 *
	 * @return $this
	 */
	protected function render_input( $control_id, array $args ) {
		$setting = $args['setting'];

		// Input attributes
		$input_atts = new MAKE_Util_HTMLAttributes( array(
			'id'    => $control_id . '-{{ data.id }}',
			'class' => array(
				'make-input',
				'make-input-' . $control_id,
			),
			'data'  => array(
				'control-type' => 'input',
				'control-id'   => $control_id,
			),
			'type'  => $args['input_type'],
			'value' => ( $setting ) ? '{{ data.' . $setting . ' }}' : '',
		) );

		if ( $setting ) {
			$input_atts->add_data( 'setting', $setting );
		}

		// Other attributes
		$input_atts->add( $args['attributes'] );

		// Label
		$label = '';
		if ( $args['label'] ) {
			$label = '<label for="' . $control_id . '-{{ data.id }}">' . esc_html( $args['label'] ) . '</label>';
		}

		// Description
		$description = '';
		if ( $args['description'] ) {
			$description = '<div class="make-input-description">' . $args['description'] . '</div>';
		}

		// Begin output
		?>
		<?php echo $label; ?>
		<input<?php echo $input_atts->render(); ?> />
		<?php echo $description; ?>
	<?php

		return $this;
	}

	/**
	 * Render a checkbox input.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $control_id
	 * @param array  $args
	 *
	 * @return $this
	 */
	protected function render_checkbox( $control_id, array $args ) {
		$input_args = array(
			'attributes' => array(
				'data' => array(
					'control-type' => 'checkbox',
				),
			),
			'input_type' => 'checkbox'
		);

		// Checked
		if ( $args['setting'] ) {
			$input_args['attributes']['checked'] = '<# if (true == data.' . $args['setting'] . ') { #>checked<# } #>';
		}

		$input_args = array_merge_recursive( $input_args, $args );

		// Begin output
		$this->render( 'input', $control_id, $input_args );

		return $this;
	}

	/**
	 * Render a hidden input.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $control_id
	 * @param array  $args
	 *
	 * @return $this
	 */
	protected function render_hidden( $control_id, array $args ) {
		$input_args = array(
			'attributes' => array(
				'data' => array(
					'control-type' => 'hidden',
				),
			),
			'input_type' => 'hidden'
		);

		$input_args = array_merge_recursive( $input_args, $args );

		// Begin output
		$this->render( 'input', $control_id, $input_args );

		return $this;
	}


	protected function render_select( $control_id, array $args ) {

	}


	protected function render_textarea( $control_id, array $args ) {

	}


	protected function render_colorpicker( $control_id, array $args ) {

	}


	protected function render_uploader( $control_id, array $args ) {

	}
}