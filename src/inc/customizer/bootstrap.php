<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_customizer_init' ) ) :
/**
 * Load the customizer files and enqueue scripts
 *
 * @since 1.0
 */
function ttf_one_customizer_init() {
	$path = '/inc/customizer/';

	// Always load
	require_once( get_template_directory() . $path . 'helpers.php' );
	require_once( get_template_directory() . $path . 'helpers-css.php' );
	require_once( get_template_directory() . $path . 'helpers-defaults.php' );
	require_once( get_template_directory() . $path . 'helpers-display.php' );
	require_once( get_template_directory() . $path . 'helpers-fonts.php' );
	require_once( get_template_directory() . $path . 'helpers-logo.php' );

	// Hook up functions
	add_action( 'customize_register', 'ttf_one_customizer_add_sections' );
	add_action( 'customize_register', 'ttf_one_customizer_set_transport' );
	add_action( 'customize_preview_init', 'ttf_one_customizer_preview_script' );
	add_action( 'customize_preview_init', 'ttf_one_add_customizations' );
	add_action( 'customize_controls_enqueue_scripts', 'ttf_one_customizer_sections_script' );
	add_action( 'customize_controls_print_styles', 'ttf_one_customizer_admin_styles' );
}
endif;

add_action( 'after_setup_theme', 'ttf_one_customizer_init' );

if ( ! function_exists( 'ttf_one_customizer_add_sections' ) ) :
/**
 * Add sections and controls to the customizer.
 *
 * Hooked to 'customize_register' via ttf_one_customizer_init()
 *
 * @since 1.0
 *
 * @param object $wp_customize
 */
function ttf_one_customizer_add_sections( $wp_customize ) {
	$path         = '/inc/customizer/';
	$section_path = $path . 'sections/';

	// Get the custom controls
	require_once( get_template_directory() . $path . 'controls.php' );

	// Modifications for existing sections
	require_once( get_template_directory() . $section_path . 'background.php' );
	require_once( get_template_directory() . $section_path . 'navigation.php' );
	require_once( get_template_directory() . $section_path . 'site-title-tagline.php' );

	// List of new sections to add
	$sections = array(
		'general'        => __( 'General', 'ttf-one' ),
		'logo'           => __( 'Logo', 'ttf-one' ),
		'font'           => __( 'Fonts', 'ttf-one' ),
		'color'          => __( 'Colors', 'ttf-one' ),
		'layout-blog'    => __( 'Layout: Blog (Posts Page)', 'ttf-one' ),
		'layout-archive' => __( 'Layout: Archives', 'ttf-one' ),
		'layout-search'  => __( 'Layout: Search Results', 'ttf-one' ),
		'layout-post'    => __( 'Layout: Posts', 'ttf-one' ),
		'layout-page'    => __( 'Layout: Pages', 'ttf-one' ),
		'header'         => __( 'Header', 'ttf-one' ),
		'main'           => __( 'Main', 'ttf-one' ),
		'footer'         => __( 'Footer', 'ttf-one' ),
		'social'         => __( 'Social Profiles &amp; RSS', 'ttf-one' )
	);
	$sections = apply_filters( 'ttf_one_customizer_sections', $sections );

	// Priority for first section
	$priority = new TTF_One_Prioritizer( 200, 50 );

	// Add and populate each section, if it exists
	foreach ( $sections as $section => $title ) {
		// First load the file
		if ( '' !== locate_template( $section_path . $section . '.php', true ) ) {
			// Custom priorities for some built-in sections
			if ( 'fonts' === $section ) {
				$wp_customize->get_section( 'background_image' )->priority = $priority->add();
			}

			// Then add the section
			$section_callback = 'ttf_one_customizer_';
			$section_callback .= ( strpos( $section, '-' ) ) ? str_replace( '-', '_', $section ) : $section;
			if ( function_exists( $section_callback ) ) {
				$section_id = 'ttf-one_' . esc_attr( $section );
				if ( ! $title ) {
					$title = ucfirst( esc_attr( $section ) );
				}

				// Add section
				$wp_customize->add_section(
					$section_id,
					array(
						'title'    => $title,
						'priority' => $priority->add(),
					)
				);

				// Callback to populate the section
				call_user_func_array(
					$section_callback,
					array(
						$wp_customize,
						$section_id
					)
				);
			}
		}
	}
}
endif;

