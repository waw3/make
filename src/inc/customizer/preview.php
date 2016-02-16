<?php
/**
 * @package Make
 */


class MAKE_Customizer_Preview extends MAKE_Util_Modules implements MAKE_Customizer_PreviewInterface, MAKE_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'thememod' => 'MAKE_Settings_ThemeModInterface',
		'scripts'  => 'MAKE_Setup_ScriptsInterface',
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

		// Setting mods
		add_action( 'customize_register', array( $this, 'setting_mods' ) );

		// Preview pane scripts
		add_action( 'customize_preview_init', array( $this, 'enqueue_preview_scripts' ) );

		// Preview theme mod values
		if ( is_admin() || is_customize_preview() ) {
			add_action( 'make_style_before_load', array( $this, 'preview_thememods' ) );
			add_action( 'wp_ajax_make-google-json', array( $this, 'preview_thememods' ), 1 );
		}

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
	 * Modifications to core/existing settings.
	 *
	 * @since x.x.x.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @return void
	 */
	public function setting_mods( WP_Customize_Manager $wp_customize ) {
		// Only run this in the proper hook context.
		if ( 'customize_register' !== current_action() ) {
			return;
		}

		// Change transport for some core settings
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	}

	/**
	 * Enqueue scripts for the Customizer preview pane.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function enqueue_preview_scripts() {
		// Only run this in the proper hook context.
		if ( 'customize_preview_init' !== current_action() ) {
			return;
		}

		wp_enqueue_script(
			'make-customizer-preview',
			$this->scripts()->get_js_directory_uri() . '/customizer/preview.js',
			array( 'customize-preview' ),
			TTFMAKE_VERSION,
			true
		);

		$data = array(
			'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			'webfonturl'    => esc_url( $this->scripts()->get_url( 'web-font-loader', 'script' ) ),
			'fontSettings'  => array_keys( $this->thememod()->get_settings( 'is_font' ) ),
			'styleSettings' => array_keys( $this->thememod()->get_settings( 'is_style' ) ),
		);

		wp_localize_script(
			'make-customizer-preview',
			'MakePreview',
			$data
		);
	}

	/**
	 * Wrapper function for substituting preview values in theme mod settings.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function preview_thememods() {
		// Only run this in the proper hook context.
		if ( ! in_array( current_action(), array( 'make_style_before_load', 'wp_ajax_make-google-json' ) ) ) {
			return;
		}

		if ( ! isset( $_POST['make-preview'] ) ) {
			return;
		}

		$preview = (array) $_POST['make-preview'];

		foreach ( $preview as $setting_id => $value ) {
			add_filter( "theme_mod_{$setting_id}", array( $this, 'preview_thememod_value' ) );
		}
	}

	/**
	 * Return a preview value for a particular theme mod setting.
	 *
	 * @since x.x.x.
	 *
	 * @param $value
	 *
	 * @return mixed
	 */
	public function preview_thememod_value( $value ) {
		// Only run this in the proper hook context.
		if ( 0 !== strpos( current_filter(), 'theme_mod_' ) ) {
			return $value;
		}

		if ( ! isset( $_POST['make-preview'] ) ) {
			return $value;
		}

		$preview = (array) $_POST['make-preview'];
		$setting_id = str_replace( 'theme_mod_', '', current_filter() );

		if ( isset( $preview[ $setting_id ] ) ) {
			return $preview[ $setting_id ];
		}

		return $value;
	}
}