<?php
/**
 * @package ttf-one
 */

/**
 * @param $type
 *
 * @return bool
 */
function ttf_one_builder_is_section_type( $type ) {
	global $ttf_one_section_data;

	if ( isset( $ttf_one_section_data['section-type'] ) && $type === $ttf_one_section_data['section-type'] ) {
		return true;
	}

	return false;
}

/**
 * @return array
 */
function ttf_one_builder_get_gallery_array( $ttf_one_section_data ) {
	if ( ! ttf_one_builder_is_section_type( 'gallery' ) ) {
		return array();
	}

	$gallery_order = array();
	if ( isset( $ttf_one_section_data['gallery-item-order'] ) ) {
		$gallery_order = $ttf_one_section_data['gallery-item-order'];
	}

	$gallery_items = array();
	if ( isset( $ttf_one_section_data['gallery-items'] ) ) {
		$gallery_items = $ttf_one_section_data['gallery-items'];
	}

	$gallery_array = array();
	if ( ! empty( $gallery_order ) && ! empty( $gallery_items ) ) {
		foreach ( $gallery_order as $order => $key ) {
			$gallery_array[$order] = $gallery_items[$key];
		}
	}

	return $gallery_array;
}

/**
 * @return string
 */
function ttf_one_builder_get_gallery_class( $ttf_one_section_data ) {
	if ( ! ttf_one_builder_is_section_type( 'gallery' ) ) {
		return '';
	}

	$gallery_class = ' ';

	// Section classes
	$gallery_class .= ttf_one_get_builder_save()->section_classes( $ttf_one_section_data );

	// Columns
	if ( isset( $ttf_one_section_data['columns'] ) && ! empty( $ttf_one_section_data['columns'] ) ) {
		$gallery_class .= ' builder-gallery-columns-' . $ttf_one_section_data['columns'];
	}

	// Captions
	if ( isset( $ttf_one_section_data['captions'] ) && ! empty( $ttf_one_section_data['captions'] ) ) {
		$gallery_class .= ' builder-gallery-captions-' . $ttf_one_section_data['captions'];
	}

	return $gallery_class;
}

/**
 * @return string
 */
function ttf_one_builder_get_gallery_style() {
	global $ttf_one_section_data;

	if ( ! ttf_one_builder_is_section_type( 'gallery' ) ) {
		return '';
	}

	$gallery_style = '';

	// Background color
	if ( isset( $ttf_one_section_data['background-color'] ) && ! empty( $ttf_one_section_data['background-color'] ) ) {
		$gallery_style .= 'background-color:' . maybe_hash_hex_color( $ttf_one_section_data['background-color'] ) . ';';
	}

	// Background image
	if ( isset( $ttf_one_section_data['background-image'] ) && 0 !== absint( $ttf_one_section_data['background-image'] ) ) {
		$image_src = wp_get_attachment_image_src( $ttf_one_section_data['background-image'], 'full' );
		if ( isset( $image_src[0] ) ) {
			$gallery_style .= 'background-image: url(\'' . addcslashes( esc_url_raw( $image_src[0] ), '"' ) . '\');';
		}
	}

	return $gallery_style;
}