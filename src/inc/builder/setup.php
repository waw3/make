<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Builder_Setup
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
		'error'    => 'MAKE_Error_CollectorInterface',
		'scripts'  => 'MAKE_Setup_ScriptsInterface',
		'ui'       => 'MAKE_Builder_UI_Setup',
		'frontend' => 'MAKE_Builder_FrontEnd_Setup',
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
	protected $loaded = false;


	private $section_types = array();


	public function __construct( MAKE_APIInterface $api, array $modules = array() ) {
		//
		if ( is_admin() ) {
			$modules = wp_parse_args( $modules, array(
				'ui' => 'MAKE_Builder_UI_Setup'
			) );

			unset( $this->dependencies['frontend'] );
		}

		//
		else {
			$modules = wp_parse_args( $modules, array(
				'frontend' => 'MAKE_Builder_FrontEnd_Setup'
			) );

			unset( $this->dependencies['ui'] );
		}

		//
		parent::__construct( $api, $modules );
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
		$file = dirname( __FILE__ ) . '/definitions/sections.php';
		if ( is_readable( $file ) ) {
			include $file;
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


	private function get_default_builder_args() {
		return array(
			'actions' => array(
				'add_remove' => true,
				'reorder'    => true,
				'collapse'   => true,
			),
		);
	}
	
	
	public function register_builder( $post_type, array $args ) {
		//
		$args = wp_parse_args( $args, $this->get_default_builder_args() );

		//
		add_post_type_support( $post_type, 'make-builder', $args );
	}


	private function get_default_section_type_args( $section_type ) {
		return array(
			'label' => ucwords( preg_replace( '/[\-_]+/', ' ', $section_type ) ),
			'description' => '',
			'icon_url' => '',
			'priority' => 10,
		);
	}


	public function section_type_exists( $section_type ) {
		return isset( $this->section_types[ $section_type ] );
	}


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
			}
		} else {
			$this->section_types[ $section_type ] = new MAKE_Builder_Model_SectionType( $args );
		}

		return true;
	}


	public function unregister_section_type( $section_type ) {
		if ( $this->section_type_exists( $section_type ) ) {
			unset( $this->section_types[ $section_type ] );

			return true;
		}

		return false;
	}


	public function get_section_type( $section_type ) {
		if ( $this->section_type_exists( $section_type ) ) {
			return $this->section_types[ $section_type ];
		}

		return null;
	}


	public function get_sorted_section_types() {

	}



}