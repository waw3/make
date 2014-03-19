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
			$allowed_choices = array( 'header-layout-1', 'header-layout-2' );
			break;
		case 'header-primary-nav-position' :
			$allowed_choices = array( 'left', 'right' );
			break;
		case 'footer-widget-areas' :
			$allowed_choices = array( '3', '1', '2', '0', '4' );
			break;
		case 'footer-layout' :
			$allowed_choices = array( 'footer-layout-1', 'footer-layout-2' );
			break;
	}

	if ( ! in_array( $value, $allowed_choices ) ) {
		$value = $allowed_choices[0];
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
 * @param  string    $css    The current CSS.
 * @return string            The modified CSS.
 */
function ttf_one_display_background( $css ) {
	$background_image = get_theme_mod( 'background_image', false );
	if ( false !== $background_image ) {
		// Get and escape the other properties
		$background_size = ttf_one_sanitize_choice( get_theme_mod( 'background_size', ttf_one_get_default( 'background_size' ) ), 'background-size' );

		// All variables are escaped at this point
		$css .= 'body{background-size:' . $background_size . ';}';
	}

	return $css;
}
endif;

add_filter( 'ttf_one_css', 'ttf_one_display_background' );

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
	$color_primary   = maybe_hash_hex_color( get_theme_mod( 'color-primary', ttf_one_get_default( 'color-primary' ) ) );
	$color_secondary = maybe_hash_hex_color( get_theme_mod( 'color-secondary', ttf_one_get_default( 'color-secondary' ) ) );
	$color_text      = maybe_hash_hex_color( get_theme_mod( 'color-text', ttf_one_get_default( 'color-text' ) ) );

	// All variables are escaped at this point
	$css .= 'a{color:' . $color_primary . ';}button{color:' . $color_primary . ';}p{color:' . $color_text . ';}';

	return $css;
}
endif;

add_filter( 'ttf_one_css', 'ttf_one_display_colors' );

if ( ! function_exists( 'ttf_one_display_favicons' ) ) :
/**
 * Write the favicons to the head to implement the options.
 *
 * @since  1.0.0
 *
 * @return void
 */
function ttf_one_display_favicons() {
	$logo_favicon = get_theme_mod( 'logo-favicon', false );
	if ( false !== $logo_favicon ) : ?>
		<link rel="icon" href="<?php echo esc_url( $logo_favicon ); ?>" />
	<?php endif;

	$logo_apple_touch = get_theme_mod( 'logo-apple-touch', false );
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
 * @param  string    $css    The current CSS.
 * @return string            The modified CSS.
 */
function ttf_one_display_subheader_styles( $css ) {
	$background_color        = maybe_hash_hex_color( get_theme_mod( 'header-subheader-background-color', ttf_one_get_default( 'header-subheader-background-color' ) ) );
	$text_color              = maybe_hash_hex_color( get_theme_mod( 'header-subheader-text-color', ttf_one_get_default( 'header-subheader-text-color' ) ) );
	$background_color_needed = ( ttf_one_get_default( 'header-subheader-background-color' ) !== $background_color );
	$text_color_needed       = ( ttf_one_get_default( 'header-subheader-text-color' ) !== $text_color );

	if ( $background_color_needed || $text_color_needed ) {
		$css .= '.sub-header{';

		if ( $background_color_needed ) {
			$css .= 'background-color:' . $background_color . ';';
		}

		if ( $text_color_needed ) {
			$css .= 'color:' . $text_color . ';';
		}

		$css .= '}';
	}

	return $css;
}
endif;

add_filter( 'ttf_one_css', 'ttf_one_display_subheader_styles' );

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
	$classes[] = get_theme_mod( 'header-layout', ttf_one_get_default( 'header-layout' ) );
	$classes[] = get_theme_mod( 'footer-layout', 'footer-layout-1' );
	if ( 'left' === get_theme_mod( 'header-primary-nav-position', ttf_one_get_default( 'header-primary-nav-position' ) ) ) {
		$classes[] = 'primary-nav-left';
	}
	return $classes;
}
endif;

