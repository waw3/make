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

		// Section setting definitions
		$settings = $this->get_default_setting_definitions();
		if ( isset( $args['settings'] ) && is_array( $args['settings'] ) ) {
			$settings = wp_parse_args( $args['settings'], $settings );
		}
		$this->settings = $settings;
		
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
	protected function get_default_setting_definitions() {
		return array(
			'id' => 0,
			'state' => '',
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