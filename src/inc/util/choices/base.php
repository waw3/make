<?php
/**
 * @package Make
 */

/**
 * Class TTFMAKE_Util_Choices_Base
 *
 * An object for defining and managing choice sets.
 *
 * @since x.x.x.
 */
class TTFMAKE_Util_Choices_Base implements TTFMAKE_Util_Choices_ChoicesInterface {
	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	protected $loaded = false;

	/**
	 * The collection of choice sets.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	protected $choice_sets = array();

	/**
	 * Load data into the object.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function load() {
		// Bail if the load routine has already been run.
		if ( true === $this->is_loaded() ) {
			return;
		}

		// Add the default choice sets.
		$this->add_choice_sets( array(
			'0-4' => array(
				0 => __( '0', 'make' ),
				1 => __( '1', 'make' ),
				2 => __( '2', 'make' ),
				3 => __( '3', 'make' ),
				4 => __( '4', 'make' )
			),
			'alignment-horizontal-2' => array(
				'left'  => __( 'Left', 'make' ),
				'right' => __( 'Right', 'make' )
			),
			'alignment-horizontal-3' => array(
				'left'   => __( 'Left', 'make' ),
				'center' => __( 'Center', 'make' ),
				'right'  => __( 'Right', 'make' )
			),
			'alignment-full-9' => array(
				'top-left'      => __( 'Top Left', 'make' ),
				'top'           => __( 'Top', 'make' ),
				'top-right'     => __( 'Top Right', 'make' ),
				'left'          => __( 'Left', 'make' ),
				'center'        => __( 'Center', 'make' ),
				'right'         => __( 'Right', 'make' ),
				'bottom-left'   => __( 'Bottom Left', 'make' ),
				'bottom'        => __( 'Bottom', 'make' ),
				'bottom-right'  => __( 'Bottom Right', 'make' ),
			),
			'background-attachment' => array(
				'scroll' => __( 'Scroll', 'make' ),
				'fixed'  => __( 'Fixed', 'make' ),
			),
			'background-repeat' => array(
				'no-repeat' => __( 'No Repeat', 'make' ),
				'repeat'    => __( 'Tile', 'make' ),
				'repeat-x'  => __( 'Tile Horizontally', 'make' ),
				'repeat-y'  => __( 'Tile Vertically', 'make' )
			),
			'background-size' => array(
				'auto'    => __( 'Auto', 'make' ),
				'cover'   => __( 'Cover', 'make' ),
				'contain' => __( 'Contain', 'make' )
			),
			'comment-count' => array(
				'icon' => __( 'With icon', 'make' ),
				'text' => __( 'With text', 'make' ),
				'none' => __( 'None', 'make' ),
			),
			'featured-images' => array(
				'post-header' => __( 'Post header', 'make' ),
				'thumbnail'   => __( 'Thumbnail', 'make' ),
				'none'        => __( 'None', 'make' ),
			),
			'font-style' => array(
				'normal' => __( 'Normal', 'make' ),
				'italic' => __( 'Italic', 'make' ),
			),
			'font-weight' => array(
				'normal' => __( 'Normal', 'make' ),
				'bold'   => __( 'Bold', 'make' ),
			),
			'footer-layout' => array(
				1  => __( 'Traditional', 'make' ),
				2  => __( 'Centered', 'make' ),
			),
			'general-layout' => array(
				'full-width' => __( 'Full-width', 'make' ),
				'boxed'      => __( 'Boxed', 'make' )
			),
			'header-bar-content-layout' => array(
				'default' => __( 'Default', 'make' ),
				'flipped' => __( 'Flipped', 'make' )
			),
			'header-layout' => array(
				1  => __( 'Traditional', 'make' ),
				2  => __( 'Centered', 'make' ),
				3  => __( 'Navigation Below', 'make' ),
			),
			'link-underline' => array(
				'always' => __( 'Always', 'make' ),
				'hover'  => __( 'On hover/focus', 'make' ),
				'never'  => __( 'Never', 'make' ),
			),
			'post-author' => array(
				'avatar' => __( 'With avatar', 'make' ),
				'name'   => __( 'Without avatar', 'make' ),
				'none'   => __( 'None', 'make' ),
			),
			'post-date' => array(
				// Translators: %s is a placeholder for a date.
				'absolute' => sprintf( __( 'Absolute (%s)', 'make' ), date( get_option( 'date_format' ), time() - WEEK_IN_SECONDS ) ),
				'relative' => __( 'Relative (1 week ago)', 'make' ),
				'none'     => __( 'None', 'make' ),
			),
			'post-item-location' => array(
				'top'            => __( 'Top', 'make' ),
				'before-content' => __( 'Before content', 'make' ),
				'post-footer'    => __( 'Post footer', 'make' ),
			),
			'text-transform' => array(
				'none'      => __( 'None', 'make' ),
				'uppercase' => __( 'Uppercase', 'make' ),
				'lowercase' => __( 'Lowercase', 'make' ),
			),
		) );

		// Loading has occurred.
		$this->loaded = true;

		/**
		 * Action: Fires at the end of the choices object's load method.
		 *
		 * This action gives a developer the opportunity to add or modify choice sets
		 * and run additional load routines.
		 *
		 * @since x.x.x.
		 *
		 * @param TTFMAKE_Utils_Choices    $choices    The choices object that has just finished loading.
		 */
		do_action( 'make_choices_loaded', $this );
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
	 * @since x.x.x.
	 *
	 * @param          $sets         Array of choice sets to add.
	 * @param  bool    $overwrite    True overwrites an existing choice set with the same ID.
	 *
	 * @return bool|WP_Error        True if addition was successful, otherwise an error object.
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

		return true;
	}

	/**
	 * Remove choice sets from the collection.
	 *
	 * @since x.x.x.
	 *
	 * @param  array|string    $set_ids    The array of choice sets to remove, or 'all'.
	 *
	 * @return bool|WP_Error               True if removal was successful, otherwise an error object.
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
			return true;
		}
	}

	/**
	 * Get a particular choice set, using the set ID.
	 *
	 * @since x.x.x.
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
		 * Filter: Modify the choices in a particular choice set.
		 *
		 * @since x.x.x.
		 *
		 * @param array     $choice_set    The array of choices in the choice set.
		 * @param string    $set_id        The ID of the choice set.
		 */
		return apply_filters( 'make_choices_get_choice_set', $choice_set, $set_id );
	}

	/**
	 * Get the label of an individual choice in a choice set.
	 *
	 * @since x.x.x.
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

		/**
		 * Filter: Modify the label for a particular choice value.
		 *
		 * @since x.x.x.
		 *
		 * @param string    $label     The label for the choice.
		 * @param mixed     $choice    The value for the choice.
		 * @param string    $set_id    The ID of the set that the choice belongs to.
		 */
		return apply_filters( 'make_choice_get_choice_label', $choices[ $choice ], $choice, $set_id );
	}

	/**
	 * Determine if a value is a valid choice.
	 *
	 * @since x.x.x.
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
	 * @since x.x.x.
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