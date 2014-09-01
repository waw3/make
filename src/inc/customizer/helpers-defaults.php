<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_option_defaults' ) ) :
/**
 * The big array of global option defaults.
 *
 * @since  1.0.0
 *
 * @return array    The default values for all theme options.
 */
function ttfmake_option_defaults() {
	$defaults = array(
		/**
		 * General
		 */
		// Site Title & Tagline
		'hide-site-title'                          => 0,
		'hide-tagline'                             => 0,
		// Logo
		'logo-regular'                             => '',
		'logo-retina'                              => '',
		'logo-favicon'                             => '',
		'logo-apple-touch'                         => '',
		// Background Image
		'background_image'                         => '',
		'background_repeat'                        => 'repeat',
		'background_position_x'                    => 'left',
		'background_attachment'                    => 'scroll',
		'background_size'                          => 'auto',
		'main-background-image'                    => '',
		'main-background-repeat'                   => 'repeat',
		'main-background-position'                 => 'left',
		'main-background-size'                     => 'auto',
		// Social Profiles & RSS
		'social-facebook'                          => '',
		'social-twitter'                           => '',
		'social-google-plus-square'                => '',
		'social-linkedin'                          => '',
		'social-instagram'                         => '',
		'social-flickr'                            => '',
		'social-youtube'                           => '',
		'social-vimeo-square'                      => '',
		'social-pinterest'                         => '',
		'social-email'                             => '',
		'social-hide-rss'                          => 0,
		'social-custom-rss'                        => '',

		/**
		 * Typography
		 */
		// Google Web Fonts
		'font-subset'                              => 'latin',
		// Site Title & Tagline
		'font-site-title-family'                   => 'sans-serif',
		'font-site-title-size'                     => 34,
		'font-site-tagline-family'                 => 'Open Sans',
		'font-site-tagline-size'                   => 12,
		// Main Menu
		'font-nav-family'						   => 'Open Sans',
		'font-nav-size'                            => 14,
		'font-subnav-family'					   => 'Open Sans',
		'font-subnav-size'                         => 13,
		// Widgets
		'font-widget-family'                       => 'Open Sans',
		'font-widget-size'                         => 13,
		// Headers & Body
		'font-h1-family'                           => 'sans-serif',
		'font-h1-size'                             => 50,
		'font-h2-family'                           => 'sans-serif',
		'font-h2-size'                             => 34,
		'font-h3-family'                           => 'sans-serif',
		'font-h3-size'                             => 24,
		'font-h4-family'                           => 'sans-serif',
		'font-h4-size'                             => 24,
		'font-h5-family'                           => 'sans-serif',
		'font-h5-size'                             => 16,
		'font-h6-family'                           => 'sans-serif',
		'font-h6-size'                             => 14,
		'font-body-family'                         => 'Open Sans',
		'font-body-size'                           => 17,

		/**
		 * Color Scheme
		 */
		// General
		'color-primary'                            => '#3070d1',
		'color-secondary'                          => '#eaecee',
		'color-text'                               => '#171717',
		'color-detail'                             => '#b9bcbf',
		// Background
		'background_color'                         => 'b9bcbf',
		'main-background-color'                    => '#ffffff',
		// Header
		'header-bar-background-color'              => '#171717',
		'header-bar-text-color'                    => '#ffffff',
		'header-bar-border-color'                  => '#171717',
		'header-background-color'                  => '#ffffff',
		'header-text-color'                        => '#171717',
		'color-site-title'                         => '#171717',
		// Footer
		'footer-background-color'                  => '#eaecee',
		'footer-text-color'                        => '#464849',
		'footer-border-color'                      => '#b9bcbf',

		/**
		 * Header
		 */
		// Background Image
		'header-background-image'                  => '',
		'header-background-repeat'                 => 'no-repeat',
		'header-background-position'               => 'center',
		'header-background-size'                   => 'cover',
		// Navigation
		'navigation-mobile-label'                  => __( 'Menu', 'make' ),
		// Layout
		'header-layout'                            => 1,
		'header-branding-position'                 => 'left',
		'header-bar-content-layout'                => 'default',
		'header-text'                              => '',
		'header-show-social'                       => 0,
		'header-show-search'                       => 1,

		/**
		 * Content & Layout
		 */
		// Global
		'general-layout'                           => 'full-width',
		'general-sticky-label'                     => __( 'Featured', 'make' ),
		'main-content-link-underline'              => 0,
		// Blog (Posts Page)
		'layout-blog-hide-header'                  => 0,
		'layout-blog-hide-footer'                  => 0,
		'layout-blog-sidebar-left'                 => 0,
		'layout-blog-sidebar-right'                => 1,
		'layout-blog-featured-images'              => 'post-header',
		'layout-blog-post-date'                    => 'absolute',
		'layout-blog-post-author'                  => 'avatar',
		'layout-blog-auto-excerpt'                 => 0,
		'layout-blog-show-categories'              => 1,
		'layout-blog-show-tags'                    => 1,
		'layout-blog-featured-images-alignment'    => 'center',
		'layout-blog-post-date-location'           => 'top',
		'layout-blog-post-author-location'         => 'post-footer',
		'layout-blog-comment-count'                => 'none',
		'layout-blog-comment-count-location'       => 'before-content',
		// Archives
		'layout-archive-hide-header'               => 0,
		'layout-archive-hide-footer'               => 0,
		'layout-archive-sidebar-left'              => 0,
		'layout-archive-sidebar-right'             => 1,
		'layout-archive-featured-images'           => 'post-header',
		'layout-archive-post-date'                 => 'absolute',
		'layout-archive-post-author'               => 'avatar',
		'layout-archive-auto-excerpt'              => 0,
		'layout-archive-show-categories'           => 1,
		'layout-archive-show-tags'                 => 1,
		'layout-archive-featured-images-alignment' => 'center',
		'layout-archive-post-date-location'        => 'top',
		'layout-archive-post-author-location'      => 'post-footer',
		'layout-archive-comment-count'             => 'none',
		'layout-archive-comment-count-location'    => 'before-content',
		// Search Results
		'layout-search-hide-header'                => 0,
		'layout-search-hide-footer'                => 0,
		'layout-search-sidebar-left'               => 0,
		'layout-search-sidebar-right'              => 1,
		'layout-search-featured-images'            => 'thumbnail',
		'layout-search-post-date'                  => 'absolute',
		'layout-search-post-author'                => 'name',
		'layout-search-auto-excerpt'               => 1,
		'layout-search-show-categories'            => 1,
		'layout-search-show-tags'                  => 1,
		'layout-search-featured-images-alignment'  => 'center',
		'layout-search-post-date-location'         => 'top',
		'layout-search-post-author-location'       => 'post-footer',
		'layout-search-comment-count'              => 'none',
		'layout-search-comment-count-location'     => 'before-content',
		// Posts
		'layout-post-hide-header'                  => 0,
		'layout-post-hide-footer'                  => 0,
		'layout-post-sidebar-left'                 => 0,
		'layout-post-sidebar-right'                => 0,
		'layout-post-featured-images'              => 'post-header',
		'layout-post-post-date'                    => 'absolute',
		'layout-post-post-author'                  => 'avatar',
		'layout-post-show-categories'              => 1,
		'layout-post-show-tags'                    => 1,
		'layout-post-featured-images-alignment'    => 'center',
		'layout-post-post-date-location'           => 'top',
		'layout-post-post-author-location'         => 'post-footer',
		'layout-post-comment-count'                => 'none',
		'layout-post-comment-count-location'       => 'before-content',
		// Pages
		'layout-page-hide-header'                  => 0,
		'layout-page-hide-footer'                  => 0,
		'layout-page-sidebar-left'                 => 0,
		'layout-page-sidebar-right'                => 0,
		'layout-page-hide-title'                   => 1,
		'layout-page-featured-images'              => 'none',
		'layout-page-post-date'                    => 'none',
		'layout-page-post-author'                  => 'none',
		'layout-page-featured-images-alignment'    => 'center',
		'layout-page-post-date-location'           => 'top',
		'layout-page-post-author-location'         => 'post-footer',
		'layout-page-comment-count'                => 'none',
		'layout-page-comment-count-location'       => 'before-content',

		/**
		 * Footer
		 */
		// Background Image
		'footer-background-image'                  => '',
		'footer-background-repeat'                 => 'no-repeat',
		'footer-background-position'               => 'center',
		'footer-background-size'                   => 'cover',
		// Widget Areas
		'footer-widget-areas'                      => 3,
		// Layout
		'footer-layout'                            => 1,
		'footer-text'                              => '',
		'footer-show-social'                       => 1,
	);

	return apply_filters( 'ttfmake_setting_defaults', $defaults );
}
endif;

if ( ! function_exists( 'ttfmake_get_default' ) ) :
/**
 * Return a particular global option default.
 *
 * @since  1.0.0.
 *
 * @param  string    $option    The key of the option to return.
 * @return mixed                Default value if found; false if not found.
 */
function ttfmake_get_default( $option ) {
	$defaults = ttfmake_option_defaults();

	// If the option key doesn't exist, look it up in the conversion array
	if ( ! isset( $defaults[ $option ] ) ) {
		$conversions = array_flip( ttfmake_customizer_get_key_conversions() );
		if ( isset( $conversions[ $option ] ) ) {
			$option = $conversions[ $option ];
		}
	}

	return ( isset( $defaults[ $option ] ) ) ? $defaults[ $option ] : false;
}
endif;
