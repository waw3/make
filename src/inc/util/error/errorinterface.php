<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Util_Error_ErrorInterface
 *
 * @since x.x.x.
 */
interface MAKE_Util_Error_ErrorInterface extends MAKE_Util_LoadInterface {
	public function add_error( $code, $message, $data = '' );

	public function has_errors();
}