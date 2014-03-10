<?php
/**
 * @package ttf-one
 */

function ttf_one_customizer_options_dump() {
	$mods = get_option( 'theme_mods_ttf-one' );
	var_dump( $mods );
}