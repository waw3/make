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
class MAKE_Builder_Model_SectionUITemplate implements MAKE_Builder_Model_SectionUITemplateInterface {
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


	public function __construct( $args = array(), $ui = array() ) {
		// Handle args
		$arg_defaults = array(
			'type'        => '',
			'label'       => '',
			'collapsible' => true,
			'parent'      => false,
			'items'       => false,
		);
		$args = wp_parse_args( $args, $arg_defaults );

		$this->type = $args['type'];
		$this->label = $args['label'];
		$this->collapsible = $args['collapsible'];
		$this->parent = $args['parent'];
		$this->items = $args['items'];

		// Handle UI
		$ui_defaults = array(
			'buttons'  => array(),
			'elements' => array(),
			'controls' => array(),
		);
		$ui = wp_parse_args( $ui, $ui_defaults );

		// Add buttons
		foreach ( (array) $ui['buttons'] as $button_id => $button_args ) {
			$this->add_button( $button_id, $button_args );
		}

		// Add elements
		foreach ( (array) $ui['elements'] as $element_id => $element_args ) {
			$this->add_element( $element_id, $element_args );
		}

		// Add controls
		foreach ( (array) $ui['controls'] as $control_id => $control_args ) {
			$this->add_control( $control_id, $control_args );
		}

		/**
		 *
		 */
		do_action( 'make_builder_section_ui_template', $this );

		/**
		 *
		 */
		do_action( 'make_builder_section_ui_template_' . $this->type, $this );
	}


	protected function get_definitions( $type ) {
		$definitions = array();

		switch ( $type ) {
			case 'button' :
				$definitions = $this->button_definitions;
				break;
			case 'element' :
				$definitions = $this->element_definitions;
				break;
			case 'control' :
				$definitions = $this->control_definitions;
				break;
		}

		uasort( $definitions, array( $this, 'sort_priority' ) );

		return $definitions;
	}


	protected function sort_priority( $a, $b ) {
		if ( $a['priority'] === $b['priority'] ) {
			return 0;
		}

		return ( $a['priority'] < $b['priority'] ) ? -1 : 1;
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


	public function is_top_level_section() {
		return ! $this->parent;
	}


	protected function get_element_controls( $element_id ) {
		$all_control_definitions = $this->get_definitions( 'control' );
		$control_ids = array_keys( wp_list_pluck( $all_control_definitions, 'element' ), $element_id );
		$element_control_definitions = array();

		foreach ( $control_ids as $id ) {
			$element_control_definitions[ $id ] = $all_control_definitions[ $id ];
		}

		return $element_control_definitions;
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
				'section-type' => $this->type,
			),
		) );

		?>
		<div<?php echo $section_atts->render(); ?>>
			<?php $this->render_header(); ?>

			<?php if ( $this->is_top_level_section() ) : ?>
				<div class="clear"></div>
			<?php endif; ?>

			<?php if ( count( $this->get_definitions( 'element' ) ) ) : ?>
				<div class="make-section-body">
					<?php
					foreach ( $this->get_definitions( 'element' ) as $element_id => $element_args ) :
						$element_args['controls'] = $this->get_element_controls( $element_id );
						$this->elements()->render( $element_args['type'], $element_id, $element_args );
					endforeach;
					?>
				</div>
			<?php endif; ?>

			<div class="clear"></div>

			<?php $this->render_footer(); ?>
		</div>
	<?php

		return $this;
	}


	protected function render_header() {
		?>
		<div class="make-section-header">
	<?php
		// Top level section
		if ( $this->is_top_level_section() ) : ?>
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
	<?php
		// Child section
		else : ?>
			<div class="make-sortable-handle">
				<span class="screen-reader-text">
					<?php esc_html_e( 'Drag-and-drop this column into place.', 'make' ); ?>
				</span>
			</div>
	<?php
		endif;
		?>
		<?php if ( count( $this->get_definitions( 'button' ) ) || $this->collapsible ) : ?>
			<div class="make-section-header-buttons">
				<?php foreach ( $this->get_definitions( 'button' ) as $button_id => $args ) : ?>
					<?php $this->buttons()->render( 'sectionbutton', $button_id, $args ); ?>
				<?php endforeach; ?>
				<?php if ( $this->collapsible ) : ?>
					<?php
					$this->buttons()->render( 'sectiontoggle', 'toggle' );
					?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		</div>
	<?php
	}


	protected function render_footer() {
		?>
		<div class="make-section-footer">
			<?php
			// Section state
			$this->controls()->render( 'hidden', 'state', array(
				'setting' => 'state',
			) );

			// Section JSON
			$this->controls->render( 'textarea', 'json', array(
				'attributes' => array(
					'name' => 'make-section[]'
				),
			) );
			?>
		</div>
	<?php
	}
}