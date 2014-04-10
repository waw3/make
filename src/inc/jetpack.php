<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_jetpack_setup' ) ) :
/**
 * Jetpack compatibility
 *
 * @since 1.0.0
 *
 * @return void
 */
function ttf_one_jetpack_setup() {
	// Add theme support for Infinite Scroll
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
endif;

add_action( 'after_setup_theme', 'ttf_one_jetpack_setup' );
