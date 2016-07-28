<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Builder_Model_SectionInstance
 *
 *
 *
 * @since 1.8.0.
 */
class MAKE_Builder_Model_SectionInstance extends MAKE_Settings_Base implements MAKE_Builder_Model_SectionInstanceInterface {
	/**
	 * The type of settings. Should be defined in the child class.
	 *
	 * @since 1.7.0.
	 *
	 * @var string
	 */
	protected $type = 'buildersection';

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var array
	 */
	private $values = array();

	/**
	 * MAKE_Builder_Model_SectionInstance constructor.
	 *
	 * @param MAKE_APIInterface|null $api
	 * @param array                  $modules
	 */
	public function __construct( MAKE_APIInterface $api = null, array $modules = array() ) {
		// Make sure parent class dependencies are available.
		$modules = wp_parse_args( $modules, array( 'error' => Make()->error() ) );

		// Load dependencies
		parent::__construct( $api, $modules );
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param string $setting_id
	 * @param mixed  $value
	 *
	 * @return bool
	 */
	public function set_value( $setting_id, $value ) {
		if ( $this->setting_exists( $setting_id ) ) {
			// Sanitize the value before saving it.
			$sanitized_value = $this->sanitize_value( $value, $setting_id );

			if ( $this->undefined !== $sanitized_value ) {
				$this->values[ $setting_id ] = $sanitized_value;
				return true;
			}
		}

		return false;
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param string $setting_id
	 *
	 * @return bool
	 */
	public function unset_value( $setting_id ) {
		if ( $this->setting_exists( $setting_id ) ) {
			unset( $this->values[ $setting_id ] );
			return true;
		}

		return false;
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param string $setting_id
	 *
	 * @return mixed|null
	 */
	public function get_raw_value( $setting_id ) {
		$value = $this->undefined;

		if ( $this->setting_exists( $setting_id ) ) {
			$value = $this->values[ $setting_id ];
		}

		return $value;
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param array $values
	 *
	 * @return void
	 */
	public function set_values( array $values ) {
		foreach ( $values as $setting_id => $value ) {
			$this->set_value( $setting_id, $value );
		}
	}
}