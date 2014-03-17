<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_is_wpcom' ) ) :
/**
 * Whether or not the current environment is WordPress.com.
 *
 * @since  1.0
 *
 * @return bool
 */
function ttf_one_is_wpcom() {
	return ( defined( 'IS_WPCOM' ) && true === IS_WPCOM );
}
endif;

/**
 * The current version of the theme.
 */
define( 'TTF_ONE_VERSION', '1.0' );

/**
 * The suffix to use for scripts.
 */
if ( ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) || ttf_one_is_wpcom() ) {
	define( 'TTF_ONE_SUFFIX', '' );
} else {
	define( 'TTF_ONE_SUFFIX', '.min' );
}

if ( ! function_exists( 'ttf_one_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function ttf_one_setup() {
	// Text domain
	load_theme_textdomain( 'ttf-one', get_template_directory() . '/languages' );

	// Feed links
	add_theme_support( 'automatic-feed-links' );

	// Featured images
	add_theme_support( 'post-thumbnails' );

	// Custom background
	add_theme_support( 'custom-background', array(
		'default-color' => '#ffffff'
	) );

	// HTML5
	add_theme_support( 'html5' );

	// Menu locations
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'ttf-one' ),
		'top'     => __( 'Top Menu', 'ttf-one' )
	) );
}
endif;

add_action( 'after_setup_theme', 'ttf_one_setup' );

if ( ! function_exists( 'ttf_one_widgets_init' ) ) :
/**
 * Register widget areas
 */
function ttf_one_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'ttf-one' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 1', 'ttf-one' ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 2', 'ttf-one' ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 3', 'ttf-one' ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 4', 'ttf-one' ),
		'id'            => 'footer-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
endif;

add_action( 'widgets_init', 'ttf_one_widgets_init' );

if ( ! function_exists( 'ttf_one_scripts' ) ) :
/**
 * Enqueue scripts and styles.
 */
function ttf_one_scripts() {
	$style_dependencies = array();

	// Google fonts
	if ( '' !== $google_request = ttf_one_get_google_font_request() ) {
		// Add fonts to head CSS block
		add_filter( 'ttf_one_css', 'ttf_one_css_fonts' );

		// Enqueue the fonts
		wp_enqueue_style(
			'ttf-one-google-fonts',
			$google_request,
			array(),
			TTF_ONE_VERSION
		);
		$style_dependencies[] = 'ttf-one-google-fonts';
	}

	// Main stylesheet
	wp_enqueue_style(
		'ttf-one-main-style',
		get_stylesheet_uri(),
		$style_dependencies,
		TTF_ONE_VERSION
	);

	$script_dependencies = array();

	// Add in Font Awesome
	wp_enqueue_style(
		'ttf-one-font-awesome',
		get_template_directory_uri() . '/css/font-awesome.css',
		array(),
		'4.0.3'
	);

	// Scripts that don't need jQuery

	$style_dependencies[] = 'jquery';

	// Global script
	wp_enqueue_script(
		'ttf-one-global',
		get_template_directory_uri() . '/js/global' . TTF_ONE_SUFFIX . '.js',
		$script_dependencies,
		TTF_ONE_VERSION,
		true
	);

	// Comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
endif;

add_action( 'wp_enqueue_scripts', 'ttf_one_scripts' );

if ( ! function_exists( 'ttf_one_head_extras' ) ) :
/**
 *
 */
function ttf_one_head_extras() { ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php
}
endif;

add_action( 'wp_head', 'ttf_one_head_extras', 99 );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/bootstrap.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load the builder.
 */
if ( is_admin() ) {
	require get_template_directory() . '/inc/builder/builder-base.php';
}
