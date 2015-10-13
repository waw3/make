<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Util_Admin_NoticeInterface
 *
 * @since x.x.x.
 */
interface MAKE_Util_Admin_NoticeInterface extends MAKE_Util_LoadInterface {
	public function register_admin_notice( $id, $message, $args = array() );

	public function sanitize_message( $message );
}