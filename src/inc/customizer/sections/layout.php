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

	$choices = array();

	// Featured Image Blog|Archive|Search options
	$choices['featured-images-archive'] = array(
		'thumbnail'  => __( 'Thumbnail', 'ttf-one' ),
		'background' => __( 'Post header background', 'ttf-one' ),
		'none'       => __( 'None', 'ttf-one' ),
	);

	// Featured Image Post|Page options
	$choices['featured-images-single'] = array(
		'thumbnail' => __( 'Thumbnail', 'ttf-one' ),
		'none'      => __( 'None', 'ttf-one' ),
	);

	// Post date options
	$choices['post-date'] = array(
		'absolute' => __( 'Absolute', 'ttf-one' ),
		'relative' => __( 'Relative', 'ttf-one' ),
		'none'     => __( 'None', 'ttf-one' ),
	);

	// Post author options
	$choices['post-author'] = array(
		'avatar' => __( 'Avatar', 'ttf-one' ),
		'name'   => __( 'Name', 'ttf-one' ),
		'both'   => __( 'Avatar + Name', 'ttf-one' ),
		'none'   => __( 'None', 'ttf-one' ),
	);

	// Byline options
	$choices['byline-location'] = array(
		'before' => __( 'Before content', 'ttf-one' ),
		'after'  => __( 'After content', 'ttf-one' ),
	);

	/**
	 * Posts Page
	 */
	$view = 'blog';

	// Blog collapsible section begin
	$setting_id = $section_prefix . 'group-' . $view;
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'group',
				'label' => __( 'Blog (Posts Page)', 'ttf-one' ),
				'group'       => $prefix . $section_prefix . $view,
				'priority'    => $priority->add()
			)
		)
	);

	// Blog Header, Footer, Sidebars heading
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

	// Blog hide site header
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

	// Blog hide site footer
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

	// Blog left sidebar
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

	// Blog right sidebar
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

	// Blog featured images
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
			'choices'  => $choices['featured-images-archive'],
			'priority' => $priority->add()
		)
	);

	// Blog post date
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
			'choices'  => $choices['post-date'],
			'priority' => $priority->add()
		)
	);

	// Blog post author
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
			'choices'  => $choices['post-author'],
			'priority' => $priority->add()
		)
	);

	// Blog byline location
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
			'choices'  => $choices['byline-location'],
			'priority' => $priority->add()
		)
	);

	// Blog content heading
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

	// Blog auto excerpt
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

	// Blog excerpt length
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

	// Blog post meta heading
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

	// Blog show categories
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

	// Blog show tags
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
endif;