<?php
/**
 * @package Make
 */


final class MAKE_Font_Source_Generic extends MAKE_Font_Source_Base {

	public function __construct() {
		// Set the label
		$this->label = __( 'Generic Fonts', 'make' );

		// Set the font data
		$this->data = array(
			'serif' => array(
				'label' => __( 'Serif', 'make' ),
				'stack' => 'Georgia,Times,"Times New Roman",serif'
			),
			'sans-serif' => array(
				'label' => __( 'Sans Serif', 'make' ),
				'stack' => '"Helvetica Neue",Helvetica,Arial,sans-serif'
			),
			'monospace' => array(
				'label' => __( 'Monospaced', 'make' ),
				'stack' => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace'
			)
		);
	}
}