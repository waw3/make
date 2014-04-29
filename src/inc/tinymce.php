<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_mce_buttons_2' ) ) :
/**
 * Activate the Styles dropdown for the Visual editor.
 *
 * @since  1.0.0
 *
 * @param  array    $buttons    Array of activated buttons.
 * @return array                The modified array.
 */
function ttfmake_mce_buttons_2( $buttons ) {
	// Add the styles dropdown
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
endif;

add_filter( 'mce_buttons_2', 'ttfmake_mce_buttons_2' );

if ( ! function_exists( 'ttfmake_mce_before_init' ) ) :
/**
 * Add styles to the Styles dropdown.
 *
 * @since  1.0.0.
 *
 * @param  array    $settings    TinyMCE settings array.
 * @return array                 Modified array.
 */
function ttfmake_mce_before_init( $settings ) {
	$style_formats = array(
		// Big (big)
		array(
			'title'  => __( 'Big', 'make' ),
			'inline' => 'big'
		),
		// Small (small)
		array(
			'title'  => __( 'Small', 'make' ),
			'inline' => 'small'
		),
		// Citation (cite)
		array(
			'title'  => __( 'Citation', 'make' ),
			'inline' => 'cite'
		),
		// Testimonial (blockquote)
		array(
			'title'   => __( 'Blockquote: testimonial', 'make' ),
			'block'   => 'blockquote',
			'classes' => 'ttfmake-testimonial',
			'wrapper' => true
		),
		// Alert (div)
		array(
			'title' => __( 'Alert', 'make' ),
			'items' => array(
				// Success (div)
				array(
					'title'   => __( 'Success (Green)', 'make' ),
					'block'   => 'div',
					'classes' => 'ttfmake-alert ttfmake-success',
				),
				// Error (div)
				array(
					'title'   => __( 'Error (Red)', 'make' ),
					'block'   => 'div',
					'classes' => 'ttfmake-alert ttfmake-error',
				),
				// Important (div)
				array(
					'title'   => __( 'Important (Orange)', 'make' ),
					'block'   => 'div',
					'classes' => 'ttfmake-alert ttfmake-important',
				),
			),
		),
		// Button (a)
		array(
			'title'      => __( 'Button', 'make' ),
			'selector'   => 'a,button',
			'attributes' => array(
				'class' => 'ttfmake-button' // Replace existing classes instead of adding
			)
		),
		// Button download (a)
		array(
			'title'    => __( 'Button: download', 'make' ),
			'selector' => 'a,button',
			'classes'  => 'ttfmake-download'
		),
		// Button primary (a)
		array(
			'title'    => __( 'Button: primary', 'make' ),
			'selector' => 'a,button',
			'classes'  => 'color-primary-background'
		),
		// Button primary (a)
		array(
			'title'    => __( 'Button: secondary', 'make' ),
			'selector' => 'a,button',
			'classes'  => 'color-secondary-background'
		),
		// List: check 1
		array(
			'title'      => __( 'List: checkmark 1', 'make' ),
			'selector'   => 'ul,ol',
			'attributes' => array(
				'class' => 'ttfmake-list ttfmake-list-check' // Replace existing classes instead of adding
			)
		),
		// List: check 2
		array(
			'title'      => __( 'List: checkmark 2', 'make' ),
			'selector'   => 'ul,ol',
			'attributes' => array(
				'class' => 'ttfmake-list ttfmake-list-check2' // Replace existing classes instead of adding
			)
		),
		// List: star
		array(
			'title'      => __( 'List: star', 'make' ),
			'selector'   => 'ul,ol',
			'attributes' => array(
				'class' => 'ttfmake-list ttfmake-list-star' // Replace existing classes instead of adding
			)
		),
		// List: dot
		array(
			'title'      => __( 'List: dot', 'make' ),
			'selector'   => 'ul,ol',
			'attributes' => array(
				'class' => 'ttfmake-list ttfmake-list-dot' // Replace existing classes instead of adding
			)
		),
	);

	// Allow styles to be customized
	$style_formats = apply_filters( 'ttfmake_style_formats', $style_formats );

	// Encode
	$settings['style_formats'] = json_encode( $style_formats );

	return $settings;
}
endif;

add_filter( 'tiny_mce_before_init', 'ttfmake_mce_before_init' );