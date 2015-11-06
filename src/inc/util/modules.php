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
	 * Container for module objects.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	protected $modules = array();

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
	 * Return the specified module without running its load routine.
	 *
	 * @since x.x.x.
	 *
	 * @param $module_name
	 *
	 * @return null
	 */
	protected function inject_module( $module_name ) {
		// Module exists.
		if ( $this->has_module( $module_name ) ) {
			return $this->modules[ $module_name ];
		}

		// Module doesn't exist. Use the get_module method to generate an error.
		else {
			return $this->get_module( $module_name );
		}
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