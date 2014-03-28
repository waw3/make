<?php global $ttf_one_section_data, $ttf_one_is_js_template; ?>
<?php $section_name = ttf_one_get_section_name( $ttf_one_section_data, $ttf_one_is_js_template ); ?>
<?php if ( true !== $ttf_one_is_js_template ) : ?>
<div class="ttf-one-gallery-item" id="ttf-one-gallery-item-<?php echo esc_attr( $ttf_one_section_data['data']['id'] ); ?>">
<?php endif; ?>
	<div class="ttf-one-titlediv">
		<div class="ttf-one-titlewrap">
			<input placeholder="<?php esc_attr_e( 'Enter title here', 'ttf-one' ); ?>" type="text" name="<?php echo $section_name; ?>[title]" class="ttf-one-title ttf-one-section-header-title-input" value="" autocomplete="off" />
		</div>
	</div>

	<div class="ttf-one-titlediv">
		<input placeholder="<?php esc_attr_e( 'Enter link here', 'ttf-one' ); ?>" type="text" name="<?php echo $section_name; ?>[image-link]" class="ttf-one-link widefat" value="" autocomplete="off" />
	</div>

	<?php ttf_one_get_builder_base()->add_uploader( $section_name, 0 ); ?>
<?php if ( true !== $ttf_one_is_js_template ) : ?>
</div>
<?php endif; ?>