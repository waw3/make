<?php
/**
 * @package ttf-one
 */

ttf_one_load_section_header();

global $ttf_one_section_data, $ttf_one_is_js_template;
$section_name     = ttf_one_get_section_name( $ttf_one_section_data, $ttf_one_is_js_template );
$columns          = ( isset( $ttf_one_section_data['data']['columns'] ) ) ? $ttf_one_section_data['data']['columns'] : 3;
$caption_color    = ( isset( $ttf_one_section_data['data']['caption-color'] ) ) ? $ttf_one_section_data['data']['caption-color'] : 'light';
$captions         = ( isset( $ttf_one_section_data['data']['captions'] ) ) ? $ttf_one_section_data['data']['captions'] : 'reveal';
$aspect           = ( isset( $ttf_one_section_data['data']['aspect'] ) ) ? $ttf_one_section_data['data']['aspect'] : 'square';
$title            = ( isset( $ttf_one_section_data['data']['title'] ) ) ? $ttf_one_section_data['data']['title'] : '';
$background_image = ( isset( $ttf_one_section_data['data']['background-image'] ) ) ? $ttf_one_section_data['data']['background-image'] : 0;
$background_color = ( isset( $ttf_one_section_data['data']['background-color'] ) ) ? $ttf_one_section_data['data']['background-color'] : '';
$background_style = ( isset( $ttf_one_section_data['data']['background-style'] ) ) ? $ttf_one_section_data['data']['background-style'] : 'tile';
$darken           = ( isset( $ttf_one_section_data['data']['darken'] ) ) ? $ttf_one_section_data['data']['darken'] : 1;
$section_order    = ( ! empty( $ttf_one_section_data['data']['gallery-item-order'] ) ) ? $ttf_one_section_data['data']['gallery-item-order'] : array();
?>

<div class="ttf-one-captions-select-wrapper">
	<label for="<?php echo $section_name; ?>[caption-color]"><?php _e( 'Caption color:', 'make' ); ?></label>
	<select id="<?php echo $section_name; ?>[caption-color]" name="<?php echo $section_name; ?>[caption-color]">
		<option value="light"<?php selected( 'light', $caption_color ); ?>><?php echo esc_html( __( 'Light', 'make' ) ); ?></option>
		<option value="dark"<?php selected( 'dark', $caption_color ); ?>><?php echo esc_html( __( 'Dark', 'make' ) ); ?></option>
	</select>
</div>

<div class="ttf-one-captions-select-wrapper">
	<label for="<?php echo $section_name; ?>[captions]"><?php _e( 'Caption style:', 'make' ); ?></label>
	<select id="<?php echo $section_name; ?>[captions]" name="<?php echo $section_name; ?>[captions]">
		<option value="overlay"<?php selected( 'overlay', $captions ); ?>><?php echo esc_html( __( 'Overlay', 'make' ) ); ?></option>
		<option value="reveal"<?php selected( 'reveal', $captions ); ?>><?php echo esc_html( __( 'Reveal', 'make' ) ); ?></option>
		<option value="none"<?php selected( 'none', $captions ); ?>><?php echo esc_html( __( 'None', 'make' ) ); ?></option>
	</select>
</div>

<div class="ttf-one-aspect-select-wrapper">
	<label for="<?php echo $section_name; ?>[aspect]"><?php _e( 'Aspect ratio:', 'make' ); ?></label>
	<select id="<?php echo $section_name; ?>[aspect]" name="<?php echo $section_name; ?>[aspect]">
		<option value="landscape"<?php selected( 'landscape', $aspect ); ?>><?php echo esc_html( __( 'Landscape', 'make' ) ); ?></option>
		<option value="portrait"<?php selected( 'portrait', $aspect ); ?>><?php echo esc_html( __( 'Portrait', 'make' ) ); ?></option>
		<option value="square"<?php selected( 'square', $aspect ); ?>><?php echo esc_html( __( 'Square', 'make' ) ); ?></option>
		<option value="none"<?php selected( 'none', $aspect ); ?>><?php echo esc_html( __( 'None', 'make' ) ); ?></option>
	</select>
</div>

<div class="ttf-one-columns-select-wrapper">
	<label for="<?php echo $section_name; ?>[columns]"><?php _e( 'Columns:', 'make' ); ?></label>
	<select id="<?php echo $section_name; ?>[columns]" name="<?php echo $section_name; ?>[columns]" class="ttf-one-gallery-columns">
		<option value="1"<?php selected( 1, $columns ); ?>>1</option>
		<option value="2"<?php selected( 2, $columns ); ?>>2</option>
		<option value="3"<?php selected( 3, $columns ); ?>>3</option>
		<option value="4"<?php selected( 4, $columns ); ?>>4</option>
	</select>
</div>

<div class="ttf-one-add-gallery-item-wrapper">
	<a href="#" class="button button-primary ttf-one-button-large button-large ttf-one-gallery-add-item"><?php _e( 'Add New Item', 'make' ); ?></a>
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

<div class="ttf-one-gallery-background-options-container">
	<h2 class="ttf-one-large-title ttf-one-gallery-options-heading">
		<?php _e( 'Options', 'make' ); ?>
	</h2>

	<div class="ttf-one-titlediv">
		<div class="ttf-one-titlewrap">
			<input placeholder="<?php esc_attr_e( 'Enter title here', 'make' ); ?>" type="text" name="<?php echo $section_name; ?>[title]" class="ttf-one-title ttf-one-section-header-title-input" value="<?php echo esc_attr( htmlspecialchars( $title ) ); ?>" autocomplete="off" />
		</div>
	</div>

	<div class="ttf-one-gallery-background-image-wrapper">
		<?php
			ttf_one_get_builder_base()->add_uploader(
				$section_name . '[background-image]',
				$background_image,
				array(
					'add'    => __( 'Set background image', 'make' ),
					'remove' => __( 'Remove background image', 'make' ),
					'title'  => __( 'Background image', 'make' ),
					'button' => __( 'Use as Background Image', 'make' ),
				)
			);
		?>
	</div>

	<div class="ttf-one-gallery-background-options-wrapper">
		<h4><?php _e( 'Background image', 'make' ); ?></h4>
		<input id="<?php echo $section_name; ?>[darken]" type="checkbox" name="<?php echo $section_name; ?>[darken]" value="1"<?php checked( $darken ); ?> />
		<label for="<?php echo $section_name; ?>[darken]">
			<?php _e( 'Darken to improve readability', 'make' ); ?>
		</label>

		<h4><?php _e( 'Background color', 'make' ); ?></h4>
		<input id="<?php echo $section_name; ?>[background-color]" type="text" name="<?php echo $section_name . '[background-color]'; ?>" class="ttf-one-gallery-background-color" value="<?php echo maybe_hash_hex_color( $background_color ); ?>" />

		<h4><?php _e( 'Background style:', 'make' ); ?></h4>
		<select id="<?php echo $section_name; ?>[background-style]" name="<?php echo $section_name; ?>[background-style]">
			<option value="tile"<?php selected( 'tile', $background_style ); ?>><?php echo esc_html( __( 'Tile', 'make' ) ); ?></option>
			<option value="cover"<?php selected( 'cover', $background_style ); ?>><?php echo esc_html( __( 'Cover', 'make' ) ); ?></option>
		</select>
	</div>
</div>

<input type="hidden" class="ttf-one-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $ttf_one_section_data['data']['state'] ) ) echo esc_attr( $ttf_one_section_data['data']['state'] ); else echo 'open'; ?>" />
<?php ttf_one_load_section_footer(); ?>