<?php
/**
 * @package Make
 */

/**
 * Interface TTFMAKE_Util_Admin_NoticeInterface
 *
 * @since x.x.x.
 */
interface TTFMAKE_Util_Admin_NoticeInterface extends TTFMAKE_Util_LoadInterface {
	public function register_admin_notice( $id, $message, $args = array() );

	public function sanitize_message( $message );
}