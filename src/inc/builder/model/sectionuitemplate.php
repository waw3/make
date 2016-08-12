<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Builder_Model_SectionUI
 *
 *
 *
 * @since 1.8.0.
 */
class MAKE_Builder_Model_SectionUITemplate extends MAKE_Util_Modules implements MAKE_Builder_Model_SectionUITemplateInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'error' => 'MAKE_Error_CollectorInterface',
	);

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var string
	 */
	public $type = '';

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var string
	 */
	public $label = '';

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var bool
	 */
	public $collapsible = true;

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var bool
	 */
	public $parent = false;

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var bool
	 */
	public $items = false;

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var array
	 */
	protected $button_definitions = array();

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var array
	 */
	protected $element_definitions = array();

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var array
	 */
	protected $control_definitions = array();

	/**
	 * Holds an instance of MAKE_Builder_UI_Buttons
	 *
	 * @since 1.8.0.
	 *
	 * @var MAKE_Builder_UI_Buttons|null
	 */
	protected $buttons = null;

	/**
	 * Holds an instance of MAKE_Builder_UI_Elements
	 *
	 * @since 1.8.0.
	 *
	 * @var MAKE_Builder_UI_Elements|null
	 */
	protected $elements = null;

	/**
	 * Holds an instance of MAKE_Builder_UI_Controls
	 *
	 * @since 1.8.0.
	 *
	 * @var MAKE_Builder_UI_Controls|null
	 */
	protected $controls = null;

	/**
	 * MAKE_Builder_Model_SectionUITemplate constructor.
	 *
	 * @param MAKE_APIInterface|null $api
	 * @param array                  $modules
	 */
	public function __construct( MAKE_APIInterface $api = null, array $modules = array() ) {
		// Make sure dependencies are available.
		$modules = wp_parse_args( $modules, array( 'error' => Make()->error() ) );

		// Load dependencies
		parent::__construct( $api, $modules );
	}

	/**
	 * Gets the instance of MAKE_Builder_UI_Buttons
	 *
	 * @since 1.8.0.
	 *
	 * @return MAKE_Builder_UI_Buttons
	 */
	protected function buttons() {
		if ( is_null( $this->buttons ) ) {
			$this->buttons = new MAKE_Builder_UI_Buttons();
		}

		return $this->buttons;
	}

	/**
	 * Gets the instance of MAKE_Builder_UI_Elements
	 *
	 * @since 1.8.0.
	 *
	 * @return MAKE_Builder_UI_Elements
	 */
	protected function elements() {
		if ( is_null( $this->elements ) ) {
			$this->elements = new MAKE_Builder_UI_Elements();
		}

		return $this->elements;
	}

	/**
	 * Gets the instance of MAKE_Builder_UI_Controls
	 *
	 * @since 1.8.0.
	 *
	 * @return MAKE_Builder_UI_Controls
	 */
	protected function controls() {
		if ( is_null( $this->controls ) ) {
			$this->controls = new MAKE_Builder_UI_Controls();
		}

		return $this->controls;
	}


	protected function get_default_button_args() {
		return array(
			'label'    => '',
			'action'   => '',
			'priority' => 10,
		);
	}


	public function add_button( $button_id, $args ) {
		$button_id = sanitize_key( $button_id );
		$args = wp_parse_args( (array) $args, $this->get_default_button_args() );

		if ( $button_id ) {
			$this->button_definitions[ $button_id ] = $args;

			return true;
		}

		return false;
	}


	public function remove_button( $button_id ) {
		if ( isset( $this->button_definitions[ $button_id ] ) ) {
			unset( $this->button_definitions[ $button_id ] );

			return true;
		}

		return false;
	}


	protected function get_default_element_args() {
		return array(
			'type'     => 'overlay',
			'label'    => '',
			'priority' => 10,
		);
	}


	public function add_element( $element_id, $args ) {
		$element_id = sanitize_key( $element_id );
		$args = wp_parse_args( (array) $args, $this->get_default_element_args() );

		if ( $element_id ) {
			$this->element_definitions[ $element_id ] = $args;

			return true;
		}

		return false;
	}


	public function remove_element( $element_id ) {
		if ( isset( $this->element_definitions[ $element_id ] ) ) {
			unset( $this->element_definitions[ $element_id ] );

			return true;
		}

		return false;
	}


	protected function get_default_control_args() {
		return array(
			'type'        => 'text',
			'label'       => '',
			'description' => '',
			'priority'    => 10,
			'setting'     => '',
			'element'     => '',
		);
	}


	public function add_control( $control_id, $args ) {
		$control_id = sanitize_key( $control_id );
		$args = wp_parse_args( (array) $args, $this->get_default_control_args() );

		if ( $control_id ) {
			$this->control_definitions[ $control_id ] = $args;

			return true;
		}

		return false;
	}


	public function remove_control( $control_id ) {
		if ( isset( $this->control_definitions[ $control_id ] ) ) {
			unset( $this->control_definitions[ $control_id ] );

			return true;
		}

		return false;
	}


	protected function get_element_controls( $element_id ) {
		$plucked = wp_list_pluck( $this->control_definitions, 'element' );

		return array_keys( $plucked, $element_id );
	}


	public function render() {
		// Section container
		$section_atts = new MAKE_Util_HTMLAttributes( array(
			'class' => array(
				'make-section',
				'make-section-{{ data.state }}',
			),
			'data'  => array(
				'section-id'   => '{{ data.id }}',
				'section-type' => '{{ data.type }}',
			),
		) );
		?>
		<div<?php echo $section_atts->render(); ?>>
			<div class="make-section-header">
				<label for="label-{{ data.id }}">
					<?php
					// The label input
					$this->controls()->render( 'input', 'label', array(
						'attributes' => array(
							'placeholder' => esc_html__( 'Add a label', 'make' )
						),
						'setting' => 'label',
					) );
					?>
					<?php
					// The section type label
					echo $this->label; ?>
				</label>
				<div class="make-section-header-buttons">
					<?php  ?>
				</div>
			</div>
			<div class="clear"></div>
			<div class="make-section-body">

			</div>
		</div>
	<?php

		return $this;
	}
}