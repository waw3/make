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

/**
 * Includes
 */
// Custom template tags
require get_template_directory() . '/inc/template-tags.php';
// Custom functions that act independently of the theme templates
require get_template_directory() . '/inc/extras.php';
// Customizer additions
require get_template_directory() . '/inc/customizer/bootstrap.php';
// Jetpack compatibility file
require get_template_directory() . '/inc/jetpack.php';
// Gallery slider
require get_template_directory() . '/inc/gallery-slider/gallery-slider.php';
// TinyMCE customizations
if ( is_admin() ) {
	require get_template_directory() . '/inc/tinymce.php';
}
// Page customizations
if ( is_admin() ) {
	require get_template_directory() . '/inc/edit-page.php';
}
// Load the builder
if ( is_admin() ) {
	require get_template_directory() . '/inc/builder/core/base.php';
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
		'default-color'      => ttf_one_get_default( 'background_color' ),
		'default-image'      => ttf_one_get_default( 'background_image' ),
		'default-repeat'     => ttf_one_get_default( 'background_repeat' ),
		'default-position-x' => ttf_one_get_default( 'background_position_x' ),
		'default-attachment' => ttf_one_get_default( 'background_attachment' ),
	) );

	// HTML5
	add_theme_support( 'html5' );

	// Menu locations
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'ttf-one' ),
	) );

	// Editor styles
	$editor_styles = array();
	if ( '' !== $google_request = ttf_one_get_google_font_request() ) {
		$editor_styles[] = $google_request;
	}
	$editor_styles[] = 'css/font-awesome.css';
	$editor_styles[] = 'css/editor-style.css';
	$editor_styles[] = add_query_arg( 'action', 'ttf-one-css', admin_url( 'admin-ajax.php' ) );
	add_editor_style( $editor_styles );
}
endif;

add_action( 'after_setup_theme', 'ttf_one_setup' );

if ( ! function_exists( 'ttf_one_widgets_init' ) ) :
/**
 * Register widget areas
 */
