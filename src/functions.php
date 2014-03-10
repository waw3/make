<?php
/**
 * @package ttf-one
 */

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

	// Menu locations
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'ttf-one' ),
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
}
endif;

add_action( 'widgets_init', 'ttf_one_widgets_init' );

if ( ! function_exists( 'ttf_one_scripts' ) ) :
/**
 * Enqueue scripts and styles.
 */
function ttf_one_scripts() {
	wp_enqueue_style( 'ttf-one-style', get_stylesheet_uri() );

	wp_enqueue_script( 'ttf-one-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'ttf-one-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

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
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
