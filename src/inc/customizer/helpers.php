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
		case 'main-background-size' :
		case 'footer-background-size' :
		case 'background-size' :
			$allowed_choices = array( 'auto', 'cover', 'contain' );
			break;
		case 'main-background-repeat' :
		case 'footer-background-repeat' :
		case 'background-repeat' :
			$allowed_choices = array( 'no-repeat', 'repeat', 'repeat-x', 'repeat-y' );
			break;
		case 'main-background-position' :
		case 'footer-background-position' :
		case 'background-position' :
			$allowed_choices = array( 'left', 'center', 'right' );
			break;
		case 'background-attachment' :
			$allowed_choices = array( 'fixed', 'scroll' );
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

if ( ! function_exists( 'ttf_one_display_background' ) ) :
/**
 * Write the CSS to implement the custom background options.
 *
 * The background options that are built into WordPress core are output separately.
 *
 * @since  1.0.0
 *
 * @return void
 */
function ttf_one_display_background() {
	$background_image = get_theme_mod( 'background_image', ttf_one_get_default( 'background_image' ) );
	if ( ! empty( $background_image ) ) {
		// Get and escape the other properties
		$background_size = ttf_one_sanitize_choice( get_theme_mod( 'background_size', ttf_one_get_default( 'background_size' ) ), 'background-size' );

		// All variables are escaped at this point
		ttf_one_get_css()->add( array(
			'selectors' => array( 'body' ),
			'declarations' => array(
				'background-size' => $background_size
			)
		) );
	}
}
endif;

add_action( 'ttf_one_css', 'ttf_one_display_background' );

if ( ! function_exists( 'ttf_one_display_colors' ) ) :
/**
 * Write the CSS to implement the color options.
 *
 * @since  1.0.0
 *
 * @param  string    $css    The current CSS.
 * @return string            The modified CSS.
 */
function ttf_one_display_colors( $css ) {
	// Escape values
	$color_primary   = maybe_hash_hex_color( get_theme_mod( 'color-primary', ttf_one_get_default( 'color-primary' ) ) );
	$color_secondary = maybe_hash_hex_color( get_theme_mod( 'color-secondary', ttf_one_get_default( 'color-secondary' ) ) );
	$color_text      = maybe_hash_hex_color( get_theme_mod( 'color-text', ttf_one_get_default( 'color-text' ) ) );
	$color_detail    = maybe_hash_hex_color( get_theme_mod( 'color-detail', ttf_one_get_default( 'color-detail' ) ) );

	ttf_one_get_css()->add( array(
		'selectors' => array( 'a', 'button' ),
		'declarations' => array(
			'color' => $color_primary
		)
	) );

	ttf_one_get_css()->add( array(
		'selectors' => array( 'p' ),
		'declarations' => array(
			'color' => $color_text
		)
	) );
}
endif;

add_action( 'ttf_one_css', 'ttf_one_display_colors' );

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
	if ( false !== $logo_favicon ) : ?>
		<link rel="icon" href="<?php echo esc_url( $logo_favicon ); ?>" />
	<?php endif;

	$logo_apple_touch = get_theme_mod( 'logo-apple-touch', ttf_one_get_default( 'logo-apple-touch' ) );
	if ( false !== $logo_apple_touch ) : ?>
		<link rel="apple-touch-icon" href="<?php echo esc_url( $logo_apple_touch ); ?>" />
	<?php endif;
}
endif;

add_action( 'wp_head', 'ttf_one_display_favicons' );

if ( ! function_exists( 'ttf_one_display_subheader_styles' ) ) :
/**
 * Write the CSS to implement colors for the subheader.
 *
 * @since  1.0.0
 *
 * @return voice
 */
