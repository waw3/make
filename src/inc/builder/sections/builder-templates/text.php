<?php ttf_one_load_section_header(); ?>
<?php global $ttf_one_section_data, $ttf_one_is_js_template; ?>
<?php $section_name = ttf_one_get_section_name( $ttf_one_section_data, $ttf_one_is_js_template ); ?>

<div class="ttf-one-columns-select ttf-one-select">
	<label for="ttf-one-gallery-columns"><?php _e( 'Columns', 'ttf-one' ); ?></label>
	<select id="ttf-one-gallery-columns">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
	</select>
</div>

<div class="ttf-one-section-sortable-stage">
	<?php for ( $i = 1; $i <= 4; $i ++ ) : $column_name = $section_name . '[columns][' . $i . ']'; ?>
	<div class="ttf-one-text-column">
		<div title="<?php esc_attr_e( 'Drag-and-drop this column into place', 'ttf-one' ); ?>" class="ttf-one-sortable-handle">
			<div class="sortable-background"></div>
		</div>

		<div class="ttf-one-titlediv">
			<input placeholder="<?php esc_attr_e( 'Enter link here', 'ttf-one' ); ?>" type="text" name="<?php echo $column_name; ?>[image-link]" class="ttf-one-link widefat" value="" autocomplete="off" />
		</div>

		<?php ttf_one_get_builder_base()->add_uploader( $column_name . '[image-id]', 0 ); ?>

		<div class="ttf-one-titlediv">
			<div class="ttf-one-titlewrap">
				<input placeholder="<?php esc_attr_e( 'Enter title here', 'ttf-one' ); ?>" type="text" name="<?php echo $column_name; ?>[title]" class="ttf-one-title ttf-one-section-header-title-input" value="" autocomplete="off" />
			</div>
		</div>

		<?php if ( true === $ttf_one_is_js_template ) : ?>
			<?php ttf_one_get_builder_base()->wp_editor( '', 'ttfoneeditortemptext' . $i ); ?>
		<?php else : ?>
			<?php $content = ( isset( $ttf_one_section_data['data']['content'] ) ) ? $ttf_one_section_data['data']['content'] : ''; ?>
			<?php ttf_one_get_builder_base()->wp_editor( $content, $column_name . '[content]' ); ?>
		<?php endif; ?>
	</div>
	<?php endfor; ?>
</div>

<input type="hidden" class="ttf-one-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $ttf_one_section_data['data']['state'] ) ) echo esc_attr( $ttf_one_section_data['data']['state'] ); else echo 'open'; ?>" />
<?php ttf_one_load_section_footer(); ?>