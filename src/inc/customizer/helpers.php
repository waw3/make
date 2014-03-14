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
		case 'site-layout' :
			$allowed_choices = array( 'full-width', 'boxed' );
			break;
		case 'background-size' :
			$allowed_choices = array( 'auto', 'cover', 'contain' );
			break;
		case 'background-repeat' :
			$allowed_choices = array( 'no-repeat', 'repeat', 'repeat-x', 'repeat-y' );
			break;
		case 'background-position' :
			$allowed_choices = array( 'left', 'center', 'right' );
			break;
		case 'background-attachment' :
			$allowed_choices = array( 'fixed', 'scroll' );
			break;
		case 'font-site-title' :
		case 'font-header' :
		case 'font-body' :
			$fonts = ttf_one_get_google_fonts();
			$allowed_choices = array_keys( $fonts );
			break;
		case 'header-layout' :
			$allowed_choices = array( 'header-layout-1', 'header-layout-2', 'header-layout-3', 'header-layout-4' );
			break;
		case 'footer-layout' :
			$allowed_choices = array( 'footer-layout-1', 'footer-layout-2', 'footer-layout-3', 'footer-layout-4' );
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
		$background_size = ttf_one_sanitize_choice( get_theme_mod( 'background_size', 'auto' ), 'background-size' );

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
	$color_primary   = maybe_hash_hex_color( get_theme_mod( 'color-primary', '#f41811' ) );
	$color_secondary = maybe_hash_hex_color( get_theme_mod( 'color-secondary', '#eeeeee' ) );
	$color_text      = maybe_hash_hex_color( get_theme_mod( 'color-text', '#1b1d25' ) );

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

if ( ! function_exists( 'ttf_one_display_header_background' ) ) :
/**
 * Write the CSS to implement the header background option.
 *
 * @since  1.0.0
 *
 * @param  string    $css    The current CSS.
 * @return string            The modified CSS.
 */
function ttf_one_display_header_background( $css ) {
	$background_color = maybe_hash_hex_color( get_theme_mod( 'header-background-color', '#ffffff' ) );
	$css .= '.site-header{background-color:' . $background_color . ';}';

	return $css;
}
endif;

add_filter( 'ttf_one_css', 'ttf_one_display_header_background' );

if ( ! function_exists( 'ttf_one_display_footer_background' ) ) :
/**
 * Write the CSS to implement the footer background option.
 *
 * @since  1.0.0
 *
 * @param  string    $css    The current CSS.
 * @return string            The modified CSS.
 */
function ttf_one_display_footer_background( $css ) {
	$background_color = maybe_hash_hex_color( get_theme_mod( 'footer-background-color', '#ffffff' ) );
	$css .= '.site-footer{background-color:' . $background_color . ';}';

	return $css;
}
endif;

add_filter( 'ttf_one_css', 'ttf_one_display_footer_background' );

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
	$classes[] = get_theme_mod( 'site-layout', 'full-width' );
	$classes[] = get_theme_mod( 'header-layout', 'header-layout-1' );
	$classes[] = get_theme_mod( 'footer-layout', 'footer-layout-1' );
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

if ( ! function_exists( 'ttf_one_css_fonts' ) ) :
/**
 * Build the CSS rules for the custom fonts
 *
 * @since  1.0.0
 *
 * @param  string    $css    The current CSS.
 * @return string            The modified CSS.
 */
function ttf_one_css_fonts( $css ) {
	$font_site_title = get_theme_mod( 'font-site-title', 'Montserrat' );
	if ( false !== $font_site_title && array_key_exists( $font_site_title, ttf_one_get_google_fonts() ) ) {
		$css .= '.font-site-title,.site-title{font-family: ' . $font_site_title . '}';
	}

	$font_header = get_theme_mod( 'font-header', 'Montserrat' );
	if ( false !== $font_header && array_key_exists( $font_header, ttf_one_get_google_fonts() ) ) {
		$css .= '.font-header,h1,h2,h3,h4,h5,h6{font-family: ' . $font_header . '}';
	}

	$font_body = get_theme_mod( 'font-body', 'Open Sans' );
	if ( false !== $font_body && array_key_exists( $font_body, ttf_one_get_google_fonts() ) ) {
		$css .= '.font-body,body{font-family:' . $font_body . '}';
	}

	return $css;
}
endif;

if ( ! function_exists( 'ttf_one_get_google_font_request' ) ) :
/**
 * Build the HTTP request URL for Google fonts
 *
 * @since 1.0.0
 *
 * @param array $fonts The names of the fonts to include in the request.
 *
 * @return string
 */
