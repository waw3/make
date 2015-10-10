<?php
/**
 * @package Make
 */

/**
 * Class TTFMAKE_Util_Font_Base
 *
 * @since x.x.x
 */
final class TTFMAKE_Util_Font_Base {

	private $font_modules = array();

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $loaded = false;

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

		// Sort font modules by priority
		$this->font_modules = $this->sort_font_modules( $this->font_modules );
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


	private function sort_font_modules( $modules ) {
		$sorted_modules = array();

		$prioritizer = array();
		foreach ( $modules as $module_id => $module ) {
			$priority = $this->get_font_module_priority( $module_id );

			if ( ! isset( $prioritizer[ $priority ] ) ) {
				$prioritizer[ $priority ] = array();
			}

			$prioritizer[ $priority ][ $module_id ] = $module;
		}

		ksort( $prioritizer );

		foreach ( $prioritizer as $module_group ) {
			$sorted_modules = array_merge( $sorted_modules, $module_group );
		}

		return $sorted_modules;
	}


	public function get_font_module( $module_id ) {
		if ( true === $this->has_font_module( $module_id ) ) {
			return $this->font_modules[ $module_id ];
		} else {
			return new WP_Error( 'make_font_module_not_valid', sprintf( __( 'The "%s" font module doesn\'t exist.', 'make' ), $module_id ) );
		}
	}


	public function get_font_module_label( $module_id ) {
		$module = $this->get_font_module( $module_id );
		return ( isset( $module->label ) ) ? $module->label : ucfirst( $module_id );
	}


	private function get_font_module_priority( $module_id ) {
		$module = $this->get_font_module( $module_id );
		return ( isset( $module->priority ) ) ? absint( $module->priority ) : 10;
	}


	public function get_font_choices( $module_id = null, $headings = true ) {
		$heading_prefix = 'make-choice-heading-';
		$choices = array();

		if ( ! is_null( $module_id ) ) {
			if ( $this->has_font_module( $module_id ) ) {
				$choices = $this->font_modules[ $module_id ]->get_font_choices();
				if ( true === $headings ) {
					$label = $this->get_font_module_label( $module_id );
					$choices = array_merge( array( $heading_prefix . $module_id => $label ), $choices );
				}
			}

			return $choices;
		}

		foreach ( $this->font_modules as $module_id => $module ) {
			$module_choices = $module->get_font_choices();
			if ( true === $headings ) {
				$label = $this->get_font_module_label( $module_id );
				$module_choices = array_merge( array( $heading_prefix . $module_id => $label ), $module_choices );
			}

			$choices = array_merge( $choices, $module_choices );
		}

		return $choices;
	}
}