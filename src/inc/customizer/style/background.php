<?php
/**
 * @package Make
 */

/**
 * Build the CSS rules for the color scheme.
 *
 * @since 1.5.0.
 *
 * @return void
 */
function ttfmake_css_background() {
	/**
	 * Header
	 */
	// Header background image
	$header_background_image = get_theme_mod( 'header-background-image', ttfmake_get_default( 'header-background-image' ) );
	if ( ! empty( $header_background_image ) ) {
		// Escape the background image URL properly
		$header_background_image = addcslashes( esc_url_raw( $header_background_image ), '"' );

		// Get and escape related options
		$header_background_repeat   = ttfmake_sanitize_choice( get_theme_mod( 'header-background-repeat', ttfmake_get_default( 'header-background-repeat' ) ), 'header-background-repeat' );
		$header_background_position = ttfmake_sanitize_choice( get_theme_mod( 'header-background-position', ttfmake_get_default( 'header-background-position' ) ), 'header-background-position' );
		$header_background_size     = ttfmake_sanitize_choice( get_theme_mod( 'header-background-size', ttfmake_get_default( 'header-background-size' ) ), 'header-background-size' );

		// Convert position value
		$header_background_position = str_replace( '-', ' ', $header_background_position );

		// All variables are escaped at this point
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.site-header-main' ),
			'declarations' => array(
				'background-image'    => 'url("' . $header_background_image . '")',
				'background-repeat'   => $header_background_repeat,
				'background-position' => $header_background_position,
				'background-size'     => $header_background_size,
			)
		) );
	}
}

add_action( 'make_css', 'ttfmake_css_background' );