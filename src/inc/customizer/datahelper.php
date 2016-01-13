<?php
/**
 * @package Make
 */


final class MAKE_Customizer_DataHelper extends MAKE_Util_Modules {
	/**
	 * Inject dependencies.
	 *
	 * @since x.x.x.
	 *
	 * @param MAKE_Compatibility_MethodsInterface $compatibility
	 * @param MAKE_Font_ManagerInterface          $font
	 * @param MAKE_Settings_ThemeModInterface     $thememod
	 */
	public function __construct(
		MAKE_Compatibility_MethodsInterface $compatibility,
		MAKE_Font_ManagerInterface $font,
		MAKE_Settings_ThemeModInterface $thememod
	) {
		// Compatibility
		$this->add_module( 'compatibility', $compatibility );

		// Fonts
		$this->add_module( 'font', $font );

		// Theme mods
		$this->add_module( 'thememod', $thememod );
	}


	public function get_typography_group_definitions( $element, $label, $description = '' ) {
		// Check for deprecated filter
		foreach ( array( 'make_customizer_typography_group_definitions' ) as $filter ) {
			if ( has_filter( $filter ) ) {
				$this->compatibility()->deprecated_hook(
					$filter,
					'1.7.0',
					__( 'To add or modify Customizer sections and controls, use the make_customizer_sections hook instead, or the core $wp_customize methods.', 'make' )
				);
			}
		}

		$font_value = $this->thememod()->get_value( 'font-family-' . $element );
		$font_choices = $this->font()->get_font_choices( null, false );
		$font_label = isset( $font_choices[ $font_value ] ) ? $font_choices[ $font_value ] : '';

		$group_title = '<h4 class="make-group-title">' . esc_html( $label ) . '</h4>';
		if ( $description ) {
			$group_title .= '<span class="description customize-control-description">' . $description . '</span>';
		}

		return array(
			'typography-group-' . $element => array(
				'control' => array(
					'control_type' => 'MAKE_Customizer_Control_Html',
					'html'  => $group_title,
				),
			),
			'font-family-' . $element   => array(
				'setting' => true,
				'control' => array(
					'label'   => __( 'Font Family', 'make' ),
					'type'    => 'select',
					'choices' => array( $font_value => $font_label ),
				),
			),
			'font-style-' . $element => array(
				'setting' => true,
				'control' => array(
					'control_type' => 'MAKE_Customizer_Control_Radio',
					'label'   => __( 'Font Style', 'make' ),
					'type'  => 'radio',
					'mode'  => 'buttonset',
					'choices' => $this->thememod()->get_choice_set( 'font-style-' . $element ),
				),
			),
			'font-weight-' . $element => array(
				'setting' => true,
				'control' => array(
					'control_type' => 'MAKE_Customizer_Control_Radio',
					'label'   => __( 'Font Weight', 'make' ),
					'type'  => 'radio',
					'mode'  => 'buttonset',
					'choices' => $this->thememod()->get_choice_set( 'font-weight-' . $element ),
				),
			),
			'font-size-' . $element     => array(
				'setting' => true,
				'control' => array(
					'control_type' => 'MAKE_Customizer_Control_Range',
					'label'   => __( 'Font Size (px)', 'make' ),
					'type'  => 'range',
					'input_attrs' => array(
						'min'  => 6,
						'max'  => 100,
						'step' => 1,
					),
				),
			),
			'text-transform-' . $element => array(
				'setting' => true,
				'control' => array(
					'control_type' => 'MAKE_Customizer_Control_Radio',
					'label'   => __( 'Text Transform', 'make' ),
					'type'  => 'radio',
					'mode'  => 'buttonset',
					'choices' => $this->thememod()->get_choice_set( 'text-transform-' . $element ),
				),
			),
			'line-height-' . $element     => array(
				'setting' => true,
				'control' => array(
					'control_type' => 'MAKE_Customizer_Control_Range',
					'label'   => __( 'Line Height (em)', 'make' ),
					'type'  => 'range',
					'input_attrs' => array(
						'min'  => 0,
						'max'  => 5,
						'step' => 0.1,
					),
				),
			),
			'letter-spacing-' . $element     => array(
				'setting' => true,
				'control' => array(
					'control_type' => 'MAKE_Customizer_Control_Range',
					'label'   => __( 'Letter Spacing (px)', 'make' ),
					'type'  => 'range',
					'input_attrs' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.5,
					),
				),
			),
			'word-spacing-' . $element     => array(
				'setting' => true,
				'control' => array(
					'control_type' => 'MAKE_Customizer_Control_Range',
					'label'   => __( 'Word Spacing (px)', 'make' ),
					'type'  => 'range',
					'input_attrs' => array(
						'min'  => 0,
						'max'  => 20,
						'step' => 1,
					),
				),
			),
			'link-underline-' . $element => array(
				'setting' => true,
				'control' => array(
					'control_type' => 'MAKE_Customizer_Control_Radio',
					'label'   => __( 'Link Underline', 'make' ),
					'type'  => 'radio',
					'mode'  => 'buttonset',
					'choices' => $this->thememod()->get_choice_set( 'link-underline-' . $element ),
				),
			),
		);
	}
}