<?php
/**
 * @package Make
 */


class MAKE_Customizer_Preview extends MAKE_Util_Modules implements MAKE_Customizer_PreviewInterface, MAKE_Util_HookInterface {
	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $hooked = false;


	public function __construct(
		MAKE_Settings_ThemeModInterface $thememod
	) {
		// Theme mods
		$this->add_module( 'thememod', $thememod );
	}

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

		//
		add_action( 'make_style_before_load', array( $this, 'preview_styles' ) );

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
			'make-customizer-preview',
			get_template_directory_uri() . '/inc/customizer/js/preview.js',
			array( 'customize-preview' ),
			TTFMAKE_VERSION,
			true
		);

		$data = array(
			'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			'fontSettings'  => array_keys( $this->thememod()->get_settings( 'is_font' ) ),
			'styleSettings' => array_keys( $this->thememod()->get_settings( 'is_style' ) ),
		);

		wp_localize_script(
			'make-customizer-preview',
			'MakePreview',
			$data
		);
	}


	public function preview_styles() {
		// Only run this in the proper hook context.
		if ( 'make_style_before_load' !== current_action() ) {
			return;
		}

		//
		if ( ! isset( $_POST['preview'] ) ) {
			return;
		}

		$preview = (array) $_POST['preview'];

		foreach ( $preview as $setting_id => $value ) {
			add_filter( "theme_mod_{$setting_id}", array( $this, 'preview_thememod_value' ) );
		}
	}


	public function preview_thememod_value( $value ) {
		// Only run this in the proper hook context.
		if ( 0 !== strpos( current_filter(), 'theme_mod_' ) ) {
			return $value;
		}

		//
		if ( ! isset( $_POST['preview'] ) ) {
			return $value;
		}

		$preview = (array) $_POST['preview'];
		$setting_id = str_replace( 'theme_mod_', '', current_filter() );

		if ( isset( $preview[ $setting_id ] ) ) {
			return $preview[ $setting_id ];
		}

		return $value;
	}
}