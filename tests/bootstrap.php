<?php
/**
 * @package Make
 */

// Check PHP version
if ( version_compare( PHP_VERSION, '5.4', '<' ) ) {
	die( 'Make\'s test suite requires PHP version 5.4 or higher.' );
}

/**
 * Load 'bootstrap-custom.php' if it exists. This allows a tester to define
 * a custom directory for the WordPress tests directory.
 */
if ( is_readable( dirname( __FILE__ ) . '/bootstrap-custom.php' ) ) {
	include_once dirname( __FILE__ ) . '/bootstrap-custom.php';
}

/**
 * Define the path to the WordPress tests directory. This script assumes
 * the tests are being run within an instance of Varying Vagrant Vagrants
 * (https://github.com/Varying-Vagrant-Vagrants/VVV/). To use a different
 * path, define the variable in the 'bootstrap-custom.php' file, which
 * will be loaded above.
 */
if ( ! isset( $wp_tests_dir ) ) {
	$wp_tests_dir = '/srv/www/wordpress-develop/tests/phpunit';
}

// Load WP testing functions.
require_once $wp_tests_dir . '/includes/functions.php';

/**
 * Set the active theme and plugins.
 */
function make_manually_load_environment() {
	// Switch to Make theme
	switch_theme( 'make' );

	// Update active plugins array
	$plugins_to_activate = array(
		'make-plus/make-plus.php'
	);

	update_option( 'active_plugins', $plugins_to_activate );
}

tests_add_filter( 'muplugins_loaded', 'make_manually_load_environment' );

// Load WP testing bootstrap routine.
require $wp_tests_dir . '/includes/bootstrap.php';