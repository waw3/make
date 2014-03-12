<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_customizer_navigation' ) ) :
/**
 * Configure settings and controls for the Navigation section.
 *
 * @since  1.0
 *
 * @return void
 */
function ttf_one_customizer_navigation() {
	global $wp_customize;

	$priority = new TTF_One_Prioritizer();
	$prefix = 'ttf-one_';

	// Menu Label
	$setting_id = 'navigation-label';
	$wp_customize->add_setting(
		$setting_id,
		array(
			'default'           => __( 'Menu', 'ttf-one' ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_html',
			'theme_supports'    => 'menus'
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'settings' => $setting_id,
			'section'  => 'nav',
			'label'    => __( 'Menu Label', 'ttf-one' ),
			'type'     => 'text',
			'priority' => $priority->add()
		)
	);
}
endif;

add_action( 'customize_register', 'ttf_one_customizer_navigation', 20 );