add_filter( 'body_class', 'ttf_one_body_layout_classes' );

if ( ! class_exists( 'TTF_One_Logo' ) ) :
/**
 * class TTF_One_Logo
 *
 * A class that adds custom logo functionality.
 *
 * @since 1.0.0
 */
class TTF_One_Logo {

	/**
	 * The one instance of TTF_One_Logo
	 *
	 * @since 1.0.0
	 *
	 * @var TTF_One_Logo
	 */
	private static $instance;

	/**
	 * Stores the logo image, width, and height information.
	 *
	 * This var acts as a "run-time" cache. Since the functions in this class are called in different places throughout
	 * the page load, once the logo information is computed for the first time, it is cached to this variable.
	 * Subsequent requests for the information are pulled from the variable in memory instead of recomputing it.
	 *
	 * @since 1.0.0
	 *
	 * @var   array    Holds the image, width, and height information for the logos.
	 */
	var $logo_information = array();

	/**
	 * Stores whether or not a specified logo type is available.
	 *
	 * @since 1.0.0
	 *
	 * @var   array    Holds boolean values to indicate if the logo type is available.
	 */
	var $has_logo_by_type = array();

	/**
	 * Instantiate or return the one TTF_One_Logo instance.
	 *
	 * @since  1.0.0
	 *
	 * @return TTF_One_Logo
	 */
	public static function instance() {
		if ( is_null( self::$instance ) )
			self::$instance = new self();

		return self::$instance;
	}

	/**
	 * Initiate the actions.
	 *
	 * @since  1.0.0
	 *
	 * @return TTF_One_Logo
	 */
	public function __construct() {
		add_filter( 'ttf_one_css', array( $this, 'print_logo_css' ) );
	}

	/**
	 * Get the ID of an attachment from its image URL.
	 *
	 * @author  Taken from reverted change to WordPress core http://core.trac.wordpress.org/ticket/23831
	 * @since   1.0.0
	 *
	 * @param   string      $url    The path to an image.
	 * @return  int|bool            ID of the attachment or 0 on failure.
	 */
	function get_attachment_id_from_url( $url = '' ) {
		// If there is no url, return.
		if ( '' === $url ) {
			return false;
		}

		global $wpdb;

		// First try this
		if ( preg_match( '#\.[a-zA-Z0-9]+$#', $url ) ) {
			$id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' " . "AND guid = %s", esc_url_raw( $url ) ) );

			if ( ! empty( $id ) ) {
				return absint( $id );
			}
		}

		$upload_dir_paths = wp_upload_dir();
		$attachment_id = 0;

		// Then try this
		if ( false !== strpos( $url, $upload_dir_paths['baseurl'] ) ) {
			// If this is the URL of an auto-generated thumbnail, get the URL of the original image
			$url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $url );

			// Remove the upload path base directory from the attachment URL
			$url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $url );

