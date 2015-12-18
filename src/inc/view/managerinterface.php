<?php
/**
 * @package Make
 */


interface MAKE_View_ManagerInterface extends MAKE_Util_ModulesInterface {
	public function add_view( $view_id, array $args = array(), $overwrite = false );

	public function remove_view( $view_id );

	public function get_sorted_views();

	public function get_current_view();

	public function is_current_view( $view_id );
}