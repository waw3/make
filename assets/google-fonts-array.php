<?php

$base_dir = basename( basename( __FILE__ ) );
$temp_dir = $base_dir . '/assets/temp/';
$dest_dir = $base_dir . '/src/inc/customizer/';

$template = <<<EOD
if ( ! function_exists( 'ttfmake_get_google_fonts' ) ) :
/**
 * Return an array of all available Google Fonts.
 *
 * Updated: %UPDATED%
 *
 * @since  1.0.0.
 *
 * @return array    All Google Fonts.
 */
function ttfmake_get_google_fonts() {
	/**
	 * Allow for developers to modify the allowed Google fonts.
	 *
	 * @since 1.2.3.
	 *
	 * @param array    $fonts    The list of Google fonts with variants and subsets.
	 */
	return apply_filters( 'make_get_google_fonts', %ARRAY% );
}
endif;
EOD;

if ( is_file( $temp_dir . 'googlefonts.json' ) ) {
	$d = file_get_contents( $temp_dir . 'googlefonts.json' );
}

exit();