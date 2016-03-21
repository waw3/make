<?php
/**
 * @package Make
 */

/**
 * Class MAKE_API
 *
 * @since x.x.x.
 */
class MAKE_API extends MAKE_Util_Modules implements MAKE_APIInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'l10n'                => 'MAKE_Setup_L10nInterface',
		'error'               => 'MAKE_Error_CollectorInterface',
		'compatibility'       => 'MAKE_Compatibility_MethodsInterface',
		'plus'                => 'MAKE_Plus_MethodsInterface',
		'notice'              => 'MAKE_Admin_NoticeInterface',
		'choices'             => 'MAKE_Choices_ManagerInterface',
		'font'                => 'MAKE_Font_ManagerInterface',
		'view'                => 'MAKE_Layout_ViewInterface',
		'thememod'            => 'MAKE_Settings_ThemeModInterface',
		'widgets'             => 'MAKE_Setup_WidgetsInterface',
		'scripts'             => 'MAKE_Setup_ScriptsInterface',
		'style'               => 'MAKE_Style_ManagerInterface',
		'formatting'          => 'MAKE_Formatting_ManagerInterface',
		'galleryslider'       => 'MAKE_GallerySlider_MethodsInterface',
		'logo'                => 'MAKE_Logo_MethodsInterface',
		'socialicons'         => 'MAKE_SocialIcons_ManagerInterface',
		'customizer_controls' => 'MAKE_Customizer_ControlsInterface',
		'customizer_preview'  => 'MAKE_Customizer_PreviewInterface',
		'setup'               => 'MAKE_Setup_MiscInterface',
		'builder'             => 'MAKE_Builder_SetupInterface',
		'integration'         => 'MAKE_Integration_ManagerInterface',
	);

	/**
	 * An associative array of the default classes to use for each dependency.
	 *
	 * @since x.x.x.
	 *
	 * @var array
	 */
	private $defaults = array(
		'l10n'                => 'MAKE_Setup_L10n',
		'error'               => 'MAKE_Error_Collector',
		'compatibility'       => 'MAKE_Compatibility_Methods',
		'plus'                => 'MAKE_Plus_Methods',
		'notice'              => 'MAKE_Admin_Notice',
		'choices'             => 'MAKE_Choices_Manager',
		'font'                => 'MAKE_Font_Manager',
		'view'                => 'MAKE_Layout_View',
		'thememod'            => 'MAKE_Settings_ThemeMod',
		'widgets'             => 'MAKE_Setup_Widgets',
		'scripts'             => 'MAKE_Setup_Scripts',
		'style'               => 'MAKE_Style_Manager',
		'formatting'          => 'MAKE_Formatting_Manager',
		'galleryslider'       => 'MAKE_GallerySlider_Methods',
		'logo'                => 'MAKE_Logo_Methods',
		'socialicons'         => 'MAKE_SocialIcons_Manager',
		'customizer_controls' => 'MAKE_Customizer_Controls',
		'customizer_preview'  => 'MAKE_Customizer_Preview',
		'setup'               => 'MAKE_Setup_Misc',
		'builder'             => 'MAKE_Builder_Setup',
		'integration'         => 'MAKE_Integration_Manager',
	);

	/**
	 * MAKE_API constructor.
	 *
	 * @since x.x.x.
	 *
	 * @param array $modules
	 */
	public function __construct( array $modules = array() ) {
		$modules = wp_parse_args( $modules, $this->get_default_modules() );

		// Remove conditional dependencies
		if ( ! is_admin() ) {
			unset( $this->dependencies['notice'] );

			if ( ! is_customize_preview() ) {
				unset( $this->dependencies['customizer_controls'] );
				unset( $this->dependencies['customizer_preview'] );
			}
		}

		parent::__construct( $this, $modules );
	}

	/**
	 * Getter for the private defaults array.
	 *
	 * @since x.x.x.
	 *
	 * @return array
	 */
	private function get_default_modules() {
		return $this->defaults;
	}

	/**
	 * Return the specified module without running its load routine.
	 *
	 * @since x.x.x.
	 *
	 * @param $module_name
	 *
	 * @return null
	 */
	public function inject_module( $module_name ) {
		// Module exists.
		if ( $this->has_module( $module_name ) ) {
			return $this->modules[ $module_name ];
		}

		// Module doesn't exist. Use the get_module method to generate an error.
		else {
			return $this->get_module( $module_name );
		}
	}
}

