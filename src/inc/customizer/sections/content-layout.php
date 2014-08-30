<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_customizer_define_contentlayout_sections' ) ) :
/**
 * Define the sections and settings for the Content & Layout panel
 *
 * @since 1.3.0.
 *
 * @param  array    $sections    The master array of Customizer sections
 * @return array                 The augmented master array
 */
function ttfmake_customizer_define_contentlayout_sections( $sections ) {
	$theme_prefix = 'ttfmake_';
	$panel = 'ttfmake_content-layout';
	$content_sections = array();



	// Filter the definitions
	$content_sections = apply_filters( 'make_customizer_contentlayout_sections', $content_sections );

	// Merge with master array
	return array_merge( $sections, $content_sections );
}
endif;

add_filter( 'make_customizer_sections', 'ttfmake_customizer_define_contentlayout_sections' );