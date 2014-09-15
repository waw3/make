<?php
global $ttfmake_overlay_id, $ttfmake_section_data, $ttfmake_is_js_template;
$ttfmake_overlay_id = 'ttfmake-configuration-overlay';
$section_name       = ttfmake_get_section_name( $ttfmake_section_data, $ttfmake_is_js_template );

// Include the header
get_template_part( '/inc/builder/core/templates/overlay', 'header' );

// Sort the config in case 3rd party code added another input
ksort( $ttfmake_section_data['section']['config'], SORT_NUMERIC );

// Print the inputs
$output = '';

foreach ( $ttfmake_section_data['section']['config'] as $input ) {
	if ( isset( $input['type'] ) && isset( $input['name'] ) ) {
		$output .= ttfmake_create_input( $section_name, $input, $ttfmake_section_data );
	}
}

echo $output;

get_template_part( '/inc/builder/core/templates/overlay', 'footer' );