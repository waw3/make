<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_page_support' ) ) :
/**
 * Modify the edit screen features supported by the Page post type
 *
 * @since 1.0.0
 *
 * @return void
 */
function ttf_one_page_support() {
	// Remove the editor if the Page Builder is enabled
	if ( class_exists( 'TTF_One_Builder_Base' ) ) {
		remove_post_type_support( 'page', 'editor' );
	}
}
endif;

add_action( 'admin_init', 'ttf_one_page_support' );
