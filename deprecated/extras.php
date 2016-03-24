<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_body_classes' ) ) :
/**
 * Adds custom classes to the array of body classes.
 *
 * @since  1.0.0.
 *
 * @param  array    $classes    Classes for the body element.
 * @return array                Modified class list.
 */
function ttfmake_body_classes( $classes ) {
	// Full-width vs Boxed
	$classes[] = make_get_thememod_value( 'general-layout' );

	// Header branding position
	if ( 'right' === make_get_thememod_value( 'header-branding-position' ) ) {
		$classes[] = 'branding-right';
	}

	// Header Bar text position
	if ( 'flipped' === make_get_thememod_value( 'header-bar-content-layout' ) ) {
		$classes[] = 'header-bar-flipped';
	}

	// Left Sidebar
	if ( true === make_has_sidebar( 'left' ) ) {
		$classes[] = 'has-left-sidebar';
	}

	// Right Sidebar
	if ( true === make_has_sidebar( 'right' ) ) {
		$classes[] = 'has-right-sidebar';
	}

	return $classes;
}
endif;

add_filter( 'body_class', 'ttfmake_body_classes' );

if ( ! function_exists( 'ttfmake_maybe_add_with_avatar_class' ) ) :
/**
 * Add a class to the bounding div if a post uses an avatar with the author byline.
 *
 * @since  1.0.11.
 *
 * @param  array     $classes    An array of post classes.
 * @param  string    $class      A comma-separated list of additional classes added to the post.
 * @param  int       $post_ID    The post ID.
 * @return array                 The modified post class array.
 */
function ttfmake_maybe_add_with_avatar_class( $classes, $class, $post_ID ) {
	if ( is_admin() ) {
		return $classes;
	}

	$author_key    = 'layout-' . make_get_current_view() . '-post-author';
	$author_option = make_get_thememod_value( $author_key );

	if ( 'avatar' === $author_option ) {
		$classes[] = 'has-author-avatar';
	}

	return $classes;
}
endif;

add_filter( 'post_class', 'ttfmake_maybe_add_with_avatar_class', 10, 3 );

if ( ! function_exists( 'ttfmake_excerpt_more' ) ) :
/**
 * Modify the excerpt suffix
 *
 * @since 1.0.0.
 *
 * @param string $more
 *
 * @return string
 */
function ttfmake_excerpt_more( $more ) {
	return ' &hellip;';
}
endif;

add_filter( 'excerpt_more', 'ttfmake_excerpt_more' );

/**
 * Add a wrapper div to the output of oembeds and the [embed] shortcode.
 *
 * Also enqueues FitVids, since the embed might be a video.
 *
 * @since 1.0.0.
 *
 * @param  string    $html    The generated HTML of the embed handler.
 * @param  string    $url     The embed URL.
 * @param  array     $attr    The attributes of the embed shortcode.
 *
 * @return string             The wrapped HTML.
 */
function ttfmake_embed_container( $html, $url, $attr ) {
	// Bail if this is the admin or an RSS feed
	if ( is_admin() || is_feed() ) {
		return $html;
	}

	if ( isset( $attr['width'] ) ) {
		// Add FitVids as a dependency for the Frontend script
		global $wp_scripts;
		if ( is_object( $wp_scripts ) && 'WP_Scripts' === get_class( $wp_scripts ) ) {
			$script = $wp_scripts->query( 'ttfmake-global', 'registered' );
			if ( $script && ! in_array( 'fitvids', $script->deps ) ) {
				$script->deps[] = 'fitvids';
			}
		}

		// Get classes
		$default_class = 'ttfmake-embed-wrapper';
		$align_class = 'aligncenter';
		if ( isset( $attr['make_align'] ) ) {
			$align = trim( $attr['make_align'] );
			if ( in_array( $align, array( 'left', 'right', 'center', 'none' ) ) ) {
				$align_class = 'align' . $align;
			}
		}
		$class = trim( "$default_class $align_class" );

		// Get style
		$style = 'max-width: ' . absint( $attr['width'] ) . 'px;';

		// Build wrapper
		$wrapper = "<div class=\"$class\" style=\"$style\">%s</div>";
		$html = sprintf( $wrapper, $html );
	}

	return $html;
}

add_filter( 'embed_handler_html', 'ttfmake_embed_container', 10, 3 );
add_filter( 'embed_oembed_html' , 'ttfmake_embed_container', 10, 3 );