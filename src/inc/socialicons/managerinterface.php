<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_SocialIcons_ManagerInterface
 *
 * @since x.x.x.
 */
interface MAKE_SocialIcons_ManagerInterface extends MAKE_Util_ModulesInterface {
	public function add_icons( $icons, $overwrite = false );

	public function remove_icons( $icons );

	public function get_icons();

	public function find_match( $item );

	public function get_icon_data();

	public function has_icon_data();

	public function render_icons();
}