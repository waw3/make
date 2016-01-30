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
		'socialicons'         => 'MAKE_SocialIcons_ManagerInterface',
		'customizer_controls' => 'MAKE_Customizer_ControlsInterface',
		'customizer_preview'  => 'MAKE_Customizer_PreviewInterface',
		'setup'               => 'MAKE_Setup_MiscInterface',
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
		'socialicons'         => 'MAKE_SocialIcons_Manager',
		'customizer_controls' => 'MAKE_Customizer_Controls',
		'customizer_preview'  => 'MAKE_Customizer_Preview',
		'setup'               => 'MAKE_Setup_Misc',
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
 * Add or modify a choice set.
 *
 * @since x.x.x.
 *
 * @param array                              $choice_sets
 * @param MAKE_Choices_ManagerInterface|null $instance
 *
 * @return mixed
 */
function make_update_choices( $choice_sets, MAKE_Choices_ManagerInterface $instance = null ) {
	if ( is_null( $instance ) ) {
		$instance = Make()->choices();
	}

	return $instance->add_choice_sets( $choice_sets, true );
}

/**
 * Add or modify a Theme Mod setting.
 *
 * @since x.x.x.
 *
 * @param array                                $settings
 * @param MAKE_Settings_ThemeModInterface|null $instance
 *
 * @return mixed
 */
function make_update_thememod_settings( $settings, MAKE_Settings_ThemeModInterface $instance = null ) {
	if ( is_null( $instance ) ) {
		$instance = Make()->thememod();
	}

	return $instance->add_settings( $settings, array(), true );
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
function make_get_thememod_value( $setting_id, $context = '' ) {
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
 *
 */
function make_add_view( $view_id, array $args = array(), $overwrite = false ) {
	return Make()->view()->add_view( $view_id, $args, $overwrite );
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
 * Check if a particular view is the current one.
 *
 * @since x.x.x.
 *
 * @param $view_id
 *
 * @return mixed
 */
function make_is_current_view( $view_id ) {
	return Make()->view()->is_current_view( $view_id );
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
	//
	if ( Make()->integration()->has_integration( 'yoastseo' ) ) {
		echo Make()->integration()->get_integration( 'yoastseo' )->maybe_render_breadcrumb( $before, $after );
	}
}

if ( ! function_exists( 'ttfmake_maybe_show_social_links' ) ) :
/**
 * Show the social links markup if the theme options and/or menus are configured for it.
 *
 * @since  1.0.0.
 * @since  1.7.0. Uses new Social Icons module.
 *
 * @param  string    $region    The site region (header or footer).
 * @return void
 */
function ttfmake_maybe_show_social_links( $region ) {
	if ( ! in_array( $region, array( 'header', 'footer' ) ) ) {
		return;
	}

	$show_social = make_get_thememod_value( $region . '-show-social' );

	if ( true === $show_social ) {
		?>
		<ul class="social-customizer social-links <?php echo $region; ?>-social-links">
			<?php echo Make()->socialicons()->render_icons( make_get_thememod_value( 'social-icons' ) ); ?>
		</ul>
	<?php
	}
}
endif;