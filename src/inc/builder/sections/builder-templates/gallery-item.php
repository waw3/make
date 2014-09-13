<?php
/**
 * @package Make
 */

global $ttfmake_section_data, $ttfmake_is_js_template, $ttfmake_gallery_id;
$section_name = 'ttfmake-section';
if ( true === $ttfmake_is_js_template ) {
	$section_name .= '[{{{ parentID }}}][gallery-items][{{{ id }}}]';
} else {
	$section_name .= '[' . $ttfmake_section_data['data']['id'] . '][gallery-items][' . $ttfmake_gallery_id . ']';
}

$title       = ( isset( $ttfmake_section_data['data']['gallery-items'][ $ttfmake_gallery_id ]['title'] ) ) ? $ttfmake_section_data['data']['gallery-items'][ $ttfmake_gallery_id ]['title'] : '';
$link        = ( isset( $ttfmake_section_data['data']['gallery-items'][ $ttfmake_gallery_id ]['link'] ) ) ? $ttfmake_section_data['data']['gallery-items'][ $ttfmake_gallery_id ]['link'] : '';
$image_id    = ( isset( $ttfmake_section_data['data']['gallery-items'][ $ttfmake_gallery_id ]['image-id'] ) ) ? $ttfmake_section_data['data']['gallery-items'][ $ttfmake_gallery_id ]['image-id'] : 0;
$description = ( isset( $ttfmake_section_data['data']['gallery-items'][ $ttfmake_gallery_id ]['description'] ) ) ? $ttfmake_section_data['data']['gallery-items'][ $ttfmake_gallery_id ]['description'] : '';

// Set up the combined section + slide ID
$section_id  = ( isset( $ttfmake_section_data['data']['id'] ) ) ? $ttfmake_section_data['data']['id'] : '';
$combined_id = ( true === $ttfmake_is_js_template ) ? '{{{ parentID }}}-{{{ id }}}' : $section_id . '-' . $ttfmake_gallery_id;
?>

<?php if ( true !== $ttfmake_is_js_template ) : ?>
<div class="ttfmake-gallery-item" id="ttfmake-gallery-item-<?php echo esc_attr( $ttfmake_gallery_id ); ?>" data-id="<?php echo esc_attr( $ttfmake_gallery_id ); ?>" data-section-type="gallery-item">
<?php endif; ?>

	<div title="<?php esc_attr_e( 'Drag-and-drop this item into place', 'make' ); ?>" class="ttfmake-sortable-handle">
		<div class="sortable-background"></div>
	</div>

	<?php echo ttfmake_get_builder_base()->add_uploader( $section_name, ttfmake_sanitize_image_id( $image_id ) ); ?>

	<a href="#" class="configure-gallery-item-link" title="<?php esc_attr_e( 'Configure item', 'make' ); ?>">
		<span>
			<?php _e( 'Configure item', 'make' ); ?>
		</span>
	</a>
	<a href="#" class="edit-content-link edit-gallery-item-link<?php if ( ! empty( $description ) ) : ?> item-has-content<?php endif; ?>" data-textarea="ttfmake-content-<?php echo $combined_id; ?>" title="<?php esc_attr_e( 'Edit content', 'make' ); ?>">
		<span>
			<?php _e( 'Edit content', 'make' ); ?>
		</span>
	</a>
	<a href="#" class="remove-gallery-item-link ttfmake-gallery-item-remove" title="<?php esc_attr_e( 'Delete item', 'make' ); ?>">
		<span>
			<?php _e( 'Delete item', 'make' ); ?>
		</span>
	</a>

	<?php ttfmake_get_builder_base()->add_frame( $combined_id, $section_name . '[description]', $description, false ); ?>

<?php if ( true !== $ttfmake_is_js_template ) : ?>
</div>
<?php endif; ?>