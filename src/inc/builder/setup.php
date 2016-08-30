<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Builder_Setup
 *
 *
 *
 * @since 1.7.0.
 */
class MAKE_Builder_Setup extends MAKE_Util_Modules implements MAKE_Builder_SetupInterface, MAKE_Util_HookInterface, MAKE_Util_LoadInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'error'            => 'MAKE_Error_CollectorInterface',
		'sanitize'         => 'MAKE_Settings_SanitizeInterface',
		'scripts'          => 'MAKE_Setup_ScriptsInterface',
		'builder_settings' => 'MAKE_Builder_SettingsInterface',
	);

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private static $hooked = false;

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private $loaded = false;

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @var array
	 */
	private $section_types = array();

	/**
	 * MAKE_Builder_Setup constructor.
	 *
	 * @since 1.8.0.
	 *
	 * @param MAKE_APIInterface $api
	 * @param array             $modules
	 */
	public function __construct( MAKE_APIInterface $api, array $modules = array() ) {
		// Module defaults.
		$modules = wp_parse_args( $modules, array(
			'builder_settings' => 'MAKE_Builder_Settings',
		) );

		// Load dependencies
		parent::__construct( $api, $modules );

		// UI module
		if ( is_admin() ) {
			$this->add_module(
				'ui',
				new MAKE_Builder_UI_Setup( $api, array( 'builder' => $this ) )
			);
		}

		// Front end module
		else {
			$this->add_module(
				'frontend',
				new MAKE_Builder_FrontEnd_Setup( $api, array( 'builder' => $this ) )
			);
		}
	}

	/**
	 * Hook into WordPress.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}



		// Choice sets
		add_action( 'make_choices_loaded', array( $this, 'add_choice_sets' ) );

		// Add filter to adjust sanitize callback parameters.
		add_filter( 'make_settings_buildersection_sanitize_callback_parameters', array( $this, 'add_sanitize_choice_parameters' ), 10, 4 );
		add_filter( 'make_settings_buildersection_sanitize_callback_parameters', array( $this, 'wrap_array_values' ), 10, 2 );

		// Hooking has occurred.
		self::$hooked = true;
	}

	/**
	 * Check if the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function is_hooked() {
		return self::$hooked;
	}

	/**
	 * Load data files.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function load() {
		if ( true === $this->is_loaded() ) {
			return;
		}

		// Load the Builder definitions
		$slugs = array(
			'post-types',
			'sections',
		);
		foreach ( $slugs as $slug ) {
			$file = dirname( __FILE__ ) . "/definitions/$slug.php";
			if ( is_readable( $file ) ) {
				include $file;
			}
		}

		// Loading has occurred.
		$this->loaded = true;

		/**
		 *
		 */
		do_action( 'make_builder_loaded', $this );
	}

	/**
	 * Check if the load routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function is_loaded() {
		return $this->loaded;
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @return array
	 */
	private function get_default_builder_args() {
		return array(
			'actions' => array(
				'add_remove' => true,
				'reorder'    => true,
				'collapse'   => true,
			),
		);
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param string $post_type
	 * @param array  $args
	 *
	 * @return void
	 */
	public function register_builder( $post_type, array $args = array() ) {
		//
		$args = wp_parse_args( $args, $this->get_default_builder_args() );

		//
		add_post_type_support( $post_type, 'make-builder', $args );
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param string $section_type
	 *
	 * @return array
	 */
	private function get_default_section_type_args( $section_type ) {
		return array(
			'label'             => ucwords( preg_replace( '/[\-_]+/', ' ', $section_type ) ),
			'description'       => '',
			'icon_url'          => '',
			'priority'          => 10,
			'collapsible'       => true,
			'parent'            => false,
			'items'             => false,
			'settings'          => array(),
			'ui'                => array(),
			'frontend_callback' => null,
		);
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param string $section_type
	 *
	 * @return bool
	 */
	public function section_type_exists( $section_type ) {
		return isset( $this->section_types[ $section_type ] );
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param string $section_type
	 * @param array  $args
	 * @param bool   $overwrite
	 *
	 * @return bool
	 */
	public function register_section_type( $section_type, $args, $overwrite = false ) {
		//
		if ( $this->section_type_exists( $section_type ) && true !== $overwrite ) {
			$this->error()->add_error(
				'make_builder_section_type_exists',
				sprintf(
					esc_html__( 'The &ldquo;%s&rdquo; section cannot be registered because it already exists.', 'make' ),
					esc_html( $section_type )
				)
			);

			return false;
		}

		//
		$args = wp_parse_args( $args, $this->get_default_section_type_args( $section_type ) );

		//
		$args['type'] = $section_type;
		
		//
		if ( isset( $args['model'] ) ) {
			$class = $args['model'];

			// Attempt to autoload the class
			$reflection = new ReflectionClass( $class );

			// If the class successfully loaded, create an instance in a PHP 5.2 compatible way.
			if ( class_exists( $class ) ) {
				unset( $args['model'] );

				// Dynamically generate a new class instance
				$this->section_types[ $section_type ] = $reflection->newInstanceArgs( array( $args ) );
			} else {
				$this->error()->add_error(
					'make_builder_invalid_section_model',
					sprintf(
						esc_html__( 'The &ldquo;%s&rdquo; section model is invalid.', 'make' ),
						esc_html( $section_type )
					)
				);

				return false;
			}
		} else {
			$this->section_types[ $section_type ] = new MAKE_Builder_Model_SectionType( $args );
		}

		return true;
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param string $section_type
	 *
	 * @return bool
	 */
	public function unregister_section_type( $section_type ) {
		if ( $this->section_type_exists( $section_type ) ) {
			unset( $this->section_types[ $section_type ] );

			return true;
		}

		return false;
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param string $section_type
	 *
	 * @return object|null
	 */
	public function get_section_type( $section_type ) {
		// Exists
		if ( $this->section_type_exists( $section_type ) ) {
			return $this->section_types[ $section_type ];
		}

		// Doesn't exist
		$this->error()->add_error(
			'make_builder_invalid_section_type',
			sprintf(
				esc_html__( 'The %s section type doesn\'t exist.', 'make' ),
				'<code>' . esc_html( $section_type ) . '</code>'
			)
		);

		return null;
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @return array
	 */
	public function get_all_section_types() {
		$all_section_types = $this->section_types;
		uasort( $all_section_types, array( $this, 'callback_sort_section_types' ) );

		return $all_section_types;
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @return array
	 */
	public function get_top_level_section_types() {
		$top_level_section_types = array_filter( $this->section_types, array( $this, 'callback_filter_top_level_section_types' ) );
		uasort( $top_level_section_types, array( $this, 'callback_sort_section_types' ) );

		return $top_level_section_types;
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param string $parent_section_type    The parent section type.
	 *
	 * @return array
	 */
	public function get_child_section_types( $parent_section_type ) {
		$parent = $this->get_section_type( $parent_section_type );
		$child_section_types = array();

		if ( ! is_null( $parent ) && false === $parent->parent && false !== $parent->items ) {
			foreach ( $this->section_types as $type => $object ) {
				if ( $parent_section_type === $object->parent ) {
					$child_section_types[ $type ] = $object;
				}
			}

			uasort( $child_section_types, array( $this, 'callback_sort_section_types' ) );
		}

		return $child_section_types;
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param MAKE_Builder_Model_SectionTypeInterface $a
	 * @param MAKE_Builder_Model_SectionTypeInterface $b
	 *
	 * @return int
	 */
	private function callback_sort_section_types( MAKE_Builder_Model_SectionTypeInterface $a, MAKE_Builder_Model_SectionTypeInterface $b ) {
		if ( $a->priority == $b->priority ) {
			return 0;
		}

		return ( $a->priority < $b->priority ) ? -1 : 1;
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param MAKE_Builder_Model_SectionTypeInterface $object
	 *
	 * @return bool
	 */
	private function callback_filter_top_level_section_types( MAKE_Builder_Model_SectionTypeInterface $object ) {
		return false === $object->parent;
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @hooked action make_choices_loaded
	 *
	 * @param MAKE_Choices_ManagerInterface $choices
	 *
	 * @return mixed
	 */
	public function add_choice_sets( MAKE_Choices_ManagerInterface $choices ) {
		return $choices->add_choice_sets( array(
			'builder-section-background-style' => array(
				'tile'  => __( 'Tile', 'make' ),
				'cover' => __( 'Cover', 'make' ),
			),
			'builder-section-type' => wp_list_pluck( $this->section_types, 'label', 'type' ),
			'builder-section-state' => array(
				'open'   => __( 'Open', 'make' ),
				'closed' => __( 'Closed', 'make' ),
			),
			'builder-banner-alignment' => array(
				'none'  => __( 'None', 'make' ),
				'left'  => __( 'Left', 'make' ),
				'right' => __( 'Right', 'make' ),
			),
			'builder-banner-responsive' => array(
				'balanced' => __( 'Default', 'make' ),
				'aspect'   => __( 'Aspect', 'make' ),
			),
			'builder-banner-transition' => array(
				'scrollHorz' => __( 'Slide horizontal', 'make' ),
				'fade'       => __( 'Fade', 'make' ),
				'none'       => __( 'None', 'make' ),
			),
			'builder-gallery-aspect' => array(
				'square'    => __( 'Square', 'make' ),
				'landscape' => __( 'Landscape', 'make' ),
				'portrait'  => __( 'Portrait', 'make' ),
				'none'      => __( 'None', 'make' ),
			),
			'builder-gallery-captions' => array(
				'reveal'  => __( 'Reveal', 'make' ),
				'overlay' => __( 'Overlay', 'make' ),
				'none'    => __( 'None', 'make' ),
			),
		) );
	}

	/**
	 * Add items to the array of parameters to feed into the sanitize callback.
	 *
	 * @since 1.8.0.
	 *
	 * @hooked filter make_settings_buildersection_sanitize_callback_parameters
	 *
	 * @param mixed                       $value
	 * @param string                      $setting_id
	 * @param string                      $callback
	 * @param MAKE_Settings_BaseInterface $settings_instance
	 *
	 * @return array
	 */
	public function add_sanitize_choice_parameters( $value, $setting_id, $callback, MAKE_Settings_BaseInterface $settings_instance ) {
		if ( $settings_instance->setting_exists( $setting_id, 'choice_set_id' ) ) {
			$value = (array) $value;
			$value[] = $setting_id;
			$value[] = $settings_instance;
		}

		return $value;
	}

	/**
	 * Wrap setting values that are arrays in another array so that the data will remain intact
	 * when it passes through call_user_func_array().
	 *
	 * @since 1.8.0.
	 *
	 * @hooked filter make_settings_buildersection_sanitize_callback_parameters
	 *
	 * @param mixed                       $value
	 * @param string                      $setting_id
	 * @param string                      $callback
	 * @param MAKE_Settings_BaseInterface $settings_instance
	 *
	 * @return array
	 */
	public function wrap_array_values( $value, $setting_id, $callback, MAKE_Settings_BaseInterface $settings_instance ) {
		if ( $settings_instance->setting_exists( $setting_id, 'in_array' ) ) {
			$value = array( $value );
		}

		return $value;
	}
}