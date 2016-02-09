<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Compatibility_Methods
 *
 * @since x.x.x.
 */
class MAKE_Compatibility_Methods extends MAKE_Util_Modules implements MAKE_Compatibility_MethodsInterface, MAKE_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'error' => 'MAKE_Error_CollectorInterface',
	);

	/**
	 * The available compatibility modes.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	private $modes = array(
		'full'    => array(
			'deprecated'    => array( '1.5', '1.6', '1.7' ),
			'hook-prefixer' => true,
			'key-converter' => true,
		),
		'1.5'     => array(
			'deprecated'    => array( '1.6', '1.7' ),
			'hook-prefixer' => false,
			'key-converter' => false,
		),
		'1.6'     => array(
			'deprecated'    => array( '1.7' ),
			'hook-prefixer' => false,
			'key-converter' => false,
		),
		'1.7'     => array(
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
	 * The current compatibility mode.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	protected $mode = array();

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $hooked = false;

	/**
	 * MAKE_Compatibility_Methods constructor.
	 *
	 * @since x.x.x.
	 *
	 * @param MAKE_APIInterface $api
	 * @param array             $modules
	 */
	public function __construct(
		MAKE_APIInterface $api,
		array $modules = array()
	) {
		// Load dependencies.
		parent::__construct( $api, $modules );

		// Set the compatibility mode.
		$this->set_mode();

		// Load deprecated function files.
		// Do this on construct to make sure deprecated functions are defined ASAP.
		if ( false !== $this->mode['deprecated'] && is_array( $this->mode['deprecated'] ) ) {
			$this->require_deprecated_files( $this->mode['deprecated'] );
		}

		// Load the hook prefixer
		if ( true === $this->mode['hook-prefixer'] ) {
			$this->add_module( 'hookprefixer', new MAKE_Compatibility_HookPrefixer( $api, array( 'compatibility' => $this ) ) );
		}

		// Load the key converter
		if ( true === $this->mode['key-converter'] ) {
			$this->add_module( 'keyconverter', new MAKE_Compatibility_KeyConverter );
		}
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

		// Add notice if user attempts to install Make Plus as a theme
		add_filter( 'upgrader_source_selection', array( $this, 'check_package' ), 9, 3 );

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
	 * Set the mode for compatibility.
	 *
	 * @since x.x.x.
	 *
	 * @return string    $mode    The mode that was set.
	 */
	protected function set_mode() {
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

		if ( ! isset( $this->modes[ $mode ] ) ) {
			$mode = 'full';
		}

		$this->mode = $this->modes[ $mode ];
		return $mode;
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
	 * @param string      $function
	 * @param string      $version
	 * @param string|null $replacement
	 * @param array|null  $backtrace
	 */
	public function deprecated_function( $function, $version, $replacement = null, $backtrace = null ) {
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

		$error_code = 'make_deprecated_function';
		$message = __( '<strong>%1$s</strong> is deprecated since version %2$s of Make. %3$s', 'make' );

		// Add an error message.
		if ( ! is_null( $replacement ) ) {
			$message2 = sprintf( __( 'Use <strong>%s</strong> instead.', 'make' ), $replacement );
			$message = sprintf( $message, $function, $version, $message2 );
		} else {
			$message2 = __( 'No alternative is available.', 'make' );
			$message = sprintf( $message, $function, $version, $message2 );
		}

		// Add a backtrace.
		if ( is_array( $backtrace ) ) {
			$message .= '<br />&emsp;' . $this->error()->parse_backtrace( $backtrace );
		}

		// Add the error.
		$this->error()->add_error( $error_code, $message );
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

		$error_code = 'make_deprecated_hook';

		// Add an error
		if ( ! is_null( $message ) ) {
			$this->error()->add_error( $error_code, sprintf( __( 'The <strong>%1$s</strong> hook is deprecated since version %2$s of Make. %3$s', 'make' ), $hook, $version, $message ) );
		} else {
			$this->error()->add_error( $error_code, sprintf( __( 'The <strong>%1$s</strong> hook is deprecated since version %2$s of Make, with no alternative available.', 'make' ), $hook, $version ) );
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
	 * @param null $backtrace
	 */
	public function doing_it_wrong( $function, $message, $version = null, $backtrace = null ) {
		/**
		 * Fires when the given function is being used incorrectly.
		 *
		 * @since x.x.x.
		 *
		 * @param string $function The function that was called.
		 * @param string $message  A message explaining what has been done incorrectly.
		 * @param string $version  The version of Make where the message was added.
		 */
		do_action( 'make_doing_it_wrong_run', $function, $message, $version );

		$error_code = 'make_doing_it_wrong';

		// Add a version.
		$message .= ( ! is_null( $version ) ) ? ' ' . sprintf( __( '(This message was added in version %s.)', 'make' ), $version ) : '';

		// Add a backtrace.
		if ( is_array( $backtrace ) ) {
			$message .= '<br />&emsp;' . $this->error()->parse_backtrace( $backtrace );
		}

		// Add the error.
		$this->error()->add_error( $error_code, sprintf( __( '<strong>%1$s</strong> was called incorrectly. %2$s' ), $function, $message ) );
	}
}