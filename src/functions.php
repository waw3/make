<?php
/**
 * @package Make
 */

/**
 * The current version of the theme.
 */
define( 'TTFMAKE_VERSION', '1.6.4' );

/**
 * The minimum version of WordPress required for Make.
 */
define( 'TTFMAKE_MIN_WP_VERSION', '4.0' );

/**
 * The suffix to use for scripts.
 */
if ( ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ) {
	define( 'TTFMAKE_SUFFIX', '' );
} else {
	define( 'TTFMAKE_SUFFIX', '.min' );
}

/**
 * Initial content width.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 620;
}

/**
 * Load files.
 *
 * @since 1.6.1.
 *
 * @return void
 */
function ttfmake_require_files() {
	$files = array(
		// Activation
		get_template_directory() . '/inc/activation.php',
		// Autoloader
		get_template_directory() . '/inc/autoload.php',
		// API
		get_template_directory() . '/inc/api.php',
		// Gallery slider
		get_template_directory() . '/inc/gallery-slider/gallery-slider.php',
		// Formatting
		get_template_directory() . '/inc/formatting/formatting.php',
		// Miscellaneous
		get_template_directory() . '/inc/extras.php',
		get_template_directory() . '/inc/template-tags.php',
		// Temp
		get_template_directory() . '/inc/customizer/logo.php',
	);

	if ( is_admin() ) {
		$admin_files = array(
			// Page customizations
			get_template_directory() . '/inc/edit-page.php',
			// Page Builder
			get_template_directory() . '/inc/builder/core/base.php'
		);

		$files = array_merge( $files, $admin_files );
	}

	/**
	 * Filter the list of theme files to load.
	 *
	 * Note that in some cases, the order that the files are listed in matters.
	 *
	 * @since 1.6.1.
	 *
	 * @param array    $files    The array of absolute file paths.
	 */
	$files = apply_filters( 'make_required_files', $files );

	foreach ( $files as $file ) {
		if ( file_exists( $file ) ) {
			require_once $file;
		}
	}

	// Load API
	global $Make;
	$Make = new MAKE_API;
}

// Load files immediately.
ttfmake_require_files();

if ( ! function_exists( 'ttfmake_content_width' ) ) :
/**
 * Set the content width based on current layout
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttfmake_content_width() {
	global $content_width;

	$new_width = $content_width;
	$left = ttfmake_has_sidebar( 'left' );
	$right = ttfmake_has_sidebar( 'right' );

	// No sidebars
	if ( ! $left && ! $right ) {
		$new_width = 960;
	}
	// Both sidebars
	else if ( $left && $right ) {
		$new_width = 464;
	}
	// One sidebar
	else if ( $left || $right ) {
		$new_width = 620;
	}

	/**
	 * Filter to modify the $content_width variable.
	 *
	 * @since 1.4.8
	 *
	 * @param int     $new_width    The new content width.
	 * @param bool    $left         True if the current view has a left sidebar.
	 * @param bool    $right        True if the current view has a right sidebar.
	 */
	$content_width = apply_filters( 'make_content_width', $new_width, $left, $right );
}
endif;

add_action( 'template_redirect', 'ttfmake_content_width' );

if ( ! function_exists( 'ttfmake_setup' ) ) :
/**
 * Sets up text domain, theme support, menus, and editor styles
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttfmake_setup() {
	// Feed links
	add_theme_support( 'automatic-feed-links' );

	// Featured images
	add_theme_support( 'post-thumbnails' );

	// Custom background
	add_theme_support( 'custom-background', array(
		'default-color'      => ttfmake_get_default( 'background_color' ),
		'default-image'      => ttfmake_get_default( 'background_image' ),
		'default-repeat'     => ttfmake_get_default( 'background_repeat' ),
		'default-position-x' => ttfmake_get_default( 'background_position_x' ),
		'default-attachment' => ttfmake_get_default( 'background_attachment' ),
	) );

	// HTML5
	add_theme_support( 'html5', array(
		'comment-list',
		'comment-form',
		'search-form',
		'gallery',
		'caption'
	) );

	// Title tag
	add_theme_support( 'title-tag' );

	// Menu locations
	register_nav_menus( array(
		'primary'    => __( 'Primary Navigation', 'make' ),
		'social'     => __( 'Social Profile Links', 'make' ),
		'header-bar' => __( 'Header Bar Navigation', 'make' ),
	) );

	// Yoast SEO breadcrumbs
	add_theme_support( 'yoast-seo-breadcrumbs' );
}
endif;

add_action( 'after_setup_theme', 'ttfmake_setup' );

if ( ! function_exists( 'ttfmake_widgets_init' ) ) :
/**
 * Register widget areas
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttfmake_widgets_init() {
	register_sidebar( array(
		'id'            => 'sidebar-left',
		'name'          => __( 'Left Sidebar', 'make' ),
		'description'   => ttfmake_sidebar_description( 'sidebar-left' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'id'            => 'sidebar-right',
		'name'          => __( 'Right Sidebar', 'make' ),
		'description'   => ttfmake_sidebar_description( 'sidebar-right' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'id'            => 'footer-1',
		'name'          => __( 'Footer 1', 'make' ),
		'description'   => ttfmake_sidebar_description( 'footer-1' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'id'            => 'footer-2',
		'name'          => __( 'Footer 2', 'make' ),
		'description'   => ttfmake_sidebar_description( 'footer-2' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'id'            => 'footer-3',
		'name'          => __( 'Footer 3', 'make' ),
		'description'   => ttfmake_sidebar_description( 'footer-3' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'id'            => 'footer-4',
		'name'          => __( 'Footer 4', 'make' ),
		'description'   => ttfmake_sidebar_description( 'footer-4' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
endif;

add_action( 'widgets_init', 'ttfmake_widgets_init' );

if ( ! function_exists( 'ttfmake_head_early' ) ) :
/**
 * Add items to the top of the wp_head section of the document head.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttfmake_head_early() {
	// Title tag fallback
	if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) : ?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
	endif;

	// JavaScript detection ?>

		<script type="text/javascript">
			/* <![CDATA[ */
			document.documentElement.className = document.documentElement.className.replace(new RegExp('(^|\\s)no-js(\\s|$)'), '$1js$2');
			/* ]]> */
		</script>

<?php
	// Meta tags ?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<?php
}
endif;

add_action( 'wp_head', 'ttfmake_head_early', 1 );

if ( ! function_exists( 'ttfmake_head_late' ) ) :
/**
 * Add additional items to the end of the wp_head section of the document head.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttfmake_head_late() {
	// Pingback link ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php
	// Core Site Icon option overrides Make's deprecated Favicon and Apple Touch Icon settings
	if ( false === get_option( 'site_icon', false ) ) :
		// Favicon
		$logo_favicon = get_theme_mod( 'logo-favicon', ttfmake_get_default( 'logo-favicon' ) );
		if ( ! empty( $logo_favicon ) ) : ?>
			<link rel="icon" href="<?php echo esc_url( $logo_favicon ); ?>" />
		<?php endif;

		// Apple Touch icon
		$logo_apple_touch = get_theme_mod( 'logo-apple-touch', ttfmake_get_default( 'logo-apple-touch' ) );
		if ( ! empty( $logo_apple_touch ) ) : ?>
			<link rel="apple-touch-icon" href="<?php echo esc_url( $logo_apple_touch ); ?>" />
		<?php endif;
	endif;
}
endif;

add_action( 'wp_head', 'ttfmake_head_late', 99 );