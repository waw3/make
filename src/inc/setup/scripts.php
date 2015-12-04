<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Setup_Scripts
 *
 * @since x.x.x.
 */
final class MAKE_Setup_Scripts extends MAKE_Util_Modules implements MAKE_Setup_ScriptsInterface, MAKE_Util_HookInterface {
	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $hooked = false;

	/**
	 * Inject dependencies.
	 *
	 * @since x.x.x.
	 *
	 * @param MAKE_Font_ManagerInterface $font
	 */
	public function __construct(
		MAKE_Font_ManagerInterface $font,
		MAKE_Settings_ThemeModInterface $thememod
	) {
		// Fonts
		$this->add_module( 'font', $font );

		// Theme Mods
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

		// Front end styles and scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );

		// Admin styles and scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'add_editor_styles' ) );

		//
		if ( is_admin() || is_customize_preview() ) {
			add_action( 'wp_ajax_make-google-json', array( $this, 'get_google_json' ) );
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


	public function enqueue_frontend_styles() {
		// Only run this in the proper hook context.
		if ( 'wp_enqueue_scripts' !== current_action() ) {
			return;
		}

		$this->register_style_libs();

		// Parent stylesheet, if child theme is active
		// @link http://justintadlock.com/archives/2014/11/03/loading-parent-styles-for-child-themes
		if ( is_child_theme() && defined( 'TTFMAKE_CHILD_VERSION' ) && version_compare( TTFMAKE_CHILD_VERSION, '1.1.0', '>=' ) ) {
			/**
			 * Toggle for loading the parent stylesheet along with the child one.
			 *
			 * @since 1.6.0.
			 *
			 * @param bool    $enqueue    True enqueues the parent stylesheet.
			 */
			if ( true === apply_filters( 'make_enqueue_parent_stylesheet', true ) ) {
				wp_enqueue_style(
					'make-parent',
					get_template_directory_uri() . '/style.css',
					array(),
					TTFMAKE_VERSION
				);
			}
		}

		// Main stylesheet
		wp_enqueue_style(
			'make-main',
			get_stylesheet_uri(),
			array(),
			TTFMAKE_VERSION
		);

		// Stylesheet dependencies
		$stylesheet = ( $this->style_is_registered( 'make-parent' ) ) ? 'make-parent' : 'make-main';
		$this->add_style_dependency( $stylesheet, 'make-google-font' );
		$this->add_style_dependency( $stylesheet, 'font-awesome' );

		// Print stylesheet
		if ( $url = $this->get_located_file_url( array( 'print.css', 'css/print.css' ) ) ) {
			wp_enqueue_style(
				'make-print',
				$url,
				array( 'make-main' ),
				TTFMAKE_VERSION,
				'print'
			);
		}
	}


	public function add_editor_styles() {
		// Only run this in the proper hook context.
		if ( 'admin_enqueue_scripts' !== current_action() ) {
			return;
		}

		$this->register_style_libs();

		$editor_styles = array();

		foreach ( array(
			'make-google-font',
			'font-awesome',
			'make-editor'
		) as $lib ) {
			if ( $this->style_is_registered( $lib ) ) {
				$editor_styles[] = $this->get_style_url( $lib );
			}
		}

		add_editor_style( $editor_styles );
	}


	public function register_style_libs() {
		// Chosen
		wp_register_style(
			'chosen',
			get_template_directory_uri() . '/css/libs/chosen/chosen.css',
			array(),
			'1.4.2'
		);

		// Editor styles
		wp_register_style(
			'make-editor',
			$this->get_located_file_url( array( 'editor-style.css', 'css/editor-style.css' ) ),
			array(),
			TTFMAKE_VERSION,
			'screen'
		);

		// Font Awesome
		wp_register_style(
			'font-awesome',
			get_template_directory_uri() . '/css/libs/font-awesome/font-awesome.min.css',
			array(),
			'4.4.0'
		);

		// Google Fonts
		if ( $url = $this->get_google_url() ) {
			wp_register_style(
				'make-google-font',
				$url,
				array(),
				TTFMAKE_VERSION
			);
		}
	}


	public function enqueue_frontend_scripts() {
		// Only run this in the proper hook context.
		if ( 'wp_enqueue_scripts' !== current_action() ) {
			return;
		}

		$this->register_script_libs();

		// Main script
		wp_enqueue_script(
			'make-frontend',
			$this->get_located_file_url( array( 'frontend.js', 'js/frontend.js' ) ),
			array( 'jquery' ),
			TTFMAKE_VERSION,
			true
		);

		// Define JS data
		$data = array(
			'fitvids' => $this->get_fitvids_selectors()
		);

		// Add JS data
		wp_localize_script(
			'make-frontend',
			'MakeFrontEnd',
			$data
		);

		// Comment reply script
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}


	public function register_script_libs() {
		// Chosen
		wp_register_script(
			'chosen',
			get_template_directory_uri() . '/js/libs/chosen/chosen.jquery.min.js',
			array( 'jquery' ),
			'1.4.2',
			true
		);

		// Cycle2
		if ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) {
			// Core script
			wp_register_script(
				'cycle2',
				get_template_directory_uri() . '/js/libs/cycle2/jquery.cycle2.js',
				array( 'jquery' ),
				'2.1.6',
				true
			);

			// Vertical centering
			wp_register_script(
				'cycle2-center',
				get_template_directory_uri() . '/js/libs/cycle2/jquery.cycle2.center.js',
				array( 'cycle2' ),
				'20140121',
				true
			);

			// Swipe support
			wp_register_script(
				'cycle2-swipe',
				get_template_directory_uri() . '/js/libs/cycle2/jquery.cycle2.swipe.js',
				array( 'cycle2' ),
				'20121120',
				true
			);
		} else {
			wp_register_script(
				'cycle2',
				get_template_directory_uri() . '/js/libs/cycle2/jquery.cycle2.min.js',
				array( 'jquery' ),
				'2.1.6',
				true
			);
		}

		// FitVids
		wp_register_script(
			'fitvids',
			get_template_directory_uri() . '/js/libs/fitvids/jquery.fitvids.min.js',
			array( 'jquery' ),
			'1.1',
			true
		);

		// Web Font Loader
		wp_register_script(
			'web-font-loader',
			'//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js'
		);
	}


	/**
	 * Get the URL of a theme file.
	 *
	 * Looks for the file in a child theme first, then in the parent theme.
	 *
	 * @since x.x.x.
	 *
	 * @uses locate_template()
	 *
	 * @param  string|array    $file_names    File(s) to search for, in order.
	 *
	 * @return string                         The file URL if one is located.
	 */
	public function get_located_file_url( $file_names ) {
		$url = '';

		$located = locate_template( $file_names );
		if ( '' !== $located ) {
			if ( 0 === strpos( $located, get_stylesheet_directory() ) ) {
				$url = str_replace( get_stylesheet_directory(), get_stylesheet_directory_uri(), $located );
			} else if ( 0 === strpos( $located, get_template_directory() ) ) {
				$url = str_replace( get_template_directory(), get_template_directory_uri(), $located );
			}
		}

		return $url;
	}


	private function get_dependency_object( $dependency_id, $type ) {
		switch ( $type ) {
			case 'style' :
				global $wp_styles;
				if ( $wp_styles instanceof WP_Styles ) {
					$style = $wp_styles->query( $dependency_id, 'registered' );
					if ( $style instanceof _WP_Dependency ) {
						return $style;
					}
				}
				break;

			case 'script' :
				global $wp_scripts;
				if ( $wp_scripts instanceof WP_Scripts ) {
					$script = $wp_scripts->query( $dependency_id, 'registered' );
					if ( $script instanceof _WP_Dependency ) {
						return $script;
					}
				}
				break;
		}

		return null;
	}


	private function sanitize_version( $version ) {
		return preg_replace( '/[^A-Za-z0-9\-_\.]+/', '', $version );
	}


	public function style_is_registered( $style_id ) {
		return ! is_null( $this->get_dependency_object( $style_id, 'style' ) );
	}


	public function add_style_dependency( $style_id, $dependency_id ) {
		if ( $this->style_is_registered( $style_id ) && $this->style_is_registered( $dependency_id ) ) {
			$style = $this->get_dependency_object( $style_id, 'style' );
			if ( ! in_array( $dependency_id, $style->deps ) ) {
				$style->deps[] = $dependency_id;
				return true;
			}
		}

		return false;
	}


	public function remove_style_dependency( $style_id, $dependency_id ) {
		if ( $this->style_is_registered( $style_id ) ) {
			$style = $this->get_dependency_object( $style_id, 'style' );
			if ( false !== $key = array_search( $dependency_id, $style->deps ) ) {
				unset( $style->deps[ $key ] );
				return true;
			}
		}

		return false;
	}


	public function update_style_version( $style_id, $version ) {
		if ( $this->style_is_registered( $style_id ) ) {
			$style = $this->get_dependency_object( $style_id, 'style' );
			$style->ver = $this->sanitize_version( $version );
			return true;
		}

		return false;
	}


	public function get_style_url( $style_id ) {
		$url = '';

		if ( $this->style_is_registered( $style_id ) ) {
			$style = $this->get_dependency_object( $style_id, 'style' );
			$url = add_query_arg( 'ver', $style->ver, $style->src );
		}

		return $url;
	}


	public function script_is_registered( $script_id ) {
		return ! is_null( $this->get_dependency_object( $script_id, 'script' ) );
	}


	public function add_script_dependency( $script_id, $dependency_id ) {
		if ( $this->script_is_registered( $script_id ) && $this->script_is_registered( $dependency_id ) ) {
			$script = $this->get_dependency_object( $script_id, 'script' );
			if ( ! in_array( $dependency_id, $script->deps ) ) {
				$script->deps[] = $dependency_id;
				return true;
			}
		}

		return false;
	}


	public function remove_script_dependency( $script_id, $dependency_id ) {
		if ( $this->script_is_registered( $script_id ) ) {
			$script = $this->get_dependency_object( $script_id, 'script' );
			if ( false !== $key = array_search( $dependency_id, $script->deps ) ) {
				unset( $script->deps[ $key ] );
				return true;
			}
		}

		return false;
	}


	public function update_script_version( $script_id, $version ) {
		if ( $this->script_is_registered( $script_id ) ) {
			$script = $this->get_dependency_object( $script_id, 'script' );
			$script->ver = $this->sanitize_version( $version );
			return true;
		}

		return false;
	}


	public function get_script_url( $script_id ) {
		$url = '';

		if ( $this->script_is_registered( $script_id ) ) {
			$script = $this->get_dependency_object( $script_id, 'script' );
			$url = add_query_arg( 'ver', $script->ver, $script->src );
		}

		return $url;
	}


	private function get_google_url( $force = false, $preview = false ) {
		$setting_id = 'google-font-url';

		if ( ! $this->thememod()->setting_exists( $setting_id ) ) {
			return '';
		} else if ( true !== $force && $this->thememod()->get_raw_value( $setting_id ) ) {
			return $this->thememod()->get_value( $setting_id );
		}

		$font_keys = array_keys( $this->thememod()->get_settings( 'is_font' ) );
		$fonts = array();

		foreach ( $font_keys as $font_key ) {
			$font = $this->thememod()->get_value( $font_key );
			if ( $font ) {
				$fonts[] = $font;
			}
		}

		$subsets = (array) $this->thememod()->get_value( 'font-subset' );

		$url = $this->font()->get_source( 'google' )->build_url( $fonts, $subsets );

		if ( true !== $preview ) {
			$this->thememod()->set_value( $setting_id, $url );
		}

		return $url;
	}


	public function get_google_json() {
		// Only run this in the proper hook context.
		if ( 'wp_ajax_make-google-json' !== current_action() ) {
			wp_send_json_error();
		}

		$font_keys = array_keys( $this->thememod()->get_settings( 'is_font' ) );
		$fonts = array();

		foreach ( $font_keys as $font_key ) {
			$font = $this->thememod()->get_value( $font_key );
			if ( $font ) {
				$fonts[] = $font;
			}
		}

		$subsets = (array) $this->thememod()->get_value( 'font-subset' );

		wp_send_json_success( $this->font()->get_source( 'google' )->build_json( $fonts, $subsets ) );
	}


	private function get_fitvids_selectors() {
		/**
		 * Filter: Allow customization of the selectors that are used to apply FitVids.
		 *
		 * @since 1.2.3.
		 *
		 * @param array    $selector_array    The selectors used by FitVids.
		 */
		$selector_array = apply_filters( 'make_fitvids_custom_selectors', array(
			"iframe[src*='www.viddler.com']",
			"iframe[src*='money.cnn.com']",
			"iframe[src*='www.educreations.com']",
			"iframe[src*='//blip.tv']",
			"iframe[src*='//embed.ted.com']",
			"iframe[src*='//www.hulu.com']",
		) );

		// Compile selectors
		return array(
			'selectors' => implode( ',', $selector_array )
		);
	}
}