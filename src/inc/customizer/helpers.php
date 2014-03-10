<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_sanitize_choice' ) ) :
/**
 * Sanitize a value from a list of allowed values.
 *
 * The first value in the 'allowed_choices' array will be the default if the given
 * value doesn't match anything in the array.
 *
 * @param mixed $value
 * @param mixed $setting
 *
 * @return mixed
 */
function ttf_one_sanitize_choice( $value, $setting ) {
	if ( is_object( $setting ) ) {
		$setting = $setting->id;
	}

	$allowed_choices = array( 0 );

	switch ( $setting ) {
		case 'site-layout' :
			$allowed_choices = array( 'full-width', 'boxed' );
			break;
	}

	if ( ! in_array( $value, $allowed_choices ) ) {
		$value = $allowed_choices[0];
	}

	return $value;
}
endif;