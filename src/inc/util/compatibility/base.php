<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Util_Compatibility_Base
 *
 * @since x.x.x.
 */
final class MAKE_Util_Compatibility_Base implements MAKE_Util_Compatibility_CompatibilityInterface {
	/**
	 * The compatibility modes.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	private $mode = array(
		'full' => array(
			'deprecated'    => array( '1.5', '1.6', '1.7' ),
			'hook-prefixer' => true,
			'key-converter' => true,
		),
		'1.5' => array(
			'deprecated'    => array( '1.6', '1.7' ),
			'hook-prefixer' => false,
			'key-converter' => false,
		),
		'1.6' => array(
			'deprecated'    => array( '1.7' ),
			'hook-prefixer' => false,
			'key-converter' => false,
		),
		'1.7' => array(
			'deprecated'    => false,
			'hook-prefixer' => false,
			'key-converter' => false,
		),
		'current' => array(
			'deprecated'    => false,
			'hook-prefixer' => false,
			'key-converter' => false,
		),
	);

	/**
	 * Switch for showing compatibility errors.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $show_errors = true;

	/**
	 * The activation status of Make Plus.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $plus = false;

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $loaded = false;

	/**
	 * Initialize and set properties.
	 *
	 * @since x.x.x.
	 */
	public function __construct() {
		/**
		 * Filter: Set the mode for compatibility.
		 *
		 * - 'full' will load all the files to enable back compatibility with deprecated code.
		 * - 'current' will not load any deprecated code. Use with caution! Could result in a fatal PHP error.
		 * - A minor release value, such as '1.5', will load files necessary for back compatibility with version 1.5.x.
		 *   (Note that there are no separate modes for releases prior to 1.5.)
		 *
		 * @since x.x.x.
		 *
		 * @param string    $mode    The compatibility mode to run the theme in.
		 */
		$mode = apply_filters( 'make_compatibility_mode', 'full' );
		if ( isset( $this->mode[ $mode ] ) ) {
			$this->mode = $this->mode[ $mode ];
		} else {
			$this->mode = $this->mode['full'];
		}

		/**
		 * Filter: Toggle for showing compatibility errors.
		 *
		 * WP_DEBUG must also be set to true.
		 *
		 * @since x.x.x.
		 *
		 * @param bool    $show_errors    True to show errors.
		 */
		$this->show_errors = apply_filters( 'make_compatibility_show_errors', true );

		// Check for Make Plus
		$this->plus = class_exists( 'TTFMP_App' );
	}

	/**
	 * Load files and hook into WordPress.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function load() {
		// Bail if the load routine has already been run.
		if ( true === $this->is_loaded() ) {
			return;
		}

		// Add notice if user attempts to install Make Plus as a theme
		add_filter( 'upgrader_source_selection', array( $this, 'check_package' ), 9, 3 );

		// Load deprecated files.
		if ( false !== $this->mode['deprecated'] && is_array( $this->mode['deprecated'] ) ) {
			$this->require_deprecated_files( $this->mode['deprecated'] );
		}

		// Load the hook prefixer
		if ( true === $this->mode['hook-prefixer'] ) {
			$this->hookprefixer_instance = new MAKE_Util_Compatibility_HookPrefixer;
			$this->hookprefixer_instance->init();
		}

		// Load the key converter
		if ( true === $this->mode['key-converter'] ) {
			$this->keyconverter_instance = new MAKE_Util_Compatibility_KeyConverter;
			$this->keyconverter_instance->init();
		}

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
	 * Load back compat files for deprecated functionality based on specified version numbers.
	 *
	 * @since x.x.x.
	 *
	 * @param array    $versions    The array of minor release versions.
	 */
	private function require_deprecated_files( array $versions ) {
		foreach ( $versions as $version ) {
			$file = dirname( __FILE__ ) . '/deprecated/deprecated-' . $version . '.php';
			if ( is_readable( $file ) ) {
				require_once $file;
			}
		}
	}

	/**
	 * Add notice if user attempts to install Make Plus as a theme.
	 *
	 * @since  1.1.2.
	 *
	 * @param  string         $source           File source location.
	 * @param  string         $remote_source    Remove file source location.
	 * @param  WP_Upgrader    $upgrader         WP_Upgrader instance.
	 *
	 * @return WP_Error                         Error or source on success.
	 */
	public function check_package( $source, $remote_source, $upgrader ) {
		// Only run this in the proper hook context.
		if ( 'upgrader_source_selection' !== current_filter() ) {
			return $source;
		}

		global $wp_filesystem;

		if ( ! isset( $_GET['action'] ) || 'upload-theme' !== $_GET['action'] ) {
			return $source;
		}

		if ( is_wp_error( $source ) ) {
			return $source;
		}

		// Check the folder contains a valid theme
		$working_directory = str_replace( $wp_filesystem->wp_content_dir(), trailingslashit( WP_CONTENT_DIR ), $source );
		if ( ! is_dir( $working_directory ) ) { // Sanity check, if the above fails, lets not prevent installation.
			return $source;
		}

		// A proper archive should have a style.css file in the single subdirectory
		if ( ! file_exists( $working_directory . 'style.css' ) && strpos( $source, 'make-plus-' ) >= 0 ) {
			return new WP_Error( 'incompatible_archive_theme_no_style', $upgrader->strings[ 'incompatible_archive' ], __( 'The uploaded package appears to be a plugin. PLEASE INSTALL AS A PLUGIN.', 'make' ) );
		}

		return $source;
	}

