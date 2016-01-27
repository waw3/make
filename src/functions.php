<?php
/**
 * @package Make
 */

/**
 * The current version of the theme.
 */
define( 'TTFMAKE_VERSION', '1.6.7' );

/**
 * The minimum version of WordPress required for Make.
 */
define( 'TTFMAKE_MIN_WP_VERSION', '4.2' );

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
	// Activation
	require_once get_template_directory() . '/inc/activation.php';

	// Autoloader
	require_once get_template_directory() . '/inc/autoload.php';

	// Load API
	global $Make;
	$Make = new MAKE_API;

	// Load other files
	$files = array(
		// Miscellaneous
		get_template_directory() . '/inc/extras.php',
		get_template_directory() . '/inc/template-tags.php',
		// Temp
		get_template_directory() . '/inc/customizer/logo.php',
	);

	if ( is_admin() ) {
		$admin_files = array(
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
}

// Load files immediately.
ttfmake_require_files();

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
		$logo_favicon = make_get_thememod_value( 'logo-favicon' );
		if ( ! empty( $logo_favicon ) ) :
			if ( is_int( $logo_favicon ) ) :
				$logo_favicon_src = wp_get_attachment_image_src( $logo_favicon, 'full' );
				$logo_favicon = isset( $logo_favicon_src[0] ) ? $logo_favicon_src[0] : '';
			endif;
			?>
			<link rel="icon" href="<?php echo esc_url( $logo_favicon ); ?>" />
		<?php endif;

		// Apple Touch icon
		$logo_apple_touch = make_get_thememod_value( 'logo-apple-touch' );
		if ( ! empty( $logo_apple_touch ) ) :
			if ( is_int( $logo_apple_touch ) ) :
				$logo_apple_touch_src = wp_get_attachment_image_src( $logo_apple_touch, 'full' );
				$logo_apple_touch = isset( $logo_apple_touch_src[0] ) ? $logo_apple_touch_src[0] : '';
			endif;
			?>
			<link rel="apple-touch-icon" href="<?php echo esc_url( $logo_apple_touch ); ?>" />
		<?php endif;
	endif;
}
endif;

add_action( 'wp_head', 'ttfmake_head_late', 99 );