<?php
/**
 * @package Make
 */


interface MAKE_APIInterface extends MAKE_Util_ModulesInterface {
	public function inject_module( $module_name );
}