<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Admin_NoticeInterface
 *
 * @since x.x.x.
 */
interface MAKE_Admin_NoticeInterface {
	public function register_admin_notice( $id, $message, $args = array() );
}