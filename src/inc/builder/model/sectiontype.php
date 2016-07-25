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
		$this->type = sanitize_key( $args['id'] );
		$this->label = wp_strip_all_tags( $args['label'] );
		$this->description = wp_strip_all_tags( $args['description'] );
		$this->icon_url = esc_url( $args['icon_url'] );
		$this->priority = absint( $args['priority'] );

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
		$this->settings = wp_parse_args( (array) $args['settings'], $this->get_default_setting_definitions() );
		
		// Section UI components
		if ( isset( $args['ui'] ) && is_array( $args['ui'] ) ) {
			$this->ui = $args['ui'];
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
	protected function get_default_setting_definitions() {
		return array(
			'id'    => array(
				'default'  => 0,
				'sanitize' => 'absint',
			),
			'state' => array(
				'default'       => 'open',
				'sanitize'      => array( Make()->sanitize(), 'sanitize_builder_section_choice' ),
				'choice_set_id' => 'builder-section-state',
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

		// Add setting definitions
		$instance->add_settings( $this->settings );

		// Set existing values
		$instance->set_values( $data );

		return $instance;
	}
}