<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Util_L10n
 *
 * Methods for loading text domains.
 *
 * @since 1.6.2.
 */
class MAKE_Util_L10n_Base implements MAKE_Util_L10n_L10nInterface {
	/**
	 * Parent theme text domain.
	 *
	 * @since 1.6.2.
	 *
	 * @var string
	 */
	protected $domain = '';

	/**
	 * Parent theme directory.
	 *
	 * @since 1.6.2.
	 *
	 * @var string
	 */
	protected $theme_dir = '';

	/**
	 * Child theme text domain.
	 *
	 * @since 1.6.2.
	 *
	 * @var string
	 */
	protected $child_domain = '';

	/**
	 * Child theme directory.
	 *
	 * @since 1.6.2.
	 *
	 * @var string
	 */
	protected $child_theme_dir = '';

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	protected $loaded = false;

	/**
	 * Populate the class properties.
	 *
	 * @since 1.6.2.
	 */
	public function __construct() {
		// Parent theme
		$theme_slug = get_template();
		$this->domain = $this->get_text_domain( $theme_slug );
		$this->theme_dir = $this->get_theme_dir( $theme_slug );

		// Child theme
		if ( is_child_theme() ) {
			$theme_slug = get_stylesheet();
			$this->child_domain = $this->get_text_domain( $theme_slug );
			$this->child_theme_dir = $this->get_theme_dir( $theme_slug );
		}
	}

	/**
	 * Load data into the object.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function load() {
		// Filter to increase flexibility of .mo file location.
		add_filter( 'load_textdomain_mofile', array( $this, 'mofile_path' ), 10, 2 );

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
	 * Determine the text domain for a given theme.
	 *
	 * @link https://github.com/justintadlock/hybrid-core/blob/7bc900fd5635c9fcdde3c3b240c4ec43a0704ccf/inc/functions-i18n.php#L144-L148
	 *
	 * @since 1.6.2.
	 *
	 * @param string    $theme_slug    The slug identifier for a theme.
	 *
	 * @return string                  The theme's text domain.
	 */
	protected function get_text_domain( $theme_slug ) {
		$theme  = wp_get_theme( $theme_slug );
		$domain = $theme->get( 'TextDomain' ) ? $theme->get( 'TextDomain' ) : $theme_slug;
		return sanitize_key( $domain );
	}

	/**
	 * Determine the root directory for a given theme.
	 *
	 * @since 1.6.2.
	 *
	 * @param string    $theme_slug    The slug identifier for a theme.
	 *
	 * @return string                  The theme's root directory.
	 */
	protected function get_theme_dir( $theme_slug ) {
		$theme = wp_get_theme( $theme_slug );
		return untrailingslashit( $theme->get_stylesheet_directory() );
	}

	/**
	 * Get the preferred path of a given .mo file.
	 *
	 * Filters the .mo file path so that child themes can include parent theme .mo files that won't
	 * be overwritten when the parent theme is updated.
	 *
	 * If the child theme is including a parent theme .mo file, or has separate .mo files for the parent text domain
	 * and the child text domain, the file names should be prefixed with the domain, e.g. make-en_US.mo
	 *
	 * @link https://github.com/justintadlock/hybrid-core/blob/7bc900fd5635c9fcdde3c3b240c4ec43a0704ccf/inc/functions-i18n.php#L218-L249
	 *
	 * @since 1.6.2.
	 *
	 * @param $mofile
	 * @param $domain
	 *
	 * @return string
	 */
	public function mofile_path( $mofile, $domain ) {
		// Only run this in the proper hook context.
		if ( 'load_textdomain_mofile' !== current_filter() ) {
			return $mofile;
		}

		if ( in_array( $domain, array( $this->domain, $this->child_domain ) ) ) {
			$locale = get_locale();

			// Get just the theme path and file name for the mofile
			$mofile_short = str_replace( array( $this->child_theme_dir, $this->theme_dir ), '', $mofile );
			$mofile_short = str_replace( "{$locale}.mo", "{$domain}-{$locale}.mo", $mofile_short );

			// Attempt to find the correct mofile.
			$locate_mofile = locate_template( array( $mofile_short ) );

			// Return the mofile.
			return $locate_mofile ? $locate_mofile : $mofile;
		}

		return $mofile;
	}

	/**
	 * Load translation strings for the parent and/or child theme.
	 *
	 * @since 1.6.2.
	 *
	 * @return bool    True if all relevant text domains successfully loaded a .mo file. Otherwise false.
	 */
	public function load_textdomains() {
		// Make sure the module is loaded.
		if ( false === $this->is_loaded() ) {
			$this->load();
		}

		// Array to collect results of load commands.
		$success = array();

		// Load the parent theme text domain.
		$success[] = load_theme_textdomain( $this->domain, $this->theme_dir . '/languages' );

		// Load the child theme text domain.
		if ( is_child_theme() ) {
			$success[] = load_theme_textdomain( $this->child_domain, $this->child_theme_dir . '/languages' );
		}

		// Return true if all relevant text domains successfully loaded a .mo file. Otherwise false.
		return count( array_keys( $success, false ) ) === 0;
	}
}