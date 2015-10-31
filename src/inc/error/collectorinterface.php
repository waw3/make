<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Error_CollectorInterface
 *
 * @since x.x.x.
 */
interface MAKE_Error_CollectorInterface {
	public function add_error( $code, $message, $data = '' );

	public function has_errors();
}