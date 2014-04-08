<?php
ttf_one_load_section_header();
global $ttf_one_section_data, $ttf_one_is_js_template;
$section_name     = ttf_one_get_section_name( $ttf_one_section_data, $ttf_one_is_js_template );
$columns          = ( isset( $ttf_one_section_data['data']['columns'] ) ) ? $ttf_one_section_data['data']['columns'] : 3;
$captions         = ( isset( $ttf_one_section_data['data']['captions'] ) ) ? $ttf_one_section_data['data']['captions'] : 'basic';
$background_image = ( isset( $ttf_one_section_data['data']['background-image'] ) ) ? $ttf_one_section_data['data']['background-image'] : 0;
$background_color = ( isset( $ttf_one_section_data['data']['background-color'] ) ) ? $ttf_one_section_data['data']['background-color'] : '';
$section_order    = ( ! empty( $ttf_one_section_data['data']['gallery-item-order'] ) ) ? $ttf_one_section_data['data']['gallery-item-order'] : array();
?>

<div class="ttf-one-captions-select-wrapper">
	<label for="<?php echo $section_name; ?>[captions]"><?php _e( 'Caption style:', 'ttf-one' ); ?></label>
	<select id="<?php echo $section_name; ?>[captions]" name="<?php echo $section_name; ?>[captions]">
		<option value="none"<?php selected( 'none', $captions ); ?>><?php echo esc_html( __( 'None', 'ttf-one' ) ); ?></option>
		<option value="basic"<?php selected( 'basic', $captions ); ?>><?php echo esc_html( __( 'Basic', 'ttf-one' ) ); ?></option>
		<option value="fancy"<?php selected( 'fancy', $captions ); ?>><?php echo esc_html( __( 'Fancy', 'ttf-one' ) ); ?></option>
	</select>
</div>

<div class="ttf-one-columns-select-wrapper">
	<label for="<?php echo $section_name; ?>[columns]"><?php _e( 'Columns:', 'ttf-one' ); ?></label>
	<select id="<?php echo $section_name; ?>[columns]" name="<?php echo $section_name; ?>[columns]" class="ttf-one-gallery-columns">
		<option value="1"<?php selected( 1, $columns ); ?>>1</option>
		<option value="2"<?php selected( 2, $columns ); ?>>2</option>
		<option value="3"<?php selected( 3, $columns ); ?>>3</option>
		<option value="4"<?php selected( 4, $columns ); ?>>4</option>
	</select>
</div>

<div class="clear"></div>

<div class="ttf-one-gallery-background-image-wrapper">
	<?php
		ttf_one_get_builder_base()->add_uploader(
			$section_name . '[background-image]',
			$background_image,
			array(
				'add'    => __( 'Set background image', 'ttf-one' ),
				'remove' => __( 'Remove background image', 'ttf-one' ),
				'title'  => __( 'Background image', 'ttf-one' ),
				'button' => __( 'Use as Background Image', 'ttf-one' ),
			)
		);
	?>
</div>

<div class="ttf-one-gallery-background-color-wrapper">
	<h4>
		<?php _e( 'Background color', 'ttf-one' ); ?>
	</h4>
	<input id="<?php echo $section_name; ?>[background-color]" type="text" name="<?php echo $section_name . '[background-color]'; ?>" class="ttf-one-gallery-background-color" value="<?php echo ttf_one_maybe_hash_hex_color( $background_color ); ?>" />
</div>

<div class="ttf-one-add-gallery-item-wrapper">
	<a href="#" class="button button-primary button-large ttf-one-gallery-add-item"><?php _e( 'Add gallery item', 'ttf-one' ); ?></a>
</div>

<div class="ttf-one-gallery-items">
	<div class="ttf-one-gallery-items-stage ttf-one-gallery-columns-<?php echo absint( $columns ); ?>">
		<?php foreach ( $section_order as $key => $section_id  ) : ?>
			<?php if ( isset( $ttf_one_section_data['data']['gallery-items'][ $section_id ] ) ) : ?>
				<?php global $ttf_one_gallery_id; $ttf_one_gallery_id = $section_id; ?>
				<?php get_template_part( '/inc/builder/sections/builder-templates/gallery', 'item' ); ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<input type="hidden" value="<?php echo esc_attr( implode( ',', $section_order ) ); ?>" name="<?php echo $section_name; ?>[gallery-item-order]" class="ttf-one-gallery-item-order" />
</div>

<input type="hidden" class="ttf-one-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $ttf_one_section_data['data']['state'] ) ) echo esc_attr( $ttf_one_section_data['data']['state'] ); else echo 'open'; ?>" />
<?php ttf_one_load_section_footer(); ?>