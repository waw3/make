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