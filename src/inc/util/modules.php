<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Modules
 *
 * @since x.x.x.
 */
abstract class MAKE_Util_Modules implements MAKE_Util_ModulesInterface {
	/**
	 * An associative array of required modules.
	 *
	 * Format:
	 * 'module name' => 'module interface or class name'
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	protected $dependencies = array();

	/**
	 * Container for module objects.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	protected $modules = array();

	/**
	 * MAKE_Util_Modules constructor.
	 *
	 * @since x.x.x.
	 *
	 * @param MAKE_APIInterface|null $api
	 * @param array                  $modules
	 */
	public function __construct(
		MAKE_APIInterface $api = null,
		array $modules = array()
	) {
		$this->load_dependencies( $api, $modules );
	}

	/**
	 * Allow modules to be accessed simply as a method with the same name.
	 *
	 * @since x.x.x.
	 *
	 * @param $name
	 * @param $arguments
	 *
	 * @return bool|mixed
	 */
	public function __call( $name, $arguments ) {
		if ( $this->has_module( $name ) ) {
			return $this->get_module( $name );
		} else {
			return trigger_error( sprintf( esc_html__( 'Call to undefined method %1$s::%2$s()', 'make' ), get_class( $this ), esc_html( $name ) ), E_USER_ERROR );
		}
	}

	/**
	 * Add a module and run its hook routine.
	 *
	 * @since x.x.x.
	 *
	 * @param  string    $module_name
	 * @param  object    $module
	 *
	 * @return bool
	 */
	protected function add_module( $module_name, $module ) {
		// Module doesn't exist yet.
		if ( ! $this->has_module( $module_name ) ) {
			$this->modules[ $module_name ] = $module;
			if ( $this->modules[ $module_name ] instanceof MAKE_Util_HookInterface ) {
				if ( ! $this->modules[ $module_name ]->is_hooked() ) {
					$this->modules[ $module_name ]->hook();
				}
			}
			return true;
		}

		// Module already exists. Generate an error if possible.
		else if ( $this->has_module( 'error' ) && $this->modules['error'] instanceof MAKE_Error_CollectorInterface ) {
			$this->modules['error']->add_error( 'make_util_module_already_exists', sprintf( __( 'The "%1$s" module can\'t be added to %2$s because it already exists.', 'make' ), esc_html( $module_name ), get_class( $this ) ) );
		}

		return false;
	}

	/**
	 * Add modules required by the dependencies array, either from the optional modules parameter or from the
	 * api parameter.
	 *
	 * @since x.x.x.
	 *
	 * @param MAKE_APIInterface $api
	 * @param array             $modules
	 */
	protected function load_dependencies( MAKE_APIInterface $api, array $modules = array() ) {
		foreach ( $this->dependencies as $dependency_name => $dependency_type ) {
			// Provided by modules array
			if ( isset( $modules[ $dependency_name ] ) ) {
				if ( is_object( $modules[ $dependency_name ] ) ) {
					$module_instance = $modules[ $dependency_name ];
				} else {
					$reflection = new ReflectionClass( $modules[ $dependency_name ] );
					$module_instance = $reflection->newInstanceArgs( array( $api ) );
				}

				if ( is_a( $module_instance, $dependency_type ) ) {
					$this->add_module( $dependency_name, $module_instance );
					continue;
				}
			}
			// Provided by API
			else if ( $api->has_module( $dependency_name ) && is_a( $api->inject_module( $dependency_name ), $dependency_type ) ) {

				$this->add_module( $dependency_name, $api->inject_module( $dependency_name ) );
				continue;
			}

			// Dependency is missing
			trigger_error(
				sprintf(
					esc_html__( '%1$s does not have a valid %2$s dependency', 'make' ),
					get_class( $this ),
					$dependency_name
				),
				E_USER_ERROR
			);
		}
	}

	/**
	 * Return the specified module and run its load routine.
	 *
	 * @since x.x.x.
	 *
	 * @param  string    $module_name
	 *
	 * @return mixed
	 */
	public function get_module( $module_name ) {
		// Module exists.
		if ( $this->has_module( $module_name ) ) {
			if ( $this->modules[ $module_name ] instanceof MAKE_Util_LoadInterface ) {
				if ( ! $this->modules[ $module_name ]->is_loaded() ) {
					$this->modules[ $module_name ]->load();
				}
			}
			return $this->modules[ $module_name ];
		}

		// Module doesn't exist. Generate an error if possible.
		else if ( $this->has_module( 'error' ) && $this->modules['error'] instanceof MAKE_Error_CollectorInterface ) {
			$this->modules['error']->add_error( 'make_util_module_not_valid', sprintf( __( 'The "%1$s" module can\'t be retrieved from %2$s because it doesn\'t exist.', 'make' ), esc_html( $module_name ), get_class( $this ) ) );
		}

		return null;
	}

	/**
	 * Check if a module exists.
	 *
	 * @since x.x.x.
	 *
	 * @param  string    $module_name
	 *
	 * @return bool
	 */
	public function has_module( $module_name ) {
		return isset( $this->modules[ $module_name ] );
	}
}