function ttf_one_display_subheader_styles() {
	// Escape values
	$background_color        = maybe_hash_hex_color( get_theme_mod( 'header-subheader-background-color', ttf_one_get_default( 'header-subheader-background-color' ) ) );
	$text_color              = maybe_hash_hex_color( get_theme_mod( 'header-subheader-text-color', ttf_one_get_default( 'header-subheader-text-color' ) ) );
	$border_color            = maybe_hash_hex_color( get_theme_mod( 'header-subheader-border-color', ttf_one_get_default( 'header-subheader-border-color' ) ) );
	$background_color_needed = ( ttf_one_get_default( 'header-subheader-background-color' ) !== $background_color );
	$text_color_needed       = ( ttf_one_get_default( 'header-subheader-text-color' ) !== $text_color );
	$border_color_needed     = ( ttf_one_get_default( 'header-subheader-border-color' ) !== $border_color );

	if ( $background_color_needed || $text_color_needed ) {
		$data = array(
			'selectors' => array( '.sub-header' ),
			'declarations' => array()
		);
		if ( $background_color_needed ) {
			$data['declarations']['background-color'] = $background_color;
		}
		if ( $text_color_needed ) {
			$data['declarations']['color'] = $text_color;
		}

		ttf_one_get_css()->add( $data );
	}

	if ( $border_color_needed ) {
		$data = array(
			'selectors' => array( '.sub-header', '.header-social-links li:first-of-type', '.header-social-links li a' ),
			'declarations' => array(
				'border-color' => $border_color
			)
		);

		ttf_one_get_css()->add( $data );
	}
}
endif;

add_action( 'ttf_one_css', 'ttf_one_display_subheader_styles' );

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

if ( ! function_exists( 'ttf_one_display_header_background' ) ) :
/**
 * Write the CSS to implement the background options for the site header.
 *
 * @since  1.0.0
 *
 * @return void
 */
function ttf_one_display_header_background() {
	$background_color = maybe_hash_hex_color( get_theme_mod( 'header-background-color', ttf_one_get_default( 'header-background-color' ) ) );
	$background_color_needed = ( ttf_one_get_default( 'header-background-color' ) !== $background_color );
	$background_image = get_theme_mod( 'header-background-image', ttf_one_get_default( 'header-background-image' ) );

	if ( $background_color_needed || ! empty( $background_image ) ) {
		$data = array(
			'selectors' => array( '.site-header-main' ),
			'declarations' => array()
		);

		if ( ! empty( $background_image ) ) {
			// Get and escape the other properties
			$background_size     = ttf_one_sanitize_choice( get_theme_mod( 'header-background-size', ttf_one_get_default( 'header-background-size' ) ), 'header-background-size' );
			$background_repeat   = ttf_one_sanitize_choice( get_theme_mod( 'header-background-repeat', ttf_one_get_default( 'header-background-repeat' ) ), 'header-background-repeat' );
			$background_position = ttf_one_sanitize_choice( get_theme_mod( 'header-background-position', ttf_one_get_default( 'header-background-position' ) ), 'header-background-position' );

			// Escape the image URL properly
			$background_image = addcslashes( esc_url_raw( $background_image ), '"' );

			// All variables are escaped at this point
			$background = array(
				'background-image' => 'url("' . $background_image . '")',
				'background-repeat' => $background_repeat,
				'background-size' => $background_size,
				'background-position' => $background_position . ' center'
			);
			$data['declarations'] = array_merge( $data['declarations'], $background );
		}

		if ( $background_color_needed ) {
			$data['declarations']['background-color'] = $background_color;
		}

		ttf_one_get_css()->add( $data );
	}
}
endif;

add_action( 'ttf_one_css', 'ttf_one_display_header_background' );

if ( ! function_exists( 'ttf_one_display_header_text_color' ) ) :
/**
 * Write the CSS to implement the text color for the header.
 *
 * @since  1.0.0
 *
 * @param  string    $css    The current CSS.
 * @return string            The modified CSS.
 */
function ttf_one_display_header_text_color( $css ) {
	$text_color = maybe_hash_hex_color( get_theme_mod( 'header-text-color', ttf_one_get_default( 'header-text-color' ) ) );

	if ( ttf_one_get_default( 'header-text-color' ) !== $text_color ) {
		$css .= '.site-header{color:' . $text_color . ';}';
	}

	return $css;
}
endif;

add_filter( 'ttf_one_css', 'ttf_one_display_header_text_color' );

