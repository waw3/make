<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_customizer_get_key_migrations' ) ) :
/**
 * Return an array of option key migration sets.
 *
 * @since 1.3.0.
 *
 * @return array    The list of key migration sets.
 */
function ttfmake_customizer_get_key_migrations() {
	/**
	 * Sets are defined by the theme version they pertain to:
	 * $theme_version => array
	 *     $old => $new
	 */
	$migrations = array(
		'1.3.0' => array(
			'font-site-title'			=> 'font-family-site-title',
			'font-header'				=> array(
				'font-family-h1', 'font-family-h2', 'font-family-h3', 'font-family-h4', 'font-family-h5', 'font-family-h6'
			),
			'font-body'					=> 'font-family-body',
			'font-site-title-size'		=> 'font-size-site-title',
			'font-site-tagline-size'	=> 'font-size-site-tagline',
			'font-nav-size'				=> 'font-size-nav',
			'font-header-size'			=> array(
				'font-size-h1', 'font-size-h2', 'font-size-h3', 'font-size-h4', 'font-size-h5', 'font-size-h6'
			),
			'font-widget-size'			=> 'font-size-widget',
			'font-body-size'			=> 'font-size-body',
		),
	);

	return apply_filters( 'make_customizer_key_migrations', $migrations );
}
endif;

if ( ! function_exists( 'ttfmake_customizer_get_key_migration_callbacks' ) ) :
/**
 * Return an array of callbacks for a particular migration set.
 *
 * @since 1.3.0.
 *
 * @param  string    $version    The theme version to get the callbacks for
 * @return array                 An array containing any callbacks for the specified set
 */
function ttfmake_customizer_get_key_migration_callbacks( $version ) {
	// $theme_version => array
	// 		$key => $callback
	$all_callbacks = array(
		'1.3.0' => array(
			'font-header-size'			=> 'ttfmake_customizer_header_sizes_callback',
		),
	);

	// Get the callbacks for the specified version
	$callbacks = array();
	if ( isset( $all_callbacks[$version] ) ) {
		$callbacks = $all_callbacks[$version];
	}

	return apply_filters( 'make_customizer_key_migration_callbacks', $callbacks, $version );
}
endif;

if ( ! function_exists( 'ttfmake_customizer_migrate_options' ) ) :
/**
 * Migrate old theme options to newer equivalents.
 *
 * This function parses the array of key migration sets from ttfmake_customizer_get_key_migrations(),
 * and compares the theme versions to an array of migration sets that have already been performed (if any).
 * For each migration set that hasn't been performed yet:
 * 1. Check to see if any of the new keys already exist. Don't perform the migration if any do.
 * 2. Process each migration rule in the set, either with the specified callback, or by copying the
 *    old value over to each of the related new keys.
 * Afterward, migration sets that were performed are stored in a theme mod called 'options-migrated' to
 * ensure that they won't be performed again.
 *
 * @since 1.3.0.
 *
 * @return void
 */
function ttfmake_customizer_migrate_options() {
	// Don't run migrations if WordPress version is not 4.0+
	if ( ! ttfmake_customizer_supports_panels() ) {
		return;
	}

	// Get the array of migration definitions
	$migrations = ttfmake_customizer_get_key_migrations();

	// Bail if all of the migrations have already been performed
	$migration_versions = array_keys( $migrations );
	$migrated = get_theme_mod( 'options-migrated', array() );
	$missing_migrations = array_diff_key( $migration_versions, $migrated );
	if ( empty( $missing_migrations ) ) {
		return;
	}

	// Get array of all the theme mods for later use
	$theme_mods = get_theme_mods();

	// Run each migration set that hasn't been done yet
	foreach ( $missing_migrations as $version ) {
		// Compile new keys
		$new_keys = array();
		foreach ( $migrations[$version] as $old => $new ) {
			$new_keys = array_merge( $new_keys, (array) $new );
		}

		// Test for new header keys in the theme mod array
		$diff = array_diff_key( $new_keys, $theme_mods );
		$has_new_keys = ( count( $new_keys ) !== count( $diff ) );

		// Only run the migration if none of the new keys exist yet
		if ( ! $has_new_keys ) {
			// Check for special callbacks
			$callbacks = ttfmake_customizer_get_key_migration_callbacks( $version );

			// Process each migration rule
			foreach ( $migrations[$version] as $old => $new ) {
				// Get the old value, even if it's a default
				// (The new key might not have the same default)
				$value = get_theme_mod( $old, ttfmake_get_default( $old ) );

				// Run the special callback for the option, if it exists
				if ( isset( $callbacks[$old] ) ) {
					call_user_func_array( $callbacks[$old], array( $value, $new ) );
				}
				// Otherwise set all the related new keys to the old key's value
				else {
					foreach ( (array) $new as $new_key ) {
						set_theme_mod( $new_key, $value );
					}
				}
			}
		}

		// Add the version to the array of completed migrations
		$migrated[] = $version;
	}

	// Update the array of completed migrations
	set_theme_mod( 'options-migrated', $migrated );
}
endif;

add_action( 'init', 'ttfmake_customizer_migrate_options' );

if ( ! function_exists( 'ttfmake_customizer_header_sizes_callback' ) ) :
/**
 * Convert the old header size value into separate sizes (H1-H6).
 *
 * @since 1.3.0.
 *
 * @param  int      $value       The old key value
 * @param  array    $new_keys    The new option keys
 * @return void
 */
function ttfmake_customizer_header_sizes_callback( $value, $new_keys ) {
	// Define the relative percentages
	$percent = apply_filters( 'ttfmake_font_relative_size', array(
		'h1' => 100,
		'h2' => 68,
		'h3' => 48,
		'h4' => 48,
		'h5' => 32,
		'h6' => 28,
	) );

	// Set the new font sizes
	foreach ( $new_keys as $key ) {
		$h = preg_replace( '/font-size-(h\d)/', '$1', $key );
		if ( $h ) {
			set_theme_mod( $key, ttfmake_get_relative_font_size( $value, $percent[$h] ) );
		}
	}
}
endif;