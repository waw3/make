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

	$priority = new TTF_One_Prioritizer( 10, 1 );
	$prefix = 'ttf-one_';
	$section = 'title_tagline';

	// Change priority for Site Title
	$site_title = $wp_customize->get_control( 'blogname' );
	$site_title->priority = $priority->add();


	// Hide Site Title
	$setting_id = 'hide-site-title';
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
			'label'    => __( 'Hide Site Title', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);

	// Change priority for Tagline
	$site_description = $wp_customize->get_control( 'blogdescription' );
	$site_description->priority = $priority->add();

	// Hide Tagline
	$setting_id = 'hide-tagline';
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
			'label'    => __( 'Hide Tagline', 'ttf-one' ),
			'type'     => 'checkbox',
			'priority' => $priority->add()
		)
	);
}
endif;

add_action( 'customize_register', 'ttf_one_customizer_sitetitletagline', 20 );