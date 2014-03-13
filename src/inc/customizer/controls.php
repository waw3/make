<?php
/**
 * @package ttf-one
 */

if ( ! class_exists( 'TTF_One_Prioritizer' ) ) :
/**
 * Class TTF_One_Prioritizer
 *
 * Increment upward from a starting number with each call to add().
 *
 * @since 1.0
 */
class TTF_One_Prioritizer {
	public $initial_priority = 0;
	public $increment = 0;
	public $current_priority = 0;

	function __construct( $initial_priority = 100, $increment = 100 ) {
		$this->initial_priority = absint( $initial_priority );
		$this->increment = absint( $increment );
		$this->current_priority = $this->initial_priority;
	}

	public function get() {
		return absint( $this->current_priority );
	}

	public function inc( $increment = 0 ) {
		if ( 0 === $increment ) {
			$increment = $this->increment;
		}
		$this->current_priority += absint( $increment );
	}

	public function add() {
		$priority = $this->get();
		$this->inc();
		return $priority;
	}

	public function reboot() {
		$this->current_priority = $this->initial_priority;
	}
}
endif;

if ( class_exists( 'WP_Customize_Image_Control' ) && ! class_exists( 'TTF_One_Customize_Image_Control' ) ) :
/**
 * Class TTF_One_Customize_Image_Control
 *
 * Extend WP_Customize_Image_Control allowing access to uploads made within the same context.
 *
 * @since 1.0
 */
class TTF_One_Customize_Image_Control extends WP_Customize_Image_Control {
	/**
	 * Override the stock tab_uploaded function.
	 *
	 * @since 1.0
	 */
	public function tab_uploaded() {
		$images = get_posts( array(
			'post_type'  => 'attachment',
			'meta_key'   => '_wp_attachment_context',
			'meta_value' => $this->context,
			'orderby'    => 'none',
			'nopaging'   => true,
		) );

		?><div class="uploaded-target"></div><?php

		if ( empty( $images ) ) {
			return;
		}

		foreach ( (array) $images as $image ) {
			$thumbnail_url = wp_get_attachment_image_src( $image->ID, 'medium' );
			$this->print_tab_image( esc_url_raw( $image->guid ), esc_url_raw( $thumbnail_url[0] ) );
		}
	}
}
endif;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'TTF_One_Customize_Misc_Control' ) ) :
/**
 * Class TTF_One_Customize_Misc_Control
 *
 * Control for adding arbitrary HTML to a Customizer section.
 *
 * @since 1.0
 */
class TTF_One_Customize_Misc_Control extends WP_Customize_Control {
	public $settings = 'blogname';
	public $description = '';

	public function render_content() {
		switch ( $this->type ) {
			default:
			case 'text' :
				echo '<p class="description">' . ttf_one_sanitize_text( $this->description ) . '</p>';
				break;

			case 'heading':
				echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
				break;

			case 'line' :
				echo '<hr />';
				break;
		}
	}
}
endif;