<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Integration_Manager
 *
 * @since x.x.x.
 */
final class MAKE_Integration_Manager extends MAKE_Util_Modules implements MAKE_Integration_ManagerInterface {
	/**
	 * Inject dependencies.
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
		parent::__construct( $api, $modules );

		// Jetpack
		if ( $this->is_plugin_active( 'jetpack/jetpack.php' ) ) {
			$this->add_integration( 'jetpack', new MAKE_Integration_Jetpack( $api ) );
		}

		// WooCommerce
		if ( $this->is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			$this->add_integration( 'woocommerce', new MAKE_Integration_WooCommerce( $api ) );
		}

		// Yoast SEO
		if ( $this->is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) {
			$this->add_integration( 'yoastseo', new MAKE_Integration_YoastSEO( $api ) );
		}
	}

	/**
	 * Public version of the function to add a module.
	 *
	 * @since x.x.x.
	 *
	 * @param  string    $module_name
	 * @param  object    $module
	 *
	 * @return bool
	 */
	public function add_integration( $module_name, $module ) {
		/**
		 * Filter: Switch to turn off an integration.
		 *
		 * @since x.x.x.
		 *
		 * @param bool    $add_integration    True to allow the integration to be added.
		 */
		$add_integration = apply_filters( 'make_add_integration_' . $module_name, true );

		if ( true === $add_integration ) {
			return parent::add_module( $module_name, $module );
		}

		return false;
	}

	/**
	 * Wrapper function for returning the specified integration module and running its load routine.
	 *
	 * @since x.x.x.
	 *
	 * @param $module_name
	 *
	 * @return mixed
	 */
	public function get_integration( $module_name ) {
		return parent::get_module( $module_name );
	}

	/**
	 * Wrapper function for checking if an integration module exists.
	 *
	 * @since x.x.x.
	 *
	 * @param $module_name
	 *
	 * @return bool
	 */
	public function has_integration( $module_name ) {
		return parent::has_module( $module_name );
	}

	/**
	 * Determine if a plugin is active from it's file path relative to the plugins directory.
	 *
	 * @since x.x.x.
	 *
	 * @link http://queryloop.com/how-to-detect-if-a-wordpress-plugin-is-active/
	 *
	 * @param  string    $plugin_relative_path
	 *
	 * @return bool
	 */
	public function is_plugin_active( $plugin_relative_path ) {
		$network_active = false;

		if ( is_multisite() ) {
			$plugins = get_site_option( 'active_sitewide_plugins' );
			if ( isset( $plugins[ $plugin_relative_path ] ) ) {
				$network_active = true;
			}
		}

		return in_array( $plugin_relative_path, (array) get_option( 'active_plugins' ) ) || $network_active;
	}
}