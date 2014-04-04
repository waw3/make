<?php
ttf_one_load_section_header();
global $ttf_one_section_data, $ttf_one_is_js_template;
$section_name = ttf_one_get_section_name( $ttf_one_section_data, $ttf_one_is_js_template );
$hide_arrows   = ( ! empty( $ttf_one_section_data['data']['hide-arrows'] ) ) ? $ttf_one_section_data['data']['hide-arrows'] : 0;
$hide_dots     = ( ! empty( $ttf_one_section_data['data']['hide-dots'] ) ) ? $ttf_one_section_data['data']['hide-dots'] : 0;
$autoplay      = ( ! empty( $ttf_one_section_data['data']['autoplay'] ) ) ? $ttf_one_section_data['data']['autoplay'] : 0;
$transition    = ( ! empty( $ttf_one_section_data['data']['transition'] ) ) ? $ttf_one_section_data['data']['transition'] : 'cross-fade';
$delay         = ( ! empty( $ttf_one_section_data['data']['delay'] ) ) ? $ttf_one_section_data['data']['delay'] : 400;
$height        = ( ! empty( $ttf_one_section_data['data']['height'] ) ) ? $ttf_one_section_data['data']['height'] : 600;
$section_order = ( ! empty( $ttf_one_section_data['data']['banner-slide-order'] ) ) ? $ttf_one_section_data['data']['banner-slide-order'] : array();
?>

<div class="ttf-one-banner-options">
	<input type="checkbox" name="<?php echo $section_name; ?>[display-arrows]" value="1"<?php checked( $display_arrows ); ?> />
	<label>
		<?php _e( 'Hide navigation arrows', 'ttf-one' ); ?>
	</label>

	<input type="checkbox" name="<?php echo $section_name; ?>[display-dots]" value="1"<?php checked( $display_dots ); ?> />
	<label>
		<?php _e( 'Hide navigation dots', 'ttf-one' ); ?>
	</label>

	<input type="checkbox" name="<?php echo $section_name; ?>[autoplay]" value="1"<?php checked( $autoplay ); ?> />
	<label>
		<?php _e( 'Autoplay slideshow', 'ttf-one' ); ?>
	</label>

	<label>
		<?php _e( 'Transition effect', 'ttf-one' ); ?>
	</label>
	<select name="<?php echo $section_name; ?>[transition]">
		<option value="cross-fade"<?php selected( 'cross-fade', $transition ); ?>><?php _e( 'Cross fade', 'ttf-one' ); ?></option>
		<option value="fade"<?php selected( 'fade', $transition ); ?>><?php _e( 'Fade', 'ttf-one' ); ?></option>
		<option value="slide-horizontal"<?php selected( 'slide-horizontal', $transition ); ?>><?php _e( 'Slide horizontal', 'ttf-one' ); ?></option>
		<option value="none"<?php selected( 'none', $transition ); ?>><?php echo _x( 'None', 'transition effect', 'ttf-one' ); ?></option>
	</select>

	<label>
		<?php _e( 'Time between slides (in ms)', 'ttf-one' ); ?>
	</label>
	<input type="text" name="<?php echo $section_name; ?>[delay]" value="<?php echo absint( $delay ); ?>" />

	<label>
		<?php _e( 'Section height', 'ttf-one' ); ?>
	</label>
	<input type="text" name="<?php echo $section_name; ?>[height]" value="<?php echo absint( $height ); ?>" />
</div>

<div class="ttf-one-add-slide-wrapper">
	<a href="#" class="button button-small ttf-one-add-slide"><?php _e( 'Add Slide', 'ttf-one' ); ?></a>
</div>

<div class="ttf-one-banner-slides">
	<div class="ttf-one-banner-slides-stage">
		<?php foreach ( $section_order as $key => $section_id  ) : ?>
			<?php if ( isset( $ttf_one_section_data['data']['banner-slides'][ $section_id ] ) ) : ?>
				<?php global $ttf_one_slide_id; $ttf_one_slide_id = $section_id; ?>
				<?php get_template_part( '/inc/builder/sections/builder-templates/banner', 'slide' ); ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<input type="hidden" value="<?php echo esc_attr( implode( ',', $section_order ) ); ?>" name="<?php echo $section_name; ?>[banner-slide-order]" class="ttf-one-banner-slide-order" />
</div>

<input type="hidden" class="ttf-one-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $ttf_one_section_data['data']['state'] ) ) echo esc_attr( $ttf_one_section_data['data']['state'] ); else echo 'open'; ?>" />
<?php ttf_one_load_section_footer(); ?>