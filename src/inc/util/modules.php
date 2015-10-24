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
	 * Add a Util module, if it doesn't exist yet.
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
		if ( ! isset( $this->modules[ $module_name ] ) ) {
			$this->modules[ $module_name ] = $module;
			if ( $this->modules[ $module_name ] instanceof MAKE_Util_HookInterface ) {
				if ( ! $this->modules[ $module_name ]->is_hooked() ) {
					$this->modules[ $module_name ]->hook();
				}
			}
			return true;
		}

		// Module already exists. Generate an error if possible.
		else if ( isset( $this->modules['error'] ) && $this->modules['error'] instanceof MAKE_Error_ErrorInterface ) {
			$this->modules['error']->add_error( 'make_util_module_already_exists', sprintf( __( 'The "%s" module already exists.', 'make' ), $module_name ) );
		}

		return false;
	}

	/**
	 * Return the specified Util module, if it exists.
	 *
	 * @since x.x.x.
	 *
	 * @param  string    $module_name
	 *
	 * @return mixed
	 */
	public function get_module( $module_name ) {
		// Module exists.
		if ( isset( $this->modules[ $module_name ] ) ) {
			if ( $this->modules[ $module_name ] instanceof MAKE_Util_LoadInterface ) {
				if ( ! $this->modules[ $module_name ]->is_loaded() ) {
					$this->modules[ $module_name ]->load();
				}
			}
			return $this->modules[ $module_name ];
		}

		// Module doesn't exist. Generate an error if possible.
		else if ( isset( $this->modules['error'] ) && $this->modules['error'] instanceof MAKE_Error_ErrorInterface ) {
			$this->modules['error']->add_error( 'make_util_module_not_valid', sprintf( __( 'The "%s" module doesn\'t exist.', 'make' ), $module_name ) );
		}

		return null;
	}
}