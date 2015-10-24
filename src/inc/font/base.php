<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Font_Base
 *
 * @since x.x.x
 */
final class MAKE_Font_Base extends MAKE_Util_Modules implements MAKE_Font_FontInterface {
	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $loaded = false;


	public function __construct(
		MAKE_Font_Source_FontSourceInterface $generic = null,
		MAKE_Font_Source_FontSourceInterface $google = null
	) {
		// Generic font source
		$this->add_module( 'generic', ( is_null( $generic ) ) ? new MAKE_Font_Source_Generic : $generic );

		// Google font source
		$this->add_module( 'google', ( is_null( $google ) ) ? new MAKE_Font_Source_Google : $google );
	}

	/**
	 * Load data files.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function load() {
		if ( $this->is_loaded() ) {
			return;
		}

		/**
		 * Action: Fires at the end of the font object's load method.
		 *
		 * This action gives a developer the opportunity to add or remove font sources
		 * and run additional load routines.
		 *
		 * @since x.x.x.
		 *
		 * @param MAKE_Font_Base    $font    The font object that has just finished loading.
		 */
		do_action( 'make_font_loaded', $this );

		// Sort font sources by priority
		$this->modules = $this->sort_font_sources( $this->modules );

		// Loading has occurred.
		$this->loaded = true;
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


	private function sort_font_sources( $sources ) {
		$prioritizer = array();
		foreach ( $sources as $source_id => $source ) {
			$priority = $source->get_priority();

			if ( ! isset( $prioritizer[ $priority ] ) ) {
				$prioritizer[ $priority ] = array();
			}

			$prioritizer[ $priority ][ $source_id ] = $source;
		}

		ksort( $prioritizer );

		$sorted_sources = array();
		foreach ( $prioritizer as $source_group ) {
			$sorted_sources = array_merge( $sorted_sources, $source_group );
		}

		return $sorted_sources;
	}


	public function get_font_choices( $source_id = null, $headings = true ) {
		$heading_prefix = 'make-choice-heading-';
		$choices = array();

		// Get choices from a single source
		if ( ! is_null( $source_id ) ) {
			if ( $this->has_module( $source_id ) ) {
				$choices = $this->get_module( $source_id )->get_font_choices();
				if ( true === $headings ) {
					$label = $this->get_module( $source_id )->get_label();
					$choices = array_merge( array( $heading_prefix . $source_id => $label ), $choices );
				}
			}

			return $choices;
		}

		// Get all choices
		foreach ( $this->modules as $source_id => $source ) {
			$source_choices = $source->get_font_choices();
			if ( true === $headings ) {
				$label = $source->get_label();
				$source_choices = array_merge( array( $heading_prefix . $source_id => $label ), $source_choices );
			}

			$choices = array_merge( $choices, $source_choices );
		}

		return $choices;
	}


	public function sanitize_font_choice( $value, $source = null, $default = '' ) {
		// Get fonts from one source, if specified. Otherwise, get all the fonts.
		if ( ! is_null( $source ) && $this->has_module( $source ) ) {
			$allowed_fonts = $this->get_font_choices( $source, false );
		} else {
			$allowed_fonts = $this->get_font_choices( null, false );
		}

		// Find the choice in the font list.
		if ( isset( $allowed_fonts[ $value ] ) ) {
			return $value;
		}

		// Not a valid choice, return the default.
		return $default;
	}
}