if ( ! function_exists( 'ttf_one_customizer_set_transport' ) ) :
/**
 * Add postMessage support for certain built-in settings in the Theme Customizer.
 *
 * Allows these settings to update asynchronously in the Preview pane.
 *
 * @since 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ttf_one_customizer_set_transport( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
endif;

if ( ! function_exists( 'ttf_one_customizer_preview_script' ) ) :
/**
 * Enqueue customizer preview script
 *
 * Hooked to 'customize_preview_init' via ttf_one_customizer_init()
 *
 * @since 1.0
 */
function ttf_one_customizer_preview_script() {
	$path = '/inc/customizer/js/';

	wp_enqueue_script(
		'ttf-one-customizer-preview',
		get_template_directory_uri() . $path . 'customizer-preview' . TTF_ONE_SUFFIX . '.js',
		array( 'customize-preview' ),
		TTF_ONE_VERSION,
		true
	);
}
endif;

if ( ! function_exists( 'ttf_one_customizer_sections_script' ) ) :
/**
 * Enqueue customizer sections script
 *
 * Hooked to 'customize_controls_enqueue_scripts' via ttf_one_customizer_init()
 *
 * @since 1.0
 */
function ttf_one_customizer_sections_script() {
	$path = '/inc/customizer/js/';

	wp_enqueue_script(
		'ttf-one-customizer-sections',
		get_template_directory_uri() . $path . 'customizer-sections' . TTF_ONE_SUFFIX . '.js',
		array( 'customize-controls' ),
		TTF_ONE_VERSION,
		true
	);
}
endif;

if ( ! function_exists( 'ttf_one_customizer_admin_styles' ) ) :
/**
 * Styles for our Customizer sections and controls. Prints in the <head>
 *
 * @since 1.0
 */
function ttf_one_customizer_admin_styles() { ?>
	<style type="text/css">
		.customize-control.customize-control-heading {
			margin-bottom: -2px;
		}
	</style>
<?php }
endif;

if ( ! function_exists( 'ttf_one_add_customizations' ) ) :
/**
 * Make sure the 'ttf_one_css' action only runs once.
 *
 * @since 1.0.0
 *
 * @return void
 */
function ttf_one_add_customizations() {
	do_action( 'ttf_one_css' );
}
endif;

add_action( 'after_setup_theme', 'ttf_one_add_customizations' );

if ( ! function_exists( 'ttf_one_display_customizations' ) ) :
/**
 * Generates the style tag and CSS needed for the theme options.
 *
 * By using the "ttf_one_css" filter, different components can print CSS in the header. It is organized this way to
 * ensure that there is only one "style" tag and not a proliferation of them.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttf_one_display_customizations() {
	// Echo the rules
	$css = ttf_one_get_css()->build();
	if ( ! empty( $css ) ) {
		echo "\n<!-- Begin One Custom CSS -->\n<style type=\"text/css\" id=\"tff-one-custom-css\">\n";
		echo $css;
		echo "\n</style>\n<!-- End One Custom CSS -->\n";
	}
}
endif;

add_action( 'wp_head', 'ttf_one_display_customizations', 11 );

if ( ! function_exists( 'ttf_one_ajax_display_customizations' ) ) :
/**
 * Generates the theme option CSS as an Ajax response
 *
 * @since 1.0.0
 *
 * @return void
 */
function ttf_one_ajax_display_customizations() {
	// Make sure this is an Ajax request
	if ( ! defined( 'DOING_AJAX' ) || true !== DOING_AJAX ) {
		return;
	}

	// Set the content type
	header( "Content-Type: text/css" );

	// Echo the rules
	echo ttf_one_get_css()->build();

	// End the Ajax response
	die();
}
endif;

add_action( 'wp_ajax_ttf-one-css', 'ttf_one_ajax_display_customizations' );

if ( ! function_exists( 'ttf_one_mce_css' ) ) :
/**
 * Make sure theme option CSS is added to TinyMCE last, to override other styles
 *
 * @since 1.0.0
 *
 * @param string $stylesheets
 *
 * @return string
 */
function ttf_one_mce_css( $stylesheets ) {
	if ( ttf_one_get_css()->build() ) {
		$stylesheets .= ',' . add_query_arg( 'action', 'ttf-one-css', admin_url( 'admin-ajax.php' ) );
	}

	return $stylesheets;
}
endif;

add_filter( 'mce_css', 'ttf_one_mce_css', 99 );