if ( ! function_exists( 'ttf_one_display_main_background' ) ) :
/**
 * Write the CSS to implement the background options for the main content area.
 *
 * @since  1.0.0.
 *
 * @param  string    $css    The current CSS.
 * @return string            The modified CSS.
 */
function ttf_one_display_main_background( $css ) {
	$background_color = maybe_hash_hex_color( get_theme_mod( 'main-background-color', ttf_one_get_default( 'main-background-color' ) ) );

	$background_image = get_theme_mod( 'main-background-image', ttf_one_get_default( 'main-background-image' ) );
	if ( ! empty( $background_image ) ) {
		// Get and escape the other properties
		$background_size       = ttf_one_sanitize_choice( get_theme_mod( 'main-background-size', ttf_one_get_default( 'main-background-size' ) ), 'main-background-size' );
		$background_repeat     = ttf_one_sanitize_choice( get_theme_mod( 'main-background-repeat', ttf_one_get_default( 'main-background-repeat' ) ), 'main-background-repeat' );
		$background_position   = ttf_one_sanitize_choice( get_theme_mod( 'main-background-position', ttf_one_get_default( 'main-background-position' ) ), 'main-background-position' );

		// Escape the image URL properly
		$background_image = addcslashes( esc_url_raw( $background_image ), '"' );

		// All variables are escaped at this point
		$css .= '.site-content{background:' . $background_color . ' url(' . $background_image . ') ' . $background_repeat . ';background-size:' . $background_size . ';background-position:' . $background_position . ' center;}';
	} else {
		$css .= '.site-content{background-color:' . $background_color . ';}';
	}

	return $css;
}
endif;

add_filter( 'ttf_one_css', 'ttf_one_display_main_background' );

if ( ! function_exists( 'ttf_one_display_footer_background' ) ) :
/**
 * Write the CSS to implement the background options for the footer area.
 *
 * @since  1.0.0.
 *
 * @param  string    $css    The current CSS.
 * @return string            The modified CSS.
 */
function ttf_one_display_footer_background( $css ) {
	$background_color = maybe_hash_hex_color( get_theme_mod( 'footer-background-color', ttf_one_get_default( 'footer-background-color' ) ) );

	$background_image = get_theme_mod( 'footer-background-image', ttf_one_get_default( 'footer-background-image' ) );
	if ( ! empty( $background_image ) ) {
		// Get and escape the other properties
		$background_size       = ttf_one_sanitize_choice( get_theme_mod( 'footer-background-size', ttf_one_get_default( 'footer-background-size' ) ), 'footer-background-size' );
		$background_repeat     = ttf_one_sanitize_choice( get_theme_mod( 'footer-background-repeat', ttf_one_get_default( 'footer-background-repeat' ) ), 'footer-background-repeat' );
		$background_position   = ttf_one_sanitize_choice( get_theme_mod( 'footer-background-position', ttf_one_get_default( 'footer-background-position' ) ), 'footer-background-position' );

		// Escape the image URL properly
		$background_image = addcslashes( esc_url_raw( $background_image ), '"' );

		// All variables are escaped at this point
		$css .= '.site-footer{background:' . $background_color . ' url(' . $background_image . ') ' . $background_repeat . ';background-size:' . $background_size . ';background-position:' . $background_position . ' center;}';
	} else {
		$css .= '.site-footer{background-color:' . $background_color . ';}';
	}

	return $css;
}
endif;

add_filter( 'ttf_one_css', 'ttf_one_display_footer_background' );

if ( ! function_exists( 'ttf_one_display_footer_text_color' ) ) :
/**
 * Write the CSS to implement the text color for the footer.
 *
 * @since  1.0.0.
 *
 * @param  string    $css    The current CSS.
 * @return string            The modified CSS.
 */
function ttf_one_display_footer_text_color( $css ) {
	$text_color = maybe_hash_hex_color( get_theme_mod( 'footer-text-color', ttf_one_get_default( 'footer-text-color' ) ) );

	if ( ttf_one_get_default( 'footer-text-color' ) !== $text_color ) {
		$css .= '.site-footer{color:' . $text_color . ';}';
	}

	return $css;
}
endif;

add_filter( 'ttf_one_css', 'ttf_one_display_footer_text_color' );

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