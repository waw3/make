<?php
/**
 * @package Make
 */

/**
 * Add a Make Plus metabox to each qualified post type edit screen
 *
 * @since  1.0.6.
 *
 * @return void
 */
function ttfmake_add_plus_metabox() {
	if ( make_is_plus() || ! is_super_admin() ) {
		return;
	}

	// Post types
	$post_types = get_post_types(
		array(
			'public' => true,
			'_builtin' => false
		)
	);
	$post_types[] = 'post';
	$post_types[] = 'page';

	// Add the metabox for each type
	foreach ( $post_types as $type ) {
		add_meta_box(
			'ttfmake-plus-metabox',
			esc_html__( 'Layout Settings', 'make' ),
			'ttfmake_render_plus_metabox',
			$type,
			'side',
			'default'
		);
	}
}

add_action( 'add_meta_boxes', 'ttfmake_add_plus_metabox' );

/**
 * Render the Make Plus metabox.
 *
 * @since 1.0.6.
 *
 * @param  object    $post    The current post object.
 * @return void
 */
function ttfmake_render_plus_metabox( $post ) {
	// Get the post type label
	$post_type = get_post_type_object( $post->post_type );
	$label = ( isset( $post_type->labels->singular_name ) ) ? $post_type->labels->singular_name : __( 'Post', 'make' );

	echo '<p class="howto">';
	printf(
		esc_html__( 'Looking to configure a unique layout for this %1$s? %2$s', 'make' ),
		esc_html( strtolower( $label ) ),
		sprintf(
			'<a href="%1$s" target="_blank">%2$s</a>',
			esc_url( ttfmake_get_plus_link( 'layout-settings' ) ),
			sprintf(
				esc_html__( 'Upgrade to %s.', 'make' ),
				'Make Plus'
			)
		)
	);
	echo '</p>';
}
