<?php
/**
 * @package Make
 */

ttfmake_load_section_header();

global $ttfmake_section_data, $ttfmake_is_js_template;
$section_name   = ttfmake_get_section_name( $ttfmake_section_data, $ttfmake_is_js_template );

$section_keys = array(
	'columns-number',
	'title',
);
$section_data = ttfmake_parse_section_data( $ttfmake_section_data['data'], $section_keys, 'text' );

$columns_number = ttfmake_sanitize_section_choice( $section_data['columns-number'], 'columns-number', 'text' );
$columns_class  = ( true !== $ttfmake_is_js_template ) ? $columns_number : 3;

$section_order  = ( ! empty( $section_data['columns-order'] ) ) ? $section_data['columns-order'] : range( 1, 4 );
?>

<div class="ttfmake-columns-select ttfmake-select">
	<label for="<?php echo $section_name; ?>[columns-number]"><?php _e( 'Columns:', 'make' ); ?></label>
	<select id="<?php echo $section_name; ?>[columns-number]" class="ttfmake-text-columns" name="<?php echo $section_name; ?>[columns-number]">
		<?php foreach ( ttfmake_get_section_choices( 'columns-number', 'text' ) as $value => $label ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, $columns_number ); ?>>
				<?php echo esc_html( $label ); ?>
			</option>
		<?php endforeach; ?>
	</select>
</div>

<div class="ttfmake-titlediv">
	<div class="ttfmake-titlewrap">
		<input placeholder="<?php esc_attr_e( 'Enter title here' ); ?>" type="text" name="<?php echo $section_name; ?>[title]" class="ttfmake-title ttfmake-section-header-title-input" value="<?php echo esc_attr( htmlspecialchars( $section_data['title'] ) ); ?>" autocomplete="off" />
	</div>
</div>

<div class="ttfmake-text-columns-stage ttfmake-text-columns-<?php echo $columns_class; ?>">
	<?php $j = 1; foreach ( $section_order as $key => $i ) : ?>
	<?php
		$column_keys = array(
			'title',
			'image-link',
			'image-id',
			'content'
		);
		$column = ( isset( $ttfmake_section_data['data']['columns'][ $i ] ) ) ? $ttfmake_section_data['data']['columns'][ $i ] : array();
		$column_data = ttfmake_parse_section_data( $column, $column_keys, 'text-column' );
		$column_name = $section_name . '[columns][' . $i . ']';
	?>
	<div class="ttfmake-text-column ttfmake-text-column-position-<?php echo $j; ?>" data-id="<?php echo $i; ?>">
		<div title="<?php esc_attr_e( 'Drag-and-drop this column into place', 'make' ); ?>" class="ttfmake-sortable-handle">
			<div class="sortable-background"></div>
		</div>

		<?php do_action( 'ttfmake_section_text_before_column', $ttfmake_section_data, $i ); ?>

		<div class="ttfmake-titlediv">
			<input placeholder="<?php esc_attr_e( 'Enter link here', 'make' ); ?>" type="text" name="<?php echo $column_name; ?>[image-link]" class="ttfmake-link code widefat" value="<?php echo esc_url( $column_data['image-link'] ); ?>" autocomplete="off" />
		</div>

		<?php ttfmake_get_builder_base()->add_uploader( $column_name, ttfmake_sanitize_image_id( $column_data['image-id'] ) ); ?>

		<div class="ttfmake-titlediv">
			<div class="ttfmake-titlewrap">
				<input placeholder="<?php esc_attr_e( 'Enter title here', 'make' ); ?>" type="text" name="<?php echo $column_name; ?>[title]" class="ttfmake-title ttfmake-section-header-title-input" value="<?php echo esc_attr( htmlspecialchars( $column_data['title'] ) ); ?>" autocomplete="off" />
			</div>
		</div>

		<?php
		$editor_settings = array(
			'tinymce'       => array(
				'toolbar1' => 'bold,italic,link,ttfmake_mce_button_button',
				'toolbar2' => '',
				'toolbar3' => '',
				'toolbar4' => '',
			),
			'quicktags'     => array(
				'buttons' => 'strong,em,link',
			),
			'textarea_name' => $column_name . '[content]'
		);

		if ( true === $ttfmake_is_js_template ) : ?>
			<?php ttfmake_get_builder_base()->wp_editor( '', 'ttfmakeeditortextcolumn' . $i . 'temp', $editor_settings ); ?>
		<?php else : ?>
			<?php ttfmake_get_builder_base()->wp_editor( $column_data['content'], 'ttfmakeeditortext' . $section_data['id'] . $i, $editor_settings ); ?>
		<?php endif; ?>

		<?php do_action( 'ttfmake_section_text_after_column', $ttfmake_section_data, $i ); ?>
	</div>
	<?php $j++; endforeach; ?>
</div>

<div class="clear"></div>

<input type="hidden" value="<?php echo esc_attr( implode( ',', $section_order ) ); ?>" name="<?php echo $section_name; ?>[columns-order]" class="ttfmake-text-columns-order" />
<input type="hidden" class="ttfmake-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $section_data['state'] ) ) echo esc_attr( $section_data['state'] ); else echo 'open'; ?>" />
<?php ttfmake_load_section_footer();