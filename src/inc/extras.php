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
	$classes[] = get_theme_mod( 'general-layout', ttfmake_get_default( 'general-layout' ) );

	// Header branding position
	if ( 'right' === get_theme_mod( 'header-branding-position', ttfmake_get_default( 'header-branding-position' ) ) ) {
		$classes[] = 'branding-right';
	}

	// Header Bar text position
	if ( 'flipped' === get_theme_mod( 'header-bar-content-layout', ttfmake_get_default( 'header-bar-content-layout' ) ) ) {
		$classes[] = 'header-bar-flipped';
	}

	// Left Sidebar
	if ( true === ttfmake_has_sidebar( 'left' ) ) {
		$classes[] = 'has-left-sidebar';
	}

	// Right Sidebar
	if ( true === ttfmake_has_sidebar( 'right' ) ) {
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
	$author_key    = 'layout-' . ttfmake_get_view() . '-post-author';
	$author_option = ttfmake_sanitize_choice( get_theme_mod( $author_key, ttfmake_get_default( $author_key ) ), $author_key );

	if ( 'avatar' === $author_option ) {
		$classes[] = 'has-author-avatar';
	}

	return $classes;
}
endif;

add_filter( 'post_class', 'ttfmake_maybe_add_with_avatar_class', 10, 3 );

if ( ! function_exists( 'sanitize_hex_color' ) ) :
/**
 * Sanitizes a hex color.
 *
 * This is a copy of the core function for use when the customizer is not being shown.
 *
 * @since  1.0.0.
 *
 * @param  string         $color    The proposed color.
 * @return string|null              The sanitized color.
 */
function sanitize_hex_color( $color ) {
	if ( '' === $color ) {
		return '';
	}
	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}
	return null;
}
endif;

if ( ! function_exists( 'sanitize_hex_color_no_hash' ) ) :
/**
 * Sanitizes a hex color without a hash. Use sanitize_hex_color() when possible.
 *
 * This is a copy of the core function for use when the customizer is not being shown.
 *
 * @since  1.0.0.
 *
 * @param  string         $color    The proposed color.
 * @return string|null              The sanitized color.
 */
function sanitize_hex_color_no_hash( $color ) {
	$color = ltrim( $color, '#' );
	if ( '' === $color ) {
		return '';
	}
	return sanitize_hex_color( '#' . $color ) ? $color : null;
}
endif;

if ( ! function_exists( 'maybe_hash_hex_color' ) ) :
/**
 * Ensures that any hex color is properly hashed.
 *
 * This is a copy of the core function for use when the customizer is not being shown.
 *
 * @since  1.0.0.
 *
 * @param  string         $color    The proposed color.
 * @return string|null              The sanitized color.
 */
function maybe_hash_hex_color( $color ) {
	if ( $unhashed = sanitize_hex_color_no_hash( $color ) ) {
		return '#' . $unhashed;
	}
	return $color;
}
endif;

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