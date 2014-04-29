<?php
/**
 * @package Make
 */

if ( ! class_exists( 'TTFMAKE_TinyMCE_Buttons' ) ) :
/**
 * Collector for builder sections.
 *
 * @since 1.0.0.
 *
 * Class TTFMAKE_TinyMCE_Buttons
 */
class TTFMAKE_TinyMCE_Buttons {
	/**
	 * The one instance of TTFMAKE_TinyMCE_Buttons.
	 *
	 * @since 1.0.0.
	 *
	 * @var   TTFMAKE_TinyMCE_Buttons
	 */
	private static $instance;

	/**
	 * Instantiate or return the one TTFMAKE_TinyMCE_Buttons instance.
	 *
	 * @since  1.0.0.
	 *
	 * @return TTFMAKE_TinyMCE_Buttons
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Register the sections.
	 *
	 * @since  1.0.0.
	 *
	 * @return TTFMAKE_TinyMCE_Buttons
	 */
	public function __construct() {
		// Add the button
		add_action( 'admin_init', array( $this, 'add_button_button' ), 11 );
	}

	/**
	 * Implement the TinyMCE button for creating a button.
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	public function add_button_button() {
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
			return;
		}

		add_filter( 'mce_external_plugins', array( $this, 'add_tinymce_plugin' ) );
		add_filter( 'mce_buttons', array( $this, 'register_mce_button' ) );
	}

	/**
	 * Implement the TinyMCE plugin for creating a button.
	 *
	 * @since  1.0.0.
	 *
	 * @param  array    $plugins    The current array of plugins.
	 * @return array                The modified plugins array.
	 */
	public function add_tinymce_plugin( $plugins ) {
		$plugins['ttfmake_mce_button_button'] = get_template_directory_uri() .'/inc/tinymce-buttons/js/tinymce-button.js';
		$plugins['ttfmake_mce_alert_button']  = get_template_directory_uri() .'/inc/tinymce-buttons/js/tinymce-alert.js';
		$plugins['ttfmake_mce_list_button']   = get_template_directory_uri() .'/inc/tinymce-buttons/js/tinymce-list.js';
		$plugins['ttfmake_mce_line_button']   = get_template_directory_uri() .'/inc/tinymce-buttons/js/tinymce-line.js';
		return $plugins;
	}

	/**
	 * Implement the TinyMCE button for creating a button.
	 *
	 * @since  1.0.0.
	 *
	 * @param  array    $buttons    The current array of plugins.
	 * @return array                The modified plugins array.
	 */
	public function register_mce_button( $buttons ) {
		$buttons[] = 'ttfmake_mce_button_button';
		$buttons[] = 'ttfmake_mce_alert_button';
		$buttons[] = 'ttfmake_mce_list_button';
		$buttons[] = 'ttfmake_mce_line_button';
		return $buttons;
	}
}
endif;

/**
 * Instantiate or return the one TTFMAKE_TinyMCE_Buttons instance.
 *
 * @since  1.0.0.
 *
 * @return TTFMAKE_TinyMCE_Buttons
 */
function ttfmake_get_tinymce_buttons() {
	return TTFMAKE_TinyMCE_Buttons::instance();
}

add_action( 'admin_init', 'ttfmake_get_tinymce_buttons' );