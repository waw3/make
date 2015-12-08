<?php
/**
 * @package Make
 */


final class MAKE_View_Manager extends MAKE_Util_Modules implements MAKE_View_ManagerInterface, MAKE_Util_LoadInterface {

	private $views = array();

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $loaded = false;

	/**
	 * Inject dependencies.
	 *
	 * @since x.x.x.
	 *
	 * @param MAKE_Error_CollectorInterface $error
	 */
	public function __construct(
		MAKE_Error_CollectorInterface $error
	) {
		// Errors
		$this->add_module( 'error', $error );
	}

	/**
	 * Load data files.
	 *
	 * @since x.x.x.
	 *
	 * @return void
	 */
	public function load() {
		if ( true === $this->is_loaded() ) {
			return;
		}



		/**
		 * Action: Fires at the end of the view object's load method.
		 *
		 * This action gives a developer the opportunity to add or modify views
		 * and run additional load routines.
		 *
		 * @since x.x.x.
		 *
		 * @param MAKE_View_Manager    $view    The view object that has just finished loading.
		 */
		do_action( 'make_view_loaded', $this );

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


	public function add_view( $view_id, array $args = array() ) {}


	public function remove_view() {}


	public function get_views() {}


	public function get_current_view() {}


	public function is_current_view() {}
}