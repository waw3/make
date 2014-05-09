<?php
/**
 * @package Make
 */

ttfmake_load_section_header();

global $ttfmake_section_data, $ttfmake_is_js_template;
$section_name     = ttfmake_get_section_name( $ttfmake_section_data, $ttfmake_is_js_template );

$keys = array(
	'columns',
	'caption-color',
	'captions',
	'aspect',
	'background-image',
	'title',
	'darken',
	'background-color',
	'background-style',
);
$data = ttfmake_parse_section_data( $ttfmake_section_data['data'], $keys, 'gallery' );

$section_order    = ( ! empty( $data['gallery-item-order'] ) ) ? $data['gallery-item-order'] : array();
?>

<div class="ttfmake-captions-select-wrapper">
	<label for="<?php echo $section_name; ?>[caption-color]"><?php _e( 'Caption color:', 'make' ); ?></label>
	<select id="<?php echo $section_name; ?>[caption-color]" name="<?php echo $section_name; ?>[caption-color]">
		<?php foreach ( ttfmake_get_section_choices( 'caption-color', 'gallery' ) as $value => $label ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, ttfmake_sanitize_section_choice( $data['caption-color'], 'caption-color', 'gallery' ) ); ?>>
				<?php echo esc_html( $label ); ?>
			</option>
		<?php endforeach; ?>
	</select>
</div>

<div class="ttfmake-captions-select-wrapper">
	<label for="<?php echo $section_name; ?>[captions]"><?php _e( 'Caption style:', 'make' ); ?></label>
	<select id="<?php echo $section_name; ?>[captions]" name="<?php echo $section_name; ?>[captions]">
		<?php foreach ( ttfmake_get_section_choices( 'captions', 'gallery' ) as $value => $label ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, ttfmake_sanitize_section_choice( $data['captions'], 'captions', 'gallery' ) ); ?>>
				<?php echo esc_html( $label ); ?>
			</option>
		<?php endforeach; ?>
	</select>
</div>

<div class="ttfmake-aspect-select-wrapper">
	<label for="<?php echo $section_name; ?>[aspect]"><?php _e( 'Aspect ratio:', 'make' ); ?></label>
	<select id="<?php echo $section_name; ?>[aspect]" name="<?php echo $section_name; ?>[aspect]">
		<?php foreach ( ttfmake_get_section_choices( 'aspect', 'gallery' ) as $value => $label ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, ttfmake_sanitize_section_choice( $data['aspect'], 'aspect', 'gallery' ) ); ?>>
				<?php echo esc_html( $label ); ?>
			</option>
		<?php endforeach; ?>
	</select>
</div>

<div class="ttfmake-columns-select-wrapper">
	<label for="<?php echo $section_name; ?>[columns]"><?php _e( 'Columns:', 'make' ); ?></label>
	<select id="<?php echo $section_name; ?>[columns]" name="<?php echo $section_name; ?>[columns]" class="ttfmake-gallery-columns">
		<?php foreach ( ttfmake_get_section_choices( 'columns', 'gallery' ) as $value => $label ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, ttfmake_sanitize_section_choice( $data['columns'], 'columns', 'gallery' ) ); ?>>
				<?php echo esc_html( $label ); ?>
			</option>
		<?php endforeach; ?>
	</select>
</div>

<div class="ttfmake-add-gallery-item-wrapper">
	<a href="#" class="button button-primary ttfmake-button-large button-large ttfmake-gallery-add-item"><?php _e( 'Add New Item', 'make' ); ?></a>
</div>

<div class="ttfmake-gallery-items">
	<div class="ttfmake-gallery-items-stage ttfmake-gallery-columns-<?php echo absint( $data['columns'] ); ?>">
		<?php foreach ( $section_order as $key => $section_id  ) : ?>
			<?php if ( isset( $data['gallery-items'][ $section_id ] ) ) : ?>
				<?php global $ttfmake_gallery_id; $ttfmake_gallery_id = $section_id; ?>
				<?php get_template_part( 'inc/builder/sections/builder-templates/gallery', 'item' ); ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<input type="hidden" value="<?php echo esc_attr( implode( ',', $section_order ) ); ?>" name="<?php echo $section_name; ?>[gallery-item-order]" class="ttfmake-gallery-item-order" />
</div>

<div class="ttfmake-gallery-background-options-container">
	<h2 class="ttfmake-large-title ttfmake-gallery-options-heading">
		<?php _e( 'Options', 'make' ); ?>
	</h2>

	<div class="ttfmake-titlediv">
		<div class="ttfmake-titlewrap">
			<input placeholder="<?php esc_attr_e( 'Enter title here', 'make' ); ?>" type="text" name="<?php echo $section_name; ?>[title]" class="ttfmake-title ttfmake-section-header-title-input" value="<?php echo esc_attr( htmlspecialchars( $data['title'] ) ); ?>" autocomplete="off" />
		</div>
	</div>

	<div class="ttfmake-gallery-background-image-wrapper">
		<?php
			ttfmake_get_builder_base()->add_uploader(
				$section_name . '[background-image]',
				ttfmake_sanitize_image_id( $data['background-image'] ),
				array(
					'add'    => __( 'Set background image', 'make' ),
					'remove' => __( 'Remove background image', 'make' ),
					'title'  => __( 'Background image', 'make' ),
					'button' => __( 'Use as Background Image', 'make' ),
				)
			);
		?>
	</div>

	<div class="ttfmake-gallery-background-options-wrapper">
		<h4><?php _e( 'Background image', 'make' ); ?></h4>
		<input id="<?php echo $section_name; ?>[darken]" type="checkbox" name="<?php echo $section_name; ?>[darken]" value="1"<?php checked( $data['darken'] ); ?> />
		<label for="<?php echo $section_name; ?>[darken]">
			<?php _e( 'Darken to improve readability', 'make' ); ?>
		</label>

		<h4><?php _e( 'Background color', 'make' ); ?></h4>
		<input id="<?php echo $section_name; ?>[background-color]" type="text" name="<?php echo $section_name . '[background-color]'; ?>" class="ttfmake-gallery-background-color" value="<?php echo maybe_hash_hex_color( $data['background-color'] ); ?>" />

		<h4><?php _e( 'Background style:', 'make' ); ?></h4>
		<select id="<?php echo $section_name; ?>[background-style]" name="<?php echo $section_name; ?>[background-style]">
			<?php foreach ( ttfmake_get_section_choices( 'background-style', 'gallery' ) as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, ttfmake_sanitize_section_choice( $data['background-style'], 'background-style', 'gallery' ) ); ?>>
					<?php echo esc_html( $label ); ?>
				</option>
			<?php endforeach; ?>
		</select>
	</div>
</div>

<input type="hidden" class="ttfmake-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $data['state'] ) ) echo esc_attr( $data['state'] ); else echo 'open'; ?>" />
<?php ttfmake_load_section_footer();