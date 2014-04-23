<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_edit_page_script' ) ) :
/**
 * Enqueue scripts that run on the Edit Page screen
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttf_one_edit_page_script() {
	global $pagenow;

	wp_enqueue_script(
		'ttf-one-admin-edit-page',
		get_template_directory_uri() . '/js/admin/edit-page.js',
		array( 'jquery' ),
		time(),
		true
	);

	wp_localize_script(
		'ttf-one-admin-edit-page',
		'TTFOneEditPage',
		array(
			'featuredImage' => __( 'Featured images are not available for this page while using the current page template.', 'ttf-one' ),
			'pageNow'       => esc_js( $pagenow ),
		)
	);
}
endif;

add_action( 'admin_enqueue_scripts', 'ttf_one_edit_page_script' );
