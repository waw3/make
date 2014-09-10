<?php
/**
 * @package Make
 */

ttfmake_load_section_header();

global $ttfmake_section_data, $ttfmake_is_js_template;
$section_id     = ( isset( $ttfmake_section_data['data']['id'] ) ) ? $ttfmake_section_data['data']['id'] : '';
$section_name   = ttfmake_get_section_name( $ttfmake_section_data, $ttfmake_is_js_template );
$columns_number = ( isset( $ttfmake_section_data['data']['columns-number'] ) ) ? $ttfmake_section_data['data']['columns-number'] : 3;
$section_order  = ( ! empty( $ttfmake_section_data['data']['columns-order'] ) ) ? $ttfmake_section_data['data']['columns-order'] : range(1, 4);
$columns_class  = ( in_array( $columns_number, range( 1, 4 ) ) && true !== $ttfmake_is_js_template ) ? $columns_number : 3;
?>

<?php if ( false === ttfmake_is_plus() ) : ?>
<div class="ttfmake-plus-info">
	<p>
		<em>
		<?php
		printf(
			__( '%s and convert any column into an area for widgets.', 'make' ),
			sprintf(
				'<a href="%1$s" target="_blank">%2$s</a>',
				esc_url( ttfmake_get_plus_link( 'widget-area' ) ),
				sprintf(
					__( 'Upgrade to %s', 'make' ),
					'Make Plus'
				)
			)
		);
		?>
		</em>
	</p>
</div>
<?php endif; ?>
<?php
/**
 * Execute code before the columns select input is displayed.
 *
 * @since 1.2.3.
 *
 * @param array    $ttfmake_section_data    The data for the section.
 */
do_action( 'ttfmake_section_text_before_columns_select', $ttfmake_section_data );

/**
 * Execute code after the columns select input is displayed.
 *
 * @since 1.2.3.
 *
 * @param array    $ttfmake_section_data    The data for the section.
 */
do_action( 'ttfmake_section_text_after_columns_select', $ttfmake_section_data );

/**
 * Execute code after the section title is displayed.
 *
 * @since 1.2.3.
 *
 * @param array    $ttfmake_section_data    The data for the section.
 */
do_action( 'ttfmake_section_text_after_title', $ttfmake_section_data ); ?>

<div class="ttfmake-text-columns-stage ttfmake-text-columns-<?php echo $columns_class; ?>">
	<?php $j = 1; foreach ( $section_order as $key => $i ) : ?>
	<?php
		$column_name = $section_name . '[columns][' . $i . ']';
		$iframe_id   = 'ttfmake-iframe-' . $section_id . '-' . $i;
		$textarea_id = 'ttfmake-content-' . $section_id . '-' . $i;
		$link        = ( isset( $ttfmake_section_data['data']['columns'][ $i ]['image-link'] ) ) ? $ttfmake_section_data['data']['columns'][ $i ]['image-link'] : '';
		$image_id    = ( isset( $ttfmake_section_data['data']['columns'][ $i ]['image-id'] ) ) ? $ttfmake_section_data['data']['columns'][ $i ]['image-id'] : 0;
		$title       = ( isset( $ttfmake_section_data['data']['columns'][ $i ]['title'] ) ) ? $ttfmake_section_data['data']['columns'][ $i ]['title'] : '';
		$content     = ( isset( $ttfmake_section_data['data']['columns'][ $i ]['content'] ) ) ? $ttfmake_section_data['data']['columns'][ $i ]['content'] : '';

		$column_buttons = array(
			100 => array(
				'label'              => __( 'Edit text column', 'make' ),
				'href'               => '#',
				'class'              => 'edit-content-link edit-text-column-link',
				'title'              => __( 'Edit content', 'make' ),
				'other-a-attributes' => 'data-textarea="' . esc_attr( $textarea_id ) . '" data-iframe="' . esc_attr( $iframe_id ) . '"',
			),
		);

		/**
		 * Filter the buttons added to a text column.
		 *
		 * @since 1.4.0.
		 *
		 * @param array    $column_buttons          The current list of buttons.
		 * @param array    $column_data             The data for the current column.
		 * @param array    $ttfmake_section_data    All data for the section.
		 */
		$column_buttons = apply_filters( 'make_column_buttons', $column_buttons, $ttfmake_section_data['data']['columns'][$i], $ttfmake_section_data );
	?>
	<div class="<?php echo esc_attr( apply_filters( 'ttfmake-text-column-classes', 'ttfmake-text-column ttfmake-text-column-position-' . $j, $i, $ttfmake_section_data ) ); ?>" data-id="<?php echo $i; ?>">
		<div title="<?php esc_attr_e( 'Drag-and-drop this column into place', 'make' ); ?>" class="ttfmake-sortable-handle">
			<div class="sortable-background"></div>
		</div>

		<?php
		/**
		 * Execute code before an individual text column is displayed.
		 *
		 * @since 1.2.3.
		 *
		 * @param array    $ttfmake_section_data    The data for the section.
		 */
		do_action( 'make_section_text_before_column', $ttfmake_section_data, $i );
		?>

		<div class="ttfmake-titlediv">
			<div class="ttfmake-titlewrap">
				<input placeholder="<?php esc_attr_e( 'Enter column title', 'make' ); ?>" type="text" name="<?php echo $column_name; ?>[title]" class="ttfmake-title ttfmake-section-header-title-input" value="<?php echo esc_attr( htmlspecialchars( $title ) ); ?>" autocomplete="off" />

				<?php foreach ( $column_buttons as $button ) : ?>
				<a href="<?php echo esc_url( $button['href'] ); ?>" class="<?php esc_attr_e( $button['class'] ); ?>" title="<?php esc_attr_e( $button['title'] ); ?>" <?php if ( ! empty( $button['other-a-attributes'] ) ) echo $button['other-a-attributes']; ?>>
					<span>
						<?php echo esc_html( $button['label'] ); ?>
					</span>
				</a>
				<?php endforeach; ?>
			</div>
		</div>

		<?php echo ttfmake_get_builder_base()->add_uploader( $column_name, ttfmake_sanitize_image_id( $image_id ) ); ?>
		<?php ttfmake_get_builder_base()->add_frame( $section_id . '-' . $i, $column_name . '[content]', $content ); ?>

		<?php
		/**
		 * Execute code after an individual text column is displayed.
		 *
		 * @since 1.2.3.
		 *
		 * @param array    $ttfmake_section_data    The data for the section.
		 */
		do_action( 'ttfmake_section_text_after_column', $ttfmake_section_data, $i );
		?>
	</div>
	<?php $j++; endforeach; ?>
</div>

<?php
/**
 * Execute code after all columns are displayed.
 *
 * @since 1.2.3.
 *
 * @param array    $ttfmake_section_data    The data for the section.
 */
do_action( 'make_section_text_after_columns', $ttfmake_section_data );
?>

<div class="clear"></div>

<input type="hidden" value="<?php echo esc_attr( implode( ',', $section_order ) ); ?>" name="<?php echo $section_name; ?>[columns-order]" class="ttfmake-text-columns-order" />
<input type="hidden" class="ttfmake-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $ttfmake_section_data['data']['state'] ) ) echo esc_attr( $ttfmake_section_data['data']['state'] ); else echo 'open'; ?>" />
<?php ttfmake_load_section_footer();