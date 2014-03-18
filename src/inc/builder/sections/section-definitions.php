<?php

if ( ! class_exists( 'TTF_One_Section_Definitions' ) ) :
/**
 * Collector for builder sections.
 *
 * @since 1.0.0.
 *
 * Class TTF_One_Section_Definitions
 */
class TTF_One_Section_Definitions {
	/**
	 * The one instance of TTF_One_Section_Definitions.
	 *
	 * @since 1.0.0.
	 *
	 * @var   TTF_One_Section_Definitions
	 */
	private static $instance;

	/**
	 * Instantiate or return the one TTF_One_Section_Definitions instance.
	 *
	 * @since  1.0.0.
	 *
	 * @return TTF_One_Section_Definitions
	 */
	public static function instance() {
		if ( is_null( self::$instance ) )
			self::$instance = new self();

		return self::$instance;
	}

	/**
	 * Register the sections.
	 *
	 * @since  1.0.0.
	 *
	 * @return TTF_One_Section_Definitions
	 */
	public function __constructor() {
		$this->register_blank_section();
	}

	/**
	 * Register the blank section.
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	public function register_blank_section() {
		ttf_one_add_section(
			'ttf-one-blank',
			_x( 'Blank', 'section name', 'ttf-one' ),
			get_template_directory_uri() . '/inc/builder/css/images/blank.png',
			__( 'A blank canvas for standard content or HTML code.', 'ttf-one' ),
			array( $this, 'save_blank' ),
			get_template_directory() . '/inc/builder/sections/builder-templates/blank.php',
			get_template_directory() . '/inc/builder/sections/front-end-templates/blank.php'
		);
	}

	/**
	 * Save the data for the blank section.
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	public function save_blank() {

	}
}
endif;

/**
 * Instantiate or return the one TTF_One_Section_Definitions instance.
 *
 * @since  1.0.0.
 *
 * @return TTF_One_Section_Definitions
 */
function ttf_one_get_section_definitions() {
	return TTF_One_Section_Definitions::instance();
}

add_action( 'admin_init', 'ttf_one_get_section_definitions' );