<?php
/**
 * @package Make
 */

/**
 * Class MAKE_SocialIcons_Manager
 *
 * @since x.x.x.
 */
class MAKE_SocialIcons_Manager extends MAKE_Util_Modules implements MAKE_SocialIcons_ManagerInterface, MAKE_Util_HookInterface, MAKE_Util_LoadInterface {
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
		'thememod'      => 'MAKE_Settings_ThemeModInterface',
	);

	/**
	 * The collection of URL patterns and their icon classes.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	private $icons = array();

	/**
	 * Required properties for icon definitions.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	private $required_properties = array(
		'title',
		'class'
	);

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $hooked = false;

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $loaded = false;

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

		// Add filter to convert deprecated social profile settings if necessary
		add_filter( 'theme_mod_social-icons', array( $this, 'filter_theme_mod' ), 1 );

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

	/**
	 * Add or update icon definitions.
	 *
	 * @since x.x.x.
	 *
	 * @param      $icons
	 * @param bool $overwrite
	 *
	 * @return bool
	 */
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

	/**
	 * Check an array of icon definition properties against another array of required ones.
	 *
	 * @since x.x.x.
	 *
	 * @param  array    $properties    The array of properties to check.
	 *
	 * @return bool                    True if all required properties are present.
	 */
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

	/**
	 * Remove icon definitions from the collection.
	 *
	 * @since x.x.x.
	 *
	 * @param $icons
	 *
	 * @return bool
	 */
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

	/**
	 * Return the property containing the array of icon definitions.
	 *
	 * @since x.x.x.
	 *
	 * @return array
	 */
	private function get_icons() {
		if ( false === $this->is_loaded() ) {
			$this->load();
		}

		return $this->icons;
	}

	/**
	 * Get the icon definition for an email address.
	 *
	 * @since x.x.x.
	 *
	 * @return mixed|void
	 */
	private function get_email_props() {
		/**
		 * Filter: Modify the icon definition for an email address.
		 *
		 * @since x.x.x.
		 *
		 * @param array    $icon    The icon definition.
		 */
		return apply_filters( 'make_socialicons_email', array(
			'title' => esc_html__( 'Email', 'make' ),
			'class' => array( 'fa', 'fa-fw', 'fa-envelope' ),
		) );
	}

	/**
	 * Get the icon definition for an RSS feed.
	 *
	 * @since x.x.x.
	 *
	 * @return mixed|void
	 */
	private function get_rss_props() {
		/**
		 * Filter: Modify the icon definition for an RSS feed.
		 *
		 * @since x.x.x.
		 *
		 * @param array    $icon    The icon definition.
		 */
		return apply_filters( 'make_socialicons_rss', array(
			'title' => esc_html__( 'RSS', 'make' ),
			'class' => array( 'fa', 'fa-fw', 'fa-rss' ),
		) );
	}

	/**
	 * Get the icon definition for a URL that doesn't match any icon URL pattern.
	 *
	 * @since x.x.x.
	 *
	 * @return mixed|void
	 */
	private function get_default_props() {
		/**
		 * Filter: Modify the icon definition for a URL that doesn't match any icon URL pattern.
		 *
		 * @since x.x.x.
		 *
		 * @param array    $icon    The icon definition.
		 */
		return apply_filters( 'make_socialicons_default', array(
			'title' => esc_html__( 'Link', 'make' ),
			'class' => array( 'fa', 'fa-fw', 'fa-external-link-square' ),
		) );
	}

	/**
	 * Compare a string to the icon URL patterns to find a match.
	 *
	 * @since x.x.x.
	 *
	 * @param $string
	 *
	 * @return array|mixed|void
	 */
	public function find_match( $string ) {
		// Special cases for email and rss
		if ( 'email' === $string ) {
			return $this->get_email_props();
		} else if ( 'rss' === $string ) {
			return $this->get_rss_props();
		}

		// If it's not a valid URL, return empty
		$string = esc_url( $string );
		if ( function_exists( 'filter_var' ) ) { // Some hosts don't enable this function
			if ( false === filter_var( $string, FILTER_VALIDATE_URL ) ) {
				return array();
			}
		}

		// Search for a pattern match
		$icons = $this->get_icons();
		foreach ( $icons as $pattern => $props ) {
			if ( false !== stripos( $string, $pattern ) ) {
				return $props;
			}
		}

		// If we've made it this far, return the default
		return $this->get_default_props();
	}

	/**
	 * Gather the data from deprecated social profile settings and convert it into the current icon data array.
	 *
	 * @since x.x.x.
	 *
	 * @return array
	 */
	private function get_icon_data_from_old_settings() {
		$old_settings = array(
			'social-facebook-official',
			'social-twitter',
			'social-google-plus-square',
			'social-linkedin',
			'social-instagram',
			'social-flickr',
			'social-youtube',
			'social-vimeo-square',
			'social-pinterest',
			'social-email',
			'social-hide-rss',
			'social-custom-rss',
		);

		$icon_data = array();

		// Populate from Customizer settings first
		foreach ( $old_settings as $setting_id ) {
			$value = get_theme_mod( $setting_id, null );

			if ( ! is_null( $value ) ) {
				switch ( $setting_id ) {
					default :
					case 'social-facebook-official' :
					case 'social-twitter' :
					case 'social-google-plus-square' :
					case 'social-linkedin' :
					case 'social-instagram' :
					case 'social-flickr' :
					case 'social-youtube' :
					case 'social-vimeo-square' :
					case 'social-pinterest' :
						if ( ! isset( $icon_data['items'] ) ) {
							$icon_data['items'] = array();
						}
						$icon_data['items'][] = $value;
						break;

					case 'social-email' :
						$icon_data['email-toggle'] = true;
						$icon_data['email-address'] = $value;
						break;

					case 'social-hide-rss' :
						$icon_data['rss-toggle'] = ! wp_validate_boolean( $value );
						break;

					case 'social-custom-rss' :
						$icon_data['rss-url'] = $value;
						break;
				}
			}
		}

		// Look for an overriding custom menu
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'social' ] ) ) {
			$menu = wp_get_nav_menu_object( $locations[ 'social' ] );
			if ( $menu && ! is_wp_error( $menu ) ) {
				$menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );

				// Set up the $menu_item variables
				_wp_menu_item_classes_by_context( $menu_items );

				// Sort the menu items
				$sorted_menu_items = array();
				foreach ( (array) $menu_items as $menu_item ) {
					$sorted_menu_items[ $menu_item->menu_order ] = $menu_item;
				}

				unset( $menu_items, $menu_item );

				// Reset the items array, since the menu overrides the Customizer fields.
				$icon_data['items'] = array();

				foreach ( $sorted_menu_items as $item ) {
					$content = $item->url;

					if ( 0 === strpos( $content, 'mailto:' ) ) {
						$icon_data['items'][] = 'email';
						$icon_data['email-toggle'] = true;
						$icon_data['email-address'] = str_replace( 'mailto:', '', $content );
					} else {
						$icon_data['items'][] = $item->url;
					}

					if ( isset( $item->target ) && $item->target ) {
						$icon_data['new-window'] = true;
					}
				}
			}
		}

		// Make sure the Email and RSS items are placed correctly.
		if ( isset( $icon_data['email-toggle'] ) && true === $icon_data['email-toggle'] ) {
			if ( ! isset( $icon_data['items'] ) ) {
				$icon_data['items'] = array();
			}

			if ( false === array_search( 'email', $icon_data['items'] ) ) {
				$icon_data['items'][] = 'email';
			}
		}
		if ( isset( $icon_data['rss-toggle'] ) && true === $icon_data['rss-toggle'] ) {
			if ( ! isset( $icon_data['items'] ) ) {
				$icon_data['items'] = array();
			}

			if ( false === array_search( 'rss', $icon_data['items'] ) ) {
				$icon_data['items'][] = 'rss';
			}
		}

		return $icon_data;
	}

	/**
	 * If the 'social-icons' setting doesn't exist yet, fall back on deprecated social profile settings.
	 *
	 * @since x.x.x.
	 *
	 * @param  array $value
	 *
	 * @return array
	 */
	public function filter_theme_mod( $value ) {
		// Only run this in the proper hook context.
		if ( "theme_mod_social-icons" !== current_filter() ) {
			return $value;
		}

		$all_mods = get_theme_mods();

		if ( ! isset( $all_mods['social-icons'] ) ) {
			$icon_data = $this->get_icon_data_from_old_settings();
			if ( ! empty( $icon_data ) ) {
				return $icon_data;
			}
		}

		return $value;
	}

	/**
	 * Render the social icons as an HTML unordered list.
	 *
	 * @since x.x.x.
	 *
	 * @return string
	 */
	public function render_icons() {
		$icon_data = $this->thememod()->get_value( 'social-icons', 'template' );
		$items = ( isset( $icon_data['items'] ) ) ? $icon_data['items'] : array();

		ob_start();

		foreach( $items as $content ) {
			$icon = $this->find_match( $content );
			if ( ! empty( $icon ) ) {
				$title = $icon['title'];
				$class = implode( ' ', $icon['class'] );
				if ( 'email' === $content ) {
					$content = 'mailto:' . $icon_data['email-address'];
				} else if ( 'rss' === $content ) {
					if ( $icon_data['rss-url'] ) {
						$content = $icon_data['rss-url'];
					} else {
						$content = get_feed_link();
					}
				}
				?>
				<li class="make-social-icon">
					<a href="<?php echo esc_attr( $content ); ?>"<?php if ( true === $icon_data['new-window'] ) : ?> target="_blank"<?php endif; ?>>
						<i class="<?php echo esc_attr( $class ); ?>"></i>
						<span class="screen-reader-text"><?php echo esc_attr( $title ); ?></span>
					</a>
				</li>
			<?php
			}
		}

		$output = ob_get_clean();

		// Add the list wrapper
		if ( $output ) {
			$output = "<ul class=\"social-customizer social-links\">\n" . $output . "</ul>\n";
		}

		return $output;
	}
}