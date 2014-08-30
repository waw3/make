<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_customizer_define_header_sections' ) ) :
/**
 * Define the sections and settings for the General panel
 *
 * @since 1.3.0.
 *
 * @param  array    $sections    The master array of Customizer sections
 * @return array                 The augmented master array
 */
function ttfmake_customizer_define_header_sections( $sections ) {
	$panel = 'ttfmake_header';
	$header_sections = array();

	

	// Filter the definitions
	$header_sections = apply_filters( 'make_customizer_header_sections', $header_sections );

	// Merge with master array
	return array_merge( $sections, $header_sections );
}
endif;

add_filter( 'make_customizer_sections', 'ttfmake_customizer_define_header_sections' );