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
	protected $buttons = array();

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var array
	 */
	protected $elements = array();

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var array
	 */
	protected $controls = array();

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
			$this->buttons[ $button_id ] = $args;

			return true;
		}

		return false;
	}


	public function remove_button( $button_id ) {
		if ( isset( $this->buttons[ $button_id ] ) ) {
			unset( $this->buttons[ $button_id ] );

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

	public function add_element( $element_id, $args ) {}

	public function remove_element( $element_id ) {}

	protected function get_default_control_args() {
		return array(
			'type'     => 'text',
			'label'    => '',
			'priority' => 10,
			'setting'  => '',
			'element'  => '',
		);
	}

	public function add_control( $control_id, $args ) {}

	public function remove_control( $control_id ) {}

	public function render() {}

}