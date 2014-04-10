<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_customizer_layout' ) ) :
/**
 * Configure settings and controls for the Layout section.
 *
 * @since  1.0
 *
 * @param object $wp_customize
 * @param string $section
 */
function ttf_one_customizer_layout( $wp_customize, $section ) {
	$priority = new TTF_One_Prioritizer();
	$prefix   = 'ttf-one_';
	$section_prefix = 'layout-';

	/**
	 * Blog, Archive, Search Result views
	 */
	$blog_views = array(
		'blog' => __( 'Blog (Posts Page)', 'ttf-one' ),
		'archive' => __( 'Archives', 'ttf-one' ),
		'search' => __( 'Search Results', 'ttf-one' ),
	);
	// Loop through each blog view
	foreach ( $blog_views as $view => $label ) {
		// Group toggle
		$setting_id = $section_prefix . 'group-' . $view;
		$wp_customize->add_control(
			new TTF_One_Customize_Misc_Control(
				$wp_customize,
				$prefix . $setting_id,
				array(
					'section'  => $section,
					'type'     => 'group',
					'label'    => $label,
					'group'    => $prefix . $section_prefix . $view,
					'priority' => $priority->add()
				)
			)
		);

		// Header, Footer, Sidebars heading
		$setting_id = $section_prefix . $view . '-heading-sidebars';
		$wp_customize->add_control(
			new TTF_One_Customize_Misc_Control(
				$wp_customize,
				$prefix . $setting_id,
				array(
					'section'     => $section,
					'type'        => 'heading',
					'label' => __( 'Header, Footer, Sidebars', 'ttf-one' ),
					'priority'    => $priority->add()
				)
			)
		);

		// Hide site header
		$setting_id = $section_prefix . $view . '-hide-header';
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => ttf_one_get_default( $setting_id ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Hide site header', 'ttf-one' ),
				'type'     => 'checkbox',
				'priority' => $priority->add()
			)
		);

		// Hide site footer
		$setting_id = $section_prefix . $view . '-hide-footer';
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => ttf_one_get_default( $setting_id ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Hide site footer', 'ttf-one' ),
				'type'     => 'checkbox',
				'priority' => $priority->add()
			)
		);

		// Left sidebar
		$setting_id = $section_prefix . $view . '-sidebar-left';
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => ttf_one_get_default( $setting_id ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Show left sidebar', 'ttf-one' ),
				'type'     => 'checkbox',
				'priority' => $priority->add()
			)
		);

		// Right sidebar
		$setting_id = $section_prefix . $view . '-sidebar-right';
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => ttf_one_get_default( $setting_id ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Show right sidebar', 'ttf-one' ),
				'type'     => 'checkbox',
				'priority' => $priority->add()
			)
		);

		// Featured images
		$setting_id = $section_prefix . $view . '-featured-images';
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => ttf_one_get_default( $setting_id ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'ttf_one_sanitize_choice',
			)
		);
		$wp_customize->add_control(
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Featured Images', 'ttf-one' ),
				'type'     => 'select',
				'choices'  => ttf_one_get_choices( $setting_id ),
				'priority' => $priority->add()
			)
		);

		// Post date
		$setting_id = $section_prefix . $view . '-post-date';
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => ttf_one_get_default( $setting_id ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'ttf_one_sanitize_choice',
			)
		);
		$wp_customize->add_control(
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Post Date', 'ttf-one' ),
				'type'     => 'select',
				'choices'  => ttf_one_get_choices( $setting_id ),
				'priority' => $priority->add()
			)
		);

		// Post author
		$setting_id = $section_prefix . $view . '-post-author';
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => ttf_one_get_default( $setting_id ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'ttf_one_sanitize_choice',
			)
		);
		$wp_customize->add_control(
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Post Author', 'ttf-one' ),
				'type'     => 'select',
				'choices'  => ttf_one_get_choices( $setting_id ),
				'priority' => $priority->add()
			)
		);

		// Byline location
		$setting_id = $section_prefix . $view . '-byline-location';
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => ttf_one_get_default( $setting_id ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'ttf_one_sanitize_choice',
			)
		);
		$wp_customize->add_control(
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Byline Location', 'ttf-one' ),
				'type'     => 'radio',
				'choices'  => ttf_one_get_choices( $setting_id ),
				'priority' => $priority->add()
			)
		);

		// Content heading
		$setting_id = $section_prefix . $view . '-heading-content';
		$wp_customize->add_control(
			new TTF_One_Customize_Misc_Control(
				$wp_customize,
				$prefix . $setting_id,
				array(
					'section'     => $section,
					'type'        => 'heading',
					'label' => __( 'Content', 'ttf-one' ),
					'priority'    => $priority->add()
				)
			)
		);

		// Auto excerpt
		$setting_id = $section_prefix . $view . '-auto-excerpt';
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => ttf_one_get_default( $setting_id ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Create auto-excerpts', 'ttf-one' ),
				'type'     => 'checkbox',
				'priority' => $priority->add()
			)
		);

		// Excerpt length
		$setting_id = $section_prefix . $view . '-excerpt-length';
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => ttf_one_get_default( $setting_id ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Excerpt Length', 'ttf-one' ),
				'type'     => 'text',
				'priority' => $priority->add()
			)
		);

		// Post meta heading
		$setting_id = $section_prefix . $view . '-heading-postmeta';
		$wp_customize->add_control(
			new TTF_One_Customize_Misc_Control(
				$wp_customize,
				$prefix . $setting_id,
				array(
					'section'     => $section,
					'type'        => 'heading',
					'label' => __( 'Post Meta', 'ttf-one' ),
					'priority'    => $priority->add()
				)
			)
		);

		// Show categories
		$setting_id = $section_prefix . $view . '-show-categories';
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => ttf_one_get_default( $setting_id ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Show categories', 'ttf-one' ),
				'type'     => 'checkbox',
				'priority' => $priority->add()
			)
		);

		// Show tags
		$setting_id = $section_prefix . $view . '-show-tags';
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => ttf_one_get_default( $setting_id ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Show tags', 'ttf-one' ),
				'type'     => 'checkbox',
				'priority' => $priority->add()
			)
		);
	}

	/**
	 * Post view
	 */
	$view = 'post';
	$label = __( 'Posts', 'ttf-one' );

	// Group toggle
	$setting_id = $section_prefix . 'group-' . $view;
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'  => $section,
				'type'     => 'group',
				'label'    => $label,
				'group'    => $prefix . $section_prefix . $view,
				'priority' => $priority->add()
			)
		)
	);

	// Header, Footer, Sidebars heading
	$setting_id = $section_prefix . $view . '-heading-sidebars';
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'heading',
				'label' => __( 'Header, Footer, Sidebars', 'ttf-one' ),
				'priority'    => $priority->add()
			)
		)
	);

	// Hide site header
	$setting_id = $section_prefix . $view . '-hide-header';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Hide site header', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Hide site footer
	$setting_id = $section_prefix . $view . '-hide-footer';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Hide site footer', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Left sidebar
	$setting_id = $section_prefix . $view . '-sidebar-left';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Show left sidebar', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Right sidebar
	$setting_id = $section_prefix . $view . '-sidebar-right';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Show right sidebar', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Featured images
	$setting_id = $section_prefix . $view . '-featured-images';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Featured Images', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => ttf_one_get_choices( $setting_id ),
			'priority' => $priority->add()
		)
	);

	// Post date
	$setting_id = $section_prefix . $view . '-post-date';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Post Date', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => ttf_one_get_choices( $setting_id ),
			'priority' => $priority->add()
		)
	);

	// Post author
	$setting_id = $section_prefix . $view . '-post-author';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Post Author', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => ttf_one_get_choices( $setting_id ),
			'priority' => $priority->add()
		)
	);

	// Byline location
	$setting_id = $section_prefix . $view . '-byline-location';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Byline Location', 'ttf-one' ),
			'type'     => 'radio',
			'choices'  => ttf_one_get_choices( $setting_id ),
			'priority' => $priority->add()
		)
	);

	// Post meta heading
	$setting_id = $section_prefix . $view . '-heading-postmeta';
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'heading',
				'label' => __( 'Post Meta', 'ttf-one' ),
				'priority'    => $priority->add()
			)
		)
	);

	// Show categories
	$setting_id = $section_prefix . $view . '-show-categories';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Show categories', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Show tags
	$setting_id = $section_prefix . $view . '-show-tags';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Show tags', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	/**
	 * Page view
	 */
	$view = 'page';
	$label = __( 'Pages', 'ttf-one' );

	// Group toggle
	$setting_id = $section_prefix . 'group-' . $view;
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'  => $section,
				'type'     => 'group',
				'label'    => $label,
				'group'    => $prefix . $section_prefix . $view,
				'priority' => $priority->add()
			)
		)
	);

	// Header, Footer, Sidebars heading
	$setting_id = $section_prefix . $view . '-heading-sidebars';
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'heading',
				'label' => __( 'Header, Footer, Sidebars', 'ttf-one' ),
				'priority'    => $priority->add()
			)
		)
	);

	// Hide site header
	$setting_id = $section_prefix . $view . '-hide-header';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Hide site header', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Hide site footer
	$setting_id = $section_prefix . $view . '-hide-footer';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Hide site footer', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Left sidebar
	$setting_id = $section_prefix . $view . '-sidebar-left';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Show left sidebar', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Right sidebar
	$setting_id = $section_prefix . $view . '-sidebar-right';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Show right sidebar', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Hide title
	$setting_id = $section_prefix . $view . '-hide-title';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Hide title', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Featured images
	$setting_id = $section_prefix . $view . '-featured-images';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Featured Images', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => ttf_one_get_choices( $setting_id ),
			'priority' => $priority->add()
		)
	);

	// Post date
	$setting_id = $section_prefix . $view . '-post-date';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Post Date', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => ttf_one_get_choices( $setting_id ),
			'priority' => $priority->add()
		)
	);

	// Post author
	$setting_id = $section_prefix . $view . '-post-author';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Post Author', 'ttf-one' ),
			'type'     => 'select',
			'choices'  => ttf_one_get_choices( $setting_id ),
			'priority' => $priority->add()
		)
	);

	// Byline location
	$setting_id = $section_prefix . $view . '-byline-location';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'ttf_one_sanitize_choice',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Byline Location', 'ttf-one' ),
			'type'     => 'radio',
			'choices'  => ttf_one_get_choices( $setting_id ),
			'priority' => $priority->add()
		)
	);
}
endif;