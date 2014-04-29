<?php
/**
 * @package ttf-one
 */

if ( ! function_exists( 'ttf_one_woocommerce_remove_hooks' ) ) :
/**
 * Remove default action hooks so we can replace them with our own.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttf_one_woocommerce_remove_hooks() {
	// Content wrapper
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

	// Sidebar
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
}
endif;

add_action( 'after_setup_theme', 'ttf_one_woocommerce_remove_hooks' );

if ( ! function_exists( 'ttf_one_woocommerce_before_main_content' ) ) :
/**
 * Markup to show before the main WooCommerce content.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttf_one_woocommerce_before_main_content() {
	// Left sidebar
	ttf_one_maybe_show_sidebar( 'left' );

	// Begin content wrapper
	?>
	<main id="site-main" class="site-main" role="main">
	<?php
}
endif;

add_action( 'woocommerce_before_main_content', 'ttf_one_woocommerce_before_main_content' );

if ( ! function_exists( 'ttf_one_woocommerce_after_main_content' ) ) :
/**
 * Markup to show after the main WooCommerce content
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttf_one_woocommerce_after_main_content() {
	// End content wrapper
	?>
	</main>
	<?php
	// Right sidebar
	ttf_one_maybe_show_sidebar( 'right' );
}
endif;

add_action( 'woocommerce_after_main_content', 'ttf_one_woocommerce_after_main_content' );