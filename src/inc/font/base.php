<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Font_Base
 *
 * @since x.x.x
 */
final class MAKE_Font_Base {
	/**
	 * @var array
	 */
	private $font_sources = array();

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
		// Load generic font source
		$this->add_font_source( 'generic', new MAKE_Font_Source_Generic );

		// Load Google font source
		$this->add_font_source( 'google', new MAKE_Font_Source_Google );

		// Loading has occurred.
		$this->loaded = true;

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
		$this->font_sources = $this->sort_font_sources( $this->font_sources );
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


	public function add_font_source( $source_id, MAKE_Font_Source_FontSourceInterface $source ) {
		// Font source already exists.
		if ( $this->has_font_source( $source_id ) ) {
			$this->error->add_error( 'make_font_source_already_exists', sprintf( __( 'The "%s" font source already exists. It can\'t be added again.', 'make' ), $source_id ) );
			return false;
		}
		// Add the new font source.
		else {
			$this->font_sources[ $source_id ] = $source;
			return true;
		}
	}


	public function remove_font_source( $source_id ) {
		// Font source exists. Remove it.
		if ( $this->has_font_source( $source_id ) ) {
			unset( $this->font_sources[ $source_id ] );
			return true;
		}
		// Font source doesn't exist.
		else {
			$this->error->add_error( 'make_font_source_does_not_exist', sprintf( __( 'The "%s" font source does not exist.', 'make' ), $source_id ) );
			return false;
		}
	}


	public function has_font_source( $source_id ) {
		return isset( $this->font_source[ $source_id ] );
	}


	private function sort_font_sources( $sources ) {
		$sorted_sources = array();

		$prioritizer = array();
		foreach ( $sources as $source_id => $source ) {
			$priority = $this->get_font_source_priority( $source_id );

			if ( ! isset( $prioritizer[ $priority ] ) ) {
				$prioritizer[ $priority ] = array();
			}

			$prioritizer[ $priority ][ $source_id ] = $source;
		}

		ksort( $prioritizer );

		foreach ( $prioritizer as $source_group ) {
			$sorted_sources = array_merge( $sorted_sources, $source_group );
		}

		return $sorted_sources;
	}


	public function get_font_source( $source_id ) {
		if ( true === $this->has_font_source( $source_id ) ) {
			return $this->font_sources[ $source_id ];
		} else {
			$this->error->add_error( 'make_font_source_does_not_exist', sprintf( __( 'The "%s" font source does not exist.', 'make' ), $source_id ) );
			return null;
		}
	}


	public function get_font_source_label( $source_id ) {
		$source = $this->get_font_source( $source_id );
		return ( isset( $source->label ) ) ? $source->label : ucfirst( $source_id );
	}


	private function get_font_source_priority( $source_id ) {
		$source = $this->get_font_source( $source_id );
		return ( isset( $source->priority ) ) ? absint( $source->priority ) : 10;
	}


	public function get_font_choices( $source_id = null, $headings = true ) {
		$heading_prefix = 'make-choice-heading-';
		$choices = array();

		if ( ! is_null( $source_id ) ) {
			if ( $this->has_font_source( $source_id ) ) {
				$choices = $this->font_sources[ $source_id ]->get_font_choices();
				if ( true === $headings ) {
					$label = $this->get_font_source_label( $source_id );
					$choices = array_merge( array( $heading_prefix . $source_id => $label ), $choices );
				}
			}

			return $choices;
		}

		foreach ( $this->font_sources as $source_id => $source ) {
			$source_choices = $source->get_font_choices();
			if ( true === $headings ) {
				$label = $this->get_font_source_label( $source_id );
				$source_choices = array_merge( array( $heading_prefix . $source_id => $label ), $source_choices );
			}

			$choices = array_merge( $choices, $source_choices );
		}

		return $choices;
	}


	public function sanitize_font_choice( $value, $source = null, $default = '' ) {
		// Get fonts from one source, if specified. Otherwise, get all the fonts.
		if ( ! is_null( $source ) && $this->has_font_source( $source ) ) {
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