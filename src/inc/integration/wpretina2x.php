<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Integration_WPRetina2x
 *
 * Integration for the WP Retina 2x plugin.
 *
 * @since 1.7.5.
 */
final class MAKE_Integration_WPRetina2x extends MAKE_Util_Modules implements MAKE_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.5.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'logo' => 'MAKE_Logo_MethodsInterface',
	);

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since 1.7.5.
	 *
	 * @var bool
	 */
	private static $hooked = false;

	/**
	 * Hook into WordPress.
	 *
	 * @since 1.7.5.
	 *
	 * @return void
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		add_filter( 'make_logo_max_width', array( $this, 'set_max_width' ) );

		// Hooking has occurred.
		self::$hooked = true;
	}

	/**
	 * Check if the hook routine has been run.
	 *
	 * @since 1.7.5.
	 *
	 * @return bool
	 */
	public function is_hooked() {
		return self::$hooked;
	}

	/**
	 * Set the max width of the logo to half the full size image width.
	 *
	 * @since 1.7.5.
	 *
	 * @param int $width
	 *
	 * @return float
	 */
	public function set_max_width( $width ) {
		// Only proceed if the core Custom Logo feature is being used.
		if ( ! $this->logo()->custom_logo_is_supported() ) {
			return $width;
		}

		$custom_logo_id = get_theme_mod( 'custom_logo' );

		if ( $custom_logo_id ) {
			$img = wp_get_attachment_image_src( $custom_logo_id, 'full' );

			if ( is_array( $img ) && $img[1] ) {
				$width = floor( absint( $img[1] ) / 2 );
			}
		}

		return $width;
	}
}