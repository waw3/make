<?php
/**
 * @package Make
 */

/**
 * Build the CSS rules for the color scheme.
 *
 * @since 1.5.0.
 *
 * @return void
 */
function ttfmake_css_color() {
	/**
	 * Global
	 */
	// Primary color
	$color_primary = maybe_hash_hex_color( get_theme_mod( 'color-primary', ttfmake_get_default( 'color-primary' ) ) );
	if ( $color_primary !== ttfmake_get_default( 'color-primary' ) ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.color-primary-text', 'a', '.entry-author-byline a.vcard', '.entry-footer a:hover', '.comment-form .required', 'ul.ttfmake-list-dot li:before', 'ol.ttfmake-list-dot li:before', '.entry-comment-count a:hover',
				'.comment-count-icon a:hover' ),
			'declarations' => array(
				'color' => $color_primary
			)
		) );
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.color-primary-background','.ttfmake-button.color-primary-background' ),
			'declarations' => array(
				'background-color' => $color_primary
			)
		) );
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.color-primary-border' ),
			'declarations' => array(
				'border-color' => $color_primary
			)
		) );
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.site-navigation ul.menu ul a:hover', '.site-navigation ul.menu ul a:focus', '.site-navigation .menu ul ul a:hover', '.site-navigation .menu ul ul a:focus' ),
			'declarations' => array(
				'background-color' => $color_primary
			),
			'media'        => 'screen and (min-width: 800px)'
		) );
	}

	// Secondary color
	$color_secondary = maybe_hash_hex_color( get_theme_mod( 'color-secondary', ttfmake_get_default( 'color-secondary' ) ) );
	if ( $color_secondary !== ttfmake_get_default( 'color-secondary' ) ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array(
				'.color-secondary-text',
				'.builder-section-banner .cycle-pager',
				'.ttfmake-shortcode-slider .cycle-pager',
				'.builder-section-banner .cycle-prev:before',
				'.builder-section-banner .cycle-next:before',
				'.ttfmake-shortcode-slider .cycle-prev:before',
				'.ttfmake-shortcode-slider .cycle-next:before',
				'.ttfmake-shortcode-slider .cycle-caption',
			),
			'declarations' => array(
				'color' => $color_secondary
			)
		) );
		ttfmake_get_css()->add( array(
			'selectors'    => array(
				'.color-secondary-background',
				'blockquote.ttfmake-testimonial',
				'tt',
				'kbd',
				'pre',
				'code',
				'samp',
				'var',
				'textarea',
				'input[type="date"]',
				'input[type="datetime"]',
				'input[type="datetime-local"]',
				'input[type="email"]',
				'input[type="month"]',
				'input[type="number"]',
				'input[type="password"]',
				'input[type="search"]',
				'input[type="tel"]',
				'input[type="text"]',
				'input[type="time"]',
				'input[type="url"]',
				'input[type="week"]',
				'.ttfmake-button.color-secondary-background',
				'button.color-secondary-background',
				'input[type="button"].color-secondary-background',
				'input[type="reset"].color-secondary-background',
				'input[type="submit"].color-secondary-background',
				'.sticky-post-label',
				'.widget_tag_cloud a',
			),
			'declarations' => array(
				'background-color' => $color_secondary
			)
		) );
		ttfmake_get_css()->add( array(
			'selectors'    => array(
				'.site-navigation .menu .sub-menu',
				'.site-navigation .menu .children',
			),
			'declarations' => array(
				'background-color' => $color_secondary
			),
			'media'        => 'screen and (min-width: 800px)'
		) );
		ttfmake_get_css()->add( array(
			'selectors'    => array(
				'.color-secondary-border',
				'table',
				'table th',
				'table td',
				'.header-layout-3 .site-navigation .menu',
			),
			'declarations' => array(
				'border-color' => $color_secondary
			)
		) );
		ttfmake_get_css()->add( array(
			'selectors'    => array(
				'hr',
				'hr.ttfmake-line-dashed',
				'hr.ttfmake-line-double',
				'blockquote.ttfmake-testimonial:after',
			),
			'declarations' => array(
				'border-top-color' => $color_secondary
			)
		) );
		ttfmake_get_css()->add( array(
			'selectors'    => array(
				'.comment-body',
				'.post',
				'.widget li',
			),
			'declarations' => array(
				'border-bottom-color' => $color_secondary
			)
		) );
	}

	// Text color
	$color_text = maybe_hash_hex_color( get_theme_mod( 'color-text', ttfmake_get_default( 'color-text' ) ) );
	if ( $color_text !== ttfmake_get_default( 'color-text' ) ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.color-text', 'body', '.entry-date a', 'body', 'button', 'input', 'select', 'textarea', '[class*="navigation"] .nav-previous a', '[class*="navigation"] .nav-previous span', '[class*="navigation"] .nav-next a', '[class*="navigation"] .nav-next span' ),
			'declarations' => array(
				'color' => $color_text
			)
		) );
		// These placeholder selectors have to be isolated in individual rules.
		// See http://css-tricks.com/snippets/css/style-placeholder-text/#comment-96771
		ttfmake_get_css()->add( array(
			'selectors'    => array( '::-webkit-input-placeholder' ),
			'declarations' => array(
				'color' => $color_text
			)
		) );
		ttfmake_get_css()->add( array(
			'selectors'    => array( ':-moz-placeholder' ),
			'declarations' => array(
				'color' => $color_text
			)
		) );
		ttfmake_get_css()->add( array(
			'selectors'    => array( '::-moz-placeholder' ),
			'declarations' => array(
				'color' => $color_text
			)
		) );
		ttfmake_get_css()->add( array(
			'selectors'    => array( ':-ms-input-placeholder' ),
			'declarations' => array(
				'color' => $color_text
			)
		) );
	}

	// Detail color
	$color_detail = maybe_hash_hex_color( get_theme_mod( 'color-detail', ttfmake_get_default( 'color-detail' ) ) );
	if ( $color_detail !== ttfmake_get_default( 'color-detail' ) ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.color-detail-text', '.builder-section-banner .cycle-pager .cycle-pager-active', '.ttfmake-shortcode-slider .cycle-pager .cycle-pager-active', '.post-categories li:after', '.post-tags li:after', '.comment-count-icon:before', '.entry-comment-count a',
				'.comment-count-icon a' ),
			'declarations' => array(
				'color' => $color_detail
			)
		) );
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.site-navigation .menu-item-has-children a:after' ),
			'declarations' => array(
				'color' => $color_detail
			),
			'media'        => 'screen and (min-width: 800px)'
		) );
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.site-navigation .menu .sub-menu a', '.site-navigation .menu .sub-menu a' ),
			'declarations' => array(
				'border-bottom-color' => $color_detail
			),
			'media'        => 'screen and (min-width: 800px)'
		) );
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.color-detail-background' ),
			'declarations' => array(
				'background-color' => $color_detail
			)
		) );
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.color-detail-border' ),
			'declarations' => array(
				'border-color' => $color_detail
			)
		) );
	}

	// Link Hover/Focus Color
	$color_primary_link = maybe_hash_hex_color( get_theme_mod( 'color-primary-link', ttfmake_get_default( 'color-primary-link' ) ) );
	if ( $color_primary_link !== ttfmake_get_default( 'color-primary-link' ) || $color_primary !== ttfmake_get_default( 'color-primary' ) ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array( 'a:hover', 'a:focus', '.entry-author-byline a.vcard:hover', '.entry-author-byline a.vcard:focus', ),
			'declarations' => array(
				'color' => $color_primary_link
			)
		) );
	}

	// Main background color
	$main_background_transparent = absint( get_theme_mod( 'main-background-color-transparent', ttfmake_get_default( 'main-background-color-transparent' ) ) );
	$main_background_color = ( $main_background_transparent )
		? 'transparent'
		: maybe_hash_hex_color( get_theme_mod( 'main-background-color', ttfmake_get_default( 'main-background-color' ) ) );
	if ( $main_background_color !== ttfmake_get_default( 'main-background-color' ) ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.site-content', 'body.mce-content-body' ),
			'declarations' => array(
				'background-color' => $main_background_color
			)
		) );
	}

	/**
	 * Site Title & Tagline
	 */
	// Prereq
	$header_text_color = maybe_hash_hex_color( get_theme_mod( 'header-text-color', ttfmake_get_default( 'header-text-color' ) ) );
	// Site title
	$color_site_title = maybe_hash_hex_color( get_theme_mod( 'color-site-title', ttfmake_get_default( 'color-site-title' ) ) );
	if ( $color_site_title !== ttfmake_get_default( 'color-site-title' ) || $header_text_color !== $color_site_title ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.site-header .site-title', '.site-header .site-title a' ),
			'declarations' => array(
				'color' => $color_site_title
			)
		) );
	}
	// Tagline
	$color_tagline = maybe_hash_hex_color( get_theme_mod( 'color-site-tagline', ttfmake_get_default( 'color-site-tagline' ) ) );
	if ( $color_tagline !== ttfmake_get_default( 'color-site-tagline' ) || $header_text_color !== $color_tagline ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.site-header .site-description' ),
			'declarations' => array(
				'color' => $color_tagline
			)
		) );
	}

	/**
	 * Header section
	 */
	// Header text color
	// $header_text_color is retrieved and sanitized above in the Site Title & Tagline section
	if ( $header_text_color !== ttfmake_get_default( 'header-text-color' ) ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.site-header', '.site-header a', '.site-navigation .menu li a' ),
			'declarations' => array(
				'color' => $header_text_color
			)
		) );
	}

	// Header background color
	$header_background_transparent = absint( get_theme_mod( 'header-background-transparent', ttfmake_get_default( 'header-background-transparent' ) ) );
	$header_background_color = ( $header_background_transparent )
		? 'transparent'
		: maybe_hash_hex_color( get_theme_mod( 'header-background-color', ttfmake_get_default( 'header-background-color' ) ) );
	if ( $header_background_color !== ttfmake_get_default( 'header-background-color' ) ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.site-header-main' ),
			'declarations' => array(
				'background-color' => $header_background_color
			)
		) );
	}

	/**
	 * Header Bar
	 */
	// Header Bar text color
	$header_bar_text_color = maybe_hash_hex_color( get_theme_mod( 'header-bar-text-color', ttfmake_get_default( 'header-bar-text-color' ) ) );
	if ( $header_bar_text_color !== ttfmake_get_default( 'header-bar-text-color' ) ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.header-bar', '.header-bar a', '.header-bar .menu li a' ),
			'declarations' => array(
				'color' => $header_bar_text_color
			)
		) );
	}

	// Header Bar border color
	$header_bar_border_color = maybe_hash_hex_color( get_theme_mod( 'header-bar-border-color', ttfmake_get_default( 'header-bar-border-color' ) ) );
	if ( $header_bar_border_color !== ttfmake_get_default( 'header-bar-border-color' ) ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.header-bar', '.header-bar .search-form input', '.header-social-links li:first-of-type', '.header-social-links li a' ),
			'declarations' => array(
				'border-color' => $header_bar_border_color
			)
		) );
	}

	// Header Bar background color
	$header_bar_background_transparent = absint( get_theme_mod( 'header-bar-background-transparent', ttfmake_get_default( 'header-bar-background-transparent' ) ) );
	$header_bar_background_color = ( $header_bar_background_transparent )
		? 'transparent'
		: maybe_hash_hex_color( get_theme_mod( 'header-bar-background-color', ttfmake_get_default( 'header-bar-background-color' ) ) );
	if ( $header_bar_background_color !== ttfmake_get_default( 'header-bar-background-color' ) ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.header-bar' ),
			'declarations' => array(
				'background-color' => $header_bar_background_color
			)
		) );
	}

	/**
	 * Footer section
	 */
	// Get and escape options
	$footer_text_color       = maybe_hash_hex_color( get_theme_mod( 'footer-text-color', ttfmake_get_default( 'footer-text-color' ) ) );
	$footer_border_color     = maybe_hash_hex_color( get_theme_mod( 'footer-border-color', ttfmake_get_default( 'footer-border-color' ) ) );
	$footer_background_color = maybe_hash_hex_color( get_theme_mod( 'footer-background-color', ttfmake_get_default( 'footer-background-color' ) ) );

	// Footer text color
	if ( $footer_text_color !== ttfmake_get_default( 'footer-text-color' ) ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.site-footer' ),
			'declarations' => array(
				'color' => $footer_text_color
			)
		) );
	}

	// Footer border color
	if ( $footer_border_color !== ttfmake_get_default( 'footer-border-color' ) ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.site-footer *:not(select)' ),
			'declarations' => array(
				'border-color' => $footer_border_color . ' !important'
			)
		) );
	}

	// Footer background color
	if ( $footer_background_color !== ttfmake_get_default( 'footer-background-color' ) ) {
		ttfmake_get_css()->add( array(
			'selectors'    => array( '.site-footer' ),
			'declarations' => array(
				'background-color' => $footer_background_color
			)
		) );
	}
}

add_action( 'make_css', 'ttfmake_css_color' );