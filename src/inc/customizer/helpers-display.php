<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_css_add_rules' ) ) :
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
function ttf_one_css_add_rules() {
	/**
	 * Background section
	 */
	$site_background_image = get_theme_mod( 'background_image', ttf_one_get_default( 'background_image' ) );
	if ( ! empty( $site_background_image ) ) {
		// Note that most site background options are handled by internal WordPress functions
		$site_background_size = ttf_one_sanitize_choice( get_theme_mod( 'background_size', ttf_one_get_default( 'background_size' ) ), 'background-size' );

		ttf_one_get_css()->add( array(
			'selectors'    => array( 'body' ),
			'declarations' => array(
				'background-size' => $site_background_size
			)
		) );
	}

	/**
	 * Colors section
	 */
	// Get and escape options
	$color_primary   = maybe_hash_hex_color( get_theme_mod( 'color-primary', ttf_one_get_default( 'color-primary' ) ) );
	$color_secondary = maybe_hash_hex_color( get_theme_mod( 'color-secondary', ttf_one_get_default( 'color-secondary' ) ) );
	$color_text      = maybe_hash_hex_color( get_theme_mod( 'color-text', ttf_one_get_default( 'color-text' ) ) );
	$color_detail    = maybe_hash_hex_color( get_theme_mod( 'color-detail', ttf_one_get_default( 'color-detail' ) ) );

	// Primary color
	if ( $color_primary !== ttf_one_get_default( 'color-primary' ) ) {
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.color-primary-text', 'a' ),
			'declarations' => array(
				'color' => $color_primary
			)
		) );
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.color-primary-background' ),
			'declarations' => array(
				'background-color' => $color_primary
			)
		) );
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.color-primary-border' ),
			'declarations' => array(
				'border-color' => $color_primary
			)
		) );
	}

	// Secondary color
	if ( $color_secondary !== ttf_one_get_default( 'color-secondary' ) ) {
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.color-secondary-text' ),
			'declarations' => array(
				'color' => $color_secondary
			)
		) );
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.color-secondary-background' ),
			'declarations' => array(
				'background-color' => $color_secondary
			)
		) );
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.color-secondary-border' ),
			'declarations' => array(
				'border-color' => $color_secondary
			)
		) );
	}

	// Text color
	if ( $color_text !== ttf_one_get_default( 'color-text' ) ) {
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.color-text', 'body' ),
			'declarations' => array(
				'color' => $color_text
			)
		) );
	}

	// Detail color
	if ( $color_detail !== ttf_one_get_default( 'color-detail' ) ) {
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.color-detail-text' ),
			'declarations' => array(
				'color' => $color_detail
			)
		) );
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.color-detail-background' ),
			'declarations' => array(
				'background-color' => $color_detail
			)
		) );
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.color-detail-border' ),
			'declarations' => array(
				'border-color' => $color_detail
			)
		) );
	}

	/**
	 * Header section
	 */
	// Get and escape options
	$header_text_color          = maybe_hash_hex_color( get_theme_mod( 'header-text-color', ttf_one_get_default( 'header-text-color' ) ) );
	$header_background_color    = maybe_hash_hex_color( get_theme_mod( 'header-background-color', ttf_one_get_default( 'header-background-color' ) ) );
	$header_background_image    = get_theme_mod( 'header-background-image', ttf_one_get_default( 'header-background-image' ) );
	$subheader_text_color       = maybe_hash_hex_color( get_theme_mod( 'header-subheader-text-color', ttf_one_get_default( 'header-subheader-text-color' ) ) );
	$subheader_border_color     = maybe_hash_hex_color( get_theme_mod( 'header-subheader-border-color', ttf_one_get_default( 'header-subheader-border-color' ) ) );
	$subheader_background_color = maybe_hash_hex_color( get_theme_mod( 'header-subheader-background-color', ttf_one_get_default( 'header-subheader-background-color' ) ) );

	// Header text color
	if ( $header_text_color !== ttf_one_get_default( 'header-text-color' ) ) {
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.site-header', '.site-header a' ),
			'declarations' => array(
				'color' => $header_text_color
			)
		) );
	}

	// Header background color
	if ( $header_background_color !== ttf_one_get_default( 'header-background-color' ) ) {
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.site-header-main' ),
			'declarations' => array(
				'background-color' => $header_background_color
			)
		) );
	}

	// Header background image
	if ( ! empty( $header_background_image ) ) {
		// Escape the background image URL properly
		$header_background_image = addcslashes( esc_url_raw( $header_background_image ), '"' );

		// Get and escape related options
		$header_background_size     = ttf_one_sanitize_choice( get_theme_mod( 'header-background-size', ttf_one_get_default( 'header-background-size' ) ), 'header-background-size' );
		$header_background_repeat   = ttf_one_sanitize_choice( get_theme_mod( 'header-background-repeat', ttf_one_get_default( 'header-background-repeat' ) ), 'header-background-repeat' );
		$header_background_position = ttf_one_sanitize_choice( get_theme_mod( 'header-background-position', ttf_one_get_default( 'header-background-position' ) ), 'header-background-position' );

		// All variables are escaped at this point
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.site-header-main' ),
			'declarations' => array(
				'background-image'    => 'url("' . $header_background_image . '")',
				'background-size'     => $header_background_size,
				'background-repeat'   => $header_background_repeat,
				'background-position' => $header_background_position . ' center'
			)
		) );
	}

	// Sub Header text color
	if ( $subheader_text_color !== ttf_one_get_default( 'header-subheader-text-color' ) ) {
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.sub-header' ),
			'declarations' => array(
				'color' => $subheader_text_color
			)
		) );
	}

	// Sub Header border color
	if ( $subheader_border_color !== ttf_one_get_default( 'header-subheader-border-color' ) ) {
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.sub-header', '.header-social-links li:first-of-type', '.header-social-links li a' ),
			'declarations' => array(
				'border-color' => $subheader_border_color
			)
		) );
	}

	// Sub Header background color
	if ( $subheader_background_color !== ttf_one_get_default( 'header-subheader-background-color' ) ) {
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.sub-header' ),
			'declarations' => array(
				'background-color' => $subheader_background_color
			)
		) );
	}

	/**
	 * Main section
	 */
	// Get and escape options
	$main_background_color       = maybe_hash_hex_color( get_theme_mod( 'main-background-color', ttf_one_get_default( 'main-background-color' ) ) );
	$main_background_image       = get_theme_mod( 'main-background-image', ttf_one_get_default( 'main-background-image' ) );
	$main_content_link_underline = absint( get_theme_mod( 'main-content-link-underline', ttf_one_get_default( 'main-content-link-underline' ) ) );

	// Main background color
	if ( $main_background_color !== ttf_one_get_default( 'main-background-color' ) ) {
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.site-content' ),
			'declarations' => array(
				'background-color' => $main_background_color
			)
		) );
	}

	// Main background image
	if ( ! empty( $main_background_image ) ) {
		// Escape the background image URL properly
		$main_background_image = addcslashes( esc_url_raw( $main_background_image ), '"' );

		// Get and escape related options
		$main_background_size     = ttf_one_sanitize_choice( get_theme_mod( 'main-background-size', ttf_one_get_default( 'main-background-size' ) ), 'main-background-size' );
		$main_background_repeat   = ttf_one_sanitize_choice( get_theme_mod( 'main-background-repeat', ttf_one_get_default( 'main-background-repeat' ) ), 'main-background-repeat' );
		$main_background_position = ttf_one_sanitize_choice( get_theme_mod( 'main-background-position', ttf_one_get_default( 'main-background-position' ) ), 'main-background-position' );

		// All variables are escaped at this point
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.site-content' ),
			'declarations' => array(
				'background-image'    => 'url("' . $main_background_image . '")',
				'background-size'     => $main_background_size,
				'background-repeat'   => $main_background_repeat,
				'background-position' => $main_background_position . ' top'
			)
		) );
	}

	// Main Content Link Underline
	if ( 1 === $main_content_link_underline ) {
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.entry-content a' ),
			'declarations' => array(
				'text-decoration' => 'underline'
			)
		) );
	}

	/**
	 * Footer section
	 */
	// Get and escape options
	$footer_text_color       = maybe_hash_hex_color( get_theme_mod( 'footer-text-color', ttf_one_get_default( 'footer-text-color' ) ) );
	$footer_border_color     = maybe_hash_hex_color( get_theme_mod( 'footer-border-color', ttf_one_get_default( 'footer-border-color' ) ) );
	$footer_background_color = maybe_hash_hex_color( get_theme_mod( 'footer-background-color', ttf_one_get_default( 'footer-background-color' ) ) );
	$footer_background_image = get_theme_mod( 'footer-background-image', ttf_one_get_default( 'footer-background-image' ) );

	// Footer text color
	if ( $footer_text_color !== ttf_one_get_default( 'footer-text-color' ) ) {
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.site-footer' ),
			'declarations' => array(
				'color' => $footer_text_color
			)
		) );
	}

	// Footer border color
	if ( $footer_border_color !== ttf_one_get_default( 'footer-border-color' ) ) {
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.site-footer' ),
			'declarations' => array(
				'border-color' => $footer_border_color
			)
		) );
	}

	// Footer background color
	if ( $footer_background_color !== ttf_one_get_default( 'footer-background-color' ) ) {
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.site-footer' ),
			'declarations' => array(
				'background-color' => $footer_background_color
			)
		) );
	}

	// Footer background image
	if ( ! empty( $footer_background_image ) ) {
		// Escape the background image URL properly
		$footer_background_image = addcslashes( esc_url_raw( $footer_background_image ), '"' );

		// Get and escape related options
		$footer_background_size     = ttf_one_sanitize_choice( get_theme_mod( 'footer-background-size', ttf_one_get_default( 'footer-background-size' ) ), 'footer-background-size' );
		$footer_background_repeat   = ttf_one_sanitize_choice( get_theme_mod( 'footer-background-repeat', ttf_one_get_default( 'footer-background-repeat' ) ), 'footer-background-repeat' );
		$footer_background_position = ttf_one_sanitize_choice( get_theme_mod( 'footer-background-position', ttf_one_get_default( 'footer-background-position' ) ), 'footer-background-position' );

		// All variables are escaped at this point
		ttf_one_get_css()->add( array(
			'selectors'    => array( '.site-footer' ),
			'declarations' => array(
				'background-image'    => 'url("' . $footer_background_image . '")',
				'background-size'     => $footer_background_size,
				'background-repeat'   => $footer_background_repeat,
				'background-position' => $footer_background_position . ' center'
			)
		) );
	}
}
endif;

add_action( 'ttf_one_css', 'ttf_one_css_add_rules' );