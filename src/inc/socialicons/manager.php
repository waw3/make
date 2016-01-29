<?php
/**
 * @package Make
 */

/**
 * Class MAKE_SocialIcons_Manager
 *
 * @since x.x.x.
 */
class MAKE_SocialIcons_Manager extends MAKE_Util_Modules implements MAKE_SocialIcons_ManagerInterface, MAKE_Util_LoadInterface {
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
	 * The collection of URL patterns and their icon classes.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	private $icons = array();


	private $required_properties = array(
		'title',
		'class'
	);

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
		if ( $this->is_loaded() ) {
			return;
		}

		// Load the default icon patterns
		$file = dirname( __FILE__ ) . '/definitions/socialicons.php';
		if ( is_readable( $file ) ) {
			include $file;
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


	public function add_icons( $icons, $overwrite = false ) {
		$icons = (array) $icons;
		$existing_icons = $this->icons;
		$new_icons = array();
		$return = true;

		// Check each setting definition for required properties before adding it.
		foreach ( $icons as $pattern => $icon_props ) {
			// Overwrite an existing icon.
			if ( isset( $existing_icons[ $pattern ] ) && true === $overwrite ) {
				$new_icons[ $pattern ] = wp_parse_args( $icon_props, $existing_icons[ $pattern ] );
			}
			// Icon already exists, overwriting disabled.
			else if ( isset( $existing_icons[ $pattern ] ) && true !== $overwrite ) {
				$this->error()->add_error( 'make_socialicons_already_exists', sprintf( __( 'The social icon URL pattern "%s" can\'t be added because it already exists.', 'make' ), esc_html( $pattern ) ) );
				$return = false;
			}
			// Icon does not have required properties.
			else if ( ! $this->has_required_properties( $icon_props ) ) {
				$this->error()->add_error( 'make_socialicons_missing_required_properties', sprintf( __( 'The social icon URL pattern "%s" setting can\'t be added because it is missing required properties.', 'make' ), esc_html( $pattern ) ) );
				$return = false;
			}
			// Add a new icon.
			else {
				$new_icons[ $pattern ] = $icon_props;
			}
		}

		// Add the valid new settings to the existing settings array.
		if ( ! empty( $new_icons ) ) {
			$this->icons = array_merge( $existing_icons, $new_icons );
		}

		return $return;
	}


	private function has_required_properties( $properties ) {
		$properties = (array) $properties;
		$required_properties = $this->required_properties;
		$existing_properties = array_keys( $properties );

		// If there aren't any required properties, return true.
		if ( empty( $required_properties ) ) {
			return true;
		}

		// This variable will contain any array keys that aren't found in $existing_properties.
		$diff = array_diff_key( $required_properties, $existing_properties );

		return empty( $diff );
	}


	public function remove_icons( $icons ) {
		if ( 'all' === $icons ) {
			// Clear the entire settings array.
			$this->icons = array();
			return true;
		}

		$return = true;

		foreach ( (array) $icons as $pattern ) {
			if ( isset( $this->icons[ $pattern ] ) ) {
				unset( $this->icons[ $pattern ] );
			} else {
				$this->error()->add_error( 'make_socialicons_cannot_remove', sprintf( __( 'The social icon URL pattern "%s" can\'t be removed because it doesn\'t exist.', 'make' ), esc_html( $pattern ) ) );
				$return = false;
			}
		}

		return $return;
	}


	private function get_icons() {
		if ( false === $this->is_loaded() ) {
			$this->load();
		}

		return $this->icons;
	}


	public function find_match( $url ) {
		$icons = $this->get_icons();

		foreach ( $icons as $pattern => $props ) {
			if ( false !== stripos( $url, $pattern ) ) {
				return array_map( 'sanitize_key', (array) $props['class'] );
			}
		}

		return array();
	}


	public function render_icons( $icon_data ) {}
}