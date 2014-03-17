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
	require_once( get_template_directory() . $path . 'helpers-fonts.php' );

	// Hook up functions
	add_action( 'customize_register', 'ttf_one_customizer_add_sections' );
	add_action( 'customize_register', 'ttf_one_customizer_set_transport' );
	add_action( 'customize_preview_init', 'ttf_one_customizer_preview_script' );
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
		'general'    => __( 'General', 'ttf-one' ),
		'logo'       => __( 'Logo', 'ttf-one' ),
		'fonts'      => __( 'Fonts', 'ttf-one' ),
		'colors'     => __( 'Colors', 'ttf-one' ),
		'header'     => __( 'Header', 'ttf-one' ),
		'main'       => __( 'Main', 'ttf-one' ),
		'footer'     => __( 'Footer', 'ttf-one' ),
		'social'     => __( 'Social Profiles &amp; RSS', 'ttf-one' )
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
			if ( function_exists( 'ttf_one_customizer_' . $section ) ) {
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
					'ttf_one_customizer_' . esc_attr( $section ),
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
 * Add postMessage support for certain settings in the Theme Customizer.
 *
 * @since 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ttf_one_customizer_set_transport( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport             = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'general-sticky-label' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header-text' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'footer-text' )->transport          = 'postMessage';
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
		/*
		#customize-theme-controls .control-section[id*="ttf-one_"] .accordion-section-title {
			background-color: #f9f9f9;
		}
		*/
		.customize-control.customize-control-heading {
			margin-bottom: -2px;
		}
	</style>
<?php }
endif;

if ( ! function_exists( 'ttf_one_display_customizations' ) ) :
/**
 * Generates the CSS needed for the theme options.
 *
 * By using the "ttf_one_css" filter, different components can print CSS in the header. It is organized this way to
 * ensure that there is only one "style" tag and not a proliferation of them.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttf_one_display_customizations() {
	$css = apply_filters( 'ttf_one_css', '' );

	if ( ! empty( $css ) ) {
		// Note that the escaping responsibility for $css lies in the functions that filter "ttf_one_css" ?>
<!-- Begin TTF_One Custom CSS -->
<style type="text/css" media="all"><?php echo $css; ?></style>
<!-- End TTF_One Custom CSS -->
	<?php
	}
}
endif;

add_action( 'wp_head', 'ttf_one_display_customizations', 11 );