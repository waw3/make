<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_customizer_init' ) ) :
/**
 * Load the customizer files and enqueue scripts
 *
 * @since 1.0
 */
function ttf_one_customizer_init() {
	$path = '/inc/customizer/';

	// Only load these on the backend
	if ( is_admin() ) {
		require_once( get_template_directory() . $path . 'customizer.php' );
	}

	// Always load these
	require_once( get_template_directory() . $path . 'customizer-helpers.php' );

	//
	add_action( 'admin_enqueue_scripts', 'ttf_one_customizer_admin_scripts' );
}
endif;

add_action( 'after_setup_theme', 'ttf_one_customizer_init' );

if ( ! function_exists( 'ttf_one_customizer_admin_scripts' ) ) :
/**
 * Enqueue customizer admin scripts
 *
 * @since 1.0
 */
function ttf_one_customizer_admin_scripts() {
	$path = '/inc/customizer/';

	wp_enqueue_script(
		'ttf-one-customizer-admin',
		get_template_directory() . $path . 'customizer.js',
		array( 'customize-preview' ),
		TTF_ONE_VERSION,
		true
	);
}
endif;