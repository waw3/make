<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Choices_ChoicesInterface
 *
 * @since x.x.x.
 */
interface MAKE_Choices_ChoicesInterface extends MAKE_Util_ModulesInterface {
	public function add_choice_sets( $sets, $overwrite = false );

	public function remove_choice_sets( $set_ids );

	public function choice_set_exists( $set_id );

	public function get_choice_set( $set_id );

	public function get_choice_label( $value, $set_id );

	public function is_valid_choice( $value, $set_id );

	public function sanitize_choice( $value, $set_id, $default = '' );
}