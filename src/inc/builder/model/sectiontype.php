<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Builder_Model_SectionType
 *
 *
 *
 * @since 1.8.0.
 */
class MAKE_Builder_Model_SectionType implements MAKE_Builder_Model_SectionTypeInterface {
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
	 * @var string
	 */
	public $description = '';

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var string
	 */
	public $icon_url = '';

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var int
	 */
	public $priority = 10;

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
	 * @var bool|string
	 */
	public $parent = false;

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var bool|array
	 */
	public $items = false;

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var array
	 */
	public $settings = array();

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var array
	 */
	public $ui = array();

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var string|array
	 */
	public $frontend_callback = null;

	/**
	 * MAKE_Builder_Model_SectionType constructor.
	 *
	 * @since 1.8.0.
	 *
	 * @param array $args
	 */
	public function __construct( array $args ) {
		$this->type = sanitize_key( $args['type'] );
		$this->label = wp_strip_all_tags( $args['label'] );
		$this->description = wp_strip_all_tags( $args['description'] );
		$this->icon_url = esc_url( $args['icon_url'] );
		$this->priority = absint( $args['priority'] );
		$this->collapsible = wp_validate_boolean( $args['collapsible'] );

		// Parent
		if ( false !== $args['parent'] ) {
			$this->parent = sanitize_key( $args['parent'] );
		}

		// Items args
		// Only process these if the section doesn't have a parent
		if ( false === $this->parent && false !== $args['items'] ) {
			$this->items = wp_parse_args( (array) $args['items'], $this->get_default_items_args() );
		}

		// Section setting definitions
		$this->settings = (array) $args['settings'];
		
		// Section UI components
		$this->ui = (array) $args['ui'];

		// Front end callback
		if ( is_callable( $args['frontend_callback'] ) ) {
			$this->frontend_callback = $args['frontend_callback'];
		}
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @return array
	 */
	protected function get_default_items_args() {
		return array(
			'can_add'    => true,
			'can_remove' => true,
			'min'        => false,
			'max'        => false,
			'start_with' => 0,
		);
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @return array
	 */
	protected function get_shared_setting_definitions() {
		return array(
			'id'    => array(
				'default'  => 0,
				'sanitize' => 'absint',
			),
			'type'  => array(
				'default'       => $this->type,
				'sanitize'      => array( Make()->sanitize(), 'sanitize_builder_section_choice' ),
				'choice_set_id' => 'builder-section-type',
			),
			'label' => array(
				'default'  => '',
				'sanitize' => 'sanitize_text_field',
			),
			'state' => array(
				'default'       => 'open',
				'sanitize'      => array( Make()->sanitize(), 'sanitize_builder_section_choice' ),
				'choice_set_id' => 'builder-section-state',
			),
			'items' => array(
				'default'  => array(),
				'sanitize' => '',
				'is_array' => true,
			),
		);
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param array $data
	 *
	 * @return MAKE_Builder_Model_SectionInstance
	 */
	public function create_instance( $data = array() ) {
		// New settings instance
		$instance = new MAKE_Builder_Model_SectionInstance();

		// Add shared setting definitions
		$instance->add_settings( $this->get_shared_setting_definitions() );

		// Add section setting definitions
		// Enable overwrite so shared definitions can be overwritten
		$instance->add_settings( $this->settings, array(), true );

		// Set existing values
		$instance->set_values( $data );

		return $instance;
	}

	/**
	 * Generate a SectionUITemplate class instance.
	 *
	 * @since 1.8.0.
	 *
	 * @return MAKE_Builder_Model_SectionUITemplate
	 */
	public function create_ui_template() {
		// New template instance
		return new MAKE_Builder_Model_SectionUITemplate(
			array(
				'type'        => $this->type,
				'label'       => $this->label,
				'collapsible' => $this->collapsible,
				'parent'      => $this->parent,
				'items'       => $this->items,
			),
			$this->ui
		);
	}
}