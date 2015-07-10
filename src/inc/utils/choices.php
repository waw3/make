<?php
/**
 * @package Make
 */

/**
 * Class TTFMAKE_Utils_Choices
 *
 * An object for defining and managing choice sets.
 *
 * @since 1.x.x.
 */
class TTFMAKE_Utils_Choices {
	/**
	 * The collection of choice sets.
	 *
	 * @since 1.x.x.
	 *
	 * @var array
	 */
	protected $choice_sets = array();

	/**
	 * Initialize the object.
	 *
	 * @since 1.x.x.
	 */
	final function __construct() {
		$this->load();

		/**
		 * Action fires after the choices object's load method has been called.
		 *
		 * This action gives a developer the opportunity add or modify choice sets
		 * and run additional load routines.
		 *
		 * @since 1.x.x.
		 *
		 * @param object    $choices    The choices object that has just finished loading.
		 */
		do_action( 'make_choices_loaded', $this );
	}

	/**
	 * Set up the object.
	 *
	 * @since 1.x.x.
	 *
	 * @return void
	 */
	protected function load() {}

	/**
	 * Add choice sets to the collection.
	 *
	 * Each choice set is an item in an associative array.
	 * The item's array key is the set ID. The item value is another
	 * associative array that contains individual choices where the key
	 * is the HTML option value and the value is the HTML option label.
	 *
	 * Example:
	 * array(
	 *     'horizontal-alignment' => array(
	 *         'left'   => __( 'Left', 'make' ),
	 *         'center' => __( 'Center', 'make' ),
	 *         'right'  => __( 'Right', 'make' ),
	 *     ),
	 * )
	 *
	 * @since 1.x.x.
	 *
	 * @param          $sets         Array of choice sets to add.
	 * @param  bool    $overwrite    True overwrites an existing choice set with the same ID.
	 *
	 * @return array|WP_Error        The modified array of choices if successful, otherwise an error object.
	 */
	public function add_choice_sets( $sets, $overwrite = false ) {
		$sets = (array) $sets;
		$existing_sets = $this->choice_sets;
		$new_sets = array();

		// Validate each choice set before adding it.
		foreach ( $sets as $set_id => $choices ) {
			$set_id = sanitize_key( $set_id );

			if (
				is_array( $choices )
				&&
				( ! isset( $existing_sets[ $set_id ] ) || true === $overwrite )
			) {
				$new_sets[ $set_id ] = $choices;
			}
		}

		// If no choices sets were valid, return false.
		if ( empty( $new_sets ) ) {
			return new WP_Error( 'make_choices_add_choice_sets_no_valid_sets', __( 'No valid choice sets were found to add.', 'make' ), $sets );
		}

		// Add the valid new choices sets to the existing choices array.
		$this->choice_sets = array_merge( $existing_sets, $new_sets );

		return $this->choice_sets;
	}

	/**
	 * Remove choice sets from the collection.
	 *
	 * @since 1.x.x.
	 *
	 * @param  array|string    $set_ids    The array of choice sets to remove, or 'all'.
	 *
	 * @return array|WP_Error              The modified array of choice sets if successful, otherwise an error object.
	 */
	public function remove_choice_sets( $set_ids ) {
		if ( 'all' === $set_ids ) {
			// Clear the entire settings array.
			$this->choice_sets = array();
			return true;
		}

		$set_ids = (array) $set_ids;
		$removed_ids = array();

		// Track each setting that's removed.
		foreach ( $set_ids as $set_id ) {
			if ( isset( $this->choice_sets[ $set_id ] ) ) {
				unset( $this->choice_sets[ $set_id ] );
				$removed_ids[] = $set_id;
			}
		}

		if ( empty( $removed_ids ) ) {
			// No choice sets were removed.
			return new WP_Error( 'make_choices_remove_choice_sets_none_removed', __( 'None of the specified choice sets were found in the collection, so none were removed.', 'make' ), $set_ids );
		} else {
			return $this->choice_sets;
		}
	}

	/**
	 * Get a particular choice set, using the set ID.
	 *
	 * @since 1.x.x.
	 *
	 * @param  string    $set_id    The ID of the choice set to retrieve.
	 *
	 * @return array                The array of choices.
	 */
	public function get_choice_set( $set_id ) {
		$all_sets = $this->choice_sets;
		$choice_set = array();

		if ( isset( $all_sets[ $set_id ] ) ) {
			$choice_set = $all_sets[ $set_id ];
		}

		/**
		 * Filter the choices in a particular choice set.
		 *
		 * @since 1.x.x.
		 *
		 * @param array     $choice_set    The array of choices in the choice set.
		 * @param string    $set_id        The ID of the choice set.
		 */
		return apply_filters( 'make_choices_get_choice_set', $choice_set, $set_id );
	}

	/**
	 * Get the label of an individual choice in a choice set.
	 *
	 * @since 1.x.x.
	 *
	 * @param  string    $set_id    The ID of the choice set.
	 * @param  string    $choice    The array key representing the value of the choice.
	 *
	 * @return string|bool          The choice label, or false if not a valid choice.
	 */
	public function get_choice_label( $set_id, $choice ) {
		if ( ! $this->is_valid_choice( $set_id, $choice ) ) {
			return new WP_Error( 'make_choices_get_choice_label_not_valid_choice', __( 'The specified choice is not valid.', 'make' ), array( $set_id, $choice ) );
		}

		$choices = $this->get_choice_set( $set_id );
		return $choices[ $choice ];
	}

	/**
	 * Determine if a value is a valid choice.
	 *
	 * @since 1.x.x.
	 *
	 * @param  string    $set_id    The ID of the choice set.
	 * @param  string    $choice    The array key representing the value of the choice.
	 *
	 * @return bool                 True if the choice exists in the set.
	 */
	public function is_valid_choice( $set_id, $choice ) {
		$choices = $this->get_choice_set( $set_id );
		return isset( $choices[ $choice ] );
	}

	/**
	 * Sanitize a value from a list of allowed values in a choice set.
	 *
	 * @since 1.x.x.
	 *
	 * @param  mixed     $value      The value given to sanitize.
	 * @param  string    $set_id     The ID of the choice set to search for the given value.
	 * @param  mixed     $default    The value to return if the given value is not valid.
	 *
	 * @return mixed                 The sanitized value.
	 */
	public function sanitize_choice( $value, $set_id, $default = '' ) {
		if ( true === $this->is_valid_choice( $set_id, $value ) ) {
			return $value;
		} else {
			return $default;
		}
	}
}