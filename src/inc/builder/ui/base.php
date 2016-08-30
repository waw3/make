<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Builder_UI_Base
 *
 * Abstract class to handle render callbacks for the Builder UI. Each aspect of the UI (buttons, elements, controls)
 * should have a child class of this class.
 *
 * @since 1.8.0.
 */
abstract class MAKE_Builder_UI_Base {
	/**
	 * Container for registered callbacks
	 *
	 * @since 1.8.0.
	 *
	 * @var array
	 */
	protected $callbacks = array();

	/**
	 * Default args that will be parsed into the $args parameter when a render method is called.
	 *
	 * @since 1.8.0.
	 *
	 * @var array
	 */
	protected $default_args = array();

	/**
	 * Register a callback for rendering a particular UI item type.
	 *
	 * @since 1.8.0.
	 *
	 * @param string       $type
	 * @param string|array $callback
	 *
	 * @return $this
	 */
	public function register_render_callback( $type, $callback ) {
		if ( is_callable( $callback ) ) {
			$this->callbacks[ $type ] = $callback;
		}

		return $this;
	}

	/**
	 * Get the callback for a particular UI item type.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $type
	 *
	 * @return string|array|bool    False if there is no valid callback.
	 */
	public function get_render_callback( $type ) {
		// Registered callback
		if ( isset( $this->callbacks[ $type ] ) ) {
			return $this->callbacks[ $type ];
		}
		// Built in callback
		else if ( method_exists( $this, 'render_' . $type ) ) {
			return array( $this, 'render_' . $type );
		}
		// No callback :(
		else {
			return false;
		}
	}

	/**
	 * Check to see if a particular UI item type is renderable.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $type
	 *
	 * @return bool
	 */
	public function can_render( $type ) {
		return ( $this->get_render_callback( $type ) ) ? true : false;
	}

	/**
	 * Render a UI item type.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $type
	 * @param string $item_id
	 * @param array  $args
	 *
	 * @return string
	 */
	public function render( $type, $item_id, array $args = array() ) {
		if ( $this->can_render( $type ) ) {
			// Get the callback
			$callback = $this->get_render_callback( $type );

			call_user_func_array( $callback, array( $item_id, $args ) );
		}

		return '';
	}
}