function ttf_one_get_google_font_request( $fonts = array() ) {
	// Grab the theme options if no fonts are specified
	if ( empty( $fonts ) ) {
		$font_option_keys = array( 'font-site-title', 'font-header', 'font-body' );
		foreach ( $font_option_keys as $key ) {
			$fonts[] = get_theme_mod( $key, 'Open Sans' );
		}
	}

	// De-dupe the fonts
	$fonts = array_unique( $fonts );

	$allowed_fonts = ttf_one_get_google_fonts();
	$family = array();

	// Validate each font and convert to URL format
	foreach ( (array) $fonts as $font ) {
		$font = trim( $font );
		if ( in_array( $font, array_keys( $allowed_fonts ) ) ) {
			$family[] = str_replace( ' ', '+', $font );
		}
	}

	$request = '';

	// Convert from array to string
	if ( ! empty( $family ) ) {
		$request = '//fonts.googleapis.com/css?family=' . implode( '|', $family );
	}

	return esc_url( $request );
}
endif;

if ( ! function_exists( 'ttf_one_get_google_fonts' ) ) :
/**
 * Return an array of all available Google Fonts.
 *
 * @since  1.0.0
 *
 * @return array    All Google Fonts.
 */
function ttf_one_get_google_fonts() {
	return array(
		'ABeeZee'                  => 'ABeeZee',
		'Abel'                     => 'Abel',
		'Abril Fatface'            => 'Abril Fatface',
		'Aclonica'                 => 'Aclonica',
		'Acme'                     => 'Acme',
		'Actor'                    => 'Actor',
		'Adamina'                  => 'Adamina',
		'Advent Pro'               => 'Advent Pro',
		'Aguafina Script'          => 'Aguafina Script',
		'Akronim'                  => 'Akronim',
		'Aladin'                   => 'Aladin',
		'Aldrich'                  => 'Aldrich',
		'Alef'                     => 'Alef',
		'Alegreya'                 => 'Alegreya',
		'Alegreya SC'              => 'Alegreya SC',
		'Alegreya Sans'            => 'Alegreya Sans',
		'Alegreya Sans SC'         => 'Alegreya Sans SC',
		'Alex Brush'               => 'Alex Brush',
		'Alfa Slab One'            => 'Alfa Slab One',
		'Alice'                    => 'Alice',
		'Alike'                    => 'Alike',
		'Alike Angular'            => 'Alike Angular',
		'Allan'                    => 'Allan',
		'Allerta'                  => 'Allerta',
		'Allerta Stencil'          => 'Allerta Stencil',
		'Allura'                   => 'Allura',
		'Almendra'                 => 'Almendra',
		'Almendra Display'         => 'Almendra Display',
		'Almendra SC'              => 'Almendra SC',
		'Amarante'                 => 'Amarante',
		'Amaranth'                 => 'Amaranth',
		'Amatic SC'                => 'Amatic SC',
		'Amethysta'                => 'Amethysta',
		'Anaheim'                  => 'Anaheim',
		'Andada'                   => 'Andada',
		'Andika'                   => 'Andika',
		'Angkor'                   => 'Angkor',
		'Annie Use Your Telescope' => 'Annie Use Your Telescope',
		'Anonymous Pro'            => 'Anonymous Pro',
		'Antic'                    => 'Antic',
		'Antic Didone'             => 'Antic Didone',
		'Antic Slab'               => 'Antic Slab',
		'Anton'                    => 'Anton',
		'Arapey'                   => 'Arapey',
		'Arbutus'                  => 'Arbutus',
		'Arbutus Slab'             => 'Arbutus Slab',
		'Architects Daughter'      => 'Architects Daughter',
		'Archivo Black'            => 'Archivo Black',
		'Archivo Narrow'           => 'Archivo Narrow',
		'Arimo'                    => 'Arimo',
		'Arizonia'                 => 'Arizonia',
		'Armata'                   => 'Armata',
		'Artifika'                 => 'Artifika',
		'Arvo'                     => 'Arvo',
		'Asap'                     => 'Asap',
		'Asset'                    => 'Asset',
		'Astloch'                  => 'Astloch',
		'Asul'                     => 'Asul',
		'Atomic Age'               => 'Atomic Age',
		'Aubrey'                   => 'Aubrey',
		'Audiowide'                => 'Audiowide',
		'Autour One'               => 'Autour One',
		'Average'                  => 'Average',
		'Average Sans'             => 'Average Sans',
		'Averia Gruesa Libre'      => 'Averia Gruesa Libre',
		'Averia Libre'             => 'Averia Libre',
		'Averia Sans Libre'        => 'Averia Sans Libre',
		'Averia Serif Libre'       => 'Averia Serif Libre',
		'Bad Script'               => 'Bad Script',
		'Balthazar'                => 'Balthazar',
		'Bangers'                  => 'Bangers',
		'Basic'                    => 'Basic',
		'Battambang'               => 'Battambang',
		'Baumans'                  => 'Baumans',
		'Bayon'                    => 'Bayon',
		'Belgrano'                 => 'Belgrano',
		'Belleza'                  => 'Belleza',
		'BenchNine'                => 'BenchNine',
		'Bentham'                  => 'Bentham',
		'Berkshire Swash'          => 'Berkshire Swash',
		'Bevan'                    => 'Bevan',
		'Bigelow Rules'            => 'Bigelow Rules',
		'Bigshot One'              => 'Bigshot One',
		'Bilbo'                    => 'Bilbo',
		'Bilbo Swash Caps'         => 'Bilbo Swash Caps',
		'Bitter'                   => 'Bitter',
		'Black Ops One'            => 'Black Ops One',
		'Bokor'                    => 'Bokor',
		'Bonbon'                   => 'Bonbon',
		'Boogaloo'                 => 'Boogaloo',
		'Bowlby One'               => 'Bowlby One',
		'Bowlby One SC'            => 'Bowlby One SC',
		'Brawler'                  => 'Brawler',
		'Bree Serif'               => 'Bree Serif',
		'Bubblegum Sans'           => 'Bubblegum Sans',
		'Bubbler One'              => 'Bubbler One',
		'Buda'                     => 'Buda',
		'Buenard'                  => 'Buenard',
		'Butcherman'               => 'Butcherman',
		'Butterfly Kids'           => 'Butterfly Kids',
		'Cabin'                    => 'Cabin',
		'Cabin Condensed'          => 'Cabin Condensed',
		'Cabin Sketch'             => 'Cabin Sketch',
		'Caesar Dressing'          => 'Caesar Dressing',
		'Cagliostro'               => 'Cagliostro',
		'Calligraffitti'           => 'Calligraffitti',
		'Cambo'                    => 'Cambo',
		'Candal'                   => 'Candal',
		'Cantarell'                => 'Cantarell',
		'Cantata One'              => 'Cantata One',
		'Cantora One'              => 'Cantora One',
		'Capriola'                 => 'Capriola',
		'Cardo'                    => 'Cardo',
		'Carme'                    => 'Carme',
		'Carrois Gothic'           => 'Carrois Gothic',
		'Carrois Gothic SC'        => 'Carrois Gothic SC',
		'Carter One'               => 'Carter One',
		'Caudex'                   => 'Caudex',
		'Cedarville Cursive'       => 'Cedarville Cursive',
		'Ceviche One'              => 'Ceviche One',
		'Changa One'               => 'Changa One',
		'Chango'                   => 'Chango',
		'Chau Philomene One'       => 'Chau Philomene One',
		'Chela One'                => 'Chela One',
		'Chelsea Market'           => 'Chelsea Market',
		'Chenla'                   => 'Chenla',
		'Cherry Cream Soda'        => 'Cherry Cream Soda',
		'Cherry Swash'             => 'Cherry Swash',
		'Chewy'                    => 'Chewy',
		'Chicle'                   => 'Chicle',
		'Chivo'                    => 'Chivo',
		'Cinzel'                   => 'Cinzel',
		'Cinzel Decorative'        => 'Cinzel Decorative',
		'Clicker Script'           => 'Clicker Script',
		'Coda'                     => 'Coda',
		'Coda Caption'             => 'Coda Caption',
		'Codystar'                 => 'Codystar',
		'Combo'                    => 'Combo',
		'Comfortaa'                => 'Comfortaa',
		'Coming Soon'              => 'Coming Soon',
		'Concert One'              => 'Concert One',
		'Condiment'                => 'Condiment',
		'Content'                  => 'Content',
		'Contrail One'             => 'Contrail One',
		'Convergence'              => 'Convergence',
		'Cookie'                   => 'Cookie',
		'Copse'                    => 'Copse',
		'Corben'                   => 'Corben',
		'Courgette'                => 'Courgette',
		'Cousine'                  => 'Cousine',
		'Coustard'                 => 'Coustard',
		'Covered By Your Grace'    => 'Covered By Your Grace',
		'Crafty Girls'             => 'Crafty Girls',
		'Creepster'                => 'Creepster',
		'Crete Round'              => 'Crete Round',
		'Crimson Text'             => 'Crimson Text',
		'Croissant One'            => 'Croissant One',
		'Crushed'                  => 'Crushed',
		'Cuprum'                   => 'Cuprum',
		'Cutive'                   => 'Cutive',
		'Cutive Mono'              => 'Cutive Mono',
		'Damion'                   => 'Damion',
		'Dancing Script'           => 'Dancing Script',
		'Dangrek'                  => 'Dangrek',
		'Dawning of a New Day'     => 'Dawning of a New Day',
		'Days One'                 => 'Days One',
		'Delius'                   => 'Delius',
		'Delius Swash Caps'        => 'Delius Swash Caps',
		'Delius Unicase'           => 'Delius Unicase',
		'Della Respira'            => 'Della Respira',
		'Denk One'                 => 'Denk One',
		'Devonshire'               => 'Devonshire',
		'Didact Gothic'            => 'Didact Gothic',
		'Diplomata'                => 'Diplomata',
		'Diplomata SC'             => 'Diplomata SC',
		'Domine'                   => 'Domine',
		'Donegal One'              => 'Donegal One',
		'Doppio One'               => 'Doppio One',
		'Dorsa'                    => 'Dorsa',
		'Dosis'                    => 'Dosis',
		'Dr Sugiyama'              => 'Dr Sugiyama',
		'Droid Sans'               => 'Droid Sans',
		'Droid Sans Mono'          => 'Droid Sans Mono',
		'Droid Serif'              => 'Droid Serif',
		'Duru Sans'                => 'Duru Sans',
		'Dynalight'                => 'Dynalight',
		'EB Garamond'              => 'EB Garamond',
		'Eagle Lake'               => 'Eagle Lake',
		'Eater'                    => 'Eater',
		'Economica'                => 'Economica',
		'Electrolize'              => 'Electrolize',
		'Elsie'                    => 'Elsie',
		'Elsie Swash Caps'         => 'Elsie Swash Caps',
		'Emblema One'              => 'Emblema One',
		'Emilys Candy'             => 'Emilys Candy',
		'Engagement'               => 'Engagement',
		'Englebert'                => 'Englebert',
		'Enriqueta'                => 'Enriqueta',
		'Erica One'                => 'Erica One',
		'Esteban'                  => 'Esteban',
		'Euphoria Script'          => 'Euphoria Script',
		'Ewert'                    => 'Ewert',
		'Exo'                      => 'Exo',
		'Exo 2'                    => 'Exo 2',
		'Expletus Sans'            => 'Expletus Sans',
		'Fanwood Text'             => 'Fanwood Text',
		'Fascinate'                => 'Fascinate',
		'Fascinate Inline'         => 'Fascinate Inline',
		'Faster One'               => 'Faster One',
		'Fasthand'                 => 'Fasthand',
		'Fauna One'                => 'Fauna One',
		'Federant'                 => 'Federant',
		'Federo'                   => 'Federo',
		'Felipa'                   => 'Felipa',
		'Fenix'                    => 'Fenix',
		'Finger Paint'             => 'Finger Paint',
		'Fjalla One'               => 'Fjalla One',
		'Fjord One'                => 'Fjord One',
		'Flamenco'                 => 'Flamenco',
		'Flavors'                  => 'Flavors',
		'Fondamento'               => 'Fondamento',
		'Fontdiner Swanky'         => 'Fontdiner Swanky',
		'Forum'                    => 'Forum',
		'Francois One'             => 'Francois One',
		'Freckle Face'             => 'Freckle Face',
		'Fredericka the Great'     => 'Fredericka the Great',
		'Fredoka One'              => 'Fredoka One',
		'Freehand'                 => 'Freehand',
		'Fresca'                   => 'Fresca',
		'Frijole'                  => 'Frijole',
		'Fruktur'                  => 'Fruktur',
		'Fugaz One'                => 'Fugaz One',
		'GFS Didot'                => 'GFS Didot',
		'GFS Neohellenic'          => 'GFS Neohellenic',
		'Gabriela'                 => 'Gabriela',
		'Gafata'                   => 'Gafata',
		'Galdeano'                 => 'Galdeano',
		'Galindo'                  => 'Galindo',
		'Gentium Basic'            => 'Gentium Basic',
		'Gentium Book Basic'       => 'Gentium Book Basic',
		'Geo'                      => 'Geo',
		'Geostar'                  => 'Geostar',
		'Geostar Fill'             => 'Geostar Fill',
		'Germania One'             => 'Germania One',
		'Gilda Display'            => 'Gilda Display',
		'Give You Glory'           => 'Give You Glory',
		'Glass Antiqua'            => 'Glass Antiqua',
		'Glegoo'                   => 'Glegoo',
		'Gloria Hallelujah'        => 'Gloria Hallelujah',
		'Goblin One'               => 'Goblin One',
		'Gochi Hand'               => 'Gochi Hand',
		'Gorditas'                 => 'Gorditas',
		'Goudy Bookletter 1911'    => 'Goudy Bookletter 1911',
		'Graduate'                 => 'Graduate',
		'Grand Hotel'              => 'Grand Hotel',
		'Gravitas One'             => 'Gravitas One',
		'Great Vibes'              => 'Great Vibes',
		'Griffy'                   => 'Griffy',
		'Gruppo'                   => 'Gruppo',
		'Gudea'                    => 'Gudea',
		'Habibi'                   => 'Habibi',
		'Hammersmith One'          => 'Hammersmith One',
		'Hanalei'                  => 'Hanalei',
		'Hanalei Fill'             => 'Hanalei Fill',
		'Handlee'                  => 'Handlee',
		'Hanuman'                  => 'Hanuman',
		'Happy Monkey'             => 'Happy Monkey',
		'Headland One'             => 'Headland One',
		'Henny Penny'              => 'Henny Penny',
		'Herr Von Muellerhoff'     => 'Herr Von Muellerhoff',
		'Holtwood One SC'          => 'Holtwood One SC',
		'Homemade Apple'           => 'Homemade Apple',
		'Homenaje'                 => 'Homenaje',
		'IM Fell DW Pica'          => 'IM Fell DW Pica',
		'IM Fell DW Pica SC'       => 'IM Fell DW Pica SC',
		'IM Fell Double Pica'      => 'IM Fell Double Pica',
		'IM Fell Double Pica SC'   => 'IM Fell Double Pica SC',
		'IM Fell English'          => 'IM Fell English',
		'IM Fell English SC'       => 'IM Fell English SC',
		'IM Fell French Canon'     => 'IM Fell French Canon',
		'IM Fell French Canon SC'  => 'IM Fell French Canon SC',
		'IM Fell Great Primer'     => 'IM Fell Great Primer',
		'IM Fell Great Primer SC'  => 'IM Fell Great Primer SC',
		'Iceberg'                  => 'Iceberg',
		'Iceland'                  => 'Iceland',
		'Imprima'                  => 'Imprima',
		'Inconsolata'              => 'Inconsolata',
		'Inder'                    => 'Inder',
		'Indie Flower'             => 'Indie Flower',
		'Inika'                    => 'Inika',
		'Irish Grover'             => 'Irish Grover',
		'Istok Web'                => 'Istok Web',
		'Italiana'                 => 'Italiana',
		'Italianno'                => 'Italianno',
		'Jacques Francois'         => 'Jacques Francois',
		'Jacques Francois Shadow'  => 'Jacques Francois Shadow',
		'Jim Nightshade'           => 'Jim Nightshade',
		'Jockey One'               => 'Jockey One',
		'Jolly Lodger'             => 'Jolly Lodger',
		'Josefin Sans'             => 'Josefin Sans',
		'Josefin Slab'             => 'Josefin Slab',
		'Joti One'                 => 'Joti One',
		'Judson'                   => 'Judson',
		'Julee'                    => 'Julee',
		'Julius Sans One'          => 'Julius Sans One',
		'Junge'                    => 'Junge',
		'Jura'                     => 'Jura',
		'Just Another Hand'        => 'Just Another Hand',
		'Just Me Again Down Here'  => 'Just Me Again Down Here',
		'Kameron'                  => 'Kameron',
		'Kantumruy'                => 'Kantumruy',
		'Karla'                    => 'Karla',
		'Kaushan Script'           => 'Kaushan Script',
		'Kavoon'                   => 'Kavoon',
		'Kdam Thmor'               => 'Kdam Thmor',
		'Keania One'               => 'Keania One',
		'Kelly Slab'               => 'Kelly Slab',
		'Kenia'                    => 'Kenia',
		'Khmer'                    => 'Khmer',
		'Kite One'                 => 'Kite One',
		'Knewave'                  => 'Knewave',
		'Kotta One'                => 'Kotta One',
		'Koulen'                   => 'Koulen',
		'Kranky'                   => 'Kranky',
		'Kreon'                    => 'Kreon',
		'Kristi'                   => 'Kristi',
		'Krona One'                => 'Krona One',
		'La Belle Aurore'          => 'La Belle Aurore',
		'Lancelot'                 => 'Lancelot',
		'Lato'                     => 'Lato',
		'League Script'            => 'League Script',
		'Leckerli One'             => 'Leckerli One',
		'Ledger'                   => 'Ledger',
		'Lekton'                   => 'Lekton',
		'Lemon'                    => 'Lemon',
		'Libre Baskerville'        => 'Libre Baskerville',
		'Life Savers'              => 'Life Savers',
		'Lilita One'               => 'Lilita One',
		'Lily Script One'          => 'Lily Script One',
		'Limelight'                => 'Limelight',
		'Linden Hill'              => 'Linden Hill',
		'Lobster'                  => 'Lobster',
		'Lobster Two'              => 'Lobster Two',
		'Londrina Outline'         => 'Londrina Outline',
		'Londrina Shadow'          => 'Londrina Shadow',
		'Londrina Sketch'          => 'Londrina Sketch',
		'Londrina Solid'           => 'Londrina Solid',
		'Lora'                     => 'Lora',
		'Love Ya Like A Sister'    => 'Love Ya Like A Sister',
		'Loved by the King'        => 'Loved by the King',
		'Lovers Quarrel'           => 'Lovers Quarrel',
		'Luckiest Guy'             => 'Luckiest Guy',
		'Lusitana'                 => 'Lusitana',
		'Lustria'                  => 'Lustria',
		'Macondo'                  => 'Macondo',
		'Macondo Swash Caps'       => 'Macondo Swash Caps',
		'Magra'                    => 'Magra',
		'Maiden Orange'            => 'Maiden Orange',
		'Mako'                     => 'Mako',
		'Marcellus'                => 'Marcellus',
		'Marcellus SC'             => 'Marcellus SC',
		'Marck Script'             => 'Marck Script',
		'Margarine'                => 'Margarine',
		'Marko One'                => 'Marko One',
		'Marmelad'                 => 'Marmelad',
		'Marvel'                   => 'Marvel',
		'Mate'                     => 'Mate',
		'Mate SC'                  => 'Mate SC',
		'Maven Pro'                => 'Maven Pro',
		'McLaren'                  => 'McLaren',
		'Meddon'                   => 'Meddon',
		'MedievalSharp'            => 'MedievalSharp',
		'Medula One'               => 'Medula One',
		'Megrim'                   => 'Megrim',
		'Meie Script'              => 'Meie Script',
		'Merienda'                 => 'Merienda',
		'Merienda One'             => 'Merienda One',
		'Merriweather'             => 'Merriweather',
		'Merriweather Sans'        => 'Merriweather Sans',
		'Metal'                    => 'Metal',
		'Metal Mania'              => 'Metal Mania',
		'Metamorphous'             => 'Metamorphous',
		'Metrophobic'              => 'Metrophobic',
		'Michroma'                 => 'Michroma',
		'Milonga'                  => 'Milonga',
		'Miltonian'                => 'Miltonian',
		'Miltonian Tattoo'         => 'Miltonian Tattoo',
		'Miniver'                  => 'Miniver',
		'Miss Fajardose'           => 'Miss Fajardose',
		'Modern Antiqua'           => 'Modern Antiqua',
		'Molengo'                  => 'Molengo',
		'Molle'                    => 'Molle',
		'Monda'                    => 'Monda',
		'Monofett'                 => 'Monofett',
		'Monoton'                  => 'Monoton',
		'Monsieur La Doulaise'     => 'Monsieur La Doulaise',
		'Montaga'                  => 'Montaga',
		'Montez'                   => 'Montez',
		'Montserrat'               => 'Montserrat',
		'Montserrat Alternates'    => 'Montserrat Alternates',
		'Montserrat Subrayada'     => 'Montserrat Subrayada',
		'Moul'                     => 'Moul',
		'Moulpali'                 => 'Moulpali',
		'Mountains of Christmas'   => 'Mountains of Christmas',
		'Mouse Memoirs'            => 'Mouse Memoirs',
		'Mr Bedfort'               => 'Mr Bedfort',
		'Mr Dafoe'                 => 'Mr Dafoe',
		'Mr De Haviland'           => 'Mr De Haviland',
		'Mrs Saint Delafield'      => 'Mrs Saint Delafield',
		'Mrs Sheppards'            => 'Mrs Sheppards',
		'Muli'                     => 'Muli',
		'Mystery Quest'            => 'Mystery Quest',
		'Neucha'                   => 'Neucha',
		'Neuton'                   => 'Neuton',
		'New Rocker'               => 'New Rocker',
		'News Cycle'               => 'News Cycle',
		'Niconne'                  => 'Niconne',
		'Nixie One'                => 'Nixie One',
		'Nobile'                   => 'Nobile',
		'Nokora'                   => 'Nokora',
		'Norican'                  => 'Norican',
		'Nosifer'                  => 'Nosifer',
		'Nothing You Could Do'     => 'Nothing You Could Do',
		'Noticia Text'             => 'Noticia Text',
		'Noto Sans'                => 'Noto Sans',
		'Noto Serif'               => 'Noto Serif',
		'Nova Cut'                 => 'Nova Cut',
		'Nova Flat'                => 'Nova Flat',
		'Nova Mono'                => 'Nova Mono',
		'Nova Oval'                => 'Nova Oval',
		'Nova Round'               => 'Nova Round',
		'Nova Script'              => 'Nova Script',
		'Nova Slim'                => 'Nova Slim',
		'Nova Square'              => 'Nova Square',
		'Numans'                   => 'Numans',
		'Nunito'                   => 'Nunito',
		'Odor Mean Chey'           => 'Odor Mean Chey',
		'Offside'                  => 'Offside',
		'Old Standard TT'          => 'Old Standard TT',
		'Oldenburg'                => 'Oldenburg',
		'Oleo Script'              => 'Oleo Script',
		'Oleo Script Swash Caps'   => 'Oleo Script Swash Caps',
		'Open Sans'                => 'Open Sans',
		'Open Sans Condensed'      => 'Open Sans Condensed',
		'Oranienbaum'              => 'Oranienbaum',
		'Orbitron'                 => 'Orbitron',
		'Oregano'                  => 'Oregano',
		'Orienta'                  => 'Orienta',
		'Original Surfer'          => 'Original Surfer',
		'Oswald'                   => 'Oswald',
		'Over the Rainbow'         => 'Over the Rainbow',
		'Overlock'                 => 'Overlock',
		'Overlock SC'              => 'Overlock SC',
		'Ovo'                      => 'Ovo',
		'Oxygen'                   => 'Oxygen',
		'Oxygen Mono'              => 'Oxygen Mono',
		'PT Mono'                  => 'PT Mono',
		'PT Sans'                  => 'PT Sans',
		'PT Sans Caption'          => 'PT Sans Caption',
		'PT Sans Narrow'           => 'PT Sans Narrow',
		'PT Serif'                 => 'PT Serif',
		'PT Serif Caption'         => 'PT Serif Caption',
		'Pacifico'                 => 'Pacifico',
		'Paprika'                  => 'Paprika',
		'Parisienne'               => 'Parisienne',
		'Passero One'              => 'Passero One',
		'Passion One'              => 'Passion One',
		'Pathway Gothic One'       => 'Pathway Gothic One',
		'Patrick Hand'             => 'Patrick Hand',
		'Patrick Hand SC'          => 'Patrick Hand SC',
		'Patua One'                => 'Patua One',
		'Paytone One'              => 'Paytone One',
		'Peralta'                  => 'Peralta',
		'Permanent Marker'         => 'Permanent Marker',
		'Petit Formal Script'      => 'Petit Formal Script',
		'Petrona'                  => 'Petrona',
		'Philosopher'              => 'Philosopher',
		'Piedra'                   => 'Piedra',
		'Pinyon Script'            => 'Pinyon Script',
		'Pirata One'               => 'Pirata One',
		'Plaster'                  => 'Plaster',
		'Play'                     => 'Play',
		'Playball'                 => 'Playball',
		'Playfair Display'         => 'Playfair Display',
		'Playfair Display SC'      => 'Playfair Display SC',
		'Podkova'                  => 'Podkova',
		'Poiret One'               => 'Poiret One',
		'Poller One'               => 'Poller One',
		'Poly'                     => 'Poly',
		'Pompiere'                 => 'Pompiere',
		'Pontano Sans'             => 'Pontano Sans',
		'Port Lligat Sans'         => 'Port Lligat Sans',
		'Port Lligat Slab'         => 'Port Lligat Slab',
		'Prata'                    => 'Prata',
		'Preahvihear'              => 'Preahvihear',
		'Press Start 2P'           => 'Press Start 2P',
		'Princess Sofia'           => 'Princess Sofia',
		'Prociono'                 => 'Prociono',
		'Prosto One'               => 'Prosto One',
		'Puritan'                  => 'Puritan',
		'Purple Purse'             => 'Purple Purse',
		'Quando'                   => 'Quando',
		'Quantico'                 => 'Quantico',
		'Quattrocento'             => 'Quattrocento',
		'Quattrocento Sans'        => 'Quattrocento Sans',
		'Questrial'                => 'Questrial',
		'Quicksand'                => 'Quicksand',
		'Quintessential'           => 'Quintessential',
		'Qwigley'                  => 'Qwigley',
		'Racing Sans One'          => 'Racing Sans One',
		'Radley'                   => 'Radley',
		'Raleway'                  => 'Raleway',
		'Raleway Dots'             => 'Raleway Dots',
		'Rambla'                   => 'Rambla',
		'Rammetto One'             => 'Rammetto One',
		'Ranchers'                 => 'Ranchers',
		'Rancho'                   => 'Rancho',
		'Rationale'                => 'Rationale',
		'Redressed'                => 'Redressed',
		'Reenie Beanie'            => 'Reenie Beanie',
		'Revalia'                  => 'Revalia',
		'Ribeye'                   => 'Ribeye',
		'Ribeye Marrow'            => 'Ribeye Marrow',
		'Righteous'                => 'Righteous',
		'Risque'                   => 'Risque',
		'Roboto'                   => 'Roboto',
		'Roboto Condensed'         => 'Roboto Condensed',
		'Roboto Slab'              => 'Roboto Slab',
		'Rochester'                => 'Rochester',
		'Rock Salt'                => 'Rock Salt',
		'Rokkitt'                  => 'Rokkitt',
		'Romanesco'                => 'Romanesco',
		'Ropa Sans'                => 'Ropa Sans',
		'Rosario'                  => 'Rosario',
		'Rosarivo'                 => 'Rosarivo',
		'Rouge Script'             => 'Rouge Script',
		'Ruda'                     => 'Ruda',
		'Rufina'                   => 'Rufina',
		'Ruge Boogie'              => 'Ruge Boogie',
		'Ruluko'                   => 'Ruluko',
		'Rum Raisin'               => 'Rum Raisin',
		'Ruslan Display'           => 'Ruslan Display',
		'Russo One'                => 'Russo One',
		'Ruthie'                   => 'Ruthie',
		'Rye'                      => 'Rye',
		'Sacramento'               => 'Sacramento',
		'Sail'                     => 'Sail',
		'Salsa'                    => 'Salsa',
		'Sanchez'                  => 'Sanchez',
		'Sancreek'                 => 'Sancreek',
		'Sansita One'              => 'Sansita One',
		'Sarina'                   => 'Sarina',
		'Satisfy'                  => 'Satisfy',
		'Scada'                    => 'Scada',
		'Schoolbell'               => 'Schoolbell',
		'Seaweed Script'           => 'Seaweed Script',
		'Sevillana'                => 'Sevillana',
		'Seymour One'              => 'Seymour One',
		'Shadows Into Light'       => 'Shadows Into Light',
		'Shadows Into Light Two'   => 'Shadows Into Light Two',
		'Shanti'                   => 'Shanti',
		'Share'                    => 'Share',
		'Share Tech'               => 'Share Tech',
		'Share Tech Mono'          => 'Share Tech Mono',
		'Shojumaru'                => 'Shojumaru',
		'Short Stack'              => 'Short Stack',
		'Siemreap'                 => 'Siemreap',
		'Sigmar One'               => 'Sigmar One',
		'Signika'                  => 'Signika',
		'Signika Negative'         => 'Signika Negative',
		'Simonetta'                => 'Simonetta',
		'Sintony'                  => 'Sintony',
		'Sirin Stencil'            => 'Sirin Stencil',
		'Six Caps'                 => 'Six Caps',
		'Skranji'                  => 'Skranji',
		'Slackey'                  => 'Slackey',
		'Smokum'                   => 'Smokum',
		'Smythe'                   => 'Smythe',
		'Sniglet'                  => 'Sniglet',
		'Snippet'                  => 'Snippet',
		'Snowburst One'            => 'Snowburst One',
		'Sofadi One'               => 'Sofadi One',
		'Sofia'                    => 'Sofia',
		'Sonsie One'               => 'Sonsie One',
		'Sorts Mill Goudy'         => 'Sorts Mill Goudy',
		'Source Code Pro'          => 'Source Code Pro',
		'Source Sans Pro'          => 'Source Sans Pro',
		'Special Elite'            => 'Special Elite',
		'Spicy Rice'               => 'Spicy Rice',
		'Spinnaker'                => 'Spinnaker',
		'Spirax'                   => 'Spirax',
		'Squada One'               => 'Squada One',
		'Stalemate'                => 'Stalemate',
		'Stalinist One'            => 'Stalinist One',
		'Stardos Stencil'          => 'Stardos Stencil',
		'Stint Ultra Condensed'    => 'Stint Ultra Condensed',
		'Stint Ultra Expanded'     => 'Stint Ultra Expanded',
		'Stoke'                    => 'Stoke',
		'Strait'                   => 'Strait',
		'Sue Ellen Francisco'      => 'Sue Ellen Francisco',
		'Sunshiney'                => 'Sunshiney',
		'Supermercado One'         => 'Supermercado One',
		'Suwannaphum'              => 'Suwannaphum',
		'Swanky and Moo Moo'       => 'Swanky and Moo Moo',
		'Syncopate'                => 'Syncopate',
		'Tangerine'                => 'Tangerine',
		'Taprom'                   => 'Taprom',
		'Tauri'                    => 'Tauri',
		'Telex'                    => 'Telex',
		'Tenor Sans'               => 'Tenor Sans',
		'Text Me One'              => 'Text Me One',
		'The Girl Next Door'       => 'The Girl Next Door',
		'Tienne'                   => 'Tienne',
		'Tinos'                    => 'Tinos',
		'Titan One'                => 'Titan One',
		'Titillium Web'            => 'Titillium Web',
		'Trade Winds'              => 'Trade Winds',
		'Trocchi'                  => 'Trocchi',
		'Trochut'                  => 'Trochut',
		'Trykker'                  => 'Trykker',
		'Tulpen One'               => 'Tulpen One',
		'Ubuntu'                   => 'Ubuntu',
		'Ubuntu Condensed'         => 'Ubuntu Condensed',
		'Ubuntu Mono'              => 'Ubuntu Mono',
		'Ultra'                    => 'Ultra',
		'Uncial Antiqua'           => 'Uncial Antiqua',
		'Underdog'                 => 'Underdog',
		'Unica One'                => 'Unica One',
		'UnifrakturCook'           => 'UnifrakturCook',
		'UnifrakturMaguntia'       => 'UnifrakturMaguntia',
		'Unkempt'                  => 'Unkempt',
		'Unlock'                   => 'Unlock',
		'Unna'                     => 'Unna',
		'VT323'                    => 'VT323',
		'Vampiro One'              => 'Vampiro One',
		'Varela'                   => 'Varela',
		'Varela Round'             => 'Varela Round',
		'Vast Shadow'              => 'Vast Shadow',
		'Vibur'                    => 'Vibur',
		'Vidaloka'                 => 'Vidaloka',
		'Viga'                     => 'Viga',
		'Voces'                    => 'Voces',
		'Volkhov'                  => 'Volkhov',
		'Vollkorn'                 => 'Vollkorn',
		'Voltaire'                 => 'Voltaire',
		'Waiting for the Sunrise'  => 'Waiting for the Sunrise',
		'Wallpoet'                 => 'Wallpoet',
		'Walter Turncoat'          => 'Walter Turncoat',
		'Warnes'                   => 'Warnes',
		'Wellfleet'                => 'Wellfleet',
		'Wendy One'                => 'Wendy One',
		'Wire One'                 => 'Wire One',
		'Yanone Kaffeesatz'        => 'Yanone Kaffeesatz',
		'Yellowtail'               => 'Yellowtail',
		'Yeseva One'               => 'Yeseva One',
		'Yesteryear'               => 'Yesteryear',
		'Zeyada'                   => 'Zeyada',
	);
}
endif;