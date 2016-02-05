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

if ( ! function_exists( 'ttfmake_get_section_data' ) ) :
/**
 * Retrieve all of the data for the sections.
 *
 * @since  1.2.0.
 *
 * @param  string    $post_id    The post to retrieve the data from.
 * @return array                 The combined data.
 */
function ttfmake_get_section_data( $post_id ) {
	$ordered_data = array();
	$ids          = get_post_meta( $post_id, '_ttfmake-section-ids', true );
	$ids          = ( ! empty( $ids ) && is_array( $ids ) ) ? array_map( 'strval', $ids ) : $ids;
	$post_meta    = get_post_meta( $post_id );

	// Temp array of hashed keys
	$temp_data = array();

	// Any meta containing the old keys should be deleted
	if ( is_array( $post_meta ) ) {
		foreach ( $post_meta as $key => $value ) {
			// Only consider builder values
			if ( 0 === strpos( $key, '_ttfmake:' ) ) {
				// Get the individual pieces
				$temp_data[ str_replace( '_ttfmake:', '', $key ) ] = $value[0];
			}
		}
	}

	// Create multidimensional array from postmeta
	$data = ttfmake_create_array_from_meta_keys( $temp_data );

	// Reorder the data in the order specified by the section IDs
	if ( is_array( $ids ) ) {
		foreach ( $ids as $id ) {
			if ( isset( $data[ $id ] ) ) {
				$ordered_data[ $id ] = $data[ $id ];
			}
		}
	}

	/**
	 * Filter the section data for a post.
	 *
	 * @since 1.2.3.
	 *
	 * @param array    $ordered_data    The array of section data.
	 * @param int      $post_id         The post ID for the retrieved data.
	 */
	return apply_filters( 'make_get_section_data', $ordered_data, $post_id );
}
endif;

if ( ! function_exists( 'ttfmake_create_array_from_meta_keys' ) ) :
/**
 * Convert an array with array keys that map to a multidimensional array to the array.
 *
 * @since  1.2.0.
 *
 * @param  array    $arr    The array to convert.
 * @return array            The converted array.
 */
function ttfmake_create_array_from_meta_keys( $arr ) {
	// The new multidimensional array we will return
	$result = array();

	// Process each item of the input array
	foreach ( $arr as $key => $value ) {
		// Store a reference to the root of the array
		$current = & $result;

		// Split up the current item's key into its pieces
		$pieces = explode( ':', $key );

		/**
		 * For all but the last piece of the key, create a new sub-array (if necessary), and update the $current
		 * variable to a reference of that sub-array.
		 */
		for ( $i = 0; $i < count( $pieces ) - 1; $i++ ) {
			$step = $pieces[ $i ];
			if ( ! isset( $current[ $step ] ) ) {
				$current[ $step ] = array();
			}
			$current = & $current[ $step ];
		}

		// Add the current value into the final nested sub-array
		$current[ $pieces[ $i ] ] = $value;
	}

	// Return the result array
	return $result;
}
endif;

if ( ! function_exists( 'ttfmake_post_type_supports_builder' ) ) :
/**
 * Check if a post type supports the Make builder.
 *
 * @since  1.2.0.
 *
 * @param  string    $post_type    The post type to test.
 * @return bool                    True if the post type supports the builder; false if it does not.
 */
function ttfmake_post_type_supports_builder( $post_type ) {
	return post_type_supports( $post_type, 'make-builder' );
}
endif;

if ( ! function_exists( 'ttfmake_is_builder_page' ) ) :
/**
 * Determine if the post uses the builder or not.
 *
 * @since  1.2.0.
 *
 * @param  int     $post_id    The post to inspect.
 * @return bool                True if builder is used for post; false if it is not.
 */
function ttfmake_is_builder_page( $post_id = 0 ) {
	if ( empty( $post_id ) ) {
		$post_id = get_the_ID();
	}

	// Pages will use the template-builder.php template to denote that it is a builder page
	$has_builder_template = ( 'template-builder.php' === get_page_template_slug( $post_id ) );

	// Other post types will use meta data to support builder pages
	$has_builder_meta = ( 1 === (int) get_post_meta( $post_id, '_ttfmake-use-builder', true ) );

	$is_builder_page = $has_builder_template || $has_builder_meta;

	/**
	 * Allow a developer to dynamically change whether the post uses the builder or not.
	 *
	 * @since 1.2.3
	 *
	 * @param bool    $is_builder_page    Whether or not the post uses the builder.
	 * @param int     $post_id            The ID of post being evaluated.
	 */
	return apply_filters( 'make_is_builder_page', $is_builder_page, $post_id );
}
endif;

