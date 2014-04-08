<?php ttf_one_load_section_header(); ?>
<?php global $ttf_one_section_data, $ttf_one_is_js_template; ?>
<?php $section_name = ttf_one_get_section_name( $ttf_one_section_data, $ttf_one_is_js_template ); ?>

	<div class="ttf-one-titlediv">
		<div class="ttf-one-titlewrap">
			<input placeholder="<?php esc_attr_e( 'Enter title here' ); ?>" type="text" name="<?php echo $section_name; ?>[title]" class="ttf-one-title ttf-one-section-header-title-input" value="<?php if ( isset( $ttf_one_section_data['data']['title'] ) ) echo esc_attr( htmlspecialchars( $ttf_one_section_data['data']['title'] ) ); ?>" autocomplete="off" />
		</div>
	</div>

	<?php
	$editor_settings = array(
		'tinymce'       => true,
		'quicktags'     => true,
		'editor_height' => 345,
		'textarea_name' => $section_name . '[content]'
	);

	if ( true === $ttf_one_is_js_template ) : ?>
		<?php ttf_one_get_builder_base()->wp_editor( '', ttf_one_get_wp_editor_id( $ttf_one_section_data, $ttf_one_is_js_template ), $editor_settings ); ?>
	<?php else : ?>
		<?php $content = ( isset( $ttf_one_section_data['data']['content'] ) ) ? $ttf_one_section_data['data']['content'] : ''; ?>
		<?php ttf_one_get_builder_base()->wp_editor( $content, ttf_one_get_wp_editor_id( $ttf_one_section_data, $ttf_one_is_js_template ), $editor_settings ); ?>
	<?php endif; ?>

	<input type="hidden" class="ttf-one-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $ttf_one_section_data['data']['state'] ) ) echo esc_attr( $ttf_one_section_data['data']['state'] ); else echo 'open'; ?>" />

<?php ttf_one_load_section_footer(); ?>