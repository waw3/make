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
		MAKE_Error_ErrorInterface $error,
		MAKE_Compatibility_CompatibilityInterface $compatibility,
		MAKE_Font_Source_FontSourceInterface $generic = null,
		MAKE_Font_Source_FontSourceInterface $google = null
	) {
		// Errors
		$this->add_module( 'error', $error );

		// Compatibility
		$this->add_module( 'compatibility', $compatibility );

		// Generic font source
		$this->add_source( 'generic', ( is_null( $generic ) ) ? new MAKE_Font_Source_Generic( $this->inject_module( 'compatibility' ) ) : $generic );

		// Google font source
		$this->add_source( 'google', ( is_null( $google ) ) ? new MAKE_Font_Source_Google( $this->inject_module( 'compatibility' ) ) : $google );
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


	public function add_source( $source_id, MAKE_Font_Source_FontSourceInterface $source ) {
		return parent::add_module( $source_id, $source );
	}


	public function get_source( $source_id ) {
		if ( ! $this->is_loaded() ) {
			$this->load();
		}

		if ( ! parent::get_module( $source_id ) instanceof MAKE_Font_Source_FontSourceInterface ) {
			$this->get_module( 'error' )->add_error( 'make_font_source_not_valid', sprintf( __( '"%s" can\'t be retrieved because it isn\'t a valid font source.', 'make' ), $source_id ) );
			return null;
		}

		return parent::get_module( $source_id );
	}


	public function inject_source( $source_id ) {
		if ( ! $this->is_loaded() ) {
			$this->load();
		}

		if ( ! parent::inject_module( $source_id ) instanceof MAKE_Font_Source_FontSourceInterface ) {
			// Use the get_source method to generate an error.
			return $this->get_source( $source_id );
		}

		return parent::inject_module( $source_id );
	}


	public function has_source( $source_id ) {
		return parent::has_module( $source_id ) && parent::inject_module( $source_id ) instanceof MAKE_Font_Source_FontSourceInterface;
	}


	public function remove_source( $source_id ) {
		if ( ! $this->has_source( $source_id ) ) {
			$this->get_module( 'error' )->add_error( 'make_font_source_not_valid', sprintf( __( 'The "%s" font source can\'t be removed because it doesn\'t exist.', 'make' ), $source_id ) );
			return false;
		}

		unset( $this->modules[ $source_id ] );
		return true;
	}


	private function get_sorted_font_sources() {
		$prioritizer = array();

		foreach ( $this->modules as $source_id => $source ) {
			if ( ! $source instanceof MAKE_Font_Source_FontSourceInterface ) {
				continue;
			}

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
		if ( ! is_null( $source_id ) && $this->has_source( $source_id ) ) {
			$choices = $this->get_source( $source_id )->get_font_choices();

			if ( true === $headings ) {
				$label = $this->get_source( $source_id )->get_label();
				$choices = array_merge( array( $heading_prefix . $source_id => $label ), $choices );
			}

			return $choices;
		}

		// Get all choices
		foreach ( $this->get_sorted_font_sources() as $source_id => $source ) {
			$source_choices = $source->get_font_choices();

			if ( true === $headings ) {
				$label = $source->get_label();
				$source_choices = array_merge( array( $heading_prefix . $source_id => $label ), $source_choices );
			}

			$choices = array_merge( $choices, $source_choices );
		}

		// Check for deprecated filter
		if ( has_filter( 'make_all_font_choices' ) ) {
			$this->get_module( 'compatibility' )->deprecated_hook(
				'make_all_font_choices',
				'1.7.0',
				__( 'To add or modify fonts, use a hook for a specific font source instead, such as make_font_data_generic.', 'make' )
			);

			$choices = apply_filters( 'make_all_font_choices', $choices );
		}

		return $choices;
	}


	public function sanitize_font_choice( $value, $source = null, $default = '' ) {
		// Get fonts from one source, if specified. Otherwise, get all the fonts.
		if ( ! is_null( $source ) && $this->has_source( $source ) ) {
			$allowed_fonts = $this->get_font_choices( $source, false );
		} else {
			$allowed_fonts = $this->get_font_choices( null, false );
		}

		// Check for deprecated filter
		if ( has_filter( 'make_sanitize_font_choice' ) ) {
			$this->get_module( 'compatibility' )->deprecated_hook(
				'make_sanitize_font_choice',
				'1.7.0'
			);
		}

		// Find the choice in the font list.
		if ( isset( $allowed_fonts[ $value ] ) ) {
			return $value;
		}

		// Not a valid choice, return the default.
		return $default;
	}
}