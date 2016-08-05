<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_Builder_SetupInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_Builder_SetupInterface ) {
	return;
}

// Setting definition presets
$settings_title = array(
	'title'            => array(
		'default'     => '',
		'sanitize'    => array( $this->sanitize(), 'sanitize_title_for_frontend' ),
		'sanitize_ui' => array( $this->sanitize(), 'sanitize_title_for_ui' ),
	),
);
$settings_content = array(
	'content' => array(
		'default' => '',
		'sanitize' => array( $this->sanitize(), 'sanitize_builder_section_content_for_frontend' ),
		'sanitize_database' => array( $this->sanitize(), 'sanitize_builder_section_content_for_db' ),
		'sanitize_ui' => array( $this->sanitize(), 'sanitize_builder_section_content_for_ui' ),
	),
);
$settings_background = array(
	'background-image' => array(
		'default'           => '',
		'sanitize'          => 'esc_url',
		'sanitize_database' => 'esc_url_raw',
	),
	'darken'           => array(
		'default'  => false,
		'sanitize' => 'wp_validate_boolean'
	),
	'background-style' => array(
		'default'       => 'tile',
		'sanitize'      => array( $this->sanitize(), 'sanitize_builder_section_choice' ),
		'choice_set_id' => 'builder-section-background-style'
	),
	'background-color' => array(
		'default'  => '',
		'sanitize' => 'maybe_hash_hex_color'
	),
);

// Columns section
$this->register_section_type(
	'text',
	array(
		'label'       => esc_html__( 'Columns', 'make' ),
		'description' => esc_html__( 'Create rearrangeable columns of content and images.', 'make' ),
		'icon_url'    => $this->scripts()->get_css_directory_uri() . '/builder/ui/images/text.png',
		'priority'    => 10,
		'items'       => array(
			'can_add'    => false,
			'can_remove' => false,
			'start_with' => 4,
		),
		'settings'    => array_merge(
			$settings_title,
			array(
				'columns-number' => array(
					'default'       => 3,
					'sanitize'      => array( $this->sanitize(), 'sanitize_builder_section_choice' ),
					'choice_set_id' => '1-4'
				),
			),
			$settings_background
		),
		'ui'          => array(
			'buttons'  => array(
				'config' => array(
					'label'   => __( 'Configure section', 'make' ),
					'action'  => 'click:openOverlay',
					'overlay' => 'config-overlay',
				),
			),
			'elements' => array(
				'column-stage' => array(
					'type'     => 'stage',
					'setting'  => 'items',
				),
				'config-overlay' => array(
					'type'     => 'overlay',
					'label'    => __( 'Configuration', 'make' ),
				),
			),
			'controls' => array(
				'items'            => array(
					'type'    => 'hidden',
					'setting' => 'items',
					'element' => 'column-stage',
				),
				'title'            => array(
					'type'    => 'title',
					'label'   => __( 'Enter section title', 'make' ),
					'setting' => 'title',
					'element' => 'config-overlay',
				),
				'columns-number'   => array(
					'type'    => 'select',
					'label'   => __( 'Columns', 'make' ),
					'action'  => 'update:updateColumns',
					'setting' => 'columns-number',
					'element' => 'config-overlay',
				),
				'background-image' => array(
					'type'    => 'image',
					'label'   => __( 'Background image', 'make' ),
					'setting' => 'background-image',
					'element' => 'config-overlay',
				),
				'darken'           => array(
					'type'    => 'checkbox',
					'label'   => __( 'Darken background to improve readability', 'make' ),
					'setting' => 'darken',
					'element' => 'config-overlay',
				),
				'background-style' => array(
					'type'    => 'select',
					'label'   => __( 'Background style', 'make' ),
					'setting' => 'background-style',
					'element' => 'config-overlay',
				),
				'background-color' => array(
					'type'    => 'color',
					'label'   => __( 'Background color', 'make' ),
					'setting' => 'background-color',
					'element' => 'config-overlay',
				),
			),
		),
	)
);

// Column
$this->register_section_type(
	'text-column',
	array(
		'label'    => esc_html__( 'Column', 'make' ),
		'priority' => 15,
		'parent'   => 'text',
		'settings' => array_merge(
			$settings_title,
			array(
				'image-link' => array(
					'default'           => '',
					'sanitize'          => 'esc_url',
					'sanitize_database' => 'esc_url_raw'
				),
				'image-id'   => array(
					'default'  => 0,
					'sanitize' => array( $this->sanitize(), 'sanitize_image' ),
				),
			),
			$settings_content
		),
		'ui'       => array(
			'buttons' => array(
				'config' => array(
					'label'   => __( 'Configure column', 'make' ),
					'action'  => 'click:openOverlay',
					'overlay' => 'config-overlay',
				),
				'content' => array(
					'label'   => __( 'Edit content', 'make' ),
					'action'  => 'click:openOverlay',
					'overlay' => 'content-overlay',
				),
			),
			'elements' => array(
				'image' => array(
					'type'     => 'image',
					'setting'  => 'image-id',
				),
				'preview' => array(
					'type'     => 'preview',
					'content'  => 'content',
				),
				'content-overlay' => array(
					'type'     => 'content',
					'setting'  => 'content',
				),
				'config-overlay' => array(
					'type'     => 'overlay',
					'label'    => __( 'Configuration', 'make' ),
				),
			),
			'controls' => array(
				'title'      => array(
					'type'    => 'title',
					'label'   => __( 'Enter column title', 'make' ),
					'setting' => 'title',
					'element' => 'config-overlay',
				),
				'image-link' => array(
					'type'    => 'text',
					'label'   => __( 'Image link URL', 'make' ),
					'setting' => 'image-link',
					'element' => 'config-overlay',
				),
			),
		),
	)
);