	/**
	 * Mark a function as deprecated and inform when it has been used.
	 *
	 * Based on _deprecated_function() in WordPress core.
	 *
	 * @param      $function
	 * @param      $version
	 * @param null $replacement
	 */
	public function deprecated_function( $function, $version, $replacement = null ) {
		/**
		 * Fires when a deprecated function is called.
		 *
		 * @since x.x.x.
		 *
		 * @param string $function    The function that was called.
		 * @param string $replacement The function that should have been called.
		 * @param string $version     The version of Make that deprecated the function.
		 */
		do_action( 'make_deprecated_function_run', $function, $replacement, $version );

		// Maybe show an error.
		if ( defined( 'WP_DEBUG' ) && true === WP_DEBUG && true === $this->show_errors ) {
			if ( function_exists( '__' ) ) {
				if ( ! is_null( $replacement ) ) {
					trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s of Make! Use %3$s instead.', 'make' ), $function, $version, $replacement ) );
				} else {
					trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s of Make, with no alternative available.', 'make' ), $function, $version ) );
				}
			} else {
				if ( ! is_null( $replacement ) ) {
					trigger_error( sprintf( '%1$s is <strong>deprecated</strong> since version %2$s of Make! Use %3$s instead.', $function, $version, $replacement ) );
				} else {
					trigger_error( sprintf( '%1$s is <strong>deprecated</strong> since version %2$s of Make, with no alternative available.', $function, $version ) );
				}
			}
		}
	}

	/**
	 * Mark an action or filter hook as deprecated and inform when it has been used.
	 *
	 * Based on _deprecated_argument() in WordPress core.
	 *
	 * @since x.x.x.
	 *
	 * @param string $hook     The hook that was used.
	 * @param string $version  The version of WordPress that deprecated the hook.
	 * @param string $message  Optional. A message regarding the change. Default null.
	 */
	public function deprecated_hook( $hook, $version, $message = null ) {
		/**
		 * Fires when a deprecated hook has an attached function/method.
		 *
		 * @since x.x.x.
		 *
		 * @param string $hook        The hook that was called.
		 * @param string $message     Optional. A message regarding the change. Default null.
		 * @param string $version     The version of Make that deprecated the hook.
		 */
		do_action( 'make_deprecated_hook_run', $hook, $message, $version );

		// Maybe show an error.
		if ( defined( 'WP_DEBUG' ) && true === WP_DEBUG && true === $this->show_errors ) {
			if ( function_exists( '__' ) ) {
				if ( ! is_null( $message ) ) {
					trigger_error( sprintf( __( 'The %1$s hook is <strong>deprecated</strong> since version %2$s of Make! %3$s', 'make' ), $hook, $version, $message ) );
				} else {
					trigger_error( sprintf( __( 'The %1$s hook is <strong>deprecated</strong> since version %2$s of Make, with no alternative available.', 'make' ), $hook, $version ) );
				}
			} else {
				if ( ! is_null( $message ) ) {
					trigger_error( sprintf( 'The %1$s hook is <strong>deprecated</strong> since version %2$s of Make! %3$s', $hook, $version, $message ) );
				} else {
					trigger_error( sprintf( 'The %1$s hook is <strong>deprecated</strong> since version %2$s of Make, with no alternative available.', $hook, $version ) );
				}
			}
		}
	}

	/**
	 * Mark something as being incorrectly called.
	 *
	 * Based on _doing_it_wrong() in WordPress core.
	 *
	 * @since x.x.x.
	 *
	 * @param string $function The function that was called.
	 * @param string $message  A message explaining what has been done incorrectly.
	 * @param string $version  The version of WordPress where the message was added.
	 */
	public function doing_it_wrong( $function, $message, $version = null ) {
		/**
		 * Fires when the given function is being used incorrectly.
		 *
		 * @since x.x.x.
		 *
		 * @param string $function The function that was called.
		 * @param string $message  A message explaining what has been done incorrectly.
		 * @param string $version  The version of Make where the message was added.
		 */
		do_action( 'make_doing_it_wrong_run', $function, $message, $version = null );

		// Maybe show an error.
		if ( defined( 'WP_DEBUG' ) && true === WP_DEBUG && true === $this->show_errors ) {
			if ( function_exists( '__' ) ) {
				$version = is_null( $version ) ? '' : sprintf( __( '(This message was added in version %s.)' ), $version );
				trigger_error( sprintf( __( '%1$s was called <strong>incorrectly</strong>. %2$s %3$s' ), $function, $message, $version ) );
			} else {
				$version = is_null( $version ) ? '' : sprintf( '(This message was added in version %s.)', $version );
				trigger_error( sprintf( '%1$s was called <strong>incorrectly</strong>. %2$s %3$s', $function, $message, $version ) );
			}
		}
	}

	/**
	 * Check to see if Make Plus is active.
	 *
	 * @since x.x.x.
	 *
	 * @return bool
	 */
	public function is_plus() {
		/**
		 * Filter: Modify the status of Make Plus.
		 *
		 * @since 1.2.3.
		 *
		 * @param bool    $is_plus    True if Make Plus is active.
		 */
		return apply_filters( 'make_is_plus', $this->plus );
	}

	/**
	 * Get the version of Make Plus currently running.
	 *
	 * @since x.x.x.
	 *
	 * @return null
	 */
	public function get_plus_version() {
		$version = null;

		if ( true === $this->is_plus() ) {
			$version = ttfmp_get_app()->version;
		}

		return $version;
	}
}