function ttf_one_widgets_init() {
	register_sidebar( array(
		'id'            => 'sidebar-left',
		'name'          => __( 'Left Sidebar', 'ttf-one' ),
		'description'   => ttf_one_sidebar_description( 'sidebar-left' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'id'            => 'sidebar-right',
		'name'          => __( 'Right Sidebar', 'ttf-one' ),
		'description'   => ttf_one_sidebar_description( 'sidebar-right' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'id'            => 'footer-1',
		'name'          => __( 'Footer 1', 'ttf-one' ),
		'description'   => ttf_one_sidebar_description( 'footer-1' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'id'            => 'footer-2',
		'name'          => __( 'Footer 2', 'ttf-one' ),
		'description'   => ttf_one_sidebar_description( 'footer-2' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'id'            => 'footer-3',
		'name'          => __( 'Footer 3', 'ttf-one' ),
		'description'   => ttf_one_sidebar_description( 'footer-3' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'id'            => 'footer-4',
		'name'          => __( 'Footer 4', 'ttf-one' ),
		'description'   => ttf_one_sidebar_description( 'footer-4' ),
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
		// Enqueue the fonts
		wp_enqueue_style(
			'ttf-one-google-fonts',
			$google_request,
			$style_dependencies,
			TTF_ONE_VERSION
		);
		$style_dependencies[] = 'ttf-one-google-fonts';
	}

	// Font Awesome
	wp_enqueue_style(
		'ttf-one-font-awesome',
		get_template_directory_uri() . '/css/font-awesome.css',
		$style_dependencies,
		'4.0.3'
	);
	$style_dependencies[] = 'ttf-one-font-awesome';

	// Main stylesheet
	wp_enqueue_style(
		'ttf-one-main-style',
		get_stylesheet_uri(),
		$style_dependencies,
		TTF_ONE_VERSION
	);
	$style_dependencies[] = 'ttf-one-main-style';

	// Print stylesheet
	wp_enqueue_style(
		'ttf-one-print-style',
		get_template_directory_uri() . '/css/print.css',
		$style_dependencies,
		TTF_ONE_VERSION,
		'print'
	);

	$script_dependencies = array();

	// Scripts that don't need jQuery

	$script_dependencies[] = 'jquery';

	// Cycle2
	ttf_one_cycle2_script_setup( $script_dependencies );
	$script_dependencies[] = 'ttf-one-cycle2';

	// FitVids
	wp_enqueue_script(
		'ttf-one-fitvids',
		get_template_directory_uri() . '/js/libs/fitvids/jquery.fitvids' . TTF_ONE_SUFFIX . '.js',
		$script_dependencies,
		'1.1',
		true
	);
	ttf_one_localize_fitvids( 'ttf-one-fitvids' );
	$script_dependencies[] = 'ttf-one-fitvids';

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

if ( ! function_exists( 'ttf_one_cycle2_script_setup' ) ) :
/**
 * Enqueue Cycle2 scripts
 *
 * @since 1.0.0
 *
 * @param array $script_dependencies
 *
 * @return void
 */
function ttf_one_cycle2_script_setup( $script_dependencies ) {
	if ( defined( 'TTF_ONE_SUFFIX' ) && '.min' === TTF_ONE_SUFFIX ) {
		wp_enqueue_script(
			'ttf-one-cycle2',
			get_template_directory_uri() . '/js/libs/cycle2/jquery.cycle2' . TTF_ONE_SUFFIX . '.js',
			$script_dependencies,
			TTF_ONE_VERSION,
			true
		);
	} else {
		wp_enqueue_script(
			'ttf-one-cycle2',
			get_template_directory_uri() . '/js/libs/cycle2/jquery.cycle2.js',
			$script_dependencies,
			'2.1.3',
			true
		);
		wp_enqueue_script(
			'ttf-one-cycle2-center',
			get_template_directory_uri() . '/js/libs/cycle2/jquery.cycle2.center.js',
			'ttf-one-cycle2',
			'20140121',
			true
		);
		wp_enqueue_script(
			'ttf-one-cycle2-swipe',
			get_template_directory_uri() . '/js/libs/cycle2/jquery.cycle2.swipe.js',
			'ttf-one-cycle2',
			'20121120',
			true
		);
	}
}
endif;

if ( ! function_exists( 'ttf_one_localize_fitvids' ) ) :
/**
 * Localize FitVids script.
 *
 * @since 1.0.0
 *
 * @param  string    $name    The handle for registering the script.
 * @return void
 */
function ttf_one_localize_fitvids( $name ) {
	// Default selectors
	$selector_array = array(
		"iframe[src*='www.viddler.com']",
		"iframe[src*='money.cnn.com']",
		"iframe[src*='www.educreations.com']",
		"iframe[src*='//blip.tv']",
		"iframe[src*='//embed.ted.com']",
		"iframe[src*='//www.hulu.com']",
	);

	// Filter selectors
	$selector_array = apply_filters( 'ttf_one_fitvids_custom_selectors', $selector_array );

	// Compile selectors
	$fitvids_custom_selectors = array(
		'selectors' => implode( ',', $selector_array )
	);

	// Send to the script
	wp_localize_script(
		$name,
		'TTFOneFitVids',
		$fitvids_custom_selectors
	);
}
endif;

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
 * Initial content width
 */
if ( ! isset( $content_width ) ) {
	$content_width = 620;
}

if ( ! function_exists( 'ttf_one_content_width' ) ) :
/**
 * Set the content width based on current layout
 *
 * @since 1.0.0
 *
 * @return void
 */
function ttf_one_content_width() {
	global $content_width;

	$left = ttf_one_has_sidebar( 'left' );
	$right = ttf_one_has_sidebar( 'right' );

	// No sidebars
	if ( ! $left && ! $right ) {
		$content_width = 960;
	}
	// Both sidebars
	else if ( $left && $right ) {
		$content_width = 464;
	}
	// One sidebar
	else if ( $left || $right ) {
		$content_width = 620;
	}
}
endif;

add_action( 'template_redirect', 'ttf_one_content_width' );

if ( ! function_exists( 'ttf_one_sanitize_hex_color' ) ) :
/**
 * Validates a hex color.
 *
 * Returns either '', a 3 or 6 digit hex color (with #), or null.
 * For validating values without a #, see sanitize_hex_color_no_hash().
 *
 * @since  1.0.0.
 *
 * @param  string         $color    Hexidecimal value to sanitize.
 * @return string|null              Sanitized value.
 */
function ttf_one_sanitize_hex_color( $color ) {
	if ( '' === $color )
		return '';

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
		return $color;

	return null;
}
endif;

if ( ! function_exists( 'ttf_one_sanitize_hex_color_no_hash' ) ) :
/**
 * Sanitizes a hex color without a hash. Use sanitize_hex_color() when possible.
 *
 * Saving hex colors without a hash puts the burden of adding the hash on the
 * UI, which makes it difficult to use or upgrade to other color types such as
 * rgba, hsl, rgb, and html color names.
 *
 * Returns either '', a 3 or 6 digit hex color (without a #), or null.
 *
 * @since  1.0.0.
 *
 * @param  string         $color    Hexidecimal value to sanitize.
 * @return string|null              Sanitized value.
 */
function ttf_one_sanitize_hex_color_no_hash( $color ) {
	$color = ltrim( $color, '#' );

	if ( '' === $color )
		return '';

	return ttf_one_sanitize_hex_color( '#' . $color ) ? $color : null;
}
endif;

if ( ! function_exists( 'ttf_one_maybe_hash_hex_color' ) ) :
/**
 * Ensures that any hex color is properly hashed.
 * Otherwise, returns value untouched.
 *
 * This method should only be necessary if using sanitize_hex_color_no_hash().
 *
 * @since  1.0.0.
 *
 * @param  string    $color    Hexidecimal value to sanitize.
 * @return string              Sanitized value.
 */
function ttf_one_maybe_hash_hex_color( $color ) {
	if ( $unhashed = ttf_one_sanitize_hex_color_no_hash( $color ) )
		return '#' . $unhashed;

	return $color;
}
endif;