			// Finally, run a custom database query to get the attachment ID from the modified attachment URL
			$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", esc_url_raw( $url ) ) );
		}

		return $attachment_id;
	}

	/**
	 * Get the dimensions of a logo image from cache or regenerate the values.
	 *
	 * @since  1.0.0
	 *
	 * @param  string    $url    The URL of the image in question.
	 * @return array             The dimensions array on success, and a blank array on failure.
	 */
	function get_logo_dimensions( $url ) {
		// Build the cache key
		$key = 'ttf-one-' . md5( 'logo-dimensions-' . $url . TTF_ONE_VERSION );

		// Pull from cache
		$dimensions = get_transient( $key );

		// If the value is not found in cache, regenerate
		if ( false === $dimensions ) {
			$dimensions = array();

			// Get the ID of the attachment
			$attachment_id = $this->get_attachment_id_from_url( $url );

			// Get the dimensions
			$info = wp_get_attachment_image_src( $attachment_id, 'full' );

			if ( false !== $info && isset( $info[1] ) && isset( $info[2] ) ) {
				// Package the data
				$dimensions = array(
					'width'  => $info[1],
					'height' => $info[2],
				);
			} else {
				// Get the image path from the URL
				$wp_upload_dir = wp_upload_dir();
				$path          = trailingslashit( $wp_upload_dir['basedir'] ) . get_post_meta( $attachment_id, '_wp_attached_file', true );

				// Sometimes, WordPress just doesn't have the metadata available. If not, get the image size
				if ( file_exists( $path ) ) {
					$getimagesize = getimagesize( $path );

					if ( false !== $getimagesize && isset( $getimagesize[0] ) && isset( $getimagesize[1] ) ) {
						$dimensions = array(
							'width'  => $getimagesize[0],
							'height' => $getimagesize[1],
						);
					}
				}
			}

			// Store the transient
			set_transient( $key, $dimensions, 86400 );
		}

		return $dimensions;
	}

	/**
	 * Determine if a custom logo should be displayed.
	 *
	 * @since  1.0.0
	 *
	 * @return bool    True if a logo should be displayed. False if a logo shouldn't be displayed.
	 */
	public function has_logo() {
		return ( $this->has_logo_by_type( 'logo-regular' ) || $this->has_logo_by_type( 'logo-retina' ) );
	}

	/**
	 * Determine if necessary information is available to show a particular logo.
	 *
	 * @since  1.0.0
	 *
	 * @param  string    $type    The type of logo to inspect for.
	 * @return bool               True if all information is available. False is something is missing.
	 */
	function has_logo_by_type( $type ) {
		// Clean the type value
		$type = sanitize_key( $type );

		// If the information is already set, return it from the instance cache
		if ( isset( $this->has_logo_by_type[ $type ] ) ) {
			return $this->has_logo_by_type[ $type ];
		}

		// Grab the logo information
		$information = $this->get_logo_information();

		// Set the default return value
		$return = false;

		// Verify that the logo type exists in the array
		if ( isset( $information[ $type ] ) ) {

			// Verify that the image is set and has a value
			if ( isset( $information[ $type ]['image'] ) && ! empty( $information[ $type ]['image'] ) ) {

				// Verify that the width is set and has a value
				if ( isset( $information[ $type ]['width'] ) && ! empty( $information[ $type ]['width'] ) ) {

					// Verify that the height is set and has a value
					if ( isset( $information[ $type ]['height'] ) && ! empty( $information[ $type ]['height'] ) ) {
						$return = true;
					}
				}
			}
		}

		// Cache to the instance var for future use
		$this->has_logo_by_type[ $type ] = $return;
		return $this->has_logo_by_type[ $type ];
	}

	/**
	 * Utility function for getting information about the theme logos.
	 *
	 * @since  1.0.0
	 *
	 * @return array    Array containing image file, width, and height for each logo.
	 */
	function get_logo_information() {
		// If the logo information is cached to an instance var, pull from there
		if ( ! empty( $this->logo_information ) ) {
			return $this->logo_information;
		}

		// Set the logo slugs
		$logos = array(
			'logo-regular',
			'logo-retina',
		);

		// For each logo slug, get the image, width and height
		foreach ( $logos as $logo ) {
			$this->logo_information[ $logo ]['image'] = get_theme_mod( $logo );

			// Set the defaults
			$this->logo_information[ $logo ]['width']  = '';
			$this->logo_information[ $logo ]['height'] = '';

			// If there is an image, get the dimensions
			if ( ! empty( $this->logo_information[ $logo ]['image'] ) ) {
				$dimensions = $this->get_logo_dimensions( $this->logo_information[ $logo ]['image'] );

				// Set the dimensions to the array if all information is present
				if ( ! empty( $dimensions ) && isset( $dimensions['width'] ) && isset( $dimensions['height'] ) ) {
					$this->logo_information[ $logo ]['width']  = $dimensions['width'];
					$this->logo_information[ $logo ]['height'] = $dimensions['height'];
				}
			}
		}

		// Allow logo settings to be overridden via filter
		$this->logo_information = apply_filters( 'ttf_one_custom_logo_information', $this->logo_information );

		return $this->logo_information;
	}

	/**
	 * Print CSS in the head for the logo.
	 *
	 * @since  1.0.0
	 *
	 * @param string $css
	 *
	 * @return string
	 */
	function print_logo_css( $css ) {
		$size = apply_filters( 'ttf_one_custom_logo_max_width', '960' );

		// Grab the logo information
		$info = $this->get_logo_information();

		// Both logo types are available
		if ( $this->has_logo_by_type( 'logo-regular' ) && $this->has_logo_by_type( 'logo-retina' ) ) {
			$final_dimensions = $this->adjust_dimensions( $info['logo-regular']['width'], $info['logo-regular']['height'], $size, false );
			ob_start(); ?>
			.custom-logo {
				background-image: url("<?php echo addcslashes( esc_url_raw( $info['logo-regular']['image'] ), '"' ); ?>");
				width: <?php echo absint( $final_dimensions['width'] ); ?>px;
			}
			.custom-logo a {
				padding-bottom: <?php echo absint( $final_dimensions['ratio'] ); ?>%;
			}
			@media
			(-webkit-min-device-pixel-ratio: 1.3),
			(-o-min-device-pixel-ratio: 2.6/2),
			(min--moz-device-pixel-ratio: 1.3),
			(min-device-pixel-ratio: 1.3),
			(min-resolution: 1.3dppx) {
				.custom-logo {
					background-image: url("<?php echo addcslashes( esc_url_raw( $info['logo-retina']['image'] ), '"' ); ?>");
				}
			}
			<?php
			$css .= ob_get_contents();
			ob_end_clean();
		}
		// Regular logo only
		else if ( $this->has_logo_by_type( 'logo-regular' ) ) {
			$final_dimensions = $this->adjust_dimensions( $info['logo-regular']['width'], $info['logo-regular']['height'], $size );
			ob_start(); ?>
			.custom-logo {
			background-image: url("<?php echo addcslashes( esc_url_raw( $info['logo-regular']['image'] ), '"' ); ?>");
			width: <?php echo absint( $final_dimensions['width'] ); ?>px;
			}
			.custom-logo a {
			padding-bottom: <?php echo absint( $final_dimensions['ratio'] ); ?>%;
			}
			<?php
			$css .= ob_get_contents();
			ob_end_clean();
		}
		// Retina logo only
		else if ( $this->has_logo_by_type( 'logo-retina' ) ) {
			$final_dimensions = $this->adjust_dimensions( $info['logo-retina']['width'], $info['logo-retina']['height'], $size, true );
			ob_start(); ?>
			.custom-logo {
				background-image: url("<?php echo addcslashes( esc_url_raw(  $info['logo-retina']['image'] ), '"' ); ?>");
				width: <?php echo absint( $final_dimensions['width'] ); ?>px;
			}
			.custom-logo a {
				padding-bottom: <?php echo absint( $final_dimensions['ratio'] ); ?>%;
			}
			<?php
			$css .= ob_get_contents();
			ob_end_clean();
		}

		return $css;
	}

	/**
	 * Scale the image to the width boundary.
	 *
	 * @since  1.0.0
	 *
	 * @param  int      $width             The image's width.
	 * @param  int      $height            The image's height.
	 * @param  int      $width_boundary    The maximum width for the image.
	 * @param  bool     $retina            Whether or not to divide the dimensions by 2.
	 * @return array                       Resulting height/width dimensions.
	 */
	function adjust_dimensions( $width, $height, $width_boundary, $retina = false ) {
		// Divide the dimensions by 2 for retina logos
		$divisor = ( true === $retina ) ? 2 : 1;
		$width   = $width / $divisor;
		$height  = $height / $divisor;

		// If width is wider than the boundary, apply the adjustment
		if ( $width > $width_boundary ) {
			$change_percentage = $width_boundary / $width;
			$width             = $width_boundary;
			$height            = $height * $change_percentage;
		}

		// Height / Width ratio
		$ratio = $height / $width * 100;

		// Arrange the resulting dimensions in an array
		return array(
			'width'  => $width,
			'height' => $height,
			'ratio'  => $ratio
		);
	}
} // end class
endif;

if ( ! function_exists( 'ttf_one_get_logo' ) ) :
/**
 * Return the one TTF_One_Logo object.
 *
 * @since  1.0.0
 *
 * @return TTF_One_Logo
 */
function ttf_one_get_logo() {
	return TTF_One_Logo::instance();
}
endif;

add_action( 'init', 'ttf_one_get_logo', 1 );

if ( ! function_exists( 'ttf_one_display_header_background' ) ) :
/**
 * Write the CSS to implement the background options for the site header.
 *
 * @since  1.0.0
 *
 * @param  string    $css    The current CSS.
 * @return string            The modified CSS.
 */
function ttf_one_display_header_background( $css ) {
	$background_color = maybe_hash_hex_color( get_theme_mod( 'header-background-color', ttf_one_get_default( 'header-background-color' ) ) );

	$background_image = get_theme_mod( 'header-background-image', false );
	if ( ! empty( $background_image ) ) {
		// Get and escape the other properties
		$background_size       = ttf_one_sanitize_choice( get_theme_mod( 'header-background-size', ttf_one_get_default( 'header-background-size' ) ), 'header-background-size' );
		$background_repeat     = ttf_one_sanitize_choice( get_theme_mod( 'header-background-repeat', ttf_one_get_default( 'header-background-repeat' ) ), 'header-background-repeat' );
		$background_position   = ttf_one_sanitize_choice( get_theme_mod( 'header-background-position', ttf_one_get_default( 'header-background-position' ) ), 'header-background-position' );

		// Escape the image URL properly
		$background_image = addcslashes( esc_url_raw( $background_image ), '"' );

		// All variables are escaped at this point
		$css .= '.site-header-main{background:' . $background_color . ' url(' . $background_image . ') ' . $background_repeat . ';background-size:' . $background_size . ';background-position:' . $background_position . ' center;}';
	} else {
		$css .= '.site-header-main{background-color:' . $background_color . ';}';
	}

	return $css;
}
endif;

add_filter( 'ttf_one_css', 'ttf_one_display_header_background' );

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

	$background_image = get_theme_mod( 'main-background-image', false );
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
	$background_color = maybe_hash_hex_color( get_theme_mod( 'footer-background-color', '#ffffff' ) );

	$background_image = get_theme_mod( 'footer-background-image', false );
	if ( ! empty( $background_image ) ) {
		// Get and escape the other properties
		$background_size       = ttf_one_sanitize_choice( get_theme_mod( 'footer-background-size', 'auto' ), 'footer-background-size' );
		$background_repeat     = ttf_one_sanitize_choice( get_theme_mod( 'footer-background-repeat', 'no-repeat' ), 'footer-background-repeat' );
		$background_position   = ttf_one_sanitize_choice( get_theme_mod( 'footer-background-position', 'center' ), 'footer-background-position' );

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
	$text_color = maybe_hash_hex_color( get_theme_mod( 'footer-text-color', '#171717' ) );

	if ( '#171717' !== $text_color ) {
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
			'title' => 'Youtube',
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
		$url = get_theme_mod( 'social-' . $service );
		if ( '' !== $url ) {
			$services_with_links[ $service ] = array(
				'title' => $details['title'],
				'url'   => $url,
				'class' => $details['class'],
			);
		}
	}

	// Special handling for RSS
	$hide_rss = (int) get_theme_mod( 'social-hide-rss', 0 );
	if ( 0 === $hide_rss ) {
		$custom_rss = get_theme_mod( 'social-custom-rss', '' );
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