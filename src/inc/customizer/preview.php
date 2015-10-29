<?php
/**
 * @package Make
 */


class MAKE_Customizer_Preview implements MAKE_Customizer_PreviewInterface, MAKE_Util_HookInterface {
	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $hooked = false;


	public function __construct() {}

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

		// Setting mods
		add_action( 'customize_register', array( $this, 'setting_mods' ) );

		// Preview pane scripts
		add_action( 'customize_preview_init', array( $this, 'enqueue_preview_scripts' ) );

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


	public function setting_mods( $wp_customize ) {
		// Only run this in the proper hook context.
		if ( 'customize_register' !== current_action() ) {
			return;
		}

		// Change transport for some core settings
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	}


	public function enqueue_preview_scripts() {
		// Only run this in the proper hook context.
		if ( 'customize_preview_init' !== current_action() ) {
			return;
		}

		wp_enqueue_script(
			'ttfmake-customizer-preview',
			get_template_directory_uri() . '/inc/customizer/js/customizer-preview' . TTFMAKE_SUFFIX . '.js',
			array( 'customize-preview' ),
			TTFMAKE_VERSION,
			true
		);
	}
}