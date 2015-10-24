<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Compatibility_HookPrefixer
 */
final class MAKE_Compatibility_HookPrefixer implements MAKE_Util_HookInterface {
	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @var bool
	 */
	private $hooked = false;

	/**
	 * Hook into WordPress.
	 *
	 * @since x.x.x.
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		// Filters
		add_action( 'after_setup_theme', array( $this, 'add_filters' ), 1 );

		// Actions
		add_action( 'after_setup_theme', array( $this, 'add_actions' ), 1 );

		// Hooking has occurred.
		$this->hooked = true;
	}

	/**
	 * Check if the hook routine has been run.
	 *
	 * @since x.x.x.
	 *
	 * @return bool
	 */
	public function is_hooked() {
		return $this->hooked;
	}

	/**
	 * Adds back compat for filters with changed names.
	 *
	 * In Make 1.2.3, filters were all changed from "ttfmake_" to "make_". In order to maintain back compatibility, the old
	 * version of the filter needs to still be called. This function collects all of those changed filters and mirrors the
	 * new filter so that the old filter name will still work.
	 *
	 * @since  1.2.3.
	 *
	 * @return void
	 */
	public function add_filters() {
		// Only run this in the proper hook context.
		if ( 'after_setup_theme' !== current_action() ) {
			return;
		}

		// All filters that need a name change
		$old_filters = array(
			'template_content_archive'     => 2,
			'fitvids_custom_selectors'     => 1,
			'template_content_page'        => 2,
			'template_content_search'      => 2,
			'footer_1'                     => 1,
			'footer_2'                     => 1,
			'footer_3'                     => 1,
			'footer_4'                     => 1,
			'sidebar_left'                 => 1,
			'sidebar_right'                => 1,
			'template_content_single'      => 2,
			'get_view'                     => 2,
			'has_sidebar'                  => 3,
			'read_more_text'               => 1,
			'supported_social_icons'       => 1,
			'exif_shutter_speed'           => 2,
			'exif_aperture'                => 2,
			'style_formats'                => 1,
			'prepare_data_section'         => 3,
			'insert_post_data_sections'    => 1,
			'section_classes'              => 2,
			'the_builder_content'          => 1,
			'builder_section_footer_links' => 1,
			'section_defaults'             => 1,
			'section_choices'              => 3,
			'gallery_class'                => 2,
			'builder_banner_class'         => 2,
			'customizer_sections'          => 1,
			'setting_defaults'             => 1,
			'font_relative_size'           => 1,
			'font_stack'                   => 2,
			'font_variants'                => 3,
			'all_fonts'                    => 1,
			'get_google_fonts'             => 1,
			'custom_logo_information'      => 1,
			'custom_logo_max_width'        => 1,
			'setting_choices'              => 2,
			'social_links'                 => 1,
			'show_footer_credit'           => 1,
			'is_plus'                      => 1,
		);

		foreach ( $old_filters as $filter => $args ) {
			add_filter( 'make_' . $filter, array( $this, 'mirror_filter' ), 10, $args );
		}
	}

	/**
	 * Prepends "ttf" to a filter name and calls that new filter variant.
	 *
	 * @since  1.2.3.
	 *
	 * @return mixed    The result of the filter.
	 */
	public function mirror_filter() {
		$filter = 'ttf' . current_filter();
		$args   = func_get_args();
		return apply_filters_ref_array( $filter, $args );
	}

	/**
	 * Adds back compat for actions with changed names.
	 *
	 * In Make 1.2.3, actions were all changed from "ttfmake_" to "make_". In order to maintain back compatibility, the old
	 * version of the action needs to still be called. This function collects all of those changed actions and mirrors the
	 * new filter so that the old filter name will still work.
	 *
	 * @since  1.2.3.
	 *
	 * @return void
	 */
	public function add_actions() {
		// Only run this in the proper hook context.
		if ( 'after_setup_theme' !== current_action() ) {
			return;
		}

		// All actions that need a name change
		$old_actions = array(
			'section_text_before_columns_select' => 1,
			'section_text_after_columns_select'  => 1,
			'section_text_after_title'           => 1,
			'section_text_before_column'         => 2,
			'section_text_after_column'          => 2,
			'section_text_after_columns'         => 1,
			'css'                                => 1,
		);

		foreach ( $old_actions as $action => $args ) {
			add_action( 'make_' . $action, array( $this, 'mirror_action' ), 10, $args );
		}
	}

	/**
	 * Prepends "ttf" to an action name and calls that new action variant.
	 *
	 * @since  1.2.3.
	 *
	 * @return mixed    The result of the action.
	 */
	public function mirror_action() {
		$action = 'ttf' . current_action();
		$args   = func_get_args();
		do_action_ref_array( $action, $args );
	}
}