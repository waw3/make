<?php
/**
 * @package Make
 */


class TTFMAKE_Util_Font_Base {

	protected $font_modules = array();

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	protected $loaded = false;

	/**
	 * Load font data and other data into the object.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function load() {
		// Load generic font module
		$this->add_font_module( 'generic', new TTFMAKE_Util_Font_Module_Generic );

		// Load Google font module
		$this->add_font_module( 'google', new TTFMAKE_Util_Font_Module_Google );

		// Loading has occurred.
		$this->loaded = true;

		/**
		 * Action: Fires at the end of the font object's load method.
		 *
		 * This action gives a developer the opportunity to add or remove font modules
		 * and run additional load routines.
		 *
		 * @since x.x.x.
		 *
		 * @param TTFMAKE_Util_Font_Base    $font    The font object that has just finished loading.
		 */
		do_action( 'make_font_loaded', $this );
	}

	/**
	 * Check if the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @return bool
	 */
	public function is_loaded() {
		return $this->loaded;
	}


	public function add_font_module( $module_id, TTFMAKE_Util_Font_Module_FontModuleInterface $module ) {
		// Font module already exists.
		if ( $this->has_font_module( $module_id ) ) {
			return new WP_Error( 'make_font_add_module_already_exists', sprintf( __( 'A font module with ID "%s" already exists. It cannot be added again.', 'make' ), $module_id ) );
		}
		// Add the new font module.
		else {
			$this->font_modules[ $module_id ] = $module;
			return true;
		}
	}


	public function remove_font_module( $module_id ) {
		// Font module exists. Remove it.
		if ( $this->has_font_module( $module_id ) ) {
			unset( $this->font_modules[ $module_id ] );
			return true;
		}
		// Font module doesn't exist.
		else {
			return new WP_Error( 'make_font_remove_module_does_not_exist', sprintf( __( 'The font module with ID "%s" does not exist.', 'make' ), $module_id ) );
		}
	}


	public function has_font_module( $module_id ) {
		return isset( $this->font_modules[ $module_id ] );
	}


	public function get_font_data() {}


	public function get_font_choices() {}
}