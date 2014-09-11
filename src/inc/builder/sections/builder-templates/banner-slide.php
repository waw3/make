<?php
/**
 * @package Make
 */

global $ttfmake_section_data, $ttfmake_is_js_template, $ttfmake_slide_id;
$section_name = 'ttfmake-section';
if ( true === $ttfmake_is_js_template ) {
    $section_name .= '[{{{ parentID }}}][banner-slides][{{{ id }}}]';
} else {
    $section_name .= '[' . $ttfmake_section_data['data']['id'] . '][banner-slides][' . $ttfmake_slide_id . ']';
}

$content          = ( isset( $ttfmake_section_data['data']['banner-slides'][ $ttfmake_slide_id ]['content'] ) ) ? $ttfmake_section_data['data']['banner-slides'][ $ttfmake_slide_id ]['content'] : '';
$background_color = ( isset( $ttfmake_section_data['data']['banner-slides'][ $ttfmake_slide_id ]['background-color'] ) ) ? $ttfmake_section_data['data']['banner-slides'][ $ttfmake_slide_id ]['background-color'] : '';
$darken           = ( isset( $ttfmake_section_data['data']['banner-slides'][ $ttfmake_slide_id ]['darken'] ) ) ? $ttfmake_section_data['data']['banner-slides'][ $ttfmake_slide_id ]['darken'] : 0;
$image_id         = ( isset( $ttfmake_section_data['data']['banner-slides'][ $ttfmake_slide_id ]['image-id'] ) ) ? $ttfmake_section_data['data']['banner-slides'][ $ttfmake_slide_id ]['image-id'] : 0;
$alignment        = ( isset( $ttfmake_section_data['data']['banner-slides'][ $ttfmake_slide_id ]['alignment'] ) ) ? $ttfmake_section_data['data']['banner-slides'][ $ttfmake_slide_id ]['alignment'] : 'none';
$state            = ( isset( $ttfmake_section_data['data']['banner-slides'][ $ttfmake_slide_id ]['state'] ) ) ? $ttfmake_section_data['data']['banner-slides'][ $ttfmake_slide_id ]['state'] : 'open';
?>

<?php if ( true !== $ttfmake_is_js_template ) : ?>
<div class="ttfmake-banner-slide" id="ttfmake-banner-slide-<?php echo esc_attr( $ttfmake_slide_id ); ?>" data-id="<?php echo esc_attr( $ttfmake_slide_id ); ?>" data-section-type="banner-slide">
<?php endif; ?>

	<div title="<?php esc_attr_e( 'Drag-and-drop this slide into place', 'make' ); ?>" class="ttfmake-sortable-handle">
		<div class="sortable-background"></div>
	</div>

	<?php echo ttfmake_get_builder_base()->add_uploader( $section_name, ttfmake_sanitize_image_id( $image_id ) ); ?>

	<a href="#" class="edit-banner-slide-link" title="<?php esc_attr_e( 'Edit banner slide', 'make' ); ?>">
		<span>
			<?php _e( 'Edit banner slide', 'make' ); ?>
		</span>
	</a>
	<a href="#" class="remove-banner-slide-link ttfmake-banner-slide-remove" title="<?php esc_attr_e( 'Remove banner slide', 'make' ); ?>">
		<span>
			<?php _e( 'Remove banner slide', 'make' ); ?>
		</span>
	</a>

	<input type="hidden" class="ttfmake-banner-slide-state" name="<?php echo $section_name; ?>[state]" value="<?php echo esc_attr( $state ); ?>" />
<?php if ( true !== $ttfmake_is_js_template ) : ?>
</div>
<?php endif; ?>
