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
		// Labels
		'navigation-mobile-label'                  => __( 'Menu', 'make' ),
		'general-sticky-label'                     => __( 'Featured', 'make' ),
		'label-read-more'                          => __( 'Read more', 'make' ),
		// Social Profiles
		'social-facebook-official'                 => '',
		'social-twitter'                           => '',
		'social-google-plus-square'                => '',
		'social-linkedin'                          => '',
		'social-instagram'                         => '',
		'social-flickr'                            => '',
		'social-youtube'                           => '',
		'social-vimeo-square'                      => '',
		'social-pinterest'                         => '',
		// Email
		'social-email'                             => '',
		// RSS
		'social-hide-rss'                          => 0,
		'social-custom-rss'                        => '',

		/**
		 * Typography
		 */
		// Global/Default
		'font-family-body'                         => 'Open Sans',
		'font-size-body'                           => 17,
		'font-weight-body'                         => 'normal',
		'font-style-body'                          => 'normal',
		'text-transform-body'                      => 'none',
		'line-height-body'                         => 1.6,
		'letter-spacing-body'                      => 0,
		'word-spacing-body'                        => 0,
		'link-underline-body'                      => 'never',
		// H1
		'font-family-h1'                           => 'sans-serif',
		'font-size-h1'                             => 46,
		'font-weight-h1'                           => 'normal',
		'font-style-h1'                            => 'normal',
		'text-transform-h1'                        => 'none',
		'line-height-h1'                           => 1.2,
		'letter-spacing-h1'                        => 0,
		'word-spacing-h1'                          => 0,
		'link-underline-h1'                        => 'never',
		// H2
		'font-family-h2'                           => 'sans-serif',
		'font-size-h2'                             => 34,
		'font-weight-h2'                           => 'bold',
		'font-style-h2'                            => 'normal',
		'text-transform-h2'                        => 'none',
		'line-height-h2'                           => 1.6,
		'letter-spacing-h2'                        => 0,
		'word-spacing-h2'                          => 0,
		'link-underline-h2'                        => 'never',
		// H3
		'font-family-h3'                           => 'sans-serif',
		'font-size-h3'                             => 24,
		'font-weight-h3'                           => 'bold',
		'font-style-h3'                            => 'normal',
		'text-transform-h3'                        => 'none',
		'line-height-h3'                           => 1.6,
		'letter-spacing-h3'                        => 0,
		'word-spacing-h3'                          => 0,
		'link-underline-h3'                        => 'never',
		// H4
		'font-family-h4'                           => 'sans-serif',
		'font-size-h4'                             => 24,
		'font-weight-h4'                           => 'normal',
		'font-style-h4'                            => 'normal',
		'text-transform-h4'                        => 'none',
		'line-height-h4'                           => 1.6,
		'letter-spacing-h4'                        => 0,
		'word-spacing-h4'                          => 0,
		'link-underline-h4'                        => 'never',
		// H5
		'font-family-h5'                           => 'sans-serif',
		'font-size-h5'                             => 16,
		'font-weight-h5'                           => 'bold',
		'font-style-h5'                            => 'normal',
		'text-transform-h5'                        => 'uppercase',
		'line-height-h5'                           => 1.6,
		'letter-spacing-h5'                        => 1,
		'word-spacing-h5'                          => 0,
		'link-underline-h5'                        => 'never',
		// H6
		'font-family-h6'                           => 'sans-serif',
		'font-size-h6'                             => 14,
		'font-weight-h6'                           => 'normal',
		'font-style-h6'                            => 'normal',
		'text-transform-h6'                        => 'uppercase',
		'line-height-h6'                           => 1.6,
		'letter-spacing-h6'                        => 2,
		'word-spacing-h6'                          => 0,
		'link-underline-h6'                        => 'never',
		// Site Title
		'font-family-site-title'                   => 'sans-serif',
		'font-size-site-title'                     => 34,
		'font-weight-site-title'                   => 'bold',
		'font-style-site-title'                    => 'normal',
		'text-transform-site-title'                => 'none',
		'line-height-site-title'                   => 1.2,
		'letter-spacing-site-title'                => 0,
		'word-spacing-site-title'                  => 0,
		'link-underline-site-title'                => 'never',
		// Tagline
		'font-family-site-tagline'                 => 'Open Sans',
		'font-size-site-tagline'                   => 12,
		'font-weight-site-tagline'                 => 'normal',
		'font-style-site-tagline'                  => 'normal',
		'text-transform-site-tagline'              => 'uppercase',
		'line-height-site-tagline'                 => 1.6,
		'letter-spacing-site-tagline'              => 1,
		'word-spacing-site-tagline'                => 0,
		'link-underline-site-tagline'              => 'never',
		// Menu Items
		'font-family-nav'                          => 'Open Sans',
		'font-size-nav'                            => 14,
		'font-weight-nav'                          => 'normal',
		'font-style-nav'                           => 'normal',
		'text-transform-nav'                       => 'none',
		'line-height-nav'                          => 1.4,
		'letter-spacing-nav'                       => 0,
		'word-spacing-nav'                         => 0,
		'link-underline-nav'                       => 'never',
		// Sub-Menu Items
		'font-family-subnav'                       => 'Open Sans',
		'font-size-subnav'                         => 13,
		'font-weight-subnav'                       => 'normal',
		'font-style-subnav'                        => 'normal',
		'text-transform-subnav'                    => 'none',
		'line-height-subnav'                       => 1.4,
		'letter-spacing-subnav'                    => 0,
		'word-spacing-subnav'                      => 0,
		'link-underline-subnav'                    => 'never',
		'font-subnav-mobile'                       => 1,
		// Header Bar Text
		'font-family-header-bar-text'              => 'Open Sans',
		'font-size-header-bar-text'                => 13,
		'font-weight-header-bar-text'              => 'normal',
		'font-style-header-bar-text'               => 'normal',
		'text-transform-header-bar-text'           => 'none',
		'line-height-header-bar-text'              => 1.6,
		'letter-spacing-header-bar-text'           => 0,
		'word-spacing-header-bar-text'             => 0,
		'link-underline-header-bar-text'           => 'never',
		// Header Bar Icons
		'font-size-header-bar-icon'                => 20,
		// Widget Title
		'font-family-widget-title'                 => 'Open Sans',
		'font-size-widget-title'                   => 13,
		'font-weight-widget-title'                 => 'bold',
		'font-style-widget-title'                  => 'normal',
		'text-transform-widget-title'              => 'none',
		'line-height-widget-title'                 => 1.6,
		'letter-spacing-widget-title'              => 0,
		'word-spacing-widget-title'                => 0,
		'link-underline-widget-title'              => 'never',
		// Widget Body
		'font-family-widget'                       => 'Open Sans',
		'font-size-widget'                         => 13,
		'font-weight-widget'                       => 'normal',
		'font-style-widget'                        => 'normal',
		'text-transform-widget'                    => 'none',
		'line-height-widget'                       => 1.6,
		'letter-spacing-widget'                    => 0,
		'word-spacing-widget'                      => 0,
		'link-underline-widget'                    => 'never',
		// Google Web Fonts
		'font-subset'                              => 'latin',

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

		/**
		 * Deprecated defaults
		 */
		'font-site-title'                          => 'sans-serif',
		'font-header'                              => 'sans-serif',
		'font-body'                                => 'Open Sans',
		'font-site-title-size'                     => 34,
		'font-site-tagline-size'                   => 12,
		'font-nav-size'                            => 14,
		'font-header-size'                         => 46,
		'font-widget-size'                         => 13,
		'font-body-size'                           => 17,
		'social-facebook'                          => '',
	);

	/**
	 * Filter the default values for the settings.
	 *
	 * @since 1.2.3.
	 *
	 * @param array    $defaults    The list of default settings.
	 */
	return apply_filters( 'make_setting_defaults', $defaults );
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
	$default  = ( isset( $defaults[ $option ] ) ) ? $defaults[ $option ] : false;

	/**
	 * Filter the retrieved default value.
	 *
	 * @since 1.2.3.
	 *
	 * @param mixed     $default    The default value.
	 * @param string    $option     The name of the default value.
	 */
	return apply_filters( 'make_get_default', $default, $option );
}
endif;
