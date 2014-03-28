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
	public function __construct() {
		$this->register_text_section();
		$this->register_banner_section();
		$this->register_gallery_section();
		$this->register_blank_section();

		// Add the section JS
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		// Add additional templating
		add_action( 'admin_footer', array( $this, 'print_templates' ) );
	}

	/**
	 * Register the text section.
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	public function register_text_section() {
		ttf_one_add_section(
			'text',
			_x( 'Text', 'section name', 'ttf-one' ),
			get_template_directory_uri() . '/inc/builder/sections/css/images/text.png',
			__( 'Organize multiple columns of content.', 'ttf-one' ),
			array( $this, 'save_text' ),
			'/inc/builder/sections/builder-templates/text',
			'/inc/builder/sections/front-end-templates/text',
			100
		);
	}

	/**
	 * Save the data for the text section.
	 *
	 * @since  1.0.0.
	 *
	 * @param  array    $data    The data from the $_POST array for the section.
	 * @return array             The cleaned data.
	 */
	public function save_text( $data ) {
		return $data;
	}

	/**
	 * Register the banner section.
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	public function register_banner_section() {
		ttf_one_add_section(
			'banner',
			_x( 'Banner', 'section name', 'ttf-one' ),
			get_template_directory_uri() . '/inc/builder/sections/css/images/banner.png',
			__( 'Display multiple types of content in a slider.', 'ttf-one' ),
			array( $this, 'save_banner' ),
			'/inc/builder/sections/builder-templates/banner',
			'/inc/builder/sections/front-end-templates/banner',
			200
		);
	}

	/**
	 * Save the data for the banner section.
	 *
	 * @since  1.0.0.
	 *
	 * @param  array    $data    The data from the $_POST array for the section.
	 * @return array             The cleaned data.
	 */
	public function save_banner( $data ) {
		return $data;
	}

	/**
	 * Register the gallery section.
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	public function register_gallery_section() {
		ttf_one_add_section(
			'gallery',
			_x( 'Gallery', 'section name', 'ttf-one' ),
			get_template_directory_uri() . '/inc/builder/sections/css/images/gallery.png',
			__( 'Display media elements using a modern slider.', 'ttf-one' ),
			array( $this, 'save_gallery' ),
			'/inc/builder/sections/builder-templates/gallery',
			'/inc/builder/sections/front-end-templates/gallery',
			300
		);
	}

	/**
	 * Save the data for the gallery section.
	 *
	 * @since  1.0.0.
	 *
	 * @param  array    $data    The data from the $_POST array for the section.
	 * @return array             The cleaned data.
	 */
	public function save_gallery( $data ) {
		return $data;
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
			'blank',
			_x( 'Blank', 'section name', 'ttf-one' ),
			get_template_directory_uri() . '/inc/builder/sections/css/images/blank.png',
			__( 'A blank canvas for standard content or HTML code.', 'ttf-one' ),
			array( $this, 'save_blank' ),
			'/inc/builder/sections/builder-templates/blank',
			'/inc/builder/sections/front-end-templates/blank',
			400
		);
	}

	/**
	 * Save the data for the blank section.
	 *
	 * @since  1.0.0.
	 *
	 * @param  array    $data    The data from the $_POST array for the section.
	 * @return array             The cleaned data.
	 */
	public function save_blank( $data ) {
		$clean_data = array();

		if ( isset( $data['title'] ) ) {
			$clean_data['title'] = sanitize_text_field( $data['title'] );
		}

		if ( isset( $data['content'] ) ) {
			$clean_data['content'] = wp_filter_post_kses( $data['content'] );
		}

		return $clean_data;
	}

	/**
	 * Enqueue the JS and CSS for the admin.
	 *
	 * @since  1.0.0.
	 *
	 * @param  string    $hook_suffix    The suffix for the screen.
	 * @return void
	 */
	public function admin_enqueue_scripts( $hook_suffix ) {
		// Only load resources if they are needed on the current page
		if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) || 'page' !== get_post_type() ) {
			return;
		}

		wp_register_script(
			'ttf-one-sections/js/models/gallery-item.js',
			get_template_directory_uri() . '/inc/builder/sections/js/models/gallery-item.js',
			array(),
			TTF_ONE_VERSION,
			true
		);

		wp_register_script(
			'ttf-one-sections/js/views/gallery-item.js',
			get_template_directory_uri() . '/inc/builder/sections/js/views/gallery-item.js',
			array(),
			TTF_ONE_VERSION,
			true
		);

		wp_enqueue_script(
			'ttf-section-behaviors',
			get_template_directory_uri() . '/inc/builder/sections/js/section-behaviors.js',
			array(
				'ttf-one-builder',
				'ttf-one-sections/js/models/gallery-item.js',
				'ttf-one-sections/js/views/gallery-item.js',
			),
			TTF_ONE_VERSION,
			true
		);
	}

	/**
	 * Print out the JS section templates
	 *
	 * @since  1.0.
	 *
	 * @return void
	 */
	public function print_templates() {
		global $hook_suffix, $typenow, $ttf_one_is_js_template;
		$ttf_one_is_js_template = true;

		// Only show when adding/editing pages
		if ( 'page' !== $typenow || ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) )) {
			return;
		}

		// Print the templates : ?>
		<script type="text/html" id="tmpl-ttf-one-gallery-item">
			<?php
			ob_start();
			ttf_one_get_builder_base()->load_section( array( 'id' => 'gallery-item', 'builder_template' => '/inc/builder/sections/builder-templates/gallery-item' ), array() );
			$html = ob_get_clean();
			echo $html;
			?>
		</script>
		<?php
		unset( $GLOBALS['ttf_one_is_js_template'] );
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