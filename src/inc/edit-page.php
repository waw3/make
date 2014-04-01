<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_page_template_default' ) ) :
/**
 * Change the default page template on the Add New Page screen.
 *
 * @since 1.0.0
 *
 * @return void
 */
function ttf_one_page_template_default() {
	global $typenow, $pagenow, $post;

	// If this is a new page, set the default page template
	if ( 'page' === $typenow && 'post-new.php' === $pagenow ) {
		$post->page_template = 'template-builder.php';
	}
}
endif;

add_action( 'admin_head', 'ttf_one_page_template_default' );