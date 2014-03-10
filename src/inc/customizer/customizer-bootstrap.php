<?php
/**
 * @package ttf-one
 */

function ttf_one_customizer_init() {
	$path = '/inc/customizer/';

	// Only load these on the backend
	if ( is_admin() ) {
		require_once( get_template_directory() . $path . 'customizer.php' );

		add_action( 'admin_enqueue_scripts', 'ttf_one_customizer_admin_scripts' );
	}

	// Always load these
	require_once( get_template_directory() . $path . 'customizer.php' );
}

add_action( 'after_setup_theme', 'ttf_one_customizer_init' );

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