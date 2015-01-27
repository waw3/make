<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_display_favicons' ) ) :
/**
 * Write the favicons to the head to implement the options.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttfmake_display_favicons() {
	$logo_favicon = get_theme_mod( 'logo-favicon', ttfmake_get_default( 'logo-favicon' ) );
	if ( ! empty( $logo_favicon ) ) : ?>
		<link rel="icon" href="<?php echo esc_url( $logo_favicon ); ?>" />
	<?php endif;

	$logo_apple_touch = get_theme_mod( 'logo-apple-touch', ttfmake_get_default( 'logo-apple-touch' ) );
	if ( ! empty( $logo_apple_touch ) ) : ?>
		<link rel="apple-touch-icon" href="<?php echo esc_url( $logo_apple_touch ); ?>" />
	<?php endif;
}
endif;

add_action( 'wp_head', 'ttfmake_display_favicons' );

if ( ! function_exists( 'ttfmake_body_layout_classes' ) ) :
/**
 * Add theme option body classes.
 *
 * @since  1.0.0.
 *
 * @param  array    $classes    Existing classes.
 * @return array                Modified classes.
 */
function ttfmake_body_layout_classes( $classes ) {
	// Full-width vs Boxed
	$classes[] = get_theme_mod( 'general-layout', ttfmake_get_default( 'general-layout' ) );

	// Header branding position
	if ( 'right' === get_theme_mod( 'header-branding-position', ttfmake_get_default( 'header-branding-position' ) ) ) {
		$classes[] = 'branding-right';
	}

	// Header Bar text position
	if ( 'flipped' === get_theme_mod( 'header-bar-content-layout', ttfmake_get_default( 'header-bar-content-layout' ) ) ) {
		$classes[] = 'header-bar-flipped';
	}

	return $classes;
}
endif;

add_filter( 'body_class', 'ttfmake_body_layout_classes' );

if ( ! function_exists( 'ttfmake_get_social_links' ) ) :
/**
 * Get the social links from options.
 *
 * @since  1.0.0.
 *
 * @return array    Keys are service names and the values are links.
 */
function ttfmake_get_social_links() {
	// Define default services; note that these are intentional non-translatable
	$default_services = array(
		'facebook' => array(
			'title' => 'Facebook',
			'class' => 'fa-facebook',
		),
		'twitter' => array(
			'title' => 'Twitter',
			'class' => 'fa-twitter',
		),
		'google-plus-square' => array(
			'title' => 'Google+',
			'class' => 'fa-google-plus-square',
		),
		'linkedin' => array(
			'title' => 'LinkedIn',
			'class' => 'fa-linkedin',
		),
		'instagram' => array(
			'title' => 'Instagram',
			'class' => 'fa-instagram',
		),
		'flickr' => array(
			'title' => 'Flickr',
			'class' => 'fa-flickr',
		),
		'youtube' => array(
			'title' => 'YouTube',
			'class' => 'fa-youtube',
		),
		'vimeo-square' => array(
			'title' => 'Vimeo',
			'class' => 'fa-vimeo-square',
		),
		'pinterest' => array(
			'title' => 'Pinterest',
			'class' => 'fa-pinterest',
		),
		'email' => array(
			'title' => __( 'Email', 'make' ),
			'class' => 'fa-envelope',
		),
		'rss' => array(
			'title' => __( 'RSS', 'make' ),
			'class' => 'fa-rss',
		),
	);

	// Set up the collector array
	$services_with_links = array();

	// Get the links for these services
	foreach ( $default_services as $service => $details ) {
		$url = get_theme_mod( 'social-' . $service, ttfmake_get_default( 'social-' . $service ) );
		if ( '' !== $url ) {
			$services_with_links[ $service ] = array(
				'title' => $details['title'],
				'url'   => $url,
				'class' => $details['class'],
			);
		}
	}

	// Special handling for RSS
	$hide_rss = (int) get_theme_mod( 'social-hide-rss', ttfmake_get_default( 'social-hide-rss' ) );
	if ( 0 === $hide_rss ) {
		$custom_rss = get_theme_mod( 'social-custom-rss', ttfmake_get_default( 'social-custom-rss' ) );
		if ( ! empty( $custom_rss ) ) {
			$services_with_links['rss']['url'] = $custom_rss;
		} else {
			$services_with_links['rss']['url'] = get_feed_link();
		}
	} else {
		unset( $services_with_links['rss'] );
	}

	// Properly set the email
	if ( isset( $services_with_links['email']['url'] ) ) {
		$services_with_links['email']['url'] = esc_url( 'mailto:' . $services_with_links['email']['url'] );
	}

	/**
	 * Filter the social links added to the site.
	 *
	 * @since 1.2.3.
	 *
	 * @param array    $services_with_links    The social services and links.
	 */
	return apply_filters( 'make_social_links', $services_with_links );
}
endif;