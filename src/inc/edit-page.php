<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttfmake_edit_page_script' ) ) :
/**
 * Enqueue scripts that run on the Edit Page screen
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttfmake_edit_page_script() {
	global $pagenow;

	wp_enqueue_script(
		'ttfmake-admin-edit-page',
		get_template_directory_uri() . '/js/admin/edit-page.js',
		array( 'jquery' ),
		TTF_ONE_VERSION,
		true
	);

	wp_localize_script(
		'ttfmake-admin-edit-page',
		'ttfOneEditPageData',
		array(
			'featuredImage' => __( 'Featured images are not available for this page while using the current page template.', 'make' ),
			'pageNow'       => esc_js( $pagenow ),
		)
	);
}
endif;

add_action( 'admin_enqueue_scripts', 'ttfmake_edit_page_script' );
