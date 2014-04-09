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

	$choices = ttf_one_get_choices( $setting );
	$allowed_choices = array_keys( $choices );

	if ( ! in_array( $value, $allowed_choices ) ) {
		$value = ttf_one_get_default( $setting );
	}

	return $value;
}
endif;

if ( ! function_exists( 'ttf_one_get_choices' ) ) :
/**
 * Return the available choices for a given setting
 *
 * @since 1.0.0
 *
 * @param string|object $setting
 *
 * @return array
 */
function ttf_one_get_choices( $setting ) {
	if ( is_object( $setting ) ) {
		$setting = $setting->id;
	}

	$choices = array( 0 );

	switch ( $setting ) {
		case 'general-layout' :
			$choices = array(
				'full-width' => __( 'Full-width', 'ttf-one' ),
				'boxed'      => __( 'Boxed', 'ttf-one' )
			);
			break;
		case 'layout-blog-featured-images' :
		case 'layout-archive-featured-images' :
		case 'layout-search-featured-images' :
			$choices = array(
				'thumbnail'  => __( 'Thumbnail', 'ttf-one' ),
				'background' => __( 'Post header background', 'ttf-one' ),
				'none'       => __( 'None', 'ttf-one' ),
			);
			break;
		case 'layout-blog-post-date' :
		case 'layout-archive-post-date' :
		case 'layout-search-post-date' :
			$choices = array(
				'absolute' => __( 'Absolute', 'ttf-one' ),
				'relative' => __( 'Relative', 'ttf-one' ),
				'none'     => __( 'None', 'ttf-one' ),
			);
			break;
		case 'layout-blog-post-author' :
		case 'layout-archive-post-author' :
		case 'layout-search-post-author' :
			$choices = array(
				'avatar' => __( 'Avatar', 'ttf-one' ),
				'name'   => __( 'Name', 'ttf-one' ),
				'both'   => __( 'Avatar + Name', 'ttf-one' ),
				'none'   => __( 'None', 'ttf-one' ),
			);
			break;
		case 'layout-blog-byline-location' :
		case 'layout-archive-byline-location' :
		case 'layout-search-byline-location' :
			$choices = array(
				'before' => __( 'Before content', 'ttf-one' ),
				'after'  => __( 'After content', 'ttf-one' ),
			);
			break;
		case 'header-background-repeat' :
		case 'main-background-repeat' :
		case 'footer-background-repeat' :
			$choices = array(
				'no-repeat' => __( 'No Repeat', 'ttf-one' ),
				'repeat'    => __( 'Tile', 'ttf-one' ),
				'repeat-x'  => __( 'Tile Horizontally', 'ttf-one' ),
				'repeat-y'  => __( 'Tile Vertically', 'ttf-one' )
			);
			break;
		case 'header-background-position' :
		case 'main-background-position' :
		case 'footer-background-position' :
			$choices = array(
				'left'   => __( 'Left', 'ttf-one' ),
				'center' => __( 'Center', 'ttf-one' ),
				'right'  => __( 'Right', 'ttf-one' )
			);
			break;
		case 'background_size' :
		case 'header-background-size' :
		case 'main-background-size' :
		case 'footer-background-size' :
			$choices = array(
				'auto'    => __( 'Auto', 'ttf-one' ),
				'cover'   => __( 'Cover', 'ttf-one' ),
				'contain' => __( 'Contain', 'ttf-one' )
			);
			break;
		case 'header-subheader-content-layout' :
			$choices = array(
				'default' => __( 'Default', 'ttf-one' ),
				'flipped' => __( 'Flipped', 'ttf-one' )
			);
			break;
		case 'header-layout' :
			$choices = array(
				1  => __( 'Layout 1', 'ttf-one' ),
				2  => __( 'Layout 2', 'ttf-one' ),
				3  => __( 'Layout 3', 'ttf-one' ),
			);
			break;
		case 'header-branding-position' :
			$choices = array(
				'left'  => __( 'Left', 'ttf-one' ),
				'right' => __( 'Right', 'ttf-one' )
			);
			break;
		case 'footer-widget-areas' :
			$choices = array(
				0 => __( '0', 'ttf-one' ),
				1 => __( '1', 'ttf-one' ),
				2 => __( '2', 'ttf-one' ),
				3 => __( '3', 'ttf-one' ),
				4 => __( '4', 'ttf-one' )
			);
			break;
		case 'footer-layout' :
			$choices = array(
				1  => __( 'Layout 1', 'ttf-one' ),
				2  => __( 'Layout 2', 'ttf-one' ),
			);
			break;
	}

	return $choices;
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
	// Full-width vs Boxed
	$classes[] = get_theme_mod( 'general-layout', ttf_one_get_default( 'general-layout' ) );
	// Header branding position
	if ( 'right' === get_theme_mod( 'header-branding-position', ttf_one_get_default( 'header-branding-position' ) ) ) {
		$classes[] = 'branding-right';
	}
	// Sub Header text position
	if ( 'flipped' === get_theme_mod( 'header-subheader-content-layout', ttf_one_get_default( 'header-subheader-content-layout' ) ) ) {
		$classes[] = 'subheader-flipped';
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