<?php
/**
 * @package Make
 */


final class MAKE_Customizer_Sections implements MAKE_Customizer_SectionsInterface, MAKE_Util_HookInterface, MAKE_Util_LoadInterface {
	/**
	 * Holds the instance of the error handling class.
	 *
	 * @since x.x.x.
	 *
	 * @var MAKE_Error_ErrorInterface|null
	 */
	private $error = null;

	/**
	 * Holds the instance of the compatibility class.
	 *
	 * @since x.x.x.
	 *
	 * @var MAKE_Error_ErrorInterface|null
	 */
	private $compatibility = null;

	/**
	 * Holds the instance of the theme mod class.
	 *
	 * @since x.x.x.
	 *
	 * @var MAKE_Settings_ThemeModInterface|null
	 */
	private $thememod = null;

	/**
	 * Array to hold the Panel definitions.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	private $panel_definitions = array();

	/**
	 * Array to hold the Section definitions.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	private $section_definitions = array();


	private $prefix = 'make_';

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


	public function __construct(
		MAKE_Error_ErrorInterface $error,
		MAKE_Compatibility_CompatibilityInterface $compatibility,
		MAKE_Settings_ThemeModInterface $thememod
	) {
		// Errors
		$this->error = $error;

		// Compatibility
		$this->compatibility = $compatibility;

		// Theme mods
		$this->thememod = $thememod;

		// Populate Panel definitions.
		$this->panel_definitions = array(
			'general'           => array(
				'title'    => __( 'General', 'make' ),
				'priority' => 100
			),
			'typography'        => array(
				'title'    => __( 'Typography', 'make' ),
				'priority' => 200
			),
			'color-scheme'      => array(
				'title'    => __( 'Color', 'make' ),
				'priority' => 300
			),
			'background-images' => array(
				'title'    => __( 'Background Images', 'make' ),
				'priority' => 400
			),
			'content-layout'    => array(
				'title'    => __( 'Layout', 'make' ),
				'priority' => 500
			),
		);
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

		// Add panels
		add_action( 'customize_register', array( $this, 'add_panels' ) );

		// Add sections
		add_action( 'customize_register', array( $this, 'add_sections' ) );

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

		$section_file_bases = array(
			'background-images'
		);

		foreach ( $section_file_bases as $name ) {
			$file = dirname( __FILE__ ) . '/sections/' . $name . '.php';
			if ( is_readable( $file ) ) {
				include_once $file;
			}
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


	public function get_panel_definitions() {
		/**
		 * Filter: Modify the array of panel definitions for the Customizer.
		 *
		 * @since 1.3.0.
		 *
		 * @param array    $panels    The array of panel definitions.
		 */
		return apply_filters( 'make_customizer_panels', $this->panel_definitions );
	}


	public function add_panels( WP_Customize_Manager $wp_customize ) {
		// Only run this in the proper hook context.
		if ( 'customize_register' !== current_action() ) {
			return;
		}

		$priority = new MAKE_Util_Priority( 1000, 100 );

		// Add panels.
		foreach ( $this->get_panel_definitions() as $panel => $data ) {
			// Determine priority.
			if ( ! isset( $data['priority'] ) || ! is_int( $data['priority'] ) ) {
				$data['priority'] = $priority->add();
			}

			// Add panel.
			$wp_customize->add_panel( $this->prefix . $panel, $data );
		}

		// Get the last priority
		$last_priority = $this->get_last_priority( $wp_customize->panels() );
		$priority->set( $last_priority + 100 );

		// Re-prioritize and rename the Widgets panel
		if ( ! isset( $wp_customize->get_panel( 'widgets' )->priority ) ) {
			// This function may fire before core has added the Widgets panel, in which case we add it.
			$wp_customize->add_panel( 'widgets' );
		}
		$wp_customize->get_panel( 'widgets' )->priority = $priority->add();
		$wp_customize->get_panel( 'widgets' )->title = __( 'Sidebars & Widgets', 'make' );
	}


	public function add_section_definitions( $section_id, array $data, $overwrite = false ) {
		$section_id = sanitize_key( $section_id );

		// Section already exists, overwriting disabled.
		if ( isset( $this->section_definitions[ $section_id ] ) && ! empty( $this->section_definitions[ $section_id ] ) && true !== $overwrite ) {
			$this->error->add_error( 'make_section_already_exists', sprintf( __( 'The "%s" section can\'t be added because it already exists.', 'make' ), $section_id ) );
			return false;
		}
		// Add/overwrite a section
		else {
			$this->section_definitions[ $section_id ] = $data;
		}

		return true;
	}


	public function get_section_definitions() {
		/**
		 * Filter: Modify the array of section definitions for the Customizer.
		 *
		 * @since 1.3.0.
		 *
		 * @param array    $sections    The array of section definitions.
		 */
		return apply_filters( 'make_customizer_sections', $this->section_definitions );
	}


	public function add_sections( WP_Customize_Manager $wp_customize ) {
		// Only run this in the proper hook context.
		if ( 'customize_register' !== current_action() ) {
			return;
		}

		if ( ! $this->is_loaded() ) {
			$this->load();
		}

		// Bucket so each panel can have its own priority class.
		$priority = array();

		// Section definitions.
		foreach ( $this->get_section_definitions() as $section => $data ) {
			// Get the ID of the current section's panel
			$panel = ( isset( $data['panel'] ) ) ? $data['panel'] : 'none';

			// Store the control definitions for later
			if ( isset( $data['controls'] ) ) {
				$controls = $data['controls'];
				unset( $data['controls'] );
			}

			// Determine the priority
			if ( ! isset( $data['priority'] ) ) {
				$panel_priority = $this->get_last_priority( $wp_customize->panels() ) + 100;
				if ( 'none' !== $panel && isset( $wp_customize->get_panel( $panel )->priority ) ) {
					$panel_priority = $wp_customize->get_panel( $panel )->priority;
				}

				// Create a separate priority counter for each panel, and one for sections without a panel
				if ( ! isset( $priority[ $panel ] ) ) {
					$priority[ $panel ] = new MAKE_Util_Priority( $panel_priority, 10 );
				}

				$data['priority'] = $priority[ $panel ]->add();
			}

			// Add the section.
			$wp_customize->add_section( $this->prefix . $section, $data );

			// Add controls to the section
			if ( isset( $controls ) ) {
				$this->add_section_controls( $wp_customize, $this->prefix . $section, $controls );
				unset( $controls );
			}
		}
	}


	private function add_section_controls( WP_Customize_Manager $wp_customize, $section, array $args, $initial_priority = 10 ) {
		$priority = new MAKE_Util_Priority( $initial_priority, 5 );

		foreach ( $args as $setting_id => $definition ) {
			// Skip this definition if the setting doesn't exist in theme mods.
			if ( ! $this->thememod->setting_exists( $setting_id ) ) {
				continue;
			}

			// Add setting
			if ( isset( $definition['setting'] ) ) {
				$defaults = array(
					'type'                 => 'theme_mod',
					'capability'           => 'edit_theme_options',
					'theme_supports'       => '',
					'default'              => $this->thememod->get_default( $setting_id ),
					'transport'            => 'refresh',
					'sanitize_callback'    => $this->thememod->get_sanitize_callback( $setting_id, 'from_customizer' ),
					'sanitize_js_callback' => ( $this->thememod->has_sanitize_callback( $setting_id, 'to_customizer' ) ) ? $this->thememod->get_sanitize_callback( $setting_id, 'to_customizer' ) : '',
				);
				$setting = wp_parse_args( $definition['setting'], $defaults );

				// Add the setting arguments inline so Theme Check can verify the presence of sanitize_callback
				$wp_customize->add_setting( $setting_id, array(
					'type'                 => $setting['type'],
					'capability'           => $setting['capability'],
					'theme_supports'       => $setting['theme_supports'],
					'default'              => $setting['default'],
					'transport'            => $setting['transport'],
					'sanitize_callback'    => $setting['sanitize_callback'],
					'sanitize_js_callback' => $setting['sanitize_js_callback'],
				) );
			}

			// Add control
			if ( isset( $definition['control'] ) ) {
				$control_id = $this->prefix . $setting_id;

				$defaults = array(
					'settings' => $setting_id,
					'section'  => $section,
					'priority' => $priority->add(),
				);

				// If this control is not linked to a specific setting, remove settings from defaults.
				if ( ! isset( $definition['setting'] ) ) {
					unset( $defaults['settings'] );
				}

				$control = wp_parse_args( $definition['control'], $defaults );

				// Check for a specialized control class
				if ( isset( $control['control_type'] ) ) {
					$class = $control['control_type'];

					// Attempt to autoload the class
					$reflection = new ReflectionClass( $class );

					// If the class successfully loaded, create an instance in a PHP 5.2 compatible way.
					if ( class_exists( $class ) ) {
						unset( $control['control_type'] );

						// Dynamically generate a new class instance
						$class_instance = $reflection->newInstanceArgs( array( $wp_customize, $control_id, $control ) );

						$wp_customize->add_control( $class_instance );
					}
				} else {
					$wp_customize->add_control( $control_id, $control );
				}
			}
		}

		// Return the final priority.
		return $priority->get();
	}

	/**
	 * Get the highest (last) priority from a collection of Customizer objects.
	 *
	 * Works with Panels, Sections, and Controls.
	 *
	 * @since x.x.x.
	 *
	 * @param $items
	 *
	 * @return int
	 */
	public function get_last_priority( $items ) {
		// Get the IDs.
		$ids = wp_list_pluck( $items, 'id' );

		// Get the priorities.
		$priorities = wp_list_pluck( $items, 'priority' );

		// Combine.
		$parsed_items = array_combine( $ids, $priorities );

		// Sort.
		sort( $parsed_items );

		// Return highest (last) priority value.
		return absint( array_pop( $parsed_items ) );
	}
}