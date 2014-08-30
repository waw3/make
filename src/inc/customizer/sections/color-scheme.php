<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_customizer_define_colorscheme_sections' ) ) :
/**
 * Define the sections and settings for the General panel
 *
 * @since 1.3.0.
 *
 * @param  array    $sections    The master array of Customizer sections
 * @return array                 The augmented master array
 */
function ttfmake_customizer_define_colorscheme_sections( $sections ) {
	$panel = 'ttfmake_color-scheme';
	$colorscheme_sections = array();

	/**
	 * General
	 */

	/**
	 * Background
	 */

	/**
	 * Header
	 */

	/**
	 * Main Column
	 */

	/**
	 * Sidebars
	 */

	/**
	 * Widgets
	 */

	/**
	 * Footer
	 */


	// Filter the definitions
	$colorscheme_sections = apply_filters( 'make_customizer_colorscheme_sections', $colorscheme_sections );

	// Merge with master array
	return array_merge( $sections, $colorscheme_sections );
}
endif;

add_filter( 'make_customizer_sections', 'ttfmake_customizer_define_colorscheme_sections' );