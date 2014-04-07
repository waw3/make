<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_page_screen_script' ) ) :
/**
 * Enqueue scripts that run on the Edit Page screen
 *
 * @since 1.0.0
 *
 * @return void
 */
function ttf_one_page_screen_script() {
	wp_enqueue_script(
		'ttf-one-admin-edit-page',
		get_template_directory_uri() . '/js/admin/edit-page.js',
		array( 'jquery' ),
		TTF_ONE_VERSION,
		true
	);
}
endif;

add_action( 'admin_enqueue_scripts', 'ttf_one_page_screen_script' );
