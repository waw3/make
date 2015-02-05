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
	// Regions
	$regions = array(
		'header' => array( '.site-header-main' ),
		'main'   => array( '.site-content' ),
		'footer' => array( '.site-footer' ),
	);

	foreach ( $regions as $region => $selectors ) {
		$background_image = get_theme_mod( $region . '-background-image', ttfmake_get_default( $region . '-background-image' ) );
		if ( ! empty( $background_image ) ) {
			// Escape the background image URL properly
			$background_image = addcslashes( esc_url_raw( $background_image ), '"' );

			// Get and escape related options
			$background_repeat   = ttfmake_sanitize_choice( get_theme_mod( $region . '-background-repeat', ttfmake_get_default( $region . '-background-repeat' ) ), $region . '-background-repeat' );
			$background_position = ttfmake_sanitize_choice( get_theme_mod( $region . '-background-position', ttfmake_get_default( $region . '-background-position' ) ), $region . '-background-position' );
			$background_attachment = ttfmake_sanitize_choice( get_theme_mod( $region . '-background-attachment', ttfmake_get_default( $region . '-background-attachment' ) ), $region . '-background-attachment' );
			$background_size     = ttfmake_sanitize_choice( get_theme_mod( $region . '-background-size', ttfmake_get_default( $region . '-background-size' ) ), $region . '-background-size' );

			// Convert position value
			$background_position = str_replace( '-', ' ', $background_position );

			// All variables are escaped at this point
			ttfmake_get_css()->add( array(
				'selectors'    => $selectors,
				'declarations' => array(
					'background-image'      => 'url("' . $background_image . '")',
					'background-repeat'     => $background_repeat,
					'background-position'   => $background_position,
					'background-attachment' => $background_attachment,
					'background-size'       => $background_size,
				)
			) );
		}
	}
}

add_action( 'make_css', 'ttfmake_css_background' );