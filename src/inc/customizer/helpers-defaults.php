<?php
/**
 * @package ttf-one
 */

/**
 *
 */
function ttf_one_option_defaults() {
	$defaults = array(
		// Site Title & Tagline
		'hide-site-title' => 0,
		'hide-tagline' => 0,
		//
	);

	return apply_filters( 'ttf_one_option_defaults', $defaults );
}

/**
 *
 */
function ttf_one_get_default( $option ) {
	$defaults = ttf_one_option_defaults();
	return ( isset( $defaults[$option] ) ) ? $defaults[$option] : false;
}