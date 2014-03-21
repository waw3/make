<?php
/**
 * @package ttf-one
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function ttf_one_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'ttf_one_page_menu_args' );

if ( ! function_exists( 'ttf_one_body_classes' ) ) :
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ttf_one_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Left Sidebar
	if ( true === ttf_one_has_sidebar( 'left' ) ) {
		$classes[] = 'has-left-sidebar';
	}

	// Right Sidebar
	if ( true === ttf_one_has_sidebar( 'right' ) ) {
		$classes[] = 'has-right-sidebar';
	}

	return $classes;
}
endif;

add_filter( 'body_class', 'ttf_one_body_classes' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function ttf_one_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() ) {
		return $title;
	}

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'ttf-one' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'ttf_one_wp_title', 10, 2 );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function ttf_one_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'ttf_one_setup_author' );

if ( ! function_exists( 'ttf_one_has_sidebar' ) ) :
/**
 * Determine if the current view should show a sidebar in the given location.
 *
 * @since 1.0.0
 *
 * @param string $location
 *
 * @return bool
 */
function ttf_one_has_sidebar( $location ) {
	global $wp_registered_sidebars;

	// Validate the sidebar location
	if ( ! in_array( 'sidebar-' . $location, array_keys( $wp_registered_sidebars ) ) ) {
		return false;
	}

	$show_sidebar = false;

	// Post types
	$post_types = get_post_types(
		array(
			'public' => true,
			'_builtin' => false
		)
	);
	$post_types[] = 'post';

	// Post parent
	$parent_post_type = '';
	if ( is_attachment() ) {
		$post_parent = get_post()->post_parent;
		$parent_post_type = get_post_type( $post_parent );
	}

	// Posts and public custom post types
	if ( is_singular( $post_types ) || ( is_attachment() && in_array( $parent_post_type, $post_types ) ) ) {
		$show_sidebar = (bool) get_theme_mod( 'main-sidebar-' . $location . '-posts', ttf_one_get_default( 'main-sidebar-' . $location . '-posts' ) );
	}
	// Pages
	else if ( is_page() || ( is_attachment() && 'page' === $parent_post_type ) ) {
		$show_sidebar = (bool) get_theme_mod( 'main-sidebar-' . $location . '-pages', ttf_one_get_default( 'main-sidebar-' . $location . '-pages' ) );
	}
	// Blog and Archives
	else if ( is_archive() || is_home() ) {
		$show_sidebar = (bool) get_theme_mod( 'main-sidebar-' . $location . '-archives', ttf_one_get_default( 'main-sidebar-' . $location . '-archives' ) );
	}
	// Search results
	else if ( is_search() ) {
		$show_sidebar = (bool) get_theme_mod( 'main-sidebar-' . $location . '-search', ttf_one_get_default( 'main-sidebar-' . $location . '-search' ) );
	}

	// Filter and return
	return apply_filters( 'ttf_one_has_sidebar', $show_sidebar, $location );
}
endif;