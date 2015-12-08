<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Setup_Widgets
 *
 * @since x.x.x.
 */
final class MAKE_Setup_Widgets implements MAKE_Setup_WidgetsInterface, MAKE_Util_HookInterface {
	/**
	 * Inject dependencies.
	 *
	 * @since x.x.x.
	 *
	 */
	public function __construct(

	) {

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

		//
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );

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


	private function get_widget_defaults( $sidebar_id ) {
		$widget_defaults = array(
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		);

		/**
		 * Filter: Modify the wrapper markup settings for the widgets in a sidebar.
		 *
		 * @since x.x.x.
		 *
		 * @param array     $widget_defaults    The default widget markup for sidebars.
		 * @param string    $sidebar_id         The ID of the sidebar that the widget markup will apply to.
		 */
		return apply_filters( 'make_widget_defaults', $widget_defaults, $sidebar_id );
	}


	public function register_sidebars() {
		// Only run this in the proper hook context.
		if ( 'widgets_init' !== current_action() ) {
			return;
		}

		//
		$sidebars = array(
			'sidebar-left'  => __( 'Left Sidebar', 'make' ),
			'sidebar-right' => __( 'Right Sidebar', 'make' ),
			'footer-1'      => __( 'Footer 1', 'make' ),
			'footer-2'      => __( 'Footer 2', 'make' ),
			'footer-3'      => __( 'Footer 3', 'make' ),
			'footer-4'      => __( 'Footer 4', 'make' ),
		);

		//
		foreach ( $sidebars as $sidebar_id => $sidebar_name ) {

			$args = array(
				'id' => $sidebar_id,
				'name' => $sidebar_name,
				'description' => $this->get_sidebar_description( $sidebar_id ),
			);

			register_sidebar( $args + $this->get_widget_defaults( $sidebar_id ) );
		}
	}


	private function get_sidebar_description( $sidebar_id ) {

	}


	private function get_enabled_views( $sidebar_id ) {

	}


	public function has_sidebar( $location ) {

	}
}