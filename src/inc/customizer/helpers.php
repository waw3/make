<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_sanitize_text' ) ) :
/**
 * Sanitize a string to allow only tags in the allowedtags array.
 *
 * @since  1.0.0
 *
 * @param  string    $string    The unsanitized string.
 * @return string               The sanitized string.
 */
function ttf_one_sanitize_text( $string ) {
	global $allowedtags;
	return wp_kses( $string , $allowedtags );
}
endif;

if ( ! function_exists( 'sanitize_hex_color' ) ) :
/**
 * Sanitizes a hex color.
 *
 * This is a copy of the core function for use when the customizer is not being shown.
 *
 * @since  1.0.0
 *
 * @param  string         $color    The proposed color.
 * @return string|null              The sanitized color.
 */
function sanitize_hex_color( $color ) {
	if ( '' === $color )
		return '';

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
		return $color;

	return null;
}
endif;

if ( ! function_exists( 'sanitize_hex_color_no_hash' ) ) :
/**
 * Sanitizes a hex color without a hash. Use sanitize_hex_color() when possible.
 *
 * This is a copy of the core function for use when the customizer is not being shown.
 *
 * @since  1.0.0
 *
 * @param  string         $color    The proposed color.
 * @return string|null              The sanitized color.
 */
function sanitize_hex_color_no_hash( $color ) {
	$color = ltrim( $color, '#' );

	if ( '' === $color )
		return '';

	return sanitize_hex_color( '#' . $color ) ? $color : null;
}
endif;

if ( ! function_exists( 'maybe_hash_hex_color' ) ) :
/**
 * Ensures that any hex color is properly hashed.
 *
 * This is a copy of the core function for use when the customizer is not being shown.
 *
 * @since  1.0.0
 *
 * @param  string         $color    The proposed color.
 * @return string|null              The sanitized color.
 */
function maybe_hash_hex_color( $color ) {
	if ( $unhashed = sanitize_hex_color_no_hash( $color ) )
		return '#' . $unhashed;

	return $color;
}
endif;

if ( ! function_exists( 'ttf_one_sanitize_choice' ) ) :
/**
 * Sanitize a value from a list of allowed values.
 *
 * The first value in the 'allowed_choices' array will be the default if the given
 * value doesn't match anything in the array.
 *
 * @since 1.0.0
 *
 * @param mixed $value
 * @param mixed $setting
 *
 * @return mixed
 */
function ttf_one_sanitize_choice( $value, $setting ) {
	if ( is_object( $setting ) ) {
		$setting = $setting->id;
	}

	$allowed_choices = array( 0 );

	switch ( $setting ) {
		case 'general-layout' :
			$allowed_choices = array( 'full-width', 'boxed' );
			break;
		case 'background_size' :
		case 'header-background-size' :
		case 'main-background-size' :
		case 'footer-background-size' :
			$allowed_choices = array( 'auto', 'cover', 'contain' );
			break;
		case 'header-background-repeat' :
		case 'main-background-repeat' :
		case 'footer-background-repeat' :
			$allowed_choices = array( 'no-repeat', 'repeat', 'repeat-x', 'repeat-y' );
			break;
		case 'header-background-position' :
		case 'main-background-position' :
		case 'footer-background-position' :
			$allowed_choices = array( 'left', 'center', 'right' );
			break;
		case 'header-layout' :
			$allowed_choices = array( 1, 2, 3 );
			break;
		case 'header-primary-nav-position' :
			$allowed_choices = array( 'left', 'right' );
			break;
		case 'footer-widget-areas' :
			$allowed_choices = array( 0, 1, 2, 3, 4 );
			break;
		case 'footer-layout' :
			$allowed_choices = array( 1, 2 );
			break;
	}

	if ( ! in_array( $value, $allowed_choices ) ) {
		$value = ttf_one_get_default( $setting );
	}

	return $value;
}
endif;

if ( ! function_exists( 'ttf_one_display_favicons' ) ) :
/**
 * Write the favicons to the head to implement the options.
 *
 * @since  1.0.0
 *
 * @return void
 */
function ttf_one_display_favicons() {
	$logo_favicon = get_theme_mod( 'logo-favicon', ttf_one_get_default( 'logo-favicon' ) );
	if ( ! empty( $logo_favicon ) ) : ?>
		<link rel="icon" href="<?php echo esc_url( $logo_favicon ); ?>" />
	<?php endif;

	$logo_apple_touch = get_theme_mod( 'logo-apple-touch', ttf_one_get_default( 'logo-apple-touch' ) );
	if ( ! empty( $logo_apple_touch ) ) : ?>
		<link rel="apple-touch-icon" href="<?php echo esc_url( $logo_apple_touch ); ?>" />
	<?php endif;
}
endif;

add_action( 'wp_head', 'ttf_one_display_favicons' );

if ( ! function_exists( 'ttf_one_body_layout_classes' ) ) :
/**
 * Add theme option body classes
 *
 * @since 1.0.0
 *
 * @param array $classes
 *
 * @return array
 */
function ttf_one_body_layout_classes( $classes ) {
	$classes[] = get_theme_mod( 'general-layout', ttf_one_get_default( 'general-layout' ) );
	if ( 'left' === get_theme_mod( 'header-primary-nav-position', ttf_one_get_default( 'header-primary-nav-position' ) ) ) {
		$classes[] = 'primary-nav-left';
	}
	return $classes;
}
endif;

add_filter( 'body_class', 'ttf_one_body_layout_classes' );

if ( ! function_exists( 'ttf_one_get_social_links' ) ) :
/**
 * Get the social links from options.
 *
 * @since  1.0.0.
 *
 * @return array    Keys are service names and the values are links.
 */
function ttf_one_get_social_links() {
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
		'google' => array(
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
		'vimeo' => array(
			'title' => 'Vimeo',
			'class' => 'fa-vimeo-square',
		),
		'pinterest' => array(
			'title' => 'Pinterest',
			'class' => 'fa-pinterest',
		),
		'email' => array(
			'title' => __( 'Email', 'ttf_one' ),
			'class' => 'fa-envelope',
		),
		'rss' => array(
			'title' => __( 'RSS', 'ttf_one' ),
			'class' => 'fa-rss',
		),
	);

	// Set up the collector array
	$services_with_links = array();

	// Get the links for these services
	foreach ( $default_services as $service => $details ) {
		$url = get_theme_mod( 'social-' . $service, ttf_one_get_default( 'social-' . $service ) );
		if ( '' !== $url ) {
			$services_with_links[ $service ] = array(
				'title' => $details['title'],
				'url'   => $url,
				'class' => $details['class'],
			);
		}
	}

	// Special handling for RSS
	$hide_rss = (int) get_theme_mod( 'social-hide-rss', ttf_one_get_default( 'social-hide-rss' ) );
	if ( 0 === $hide_rss ) {
		$custom_rss = get_theme_mod( 'social-custom-rss', ttf_one_get_default( 'social-custom-rss' ) );
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

	return apply_filters( 'ttf_one_social_links', $services_with_links );
}
endif;