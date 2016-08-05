<?php
/**
 * @package Make
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
		'setting' => false,
	);


	public function render_hidden( $control_id, $args ) {
		$setting = $args['setting'];

		// Input attributes
		$input_atts = new MAKE_Util_HTMLAttributes( array(
			'class' => array(
				'make-input',
				'make-input-' . $control_id,
			),
			'data'  => array(
				'type'       => 'hidden',
				'control-id' => $control_id,
			),
			'type'  => 'hidden',
			'value' => ( $setting ) ? '{{ data.' . $setting . ' }}' : '',
		) );

		if ( $setting ) {
			$input_atts->add_data( 'setting', $setting );
		}

		// Other attributes
		$input_atts->add( $args['attributes'] );

		// Begin output
		?>
		<input<?php echo $input_atts->render(); ?> />
	<?php
	}



}