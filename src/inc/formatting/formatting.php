<?php
/**
 * @package Make
 */

if ( ! class_exists( 'TTFMAKE_Formatting' ) ) :
/**
 * Class TTFMAKE_Formatting
 *
 * TinyMCE plugin that adds formatting options and tools to the editor.
 *
 * @since 1.4.0.
 */
class TTFMAKE_Formatting {
	/**
	 * The one instance of TTFMAKE_Formatting.
	 *
	 * @since 1.4.0.
	 *
	 * @var   TTFMAKE_Formatting
	 */
	private static $instance;

	/**
	 * Instantiate or return the one TTFMAKE_Formatting instance.
	 *
	 * @since  1.4.0.
	 *
	 * @return TTFMAKE_Formatting
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Construct the object.
	 *
	 * @since 1.4.0.
	 *
	 * @return TTFMAKE_Formatting
	 */
	public function __construct() {}

	/**
	 * Initialize the formatting functionality and hook into WordPress.
	 *
	 * @since 1.4.0.
	 *
	 * @return void
	 */
	public function init() {
		if ( is_admin() && ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) ) {
			// Add plugin and button
			add_filter( 'mce_external_plugins', array( $this, 'register_plugins' ) );
			add_filter( 'mce_buttons', array( $this, 'register_buttons' ) );

			// Add translations for plugin
			add_filter( 'wp_mce_translation', array( $this, 'add_translations' ), 10, 2 );

			// Enqueue admin styles and scripts for plugin functionality
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		}

		// Enqueue front end scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
	}

	/**
	 * Add plugins to TinyMCE.
	 *
	 * @since 1.4.0.
	 *
	 * @param  array    $plugins
	 * @return mixed
	 */
	public function register_plugins( $plugins ) {
		// Format Builder
		$plugins['ttfmake_format_builder'] = trailingslashit( get_template_directory_uri() ) . 'inc/formatting/format-builder/plugin.js';

		// Dynamic Stylesheet
		$plugins['ttfmake_dynamic_stylesheet'] = trailingslashit( get_template_directory_uri() ) . 'inc/formatting/dynamic-stylesheet/plugin.js';

		// Icon Picker
		$plugins['ttfmake_icon_picker'] = trailingslashit( get_template_directory_uri() ) . 'inc/formatting/icon-picker/plugin.js';

		return $plugins;
	}

	/**
	 * Add buttons to the TinyMCE toolbar.
	 *
	 * @since 1.4.0.
	 *
	 * @param  array    $buttons
	 * @return array
	 */
	public function register_buttons( $buttons ) {
		// Format Builder
		$buttons[] = 'ttfmake_format_builder';

		// Icon Picker
		$buttons[] = 'ttfmake_icon_picker';

		return $buttons;
	}

	/**
	 * Add translatable strings for the Format Builder UI.
	 *
	 * @since 1.4.0.
	 *
	 * @param  array    $translations
	 * @return array
	 */
	public function add_translations( $translations ) {
		$formatting_translations = array(
			'Format Builder' => __( 'Format Builder', 'make' ),
		);

		return array_merge( $translations, $formatting_translations );
	}

	/**
	 * Enqueue formatting scripts for Post/Page editing screens in the admin.
	 *
	 * @since 1.4.0.
	 *
	 * @param $hook_suffix
	 */
	public function enqueue_admin_scripts( $hook_suffix ) {
		if ( in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ) {
			/**
			 * Admin styles
			 */
			wp_enqueue_style(
				'ttfmake-formatting',
				trailingslashit( get_template_directory_uri() ) . 'inc/formatting/formatting.css',
				array(),
				TTFMAKE_VERSION
			);

			/**
			 * Format Builder
			 */
			$dependencies = array( 'backbone', 'underscore', 'jquery' );

			// Core
			wp_enqueue_script(
				'ttfmake-format-builder-core',
				trailingslashit( get_template_directory_uri() ) . 'inc/formatting/format-builder/format-builder.js',
				$dependencies,
				TTFMAKE_VERSION
			);

			// Base model
			wp_enqueue_script(
				'ttfmake-format-builder-model-base',
				trailingslashit( get_template_directory_uri() ) . 'inc/formatting/format-builder/models/base.js',
				$dependencies,
				TTFMAKE_VERSION
			);
			$dependencies[] = 'ttfmake-format-builder-model-base';

			// Format models
			$models = apply_filters( 'make_format_builder_format_models', array(
				'button',
				'alert',
				'list'
			) );
			foreach ( $models as $model ) {
				$handle = 'ttfmake-format-builder-model-' . $model;
				wp_enqueue_script(
					$handle,
					trailingslashit( get_template_directory_uri() ) . "inc/formatting/format-builder/models/$model.js",
					$dependencies,
					TTFMAKE_VERSION
				);
				$dependencies[] = $handle;
			}

			/**
			 * Dynamic Stylesheet
			 */
			wp_enqueue_script(
				'ttfmake-dynamic-stylesheet',
				trailingslashit( get_template_directory_uri() ) . 'inc/formatting/dynamic-stylesheet/dynamic-stylesheet.js',
				array( 'jquery', 'editor' ),
				TTFMAKE_VERSION,
				true
			);
			wp_localize_script(
				'ttfmake-dynamic-stylesheet',
				'ttfmakeDynamicStylesheetVars',
				array(
					'tinymce' => true
				)
			);

			/**
			 * Icon Picker
			 */
			// Icon styles
			wp_enqueue_style(
				'ttfmake-font-awesome',
				get_template_directory_uri() . '/css/font-awesome' . TTFMAKE_SUFFIX . '.css',
				array(),
				'4.2.0'
			);

			// Icon definitions
			wp_enqueue_script(
				'ttfmake-icon-picker-list',
				trailingslashit( get_template_directory_uri() ) . 'inc/formatting/icon-picker/icons.js',
				array(),
				TTFMAKE_VERSION
			);

			// Icon Picker
			wp_enqueue_script(
				'ttfmake-icon-picker',
				trailingslashit( get_template_directory_uri() ) . 'inc/formatting/icon-picker/icon-picker.js',
				array( 'ttfmake-icon-picker-list' ),
				TTFMAKE_VERSION
			);
		}
	}

	/**
	 * Enqueue scripts for the front end.
	 *
	 * @since 1.4.0.
	 *
	 * @return void
	 */
	public function enqueue_frontend_scripts() {
		// Dynamic styles
		wp_enqueue_script(
			'ttfmake-dynamic-stylesheet',
			trailingslashit( get_template_directory_uri() ) . 'inc/formatting/dynamic-stylesheet/dynamic-stylesheet.js',
			array( 'jquery' ),
			TTFMAKE_VERSION,
			true
		);
	}
}
endif;

/**
 * Instantiate or return the one TTFMAKE_Formatting instance.
 *
 * @since  1.4.0.
 *
 * @return TTFMAKE_Formatting
 */
function ttfmake_formatting() {
	return TTFMAKE_Formatting::instance();
}

/**
 * Run the init function for the Format Builder
 *
 * @since 1.4.0.
 *
 * @return void
 */
function ttfmake_formatting_init() {
	ttfmake_formatting()->init();
}

add_action( 'after_setup_theme', 'ttfmake_formatting_init' );