<?php
/**
 * @package Make
 */

/**
 * Interface TTFMAKE_Utils_ChoicesInterface
 *
 * @since x.x.x.
 */
interface TTFMAKE_Utils_ChoicesInterface {
	public function add_choice_sets( $sets, $overwrite = false );

	public function remove_choice_sets( $set_ids );

	public function get_choice_set( $set_id );

	public function get_choice_label( $set_id, $choice );

	public function is_valid_choice( $set_id, $choice );

	public function sanitize_choice( $value, $set_id, $default = '' );
}