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

	public function find_match( $url );

	public function render_icons();
}