/**
 * Check if Make Plus is active.
 *
 * @since x.x.x.
 *
 * @return bool
 */
function make_is_plus() {
	return Make()->plus()->is_plus();
}

/**
 * Get a sanitized value for a Theme Mod setting.
 *
 * @since x.x.x.
 *
 * @param        $setting_id
 * @param string $context
 *
 * @return mixed
 */
function make_get_thememod_value( $setting_id, $context = 'template' ) {
	return Make()->thememod()->get_value( $setting_id, $context );
}

/**
 * Get the default value for a Theme Mod setting.
 *
 * @since x.x.x.
 *
 * @param $setting_id
 *
 * @return mixed
 */
function make_get_thememod_default( $setting_id ) {
	return Make()->thememod()->get_default( $setting_id );
}

/**
 * Get the current view.
 *
 * @since x.x.x.
 *
 * @return mixed
 */
function make_get_current_view() {
	return Make()->view()->get_current_view();
}

/**
 * Check if the current view has a sidebar in the specified location (left or right).
 *
 * @since x.x.x.
 *
 * @param $location
 *
 * @return mixed
 */
function make_has_sidebar( $location ) {
	return Make()->widgets()->has_sidebar( $location );
}

/**
 * Check if a custom logo has been set.
 *
 * @since x.x.x.
 *
 * @return bool
 */
function make_has_logo() {
	return Make()->logo()->has_logo();
}

/**
 * Output the markup for a custom logo.
 *
 * @since x.x.x.
 *
 * return void
 */
function make_logo() {
	echo Make()->logo()->get_logo();
}

/**
 * Check to see if social icons have been configured for display.
 *
 * @since x.x.x.
 *
 * @return bool
 */
function make_has_socialicons() {
	return Make()->socialicons()->has_icon_data();
}

/**
 * Display social icons for the site header or footer.
 *
 * @since x.x.x.
 *
 * @param $region
 *
 * @return void
 */
function make_socialicons( $region ) {
	if ( ! in_array( $region, array( 'header', 'footer' ) ) ) {
		return;
	}

	if ( make_has_socialicons() && make_get_thememod_value( $region . '-show-social' ) ) {
		?>
		<div class="<?php echo $region; ?>-social-links">
			<?php echo Make()->socialicons()->render_icons(); ?>
		</div>
		<?php
	}
}

/**
 * Display a breadcrumb.
 *
 * @since x.x.x.
 *
 * @param string $before
 * @param string $after
 *
 * @return void
 */
function make_breadcrumb( $before = '<p class="yoast-seo-breadcrumb">', $after = '</p>' ) {
	if ( Make()->integration()->has_integration( 'yoastseo' ) ) {
		echo Make()->integration()->get_integration( 'yoastseo' )->maybe_render_breadcrumb( $before, $after );
	}
}

if ( ! function_exists( 'sanitize_hex_color' ) ) :
/**
 * Sanitizes a hex color.
 *
 * This replicates the core function that is unfortunately only available in the Customizer.
 *
 * @since  1.0.0.
 *
 * @param string $color    The proposed color.
 *
 * @return string    The sanitized color.
 */
function sanitize_hex_color( $color ) {
	if ( '' === $color ) {
		return '';
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}

	return '';
}
endif;

if ( ! function_exists( 'sanitize_hex_color_no_hash' ) ) :
/**
 * Sanitizes a hex color without a hash. Use sanitize_hex_color() when possible.
 *
 * This replicates the core function that is unfortunately only available in the Customizer.
 *
 * @since  1.0.0.
 *
 * @param  string         $color    The proposed color.
 * @return string|null              The sanitized color.
 */
function sanitize_hex_color_no_hash( $color ) {
	$color = ltrim( $color, '#' );
	if ( '' === $color ) {
		return '';
	}

	return sanitize_hex_color( '#' . $color ) ? $color : null;
}
endif;

if ( ! function_exists( 'maybe_hash_hex_color' ) ) :
/**
 * Ensures that any hex color is properly hashed.
 *
 * This replicates the core function that is unfortunately only available in the Customizer.
 *
 * @since  1.0.0.
 *
 * @param  string         $color    The proposed color.
 * @return string|null              The sanitized color.
 */
function maybe_hash_hex_color( $color ) {
	if ( $unhashed = sanitize_hex_color_no_hash( $color ) ) {
		return '#' . $unhashed;
	}

	return $color;
}
endif;