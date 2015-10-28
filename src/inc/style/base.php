<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Style_Base
 *
 * @since x.x.x.
 */
final class MAKE_Style_Base extends MAKE_Util_Modules implements MAKE_Style_StyleInterface, MAKE_Util_HookInterface, MAKE_Util_LoadInterface {
	/**
	 * Array for file paths to include in the load method.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	private $includes = array();


	private $file_action = 'make-css';


	private $inline_action = 'make-css-inline';

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $hooked = false;

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $loaded = false;

	/**
	 * Inject dependencies, populate class properties.
	 *
	 * @since x.x.x.
	 *
	 * @param MAKE_Compatibility_CompatibilityInterface $compatibility
	 * @param MAKE_Settings_ThemeModInterface           $thememod
	 * @param MAKE_Style_CSSInterface|null              $css
	 */
	public function __construct(
		MAKE_Compatibility_CompatibilityInterface $compatibility,
		MAKE_Settings_ThemeModInterface $thememod,
		MAKE_Style_CSSInterface $css = null
	) {
		// Compatibility
		$this->add_module( 'compatibility', $compatibility );

		// Theme mods
		$this->add_module( 'thememod', $thememod );

		// CSS
		$this->add_module( 'css', ( is_null( $css ) ) ? new MAKE_Style_CSS : $css );

		// Define includes
		$includes_path = dirname( __FILE__ ) . '/includes/';
		$this->includes = array(
			$includes_path . 'builder.php',
			$includes_path . 'thememod-background.php',
			$includes_path . 'thememod-color.php',
		);
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

		// Add styles as inline CSS in the document head.
		add_action( 'wp_head', array( $this, 'get_styles_as_inline' ), 11 );

		// Register Ajax handler for returning styles as inline CSS.
		add_action( 'wp_ajax_' . $this->inline_action, array( $this, 'get_styles_as_inline_ajax' ) );
		add_action( 'wp_ajax_nopriv_' . $this->inline_action, array( $this, 'get_styles_as_inline_ajax' ) );

		// Register Ajax handler for outputting styles as a file.
		add_action( 'wp_ajax_' . $this->file_action, array( $this, 'get_styles_as_file' ) );
		add_action( 'wp_ajax_nopriv_' . $this->file_action, array( $this, 'get_styles_as_file' ) );

		// Add styles file to TinyMCE.
		add_filter( 'mce_css', array( $this, 'mce_css' ), 99 );

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
	 * Load data files.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function load() {
		if ( $this->is_loaded() ) {
			return;
		}

		// Load the style includes.
		foreach ( $this->includes as $file ) {
			if ( is_readable( $file ) ) {
				include $file;
			}
		}

		// Check for deprecated action.
		if ( has_action( 'make_css' ) ) {
			$this->get_module( 'compatibility' )->deprecated_hook(
				'make_css',
				'1.7.0',
				__( 'To add dynamic CSS rules, hook into make_style_loaded instead.', 'make' )
			);

			/**
			 * The hook used to add CSS rules for the generated inline CSS.
			 *
			 * This hook is the correct hook to use for adding CSS styles to the group of selectors and properties that will be
			 * added to inline CSS that is printed in the head. Hooking elsewhere may lead to rules not being registered
			 * correctly for the CSS generation. Most Customizer options will use this hook to register additional CSS rules.
			 *
			 * @since 1.2.3.
			 * @deprecated 1.7.0.
			 */
			do_action( 'make_css' );
		}

		/**
		 * Action: Fires at the end of the Styles object's load method.
		 *
		 * This action gives a developer the opportunity to add or modify dynamic styles
		 * and run additional load routines.
		 *
		 * @since 1.2.3.
		 *
		 * @param MAKE_Style_Base    $style    The styles object
		 */
		do_action( 'make_style_loaded', $this );

		// Loading has occurred.
		$this->loaded = true;
	}

	/**
	 * Check if the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @return bool
	 */
	public function is_loaded() {
		return $this->loaded;
	}

	/**
	 * Convenience method for getting the Theme mods class.
	 *
	 * @since x.x.x.
	 *
	 * @return mixed
	 */
	public function thememod() {
		return $this->get_module( 'thememod' );
	}

	/**
	 * Convenience method for getting the CSS class.
	 *
	 * @since x.x.x.
	 *
	 * @return mixed
	 */
	public function css() {
		return $this->get_module( 'css' );
	}


	public function get_styles_as_inline( $include_tag = true ) {
		if ( ! $this->is_loaded() ) {
			$this->load();
		}

		/**
		 * Action: Fires before CSS rules are rendered.
		 *
		 * @since x.x.x.
		 */
		do_action( 'make_style_before' );

		/**
		 * Action: Fires before the inline CSS rules are rendered and output.
		 *
		 * @since x.x.x.
		 */
		do_action( 'make_style_before_inline' );

		// Echo the rules.
		if ( $this->css()->has_rules() ) {
			if ( $include_tag ) {
				echo "\n<!-- Begin Make Inline CSS -->\n<style id=\"make-inline-css\" type=\"text/css\">\n";
			}

			echo wp_filter_nohtml_kses( $this->css()->build() );

			if ( $include_tag ) {
				echo "\n</style>\n<!-- End Make Inline Custom CSS -->\n";
			}
		}
	}


	public function get_styles_as_inline_ajax() {
		// Only run this in the proper hook context.
		if ( ! in_array( current_action(), array( 'wp_ajax_' . $this->inline_action, 'wp_ajax_nopriv_' . $this->inline_action ) ) ) {
			wp_die();
		}

		// Send the styles without a <style> tag wrap.
		$this->get_styles_as_inline( false );

		// End the Ajax response.
		wp_die();
	}

	/**
	 *
	 *
	 * @return void
	 */
	public function get_styles_as_file() {
		// Only run this in the proper hook context.
		if ( ! in_array( current_action(), array( 'wp_ajax_' . $this->file_action, 'wp_ajax_nopriv_' . $this->file_action ) ) ) {
			wp_die();
		}

		if ( ! $this->is_loaded() ) {
			$this->load();
		}

		/**
		 * This action is documented in the get_styles_as_inline() method.
		 */
		do_action( 'make_style_before' );

		/**
		 * Action: Fires before the CSS rules are rendered and output as a file.
		 *
		 * @since x.x.x.
		 */
		do_action( 'make_style_before_file' );

		/**
		 * Filter: Set whether the dynamic stylesheet will send headers telling the browser
		 * to cache the request. Set to false to turn off these headers.
		 *
		 * @since x.x.x.
		 *
		 * @param bool    $cache_headers
		 */
		if ( ( ! defined( 'SCRIPT_DEBUG' ) || false === SCRIPT_DEBUG ) && true === apply_filters( 'make_style_file_cache_headers', true ) ) {
			// Set headers for caching
			// @link http://stackoverflow.com/a/15000868
			// @link http://www.mobify.com/blog/beginners-guide-to-http-cache-headers/
			$expires = HOUR_IN_SECONDS;
			header( 'Pragma: public' );
			header( 'Cache-Control: private, max-age=' . $expires );
			header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time() + $expires ) . ' GMT' );
		}

