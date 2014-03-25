<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_customizer_main' ) ) :
/**
 * Configure settings and controls for the Background section.
 *
 * @since  1.0
 *
 * @param object $wp_customize
 * @param string $section
 */
function ttf_one_customizer_main( $wp_customize, $section ) {
	$priority = new TTF_One_Prioritizer();
	$prefix   = 'ttf-one_';

	// Background color
	$setting_id = 'main-background-color';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'maybe_hash_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Background Color', 'ttf-one' ),
				'priority' => $priority->add()
			)
		)
	);

	// Background Image
	$setting_id = 'main-background-image';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => ttf_one_get_default( $setting_id ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new TTF_One_Customize_Image_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'settings' => $setting_id,
				'section'  => $section,
				'label'    => __( 'Background Image', 'ttf-one' ),
				'priority' => $priority->add(),
				'context'  => $prefix . $setting_id
			)
		)
	);

	// Background Repeat
	$setting_id = 'main-background-repeat';
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
			'label'    => __( 'Background Repeat', 'ttf-one' ),
			'type'     => 'radio',
			'choices'  => array(
				'no-repeat' => __( 'No Repeat', 'ttf-one' ),
				'repeat'    => __( 'Tile', 'ttf-one' ),
				'repeat-x'  => __( 'Tile Horizontally', 'ttf-one' ),
				'repeat-y'  => __( 'Tile Vertically', 'ttf-one' )
			),
			'priority' => $priority->add()
		)
	);

	// Background Position
	$setting_id = 'main-background-position';
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
			'label'    => __( 'Background Position', 'ttf-one' ),
			'type'     => 'radio',
			'choices'  => array(
				'left'   => __( 'Left', 'ttf-one' ),
				'center' => __( 'Center', 'ttf-one' ),
				'right'  => __( 'Right', 'ttf-one' )
			),
			'priority' => $priority->add()
		)
	);

	// Background Size
	$setting_id = 'main-background-size';
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
			'label'    => __( 'Background Size', 'ttf-one' ),
			'type'     => 'radio',
			'choices'  => array(
				'auto'  => __( 'Auto', 'ttf-one' ),
				'cover'   => __( 'Cover', 'ttf-one' ),
				'contain' => __( 'Contain', 'ttf-one' )
			),
			'priority' => $priority->add()
		)
	);

	// Left sidebar heading
	$setting_id = 'main-sidebar-left-heading';
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'heading',
				'label' => __( 'Display Left Sidebar', 'ttf-one' ),
				'priority'    => $priority->add()
			)
		)
	);

	// Left sidebar posts
	$setting_id = 'main-sidebar-left-posts';
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
			'label'    => __( 'Posts', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Left sidebar pages
	$setting_id = 'main-sidebar-left-pages';
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
			'label'    => __( 'Pages', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Left sidebar blog and archives
	$setting_id = 'main-sidebar-left-archives';
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
			'label'    => __( 'Blog Page & Archives', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Left sidebar search results
	$setting_id = 'main-sidebar-left-search';
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
			'label'    => __( 'Search Results', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Right sidebar heading
	$setting_id = 'main-sidebar-right-heading';
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'heading',
				'label' => __( 'Display Right Sidebar', 'ttf-one' ),
				'priority'    => $priority->add()
			)
		)
	);

	// Right sidebar posts
	$setting_id = 'main-sidebar-right-posts';
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
			'label'    => __( 'Posts', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Right sidebar pages
	$setting_id = 'main-sidebar-right-pages';
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
			'label'    => __( 'Pages', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Right sidebar blog and archives
	$setting_id = 'main-sidebar-right-archives';
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
			'label'    => __( 'Blog Page & Archives', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Right sidebar search results
	$setting_id = 'main-sidebar-right-search';
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
			'label'    => __( 'Search Results', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Content options heading
	$setting_id = 'main-content-heading';
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'heading',
				'label' => __( 'Content Options', 'ttf-one' ),
				'priority'    => $priority->add()
			)
		)
	);

	// Underline content links
	$setting_id = 'main-content-link-underline';
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
			'label'    => __( 'Underline links in content', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);
}
endif;