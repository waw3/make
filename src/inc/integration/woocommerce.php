<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Integration_WooCommerce
 *
 * @since x.x.x.
 */
class MAKE_Integration_WooCommerce extends MAKE_Util_Modules implements MAKE_Util_HookInterface {
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
	 * @param MAKE_Util_ModulesInterface $api
	 */
	public function __construct(
		MAKE_Util_ModulesInterface $api
	) {
		// API
		$this->add_module( 'api', $api );

		// Widgets
		$this->add_module( 'widgets', $this->api()->inject_module( 'widgets' ) );

		// Integrations
		$this->add_module( 'integration', $this->api()->inject_module( 'integration' ) );
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

		// Set up integration
		add_action( 'after_setup_theme', array( $this, 'setup' ) );

		// Before main content
		add_action( 'woocommerce_before_main_content', array( $this, 'before_main_content' ) );

		// After main content
		add_action( 'woocommerce_after_main_content', array( $this, 'after_main_content' ) );

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
	 * Add theme support and remove default action hooks so we can replace them with our own.
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	function setup() {
		// Only run this in the proper hook context.
		if ( 'after_setup_theme' !== current_action() ) {
			return;
		}

		// Theme support
		add_theme_support( 'woocommerce' );

		// Content wrapper
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

		// Sidebar
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );

		// Replace the WooCommerce breadcrumbs with Yoast SEO breadcrumbs, if available.
		if ( $this->integration()->has_integration( 'yoastseo' ) ) {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
			add_action( 'woocommerce_before_main_content', 'make_breadcrumb', 20 );
		}
	}

	/**
	 * Markup to show before the main WooCommerce content.
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	function before_main_content() {
		// Only run this in the proper hook context.
		if ( 'woocommerce_before_main_content' !== current_action() ) {
			return;
		}

		// Left sidebar
		ttfmake_maybe_show_sidebar( 'left' );

		// Begin content wrapper
		?>
		<main id="site-main" class="site-main" role="main">
		<?php
	}

	/**
	 * Markup to show after the main WooCommerce content
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	function after_main_content() {
		// Only run this in the proper hook context.
		if ( 'woocommerce_after_main_content' !== current_action() ) {
			return;
		}

		// End content wrapper
		?>
		</main>
		<?php
		// Right sidebar
		ttfmake_maybe_show_sidebar( 'right' );
	}
}