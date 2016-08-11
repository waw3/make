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
		'choices'     => array(),
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

	/**
	 * Render an input that will become a color picker in the UI.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $control_id
	 * @param array  $args
	 *
	 * @return $this
	 */
	protected function render_colorpicker( $control_id, array $args ) {
		$input_args = array(
			'attributes' => array(
				'data' => array(
					'control-type' => 'colorpicker',
				),
			),
		);

		$input_args = array_merge_recursive( $input_args, $args );

		// Begin output
		$this->render( 'input', $control_id, $input_args );

		return $this;
	}


	protected function render_uploader( $control_id, array $args ) {

	}

	/**
	 * Render a select.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $control_id
	 * @param array  $args
	 *
	 * @return $this
	 */
	protected function render_select( $control_id, array $args ) {
		// Bail if there are no choices
		if ( empty( $args['choices'] ) ) {
			return $this;
		}

		$setting = $args['setting'];

		$select_atts = new MAKE_Util_HTMLAttributes( array(
			'id'    => $control_id . '-{{ data.id }}',
			'class' => array(
				'make-select',
				'make-select-' . $control_id,
			),
			'data'  => array(
				'control-type' => 'select',
				'control-id'   => $control_id,
			),
		) );

		if ( $setting ) {
			$select_atts->add_data( 'setting', $setting );
		}

		// Other attributes
		$select_atts->add( $args['attributes'] );

		// Label
		$label = '';
		if ( $args['label'] ) {
			$label = '<label for="' . $control_id . '-{{ data.id }}">' . esc_html( $args['label'] ) . '</label>';
		}

		// Description
		$description = '';
		if ( $args['description'] ) {
			$description = '<div class="make-select-description">' . $args['description'] . '</div>';
		}

		// Begin output
		?>
		<?php echo $label; ?>
		<select<?php echo $select_atts->render(); ?>>
		<?php foreach ( $args['choices'] as $value => $label ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>" selected="<# if (<?php echo esc_attr( $value ); ?> == data.<?php echo esc_attr( $setting ); ?>) { #>selected<# } #>"><?php echo esc_html( $label ); ?></option>
		<?php endforeach; ?>
		</select>
		<?php echo $description; ?>
	<?php

		return $this;
	}


	protected function render_textarea( $control_id, array $args ) {
		$setting = $args['setting'];

		$textarea_atts = new MAKE_Util_HTMLAttributes( array(
			'id'    => $control_id . '-{{ data.id }}',
			'class' => array(
				'make-textarea',
				'make-textarea-' . $control_id,
			),
			'data'  => array(
				'control-type' => 'textarea',
				'control-id'   => $control_id,
			),
		) );

		if ( $setting ) {
			$textarea_atts->add_data( 'setting', $setting );
		}

		// Other attributes
		$textarea_atts->add( $args['attributes'] );

		// Begin output
		?>
		<textarea<?php echo $textarea_atts->render(); ?>>
			{{{ data.<?php echo esc_js( $setting ); ?> }}}
		</textarea>
	<?php

		return $this;
	}
}