// Banner section
$this->register_section_type(
	'banner',
	array(
		'label'       => esc_html__( 'Banner', 'make' ),
		'description' => esc_html__( 'Display multiple types of content in a banner or a slider.', 'make' ),
		'icon_url'    => $this->scripts()->get_css_directory_uri() . '/builder/ui/images/banner.png',
		'priority'    => 20,
		'items'       => true,
		'settings'    => array_merge(
			$settings_title,
			array(
				'hide-arrows' => array(
					'default'  => false,
					'sanitize' => 'wp_validate_boolean',
				),
				'hide-dots'   => array(
					'default'  => false,
					'sanitize' => 'wp_validate_boolean',
				),
				'autoplay'    => array(
					'default'  => true,
					'sanitize' => 'wp_validate_boolean',
				),
				'delay'       => array(
					'default'  => 6000,
					'sanitize' => 'absint',
				),
				'transition'  => array(
					'default'       => 'scrollHorz',
					'sanitize'      => array( $this->sanitize(), 'sanitize_builder_section_choice' ),
					'choice_set_id' => 'builder-banner-transition',
				),
				'height'      => array(
					'default'  => 600,
					'sanitize' => 'absint',
				),
				'responsive'  => array(
					'default'       => 'balanced',
					'sanitize'      => array( $this->sanitize(), 'sanitize_builder_section_choice' ),
					'choice_set_id' => 'builder-banner-responsive',
				),
			),
			$settings_background
		),
		'ui'          => array(),
	)
);

// Banner slide
$this->register_section_type(
	'banner-slide',
	array(
		'label'    => esc_html__( 'Banner Slide', 'make' ),
		'priority' => 25,
		'parent'   => 'banner',
		'settings' => array_merge(
			$settings_content,
			array(
				'background-color' => array(
					'default'  => '',
					'sanitize' => 'maybe_hash_hex_color'
				),
				'darken'           => array(
					'default'  => false,
					'sanitize' => 'wp_validate_boolean'
				),
				'image-id'         => array(
					'default'  => 0,
					'sanitize' => array( $this->sanitize(), 'sanitize_image' ),
				),
				'alignment'        => array(
					'default'       => 'none',
					'sanitize'      => array( $this->sanitize(), 'sanitize_builder_section_choice' ),
					'choice_set_id' => 'builder-banner-alignment',
				),
			)
		),
		'ui'       => array(),
	)
);

// Gallery section
$this->register_section_type(
	'gallery',
	array(
		'label'       => esc_html__( 'Gallery', 'make' ),
		'description' => esc_html__( 'Display your images in various grid combinations.', 'make' ),
		'icon_url'    => $this->scripts()->get_css_directory_uri() . '/builder/ui/images/gallery.png',
		'priority'    => 30,
		'items'       => true,
		'settings'    => array_merge(
			$settings_title,
			array(
				'columns'       => array(
					'default'       => 3,
					'sanitize'      => array( $this->sanitize(), 'sanitize_builder_section_choice' ),
					'choice_set_id' => '1-4'
				),
				'aspect'        => array(
					'default'       => 'square',
					'sanitize'      => array( $this->sanitize(), 'sanitize_builder_section_choice' ),
					'choice_set_id' => 'builder-gallery-aspect',
				),
				'captions'      => array(
					'default'       => 'reveal',
					'sanitize'      => array( $this->sanitize(), 'sanitize_builder_section_choice' ),
					'choice_set_id' => 'builder-gallery-captions',
				),
				'caption-color' => array(
					'default'       => 'light',
					'sanitize'      => array( $this->sanitize(), 'sanitize_builder_section_choice' ),
					'choice_set_id' => 'color-scheme-2'
				),
			),
			$settings_background
		),
		'ui'          => array(),
	)
);

// Gallery item
$this->register_section_type(
	'gallery-item',
	array(
		'label'    => esc_html__( 'Gallery Item', 'make' ),
		'priority' => 35,
		'parent'   => 'gallery',
		'settings' => array_merge(
			$settings_title,
			array(
				'link'        => array(
					'default'           => '',
					'sanitize'          => 'esc_url',
					'sanitize_database' => 'esc_url_raw',
				),
				'description' => array(
					'default'           => '',
					'sanitize'          => array( $this->sanitize(), 'sanitize_builder_section_content_for_frontend' ),
					'sanitize_database' => array( $this->sanitize(), 'sanitize_builder_section_content_for_db' ),
					'sanitize_ui'       => array( $this->sanitize(), 'sanitize_builder_section_content_for_ui' ),
				),
				'image-id'    => array(
					'default'  => 0,
					'sanitize' => array( $this->sanitize(), 'sanitize_image' ),
				),
			)
		),
		'ui'       => array(),
	)
);