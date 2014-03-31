<?php
ttf_one_load_section_header();
global $ttf_one_section_data, $ttf_one_is_js_template;
$section_name = ttf_one_get_section_name( $ttf_one_section_data, $ttf_one_is_js_template );
$columns = ( isset( $ttf_one_section_data['data']['columns'] ) ) ? $ttf_one_section_data['data']['columns'] : 1 ;
$captions = ( isset( $ttf_one_section_data['data']['captions'] ) ) ? $ttf_one_section_data['data']['captions'] : 'none' ;
?>

<div class="ttf-one-columns-select-wrapper">
	<label for="ttf-one-gallery-columns"><?php _e( 'Columns', 'ttf-one' ); ?></label>
	<select id="ttf-one-gallery-columns" name="<?php echo $section_name; ?>[columns]">
		<option value="1"<?php selected( 1, $columns ); ?>>1</option>
		<option value="2"<?php selected( 2, $columns ); ?>>2</option>
		<option value="3"<?php selected( 3, $columns ); ?>>3</option>
		<option value="4"<?php selected( 4, $columns ); ?>>4</option>
	</select>
</div>

<div class="ttf-one-captions-select-wrapper">
	<label for="ttf-one-gallery-captions"><?php _e( 'Caption Style', 'ttf-one' ); ?></label>
	<select id="ttf-one-gallery-captions" name="<?php echo $section_name; ?>[captions]">
		<option value="none"<?php selected( 'none', $captions ); ?>><?php echo esc_html( __( 'None', 'ttf-one' ) ); ?></option>
		<option value="basic"<?php selected( 'basic', $captions ); ?>><?php echo esc_html( __( 'Basic', 'ttf-one' ) ); ?></option>
		<option value="fancy"<?php selected( 'fancy', $captions ); ?>><?php echo esc_html( __( 'Fancy', 'ttf-one' ) ); ?></option>
	</select>
</div>

<div class="ttf-one-gallery-background-wrapper">
	<a href="#" class="ttf-one-gallery-background"><?php _e( 'Set a background image or color', 'ttf-one' ); ?></a>
</div>

<div class="ttf-one-gallery-add-item-wrapper">
	<a href="#" class="ttf-one-gallery-add-item"><?php _e( 'Add a new gallery item', 'ttf-one' ); ?></a>
</div>

<div class="ttf-one-gallery-items">
	<div class="ttf-one-gallery-items-stage">
		<?php if ( isset( $ttf_one_section_data['data']['gallery-items'] ) && is_array( $ttf_one_section_data['data']['gallery-items'] ) ) : ?>
			<?php foreach ( $ttf_one_section_data['data']['gallery-items'] as $id => $item ) : ?>
				<?php global $ttf_one_gallery_id; $ttf_one_gallery_id = $id; ?>
				<?php get_template_part( '/inc/builder/sections/builder-templates/gallery', 'item' ); ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<input type="hidden" value="" name="ttf-one-gallery-item-order" class="ttf-one-gallery-item-order" />
</div>

<input type="hidden" class="ttf-one-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $ttf_one_section_data['data']['state'] ) ) echo esc_attr( $ttf_one_section_data['data']['state'] ); else echo 'open'; ?>" />
<?php ttf_one_load_section_footer(); ?>