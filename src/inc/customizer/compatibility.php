<?php
/**
 * @package Make
 */


function ttfmake_customizer_get_key_conversions() {
	// $new => $old
	$conversions = array(
		'font-site-title-family' => 'font-site-title',
		'font-h1-family'		 => 'font-header',
		'font-body-family'       => 'font-body',
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


function ttfmake_customizer_migrate_header_options() {
	$theme_mods = get_theme_mods();

	// New header option keys
	$new_header_family_keys = array(
		'font-h1-family',
		'font-h2-family',
		'font-h3-family',
		'font-h4-family',
		'font-h5-family',
		'font-h6-family',
	);
	$new_header_size_keys = array(
		'font-h1-size',
		'font-h2-size',
		'font-h3-size',
		'font-h4-size',
		'font-h5-size',
		'font-h6-size',
	);
	$new_header_keys = array_merge( $new_header_family_keys, $new_header_size_keys );

	// Test for new header keys in the theme mod array
	$diff = array_diff_key( $new_header_keys, $theme_mods );
	$has_new_keys = ( count( $new_header_keys ) !== count( $diff ) );

	// Only set new theme mod values if no new keys exist and one of the old keys has a non-default value
	if ( ! $has_new_keys ) {
		// Check for customized header font family
		if ( isset( $theme_mods['font-header'] ) ) {
			$header_family = get_theme_mod( 'font-header' );
			foreach ( $new_header_family_keys as $key ) {
				set_theme_mod( $key, $header_family );
			}
			remove_theme_mod( 'font-header' );
		}

		// Check for customized header font size
		if ( isset( $theme_mods['font-header-size'] ) ) {
			$header_size = get_theme_mod( 'font-header-size' );
			$percent = apply_filters( 'ttfmake_font_relative_size', array(
				'h1' => 100,
				'h2' => 68,
				'h3' => 48,
				'h4' => 48,
				'h5' => 32,
				'h6' => 28,
			) );
			foreach ( $new_header_size_keys as $key ) {
				$h = preg_replace( '/font-(h\d)-size/', '$1', $key );
				set_theme_mod( $key, ttfmake_get_relative_font_size( $header_size, $percent[$h] ) );
			}
			remove_theme_mod( 'font-header-size' );
		}
	}
}

// TODO hook up header function