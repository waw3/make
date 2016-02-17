<?php
/**
 * @package Make
 */


final class MAKE_Layout_View extends MAKE_Util_Modules implements MAKE_Layout_ViewInterface, MAKE_Util_LoadInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'error'         => 'MAKE_Error_CollectorInterface',
		'compatibility' => 'MAKE_Compatibility_MethodsInterface',
	);

	/**
	 * @var array
	 */
	private $views = array();


	private $default_view = 'post';

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $loaded = false;

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

		$views = array(
			'blog' => array(
				'label'    => __( 'Blog (Post Page)', 'make' ),
				'callback' => 'is_home',
			),
			'archive' => array(
				'label'    => __( 'Archives', 'make' ),
				'callback' => 'is_archive',
			),
			'search' => array(
				'label'    => __( 'Search Results', 'make' ),
				'callback' => 'is_search',
			),
			'page' => array(
				'label'    => __( 'Pages', 'make' ),
				'callback' => array( $this, 'callback_page' ),
			),
			'post' => array(
				'label'    => __( 'Posts', 'make' ),
				'callback' => array( $this, 'callback_post' ),
			),
		);

		foreach ( $views as $view_id => $view_args ) {
			$this->add_view( $view_id, $view_args );
		}

		// Loading has occurred.
		$this->loaded = true;

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


	public function add_view( $view_id, array $args = array(), $overwrite = false ) {
		// Make sure we're not doing it wrong.
		if ( 'make_view_loaded' !== current_action() && did_action( 'make_view_loaded' ) ) {
			$backtrace = debug_backtrace();

			$this->compatibility()->doing_it_wrong(
				__FUNCTION__,
				__( 'This function should only be called during or before the <code>make_view_loaded</code> action.', 'make' ),
				'1.7.0',
				$backtrace[0]
			);

			return false;
		}

		$view_id = sanitize_key( $view_id );
		$return = true;

		$defaults = array(
			'label'    => ucwords( preg_replace( '/[\-_]*/', ' ', $view_id ) ),
			'callback' => '',
			'priority' => 10,
		);
		$args = wp_parse_args( $args, $defaults );

		// Invalid callback.
		if ( ! is_callable( $args[ 'callback' ] ) ) {
			$this->error()->add_message( 'make_view_callback_not_valid', sprintf( __( 'The view callback (%1$s) for "%2$s" is not valid.', 'make' ), esc_html( print_r( $args[ 'callback' ], true ) ), esc_html( $view_id ) ) );
			$return = false;
		}
		// Overwrite an existing view.
		else if ( isset( $this->views[ $view_id ] ) && true === $overwrite ) {
			$this->views[ $view_id ] = $args;
		}
		// View already exists, overwriting disabled.
		else if ( isset( $this->views[ $view_id ] ) && true !== $overwrite ) {
			$this->error()->add_message( 'make_view_already_exists', sprintf( __( 'The "%s" view can\'t be added because it already exists.', 'make' ), esc_html( $view_id ) ) );
			$return = false;
		}
		// Add a new view.
		else {
			$this->views[ $view_id ] = $args;
		}

		return $return;
	}


	public function remove_view( $view_id ) {
		if ( ! isset( $this->views[ $view_id ] ) ) {
			$this->error()->add_message( 'make_view_cannot_remove', sprintf( __( 'The "%s" view can\'t be removed because it doesn\'t exist.', 'make' ), esc_html( $view_id ) ) );
			return false;
		} else {
			unset( $this->views[ $view_id ] );
		}

		return true;
	}


	public function get_sorted_views() {
		if ( ! $this->is_loaded() ) {
			$this->load();
		}

		$prioritizer = array();

		foreach ( $this->views as $view_id => $view_args ) {
			$priority = ( isset( $view_args['priority'] ) ) ? absint( $view_args['priority'] ) : 10;

			if ( ! isset( $prioritizer[ $priority ] ) ) {
				$prioritizer[ $priority ] = array();
			}

			$prioritizer[ $priority ][ $view_id ] = $view_args;
		}

		ksort( $prioritizer );

		$sorted_views = array();

		foreach ( $prioritizer as $view_group ) {
			$sorted_views = array_merge( $sorted_views, $view_group );
		}

		return $sorted_views;
	}


	public function view_exists( $view_id ) {
		$views = $this->get_sorted_views();
		return isset( $views[ $view_id ] );
	}


	public function get_view_label( $view_id ) {
		$label = '';

		if ( $this->view_exists( $view_id ) ) {
			$views = $this->get_sorted_views();
			$label = ( isset( $views[ $view_id ]['label'] ) ) ? $views[ $view_id ]['label'] : '';
		}

		return $label;
	}


	public function get_current_view() {
		// Make sure we're not doing it wrong.
		if ( ! did_action( 'template_redirect' ) ) {
			$backtrace = debug_backtrace();

			$this->compatibility()->doing_it_wrong(
				__FUNCTION__,
				__( 'View cannot be accurately determined until after the <code>template_redirect</code> action has run.', 'make' ),
				'1.7.0',
				$backtrace[0]
			);

			return null;
		}

		$views = $this->get_sorted_views();
		$view = $this->default_view;

		foreach ( $views as $view_id => $view_args ) {
			if ( is_callable( $view_args['callback'] ) && true === call_user_func( $view_args['callback'] ) ) {
				$view = $view_id;
			}
		}

		// Check for deprecated filter.
		if ( has_filter( 'make_get_view' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_get_view',
				'1.7.0',
				__( 'To add or modify theme views, use the function make_add_view() instead.', 'make' )
			);

			/**
			 * Allow developers to dynamically change the view.
			 *
			 * @since 1.2.3.
			 * @deprecated 1.7.0.
			 *
			 * @param string    $view                The view name.
			 * @param string    $parent_post_type    The post type for the parent post of the current post.
			 */
			$view = apply_filters( 'make_get_view', $view, $this->get_parent_post_type( get_post() ) );
		}

		return $view;
	}


	public function is_current_view( $view_id ) {
		return $view_id === $this->get_current_view();
	}


	private function callback_post() {
		// Post types
		$post_types = get_post_types(
			array(
				'public' => true,
				'_builtin' => false
			)
		);
		$post_types[] = 'post';

		return is_singular( $post_types ) || ( is_attachment() && in_array( $this->get_parent_post_type( get_post() ), $post_types ) );
	}


	private function callback_page() {
		return is_page() || ( is_attachment() && 'page' === $this->get_parent_post_type( get_post() ) );
	}


	private function get_parent_post_type( WP_Post $post ) {
		return get_post_type( $post->post_parent );
	}
}