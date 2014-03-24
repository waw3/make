<?php ttf_one_load_section_header(); ?>
<?php global $ttf_one_section_data, $ttf_one_is_js_template; ?>
<?php $section_name = ttf_one_get_section_name( $ttf_one_section_data, $ttf_one_is_js_template ); ?>

<input type="hidden" class="ttf-one-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $ttf_one_section_data['data']['state'] ) ) echo esc_attr( $ttf_one_section_data['data']['state'] ); else echo 'open'; ?>" />
<?php ttf_one_load_section_footer(); ?>