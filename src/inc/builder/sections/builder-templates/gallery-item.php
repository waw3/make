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
?>

<?php if ( true !== $ttfmake_is_js_template ) : ?>
<div class="ttfmake-gallery-item" id="ttfmake-gallery-item-<?php echo esc_attr( $ttfmake_gallery_id ); ?>" data-id="<?php echo esc_attr( $ttfmake_gallery_id ); ?>" data-section-type="gallery-item">
<?php endif; ?>

	<div title="<?php esc_attr_e( 'Drag-and-drop this column into place', 'make' ); ?>" class="ttfmake-sortable-handle">
		<div class="sortable-background"></div>
	</div>

	<?php echo ttfmake_get_builder_base()->add_uploader( $section_name, ttfmake_sanitize_image_id( $image_id ) ); ?>

	<a href="#" class="edit-gallery-item-link">
		<span>
			<?php _e( 'Edit gallery item', 'make' ); ?>
		</span>
	</a>
	<a href="#" class="remove-gallery-item-link">
		<span>
			<?php _e( 'Remove gallery item', 'make' ); ?>
		</span>
	</a>

<?php if ( true !== $ttfmake_is_js_template ) : ?>
</div>
<?php endif; ?>