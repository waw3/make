<?php
/**
 * @package Make
 */


final class MAKE_Font_Source_Generic extends MAKE_Font_Source_Base {
	/**
	 * An associative array of required modules.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'compatibility' => 'MAKE_Compatibility_MethodsInterface',
	);

	/**
	 * MAKE_Font_Source_Generic constructor.
	 *
	 * @since x.x.x.
	 *
	 * @param MAKE_APIInterface $api
	 * @param array             $modules
	 */
	public function __construct(
		MAKE_APIInterface $api,
		array $modules = array()
	) {
		// Load dependencies.
		parent::__construct( $api, $modules );

		// Set the ID.
		$this->id = 'generic';

		// Set the label.
		$this->label = __( 'Generic Fonts', 'make' );

		// Set the font data.
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

		// Check for deprecated filters
		if ( has_filter( 'make_get_standard_fonts' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_get_standard_fonts',
				'1.7.0',
				__( 'To add or modify Generic Fonts, use the make_font_data_generic hook instead.', 'make' )
			);

			$this->data = apply_filters( 'make_get_standard_fonts', $this->data );
		}
		if ( has_filter( 'make_all_fonts' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_all_fonts',
				'1.7.0',
				__( 'To add or modify fonts, use a hook for a specific font source instead, such as make_font_data_generic.', 'make' )
			);

			$this->data = apply_filters( 'make_all_fonts', $this->data );
		}
	}
}