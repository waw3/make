<?php global $ttf_one_section_data, $ttf_one_is_js_template, $ttf_one_gallery_id; ?>
<?php
$section_name = 'ttf-one-section';
if ( true === $ttf_one_is_js_template ) {
	$section_name .= '[{{{ parentID }}}][gallery-items][{{{ id }}}]';
} else {
	$section_name .= '[' . $ttf_one_section_data['data']['id'] . '][gallery-items][' . $ttf_one_gallery_id . ']';
}

$title       = ( isset( $ttf_one_section_data['data']['gallery-items'][ $ttf_one_gallery_id ]['title'] ) ) ? $ttf_one_section_data['data']['gallery-items'][ $ttf_one_gallery_id ]['title'] : '';
$link        = ( isset( $ttf_one_section_data['data']['gallery-items'][ $ttf_one_gallery_id ]['link'] ) ) ? $ttf_one_section_data['data']['gallery-items'][ $ttf_one_gallery_id ]['link'] : '';
$image_id    = ( isset( $ttf_one_section_data['data']['gallery-items'][ $ttf_one_gallery_id ]['image-id'] ) ) ? $ttf_one_section_data['data']['gallery-items'][ $ttf_one_gallery_id ]['image-id'] : 0;
$description = ( isset( $ttf_one_section_data['data']['gallery-items'][ $ttf_one_gallery_id ]['description'] ) ) ? $ttf_one_section_data['data']['gallery-items'][ $ttf_one_gallery_id ]['description'] : '';
?>
<?php if ( true !== $ttf_one_is_js_template ) : ?>
<div class="ttf-one-gallery-item" id="ttf-one-gallery-item-<?php echo esc_attr( $ttf_one_gallery_id ); ?>" data-id="<?php echo esc_attr( $ttf_one_gallery_id ); ?>">
<?php endif; ?>
	<div title="<?php esc_attr_e( 'Drag-and-drop this column into place', 'ttf-one' ); ?>" class="ttf-one-sortable-handle">
		<div class="sortable-background"></div>
	</div>

	<div class="ttf-one-titlediv">
		<input placeholder="<?php esc_attr_e( 'Enter link here', 'ttf-one' ); ?>" type="text" name="<?php echo $section_name; ?>[link]" class="ttf-one-link code widefat" value="<?php echo esc_url( $link ); ?>" autocomplete="off" />
	</div>

	<?php ttf_one_get_builder_base()->add_uploader( $section_name, absint( $image_id ) ); ?>

	<div class="ttf-one-titlediv">
		<div class="ttf-one-titlewrap">
			<input placeholder="<?php esc_attr_e( 'Enter title here', 'ttf-one' ); ?>" type="text" name="<?php echo $section_name; ?>[title]" class="ttf-one-title" value="<?php echo esc_attr( htmlspecialchars( $title ) ); ?>" autocomplete="off" />
		</div>
	</div>

	<div class="ttf-one-gallery-item-description-wrapper">
		<textarea placeholder="<?php esc_attr_e( 'Enter description here', 'ttf-one' ); ?>" name="<?php echo $section_name; ?>[description]"><?php echo esc_textarea( $description ); ?></textarea>
	</div>

	<a href="#" class="ttf-one-gallery-item-remove">
		<?php _e( 'Remove gallery item', 'ttf-one' ); ?>
	</a>
<?php if ( true !== $ttf_one_is_js_template ) : ?>
</div>
<?php endif; ?>