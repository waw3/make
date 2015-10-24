<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Error_ErrorInterface
 *
 * @since x.x.x.
 */
interface MAKE_Error_ErrorInterface {
	public function add_error( $code, $message, $data = '' );

	public function has_errors();
}