		// Set header for content type.
		header( 'Content-type: text/css' );

		// Echo the rules.
		echo wp_filter_nohtml_kses( $this->css()->build() );

		// End the Ajax response.
		wp_die();
	}

	/**
	 * Generate a URL for accessing the dynamically-generated CSS file.
	 *
	 * @since x.x.x.
	 *
	 * @return string
	 */
	public function get_file_url() {
		return add_query_arg( 'action', $this->file_action, admin_url( 'admin-ajax.php' ) );
	}

	/**
	 * Make sure theme option CSS is added to TinyMCE last, to override other styles.
	 *
	 * @since  1.0.0.
	 *
	 * @param  string    $stylesheets    List of stylesheets added to TinyMCE.
	 * @return string                    Modified list of stylesheets.
	 */
	function mce_css( $stylesheets ) {
		if ( $this->css()->has_rules() ) {
			$stylesheets .= ',' . $this->get_file_url();
		}

		return $stylesheets;
	}

	/**
	 * Convert a hex string into a comma separated RGB string.
	 *
	 * @link http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
	 *
	 * @since 1.5.0.
	 *
	 * @param  $value
	 * @return bool|string
	 */
	public function hex_to_rgb( $value ) {
		$hex = sanitize_hex_color_no_hash( $value );

		if ( 6 === strlen( $hex ) ) {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		} else if ( 3 === strlen( $hex ) ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			return false;
		}

		return "$r, $g, $b";
	}
}