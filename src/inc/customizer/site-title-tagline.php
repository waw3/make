<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_customizer_sitetitletagline' ) ) :
/**
 * Configure settings and controls for the Site Title & Tagline section.
 *
 * @since  1.0
 *
 * @return void
 */
function ttf_one_customizer_sitetitletagline() {
	global $wp_customize;

	$priority = new TTF_One_Prioritizer();
	$prefix = 'ttf-one_';

	// Hide Site Title
	$setting_id = 'hide-site-title';
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
			'section'  => 'title_tagline',
			'label'    => __( 'Hide Site Title', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Hide Tagline
	$setting_id = 'hide-tagline';
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
			'section'  => 'title_tagline',
			'label'    => __( 'Hide Tagline', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);
}
endif;

add_action( 'customize_register', 'ttf_one_customizer_sitetitletagline', 20 );