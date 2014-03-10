<?php
/**
 * @package ttf-one
 */

/**
 * Temporary function for debugging global options
 */
function ttf_one_customizer_options_dump() {
	$mods = get_option( 'theme_mods_ttf-one' );
	var_dump( $mods );
}