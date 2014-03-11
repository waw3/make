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

	$priority = 100;
	$prefix = 'ttf-one_';

	// Menu Label
	$setting_id = 'navigation-label';
	$wp_customize->add_setting(
		$prefix . $setting_id,
		array(
			'default'           => __( 'Menu', 'ttf-one' ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_html',
		)
	);
	$wp_customize->add_control(
		$prefix . $setting_id,
		array(
			'label'    => __( 'Menu Label', 'ttf-one' ),
			'section'  => 'nav',
			'priority' => $priority
		)
	);
}
endif;

add_action( 'init', 'ttf_one_customizer_navigation' );