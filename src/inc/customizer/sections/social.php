<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_customizer_social' ) ) :
/**
 * Configure settings and controls for the Social section
 *
 * @since 1.0
 *
 * @param object $wp_customize
 * @param string $section
 */
function ttf_one_customizer_social( $wp_customize, $section ) {
	$priority = new TTF_One_Prioritizer();
	$prefix = 'ttf-one_';

	// Social description
	$setting_id = 'social-description';
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'text',
				'description' => __( 'Enter the complete URL to your profile for each service below that you would like to share.', 'ttf-one' ),
				'priority'    => $priority->add()
			)
		)
	);

	// Facebook
	$setting_id = 'social-facebook';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => 'Facebook', // brand names not translated
			'type'     => 'text',
			'priority' => $priority->add()
		)
	);

	// Twitter
	$setting_id = 'social-twitter';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => 'Twitter', // brand names not translated
			'type'     => 'text',
			'priority' => $priority->add()
		)
	);

	// Google +
	$setting_id = 'social-google';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => 'Google +', // brand names not translated
			'type'     => 'text',
			'priority' => $priority->add()
		)
	);

	// LinkedIn
	$setting_id = 'social-linkedin';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => 'LinkedIn', // brand names not translated
			'type'     => 'text',
			'priority' => $priority->add()
		)
	);

	// Instagram
	$setting_id = 'social-instagram';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => 'Instagram', // brand names not translated
			'type'     => 'text',
			'priority' => $priority->add()
		)
	);

	// Pinterest
	$setting_id = 'social-pinterest';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => 'Pinterest', // brand names not translated
			'type'     => 'text',
			'priority' => $priority->add()
		)
	);

	// Flickr
	$setting_id = 'social-flickr';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => 'Flickr', // brand names not translated
			'type'     => 'text',
			'priority' => $priority->add()
		)
	);

	// Custom description
	$setting_id = 'social-custom-description';
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'text',
				'description' => __( 'To add a social profile not listed above, enter the complete URL in the field below and then upload an icon for it.', 'ttf-one' ),
				'priority'    => $priority->add()
			)
		)
	);

	// Custom URL
	$setting_id = 'social-custom-url';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Custom URL', 'ttf-one' ),
			'type'     => 'text',
			'priority' => $priority->add()
		)
	);

	// Custom Icon
	$setting_id = 'social-custom-icon';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '',
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
				'label'    => __( 'Custom Icon', 'ttf-one' ),
				'priority' => $priority->add(),
				'context'  => $prefix . $setting_id
			)
		)
	);

	// Custom alternate
	$setting_id = 'social-custom-alternate';
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'text',
				'description' => sprintf(
					__( 'If you would like to add more than one custom social profile, or would like to change the order of the icons, use %s.', 'ttf-one' ),
					sprintf(
						'<a href="' . esc_url( '#' ) . '">%s</a>',
						__( 'this alternate method', 'ttf-one' )
					)
				),
				'priority'    => $priority->add()
			)
		)
	);

	// RSS Heading
	$setting_id = 'social-rss-heading';
	$wp_customize->add_control(
		new TTF_One_Customize_Misc_Control(
			$wp_customize,
			$prefix . $setting_id,
			array(
				'section'     => $section,
				'type'        => 'heading',
				'label' => __( 'Default RSS', 'ttf-one' ),
				'priority'    => $priority->add()
			)
		)
	);

	// Hide RSS
	$setting_id = 'social-hide-rss';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => 0,
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Hide default RSS feed', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Custom RSS
	$setting_id = 'social-custom-rss';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => $section,
			'label'    => __( 'Custom RSS URL', 'ttf-one' ),
			'type'     => 'text',
			'priority' => $priority->add()
		)
	);
}
endif;