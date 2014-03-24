<?php ttf_one_load_section_header(); ?>
<?php global $ttf_one_section_data, $ttf_one_is_js_template; ?>
<?php $section_name = ttf_one_get_section_name( $ttf_one_section_data, $ttf_one_is_js_template ); ?>

<div class="ttf-one-columns-select">
	<label for="ttf-one-gallery-columns"><?php _e( 'Columns', 'ttf-one' ); ?></label>
	<select id="ttf-one-gallery-columns">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
	</select>
</div>

<div class="ttf-one-captions-select">
	<label for="ttf-one-gallery-captions"><?php _e( 'Caption Style', 'ttf-one' ); ?></label>
	<select id="ttf-one-gallery-captions">
		<option value="none"><?php echo esc_html( __( 'None', 'ttf-one' ) ); ?></option>
		<option value="basic"><?php echo esc_html( __( 'Basic', 'ttf-one' ) ); ?></option>
		<option value="fancy"><?php echo esc_html( __( 'Fancy', 'ttf-one' ) ); ?></option>
	</select>
</div>

<div class="ttf-one-gallery-background">
	<a href="#"><?php _e( 'Set a background image or color', 'ttf-one' ); ?></a>
</div>

<div class="ttf-one-gallery-add-item">
	<a href="#"><?php _e( 'Add a new gallery item', 'ttf-one' ); ?></a>
</div>

<div class="ttf-one-gallery-items">
	<div class="ttf-one-gallery-item">
		<div class="ttf-one-titlediv">
			<div class="ttf-one-titlewrap">
				<input placeholder="<?php esc_attr_e( 'Enter title here', 'ttf-one' ); ?>" type="text" name="<?php echo $section_name; ?>[title]" class="ttf-one-title ttf-one-section-header-title-input" value="" autocomplete="off" />
			</div>
		</div>

		<div class="ttf-one-titlediv">
			<input placeholder="<?php esc_attr_e( 'Enter link here', 'ttf-one' ); ?>" type="text" name="<?php echo $section_name; ?>[image-link]" class="ttf-one-link widefat" value="" autocomplete="off" />
		</div>

		<?php ttf_one_get_builder_base()->add_uploader( $section_name, 0 ); ?>
	</div>
</div>

<input type="hidden" class="ttf-one-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $ttf_one_section_data['data']['state'] ) ) echo esc_attr( $ttf_one_section_data['data']['state'] ); else echo 'open'; ?>" />
<?php ttf_one_load_section_footer(); ?>