/**
 * Handle frontend scripts for use with the existing sections on the current Builder page.
 *
 * @since 1.6.1.
 *
 * @return void
 */
function ttfmake_frontend_builder_scripts() {
	if ( ttfmake_is_builder_page() ) {
		$sections = ttfmake_get_section_data( get_the_ID() );
		// Bail if there are no sections
		if ( empty( $sections ) ) {
			return;
		}
		// Parse the sections included on the page.
		$sections      = ttfmake_get_section_data( get_the_ID() );
		$section_types = wp_list_pluck( $sections, 'section-type' );

		foreach ( $section_types as $section_id => $section_type ) {
			switch ( $section_type ) {
				default :
					break;
				case 'banner' :
					// Add Cycle2 as a dependency for the Frontend script
					global $wp_scripts;
					$script = $wp_scripts->query( 'ttfmake-global', 'registered' );
					if ( $script && ! in_array( 'cycle2', $script->deps ) ) {
						$script->deps[] = 'cycle2';
						if ( ! defined( 'TTFMAKE_SUFFIX' ) || '.min' !== TTFMAKE_SUFFIX ) {
							$script->deps[] = 'cycle2-center';
							$script->deps[] = 'cycle2-swipe';
						}
					}
					break;
			}
		}
	}
}

add_action( 'wp_head', 'ttfmake_frontend_builder_scripts' );

if ( ! function_exists( 'ttfmake_builder_css' ) ) :
/**
 * Trigger an action hook for each section on a Builder page for the purpose
 * of adding section-specific CSS rules to the document head.
 *
 * @since 1.4.5
 *
 * @return void
 */
function ttfmake_builder_css() {
	if ( ttfmake_is_builder_page() ) {
		$sections = ttfmake_get_section_data( get_the_ID() );

		if ( ! empty( $sections ) ) {
			foreach ( $sections as $id => $data ) {
				if ( isset( $data['section-type'] ) ) {
					/**
					 * Allow section-specific CSS rules to be added to the document head of a Builder page.
					 *
					 * @since 1.4.5
					 *
					 * @param array    $data    The Builder section's data.
					 * @param int      $id      The ID of the Builder section.
					 */
					do_action( 'make_builder_' . $data['section-type'] . '_css', $data, $id );
				}
			}
		}
	}
}
endif;

add_action( 'make_css', 'ttfmake_builder_css' );

if ( ! function_exists( 'ttfmake_builder_banner_css' ) ) :
/**
 * Add frontend CSS rules for Banner sections based on certain section options.
 *
 * @since 1.4.5
 *
 * @param array    $data    The banner's section data.
 * @param int      $id      The banner's section ID.
 *
 * @return void
 */
function ttfmake_builder_banner_css( $data, $id ) {
	$prefix = 'builder-section-';
	$id = sanitize_title_with_dashes( $data['id'] );
	/**
	 * This filter is documented in inc/builder/core/save.php
	 */
	$section_id = apply_filters( 'make_section_html_id', $prefix . $id, $data );

	$responsive = ( isset( $data['responsive'] ) ) ? $data['responsive'] : 'balanced';
	$slider_height = absint( $data['height'] );
	if ( 0 === $slider_height ) {
		$slider_height = 600;
	}
	$slider_ratio = ( $slider_height / 960 ) * 100;

	if ( 'aspect' === $responsive ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array( '#' . esc_attr( $section_id ) . ' .builder-banner-slide' ),
			'declarations' => array(
				'padding-bottom' => $slider_ratio . '%'
			),
		) );
	} else {
		ttfmake_get_css()->add( array(
			'selectors'    => array( '#' . esc_attr( $section_id ) . ' .builder-banner-slide' ),
			'declarations' => array(
				'padding-bottom' => $slider_height . 'px'
			),
		) );
		ttfmake_get_css()->add( array(
			'selectors'    => array( '#' . esc_attr( $section_id ) . ' .builder-banner-slide' ),
			'declarations' => array(
				'padding-bottom' => $slider_ratio . '%'
			),
			'media'        => 'screen and (min-width: 600px) and (max-width: 960px)'
		) );
	}
}
endif;

add_action( 'make_builder_banner_css', 'ttfmake_builder_banner_css', 10, 2 );

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