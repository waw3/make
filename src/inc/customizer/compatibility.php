<?php
/**
 * @package Make
 */


function ttfmake_customizer_get_key_conversions() {
	// $new => $old
	$conversions = array(
		'typography-sitetitle-family' => 'font-site-title',
	);

	return apply_filters( 'make_customizer_key_conversions', $conversions );
}


function ttfmake_customizer_key_conversion_filter( $value ) {
	$theme_mods = get_theme_mods();
	$conversions = ttfmake_customizer_get_key_conversions();

	// Reverse-engineer the setting key from the filter
	$filter = current_filter();
	$new_key = str_replace( 'theme_mod_', '', $filter );

	// Use the value from the old key, if it exists
	if ( isset( $conversions[$new_key] )  ) {
		$old_key = $conversions[$new_key];
		if ( isset( $theme_mods[$old_key] ) ) {
			$value = $theme_mods[$old_key];
		}
	}

	return $value;
}


function ttfmake_customizer_add_key_conversion_filters() {
	$theme_mods = get_theme_mods();
	$conversions = ttfmake_customizer_get_key_conversions();

	// Add a filter for each new key that doesn't yet exist but has an existing value for the old key
	foreach ( $conversions as $new_key => $old_key ) {
		if ( ! isset( $theme_mods[$new_key] ) && isset( $theme_mods[$old_key] ) ) {
			add_filter( 'theme_mod_' . $new_key, 'ttfmake_customizer_key_conversion_filter', 1 );
		}
	}
}

add_action( 'wp', 'ttfmake_customizer_add_key_conversion_filters' );