<?php
/**
 * @package Make
 */

if ( ! class_exists( 'TTFMAKE_Format_Builder' ) ) :
/**
 * Class TTFMAKE_Format_Builder
 *
 * TinyMCE plugin that adds a Format Builder dialog to the editor.
 *
 * @since 1.4.0.
 */
class TTFMAKE_Format_Builder {
	/**
	 * The one instance of TTFMAKE_Format_Builder.
	 *
	 * @since 1.4.0.
	 *
	 * @var   TTFMAKE_Format_Builder
	 */
	private static $instance;

	/**
	 * Instantiate or return the one TTFMAKE_Format_Builder instance.
	 *
	 * @since  1.4.0.
	 *
	 * @return TTFMAKE_Format_Builder
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
	 * @return TTFMAKE_Format_Builder
	 */
	public function __construct() {}

	/**
	 * Initialize the Format Builder functionality and hook into WordPress.
	 *
	 * @since 1.4.0.
	 *
	 * @return void
	 */
	public function init() {
		if ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) {
			// Add plugin and button
			add_filter( 'mce_external_plugins', array( $this, 'register_plugin' ) );
			add_filter( 'mce_buttons', array( $this, 'register_button' ) );

			// Add translations for plugin
			add_filter( 'wp_mce_translation', array( $this, 'add_translations' ), 10, 2 );

			// Enqueue styles and scripts for plugin functionality
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}
	}

	/**
	 * Add the plugin to TinyMCE.
	 *
	 * @since 1.4.0.
	 *
	 * @param  array    $plugins
	 * @return mixed
	 */
	public function register_plugin( $plugins ) {
		$plugins['ttfmake_format_builder'] = trailingslashit( get_template_directory_uri() ) . 'inc/format-builder/js/plugin.js';
		return $plugins;
	}

	/**
	 * Add the Format Builder to the TinyMCE toolbar.
	 *
	 * @since 1.4.0.
	 *
	 * @param  array    $buttons
	 * @return array
	 */
	public function register_button( $buttons ) {
		$buttons[] = 'ttfmake_format_builder';
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
		$format_builder_translations = array(
			'Format Builder' => __( 'Format Builder', 'make' ),
		);

		return array_merge( $translations, $format_builder_translations );
	}

	/**
	 * Enqueue the Format Builder JS scripts.
	 *
	 * @since 1.4.0.
	 *
	 * @param $hook_suffix
	 */
	public function enqueue_scripts( $hook_suffix ) {
		if ( in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ) {
			// Styles
			wp_enqueue_style(
				'ttfmake-format-builder',
				trailingslashit( get_template_directory_uri() ) . 'inc/format-builder/css/format-builder.css',
				array(),
				TTFMAKE_VERSION
			);

			// Icons
			wp_enqueue_style(
				'ttfmake-font-awesome',
				get_template_directory_uri() . '/css/font-awesome' . TTFMAKE_SUFFIX . '.css',
				array(),
				'4.2.0'
			);

			// Scripts
			$dependencies = array( 'backbone', 'underscore', 'jquery' );

			// Core
			wp_enqueue_script(
				'ttfmake-format-builder-core',
				trailingslashit( get_template_directory_uri() ) . 'inc/format-builder/js/core.js',
				$dependencies,
				TTFMAKE_VERSION
			);

			// Base model
			wp_enqueue_script(
				'ttfmake-format-builder-model-base',
				trailingslashit( get_template_directory_uri() ) . 'inc/format-builder/js/models/base.js',
				$dependencies,
				TTFMAKE_VERSION
			);
			$dependencies[] = 'ttfmake-format-builder-model-base';

			// Format models
			$models = array(
				'button',
			);
			foreach ( $models as $model ) {
				$handle = 'ttfmake-format-builder-model-' . $model;
				wp_enqueue_script(
					$handle,
					trailingslashit( get_template_directory_uri() ) . "inc/format-builder/js/models/$model.js",
					$dependencies,
					TTFMAKE_VERSION
				);
				$dependencies[] = $handle;
			}

			// Icon list
			wp_enqueue_script(
				'ttfmake-icon-picker-list',
				trailingslashit( get_template_directory_uri() ) . 'inc/format-builder/js/icons.js',
				array(),
				TTFMAKE_VERSION
			);

			// Icon Picker
			wp_enqueue_script(
				'ttfmake-icon-picker',
				trailingslashit( get_template_directory_uri() ) . 'inc/format-builder/js/icon-picker.js',
				array( 'ttfmake-icon-picker-list' ),
				TTFMAKE_VERSION
			);
		}
	}
}
endif;

/**
 * Instantiate or return the one TTFMAKE_Format_Builder instance.
 *
 * @since  1.4.0.
 *
 * @return TTFMAKE_Format_Builder
 */
function ttfmake_format_builder() {
	return TTFMAKE_Format_Builder::instance();
}

/**
 * Run the init function for the Format Builder
 *
 * @since 1.4.0.
 *
 * @return void
 */
function ttfmake_format_builder_init() {
	ttfmake_format_builder()->init();
}

add_action( 'admin_init', 'ttfmake_format_builder_init' );