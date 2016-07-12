<?php
/**
 * @package Make
 */


class MAKE_Builder_Model_SectionType {

	public $type = '';


	public $label = '';


	public $description = '';


	public $icon_url = '';


	public $priority = 10;


	public $settings = array();


	public $ui = array();


	public $frontend_callback = null;
	

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


	protected function get_default_setting_definitions() {
		return array(
			'id' => 0,
			'state' => '',
		);
	}


	public function create_instance( $data ) {
		// New settings instance
		$instance = new MAKE_Builder_Model_SectionInstance();

		// Add setting definitions
		$instance->add_settings( $this->settings );

		// Set existing values
		$instance->set_values( $data );

		return $instance;
	}
}