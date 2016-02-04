<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Setup_Misc
 *
 * @since x.x.x.
 */
final class MAKE_Setup_Misc extends MAKE_Util_Modules implements MAKE_Setup_MiscInterface, MAKE_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'thememod' => 'MAKE_Settings_ThemeModInterface',
		'widgets'  => 'MAKE_Setup_WidgetsInterface',
	);

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $hooked = false;

	/**
	 * Hook into WordPress.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		// Theme support
		add_action( 'after_setup_theme', array( $this, 'theme_support' ) );

		// Menu locations
		add_action( 'after_setup_theme', array( $this, 'menu_locations' ) );

		// Content width
		add_action( 'template_redirect', array( $this, 'content_width' ) );

		// Hooking has occurred.
		$this->hooked = true;
	}

	/**
	 * Check if the hook routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @return bool
	 */
	public function is_hooked() {
		return $this->hooked;
	}

	/**
	 * Declare theme support for various WordPress features.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function theme_support() {
		// Only run this in the proper hook context.
		if ( 'after_setup_theme' !== current_action() ) {
			return;
		}

		// Automatic feed links
		add_theme_support( 'automatic-feed-links' );

		// Custom background
		add_theme_support( 'custom-background', array(
			'default-color'      => $this->thememod()->get_default( 'background_color' ),
			'default-image'      => $this->thememod()->get_default( 'background_image' ),
			'default-repeat'     => $this->thememod()->get_default( 'background_repeat' ),
			'default-position-x' => $this->thememod()->get_default( 'background_position_x' ),
			'default-attachment' => $this->thememod()->get_default( 'background_attachment' ),
		) );

		// HTML5
		add_theme_support( 'html5', array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption'
		) );

		// Post thumbnails (featured images)
		add_theme_support( 'post-thumbnails' );

		// Title tag
		add_theme_support( 'title-tag' );
	}

	/**
	 * Register menu locations.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function menu_locations() {
		// Only run this in the proper hook context.
		if ( 'after_setup_theme' !== current_action() ) {
			return;
		}

		register_nav_menus( array(
			'primary'    => __( 'Primary Navigation', 'make' ),
			'header-bar' => __( 'Header Bar Navigation', 'make' ),
		) );
	}

	/**
	 * Set the content width based on current layout
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	public function content_width() {
		// Only run this in the proper hook context.
		if ( 'template_redirect' !== current_action() ) {
			return;
		}

		global $content_width;

		$new_width = $content_width;
		$left = $this->widgets()->has_sidebar( 'left' );
		$right = $this->widgets()->has_sidebar( 'right' );

		// No sidebars
		if ( ! $left && ! $right ) {
			$new_width = 960;
		}
		// Both sidebars
		else if ( $left && $right ) {
			$new_width = 464;
		}
		// One sidebar
		else if ( $left || $right ) {
			$new_width = 620;
		}

		/**
		 * Filter to modify the $content_width variable.
		 *
		 * @since 1.4.8
		 *
		 * @param int     $new_width    The new content width.
		 * @param bool    $left         True if the current view has a left sidebar.
		 * @param bool    $right        True if the current view has a right sidebar.
		 */
		$content_width = apply_filters( 'make_content_width', $new_width, $left, $right );
	}
}