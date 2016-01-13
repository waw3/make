<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Customizer_Control_Misc
 *
 * Control for adding arbitrary HTML to a Customizer section.
 *
 * This control has been deprecated in favor of MAKE_Customizer_Control_Html.
 *
 * @since 1.0.0.
 * @deprecated 1.7.0.
 */
class MAKE_Customizer_Control_Misc extends MAKE_Customizer_Control_Html {
	/**
	 * Convert the ID and args for use with MAKE_Customizer_Control_Html.
	 *
	 * @since x.x.x.
	 *
	 * @param WP_Customize_Manager $manager
	 * @param string               $id
	 * @param array                $args
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {
		parent::__construct( $manager, $id, $args );

		$type = $this->type;
		$this->type = 'make-html';

		switch ( $type ) {
			case 'group-title' :
				$this->html = '<h4 class="make-group-title">' . esc_html( $this->label ) . '</h4>';
				if ( '' !== $this->description ) {
					$this->html .= '<span class="description customize-control-description">' . $this->description . '</span>';
				}
				$this->label = '';
				$this->description = '';
				break;
			case 'line' :
				$this->html = '<hr class="make-ruled-line" />';
				break;
		}

		Make()->error()->add_error( 'make_customizer_control_misc_deprecated', __( 'The TTFMAKE_Customize_Misc_Control control is deprecated. Use MAKE_Customizer_Control_Html instead.', 'make' ) );
	}
}