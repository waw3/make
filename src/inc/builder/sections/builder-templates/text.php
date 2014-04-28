<?php
/**
 * @package ttf-one
 */

ttf_one_load_section_header();

global $ttf_one_section_data, $ttf_one_is_js_template;
$section_name   = ttf_one_get_section_name( $ttf_one_section_data, $ttf_one_is_js_template );
$columns_number = ( isset( $ttf_one_section_data['data']['columns-number'] ) ) ? $ttf_one_section_data['data']['columns-number'] : 3;
$section_order  = ( ! empty( $ttf_one_section_data['data']['columns-order'] ) ) ? $ttf_one_section_data['data']['columns-order'] : range(1, 4);
$columns_class  = ( in_array( $columns_number, range( 1, 4 ) ) && true !== $ttf_one_is_js_template ) ? $columns_number : 3;
?>

<div class="ttf-one-columns-select ttf-one-select">
	<label for="<?php echo $section_name; ?>[columns-number]"><?php _e( 'Columns:', 'ttf-one' ); ?></label>
	<select id="<?php echo $section_name; ?>[columns-number]" class="ttf-one-text-columns" name="<?php echo $section_name; ?>[columns-number]">
		<option value="1"<?php selected( 1, $columns_number ); ?>>1</option>
		<option value="2"<?php selected( 2, $columns_number ); ?>>2</option>
		<option value="3"<?php selected( 3, $columns_number ); ?>>3</option>
		<option value="4"<?php selected( 4, $columns_number ); ?>>4</option>
	</select>
</div>

<div class="ttf-one-text-columns-stage ttf-one-text-columns-<?php echo $columns_class; ?>">
	<?php $j = 1; foreach ( $section_order as $key => $i ) : ?>
	<?php
		$column_name = $section_name . '[columns][' . $i . ']';
		$link     = ( isset( $ttf_one_section_data['data']['columns'][ $i ]['image-link'] ) ) ? $ttf_one_section_data['data']['columns'][ $i ]['image-link'] : '';
		$image_id = ( isset( $ttf_one_section_data['data']['columns'][ $i ]['image-id'] ) ) ? $ttf_one_section_data['data']['columns'][ $i ]['image-id'] : 0;
		$title    = ( isset( $ttf_one_section_data['data']['columns'][ $i ]['title'] ) ) ? $ttf_one_section_data['data']['columns'][ $i ]['title'] : '';
		$content  = ( isset( $ttf_one_section_data['data']['columns'][ $i ]['content'] ) ) ? $ttf_one_section_data['data']['columns'][ $i ]['content'] : '';
	?>
	<div class="ttf-one-text-column ttf-one-text-column-position-<?php echo $j; ?>" data-id="<?php echo $i; ?>">
		<div title="<?php esc_attr_e( 'Drag-and-drop this column into place', 'ttf-one' ); ?>" class="ttf-one-sortable-handle">
			<div class="sortable-background"></div>
		</div>

		<div class="ttf-one-titlediv">
			<input placeholder="<?php esc_attr_e( 'Enter link here', 'ttf-one' ); ?>" type="text" name="<?php echo $column_name; ?>[image-link]" class="ttf-one-link code widefat" value="<?php echo esc_url( $link ); ?>" autocomplete="off" />
		</div>

		<?php ttf_one_get_builder_base()->add_uploader( $column_name, absint( $image_id ) ); ?>

		<div class="ttf-one-titlediv">
			<div class="ttf-one-titlewrap">
				<input placeholder="<?php esc_attr_e( 'Enter title here', 'ttf-one' ); ?>" type="text" name="<?php echo $column_name; ?>[title]" class="ttf-one-title ttf-one-section-header-title-input" value="<?php echo esc_attr( htmlspecialchars( $title ) ); ?>" autocomplete="off" />
			</div>
		</div>

		<?php
		$editor_settings = array(
			'tinymce'       => array(
				'toolbar1' => 'bold,italic,link',
				'toolbar2' => '',
				'toolbar3' => '',
				'toolbar4' => '',
			),
			'quicktags'     => array(
				'buttons' => 'strong,em,link',
			),
			'textarea_name' => $column_name . '[content]'
		);

		if ( true === $ttf_one_is_js_template ) : ?>
			<?php ttf_one_get_builder_base()->wp_editor( '', 'ttfoneeditortextcolumn' . $i . 'temp', $editor_settings ); ?>
		<?php else : ?>
			<?php ttf_one_get_builder_base()->wp_editor( $content, 'ttfoneeditortext' . $ttf_one_section_data['data']['id'] . $i, $editor_settings ); ?>
		<?php endif; ?>
	</div>
	<?php $j++; endforeach; ?>
</div>

<div class="clear"></div>

<input type="hidden" value="<?php echo esc_attr( implode( ',', $section_order ) ); ?>" name="<?php echo $section_name; ?>[columns-order]" class="ttf-one-text-columns-order" />
<input type="hidden" class="ttf-one-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $ttf_one_section_data['data']['state'] ) ) echo esc_attr( $ttf_one_section_data['data']['state'] ); else echo 'open'; ?>" />
<?php ttf_one_load_section_footer(); ?>