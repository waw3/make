<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_css_add_rules' ) ) :
/**
 * Process user options to generate CSS needed to implement the choices.
 *
 * This function reads in the options from theme mods and determines whether a CSS rule is needed to implement an
 * option. CSS is only written for choices that are non-default in order to avoid adding unnecessary CSS. All options
 * are also filterable allowing for more precise control via a child theme or plugin.
 *
 * Note that all CSS for options is present in this function except for the CSS for fonts and the logo, which require
 * a lot more code to implement.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttfmake_css_add_rules() {
	/**
	 * Background section
	 */
	$site_background_image = get_theme_mod( 'background_image', ttfmake_get_default( 'background_image' ) );
	if ( ! empty( $site_background_image ) ) {
		// Note that most site background options are handled by internal WordPress functions
		$site_background_size = ttfmake_sanitize_choice( get_theme_mod( 'background_size', ttfmake_get_default( 'background_size' ) ), 'background-size' );

		ttfmake_get_css()->add( array(
			'selectors'    => array( 'body' ),
			'declarations' => array(
				'background-size' => $site_background_size
			)
		) );
	}

	/**
	 * Header section
	 */
	// Get and escape options
	$header_background_image     = get_theme_mod( 'header-background-image', ttfmake_get_default( 'header-background-image' ) );

	// Header background image
	if ( ! empty( $header_background_image ) ) {
		// Escape the background image URL properly
		$header_background_image = addcslashes( esc_url_raw( $header_background_image ), '"' );

		// Get and escape related options
		$header_background_size     = ttfmake_sanitize_choice( get_theme_mod( 'header-background-size', ttfmake_get_default( 'header-background-size' ) ), 'header-background-size' );
		$header_background_repeat   = ttfmake_sanitize_choice( get_theme_mod( 'header-background-repeat', ttfmake_get_default( 'header-background-repeat' ) ), 'header-background-repeat' );
		$header_background_position = ttfmake_sanitize_choice( get_theme_mod( 'header-background-position', ttfmake_get_default( 'header-background-position' ) ), 'header-background-position' );

		// All variables are escaped at this point
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.site-header-main' ),
			'declarations' => array(
				'background-image'    => 'url("' . $header_background_image . '")',
				'background-size'     => $header_background_size,
				'background-repeat'   => $header_background_repeat,
				'background-position' => $header_background_position . ' center'
			)
		) );
	}

	/**
	 * Main section
	 */
	// Get and escape options
	$main_background_image       = get_theme_mod( 'main-background-image', ttfmake_get_default( 'main-background-image' ) );

	// Main background image
	if ( ! empty( $main_background_image ) ) {
		// Escape the background image URL properly
		$main_background_image = addcslashes( esc_url_raw( $main_background_image ), '"' );

		// Get and escape related options
		$main_background_size     = ttfmake_sanitize_choice( get_theme_mod( 'main-background-size', ttfmake_get_default( 'main-background-size' ) ), 'main-background-size' );
		$main_background_repeat   = ttfmake_sanitize_choice( get_theme_mod( 'main-background-repeat', ttfmake_get_default( 'main-background-repeat' ) ), 'main-background-repeat' );
		$main_background_position = ttfmake_sanitize_choice( get_theme_mod( 'main-background-position', ttfmake_get_default( 'main-background-position' ) ), 'main-background-position' );

		// All variables are escaped at this point
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.site-content' ),
			'declarations' => array(
				'background-image'    => 'url("' . $main_background_image . '")',
				'background-size'     => $main_background_size,
				'background-repeat'   => $main_background_repeat,
				'background-position' => $main_background_position . ' top'
			)
		) );
	}

	/**
	 * Footer section
	 */
	// Get and escape options
	$footer_background_image = get_theme_mod( 'footer-background-image', ttfmake_get_default( 'footer-background-image' ) );

	// Footer background image
	if ( ! empty( $footer_background_image ) ) {
		// Escape the background image URL properly
		$footer_background_image = addcslashes( esc_url_raw( $footer_background_image ), '"' );

		// Get and escape related options
		$footer_background_size     = ttfmake_sanitize_choice( get_theme_mod( 'footer-background-size', ttfmake_get_default( 'footer-background-size' ) ), 'footer-background-size' );
		$footer_background_repeat   = ttfmake_sanitize_choice( get_theme_mod( 'footer-background-repeat', ttfmake_get_default( 'footer-background-repeat' ) ), 'footer-background-repeat' );
		$footer_background_position = ttfmake_sanitize_choice( get_theme_mod( 'footer-background-position', ttfmake_get_default( 'footer-background-position' ) ), 'footer-background-position' );

		// All variables are escaped at this point
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.site-footer' ),
			'declarations' => array(
				'background-image'    => 'url("' . $footer_background_image . '")',
				'background-size'     => $footer_background_size,
				'background-repeat'   => $footer_background_repeat,
				'background-position' => $footer_background_position . ' center'
			)
		) );
	}

	/**
	 * Featured image alignment
	 */
	$templates = array(
		'blog',
		'archive',
		'search',
		'post',
		'page'
	);

	foreach ( $templates as $template_name ) {
		$key       = 'layout-' . $template_name . '-featured-images-alignment';
		$default   = ttfmake_get_default( $key );
		$alignment = ttfmake_sanitize_choice( get_theme_mod( $key, $default ), $key );

		if ( $alignment !== $default ) {
			ttfmake_get_css()->add( array(
				'selectors'    => array( '.' . $template_name . ' .entry-header .entry-thumbnail' ),
				'declarations' => array(
					'text-align' => $alignment,
				)
			) );
		}
	}
}
endif;

add_action( 'make_css', 'ttfmake_css_add_rules' );

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