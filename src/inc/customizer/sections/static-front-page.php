<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_customizer_staticfrontpage' ) ) :
/**
 * Configure settings and controls for the Static Front Page section.
 *
 * @since  1.3.0.
 *
 * @return void
 */
function ttfmake_customizer_staticfrontpage() {
	global $wp_customize;
	$theme_prefix = 'ttfmake_';
	$section = 'static_front_page';
	$priority = new TTFMAKE_Prioritizer( 10, 5 );

	// Move Static Front Page section to General panel
	$wp_customize->get_section( $section )->panel = $theme_prefix . 'general';

	// Set Static Front Page section priority
	$social_priority = $wp_customize->get_section( $theme_prefix . 'social' )->priority;
	$wp_customize->get_section( $section )->priority = $social_priority + 5;
}
endif;

add_action( 'customize_register', 'ttfmake_customizer_staticfrontpage', 20 );