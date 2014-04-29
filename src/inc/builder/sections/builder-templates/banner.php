<?php
/**
 * @package ttf-one
 */

ttfmake_load_section_header();

global $ttfmake_section_data, $ttfmake_is_js_template;
$section_name  = ttfmake_get_section_name( $ttfmake_section_data, $ttfmake_is_js_template );
$title         = ( isset( $ttfmake_section_data['data']['title'] ) ) ? $ttfmake_section_data['data']['title'] : '';
$hide_arrows   = ( isset( $ttfmake_section_data['data']['hide-arrows'] ) ) ? $ttfmake_section_data['data']['hide-arrows'] : 0;
$hide_dots     = ( isset( $ttfmake_section_data['data']['hide-dots'] ) ) ? $ttfmake_section_data['data']['hide-dots'] : 0;
$autoplay      = ( isset( $ttfmake_section_data['data']['autoplay'] ) ) ? $ttfmake_section_data['data']['autoplay'] : 1;
$transition    = ( isset( $ttfmake_section_data['data']['transition'] ) ) ? $ttfmake_section_data['data']['transition'] : 'scrollHorz';
$delay         = ( isset( $ttfmake_section_data['data']['delay'] ) ) ? $ttfmake_section_data['data']['delay'] : 6000;
$height        = ( isset( $ttfmake_section_data['data']['height'] ) ) ? $ttfmake_section_data['data']['height'] : 600;
$section_order = ( ! empty( $ttfmake_section_data['data']['banner-slide-order'] ) ) ? $ttfmake_section_data['data']['banner-slide-order'] : array();
?>

<div class="ttf-one-add-slide-wrapper">
	<a href="#" class="button button-primary ttf-one-button-large button-large ttf-one-add-slide"><?php _e( 'Add New Slide', 'make' ); ?></a>
</div>

<div class="ttf-one-banner-slides">
	<div class="ttf-one-banner-slides-stage">
		<?php foreach ( $section_order as $key => $section_id  ) : ?>
			<?php if ( isset( $ttfmake_section_data['data']['banner-slides'][ $section_id ] ) ) : ?>
				<?php global $ttfmake_slide_id; $ttfmake_slide_id = $section_id; ?>
				<?php get_template_part( '/inc/builder/sections/builder-templates/banner', 'slide' ); ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<input type="hidden" value="<?php echo esc_attr( implode( ',', $section_order ) ); ?>" name="<?php echo $section_name; ?>[banner-slide-order]" class="ttf-one-banner-slide-order" />
</div>

<div class="ttf-one-banner-options">
	<h2 class="ttf-one-large-title">
		<?php _e( 'Options', 'make' ); ?>
	</h2>

	<div class="ttf-one-titlediv">
		<div class="ttf-one-titlewrap">
			<input placeholder="<?php esc_attr_e( 'Enter title here', 'make' ); ?>" type="text" name="<?php echo $section_name; ?>[title]" class="ttf-one-title ttf-one-section-header-title-input" value="<?php echo esc_attr( htmlspecialchars( $title ) ); ?>" autocomplete="off" />
		</div>
	</div>

	<div class="ttf-one-banner-options-container">
		<h4 class="ttf-one-banner-options-title">
			<?php _e( 'Slideshow display', 'make' ); ?>
		</h4>

		<p>
			<input id="<?php echo $section_name; ?>[hide-arrows]" type="checkbox" name="<?php echo $section_name; ?>[hide-arrows]" value="1"<?php checked( $hide_arrows ); ?> />
			<label for="<?php echo $section_name; ?>[hide-arrows]">
				<?php _e( 'Hide navigation arrows', 'make' ); ?>
			</label>
		</p>

		<p>
			<input id="<?php echo $section_name; ?>[hide-dots]" type="checkbox" name="<?php echo $section_name; ?>[hide-dots]" value="1"<?php checked( $hide_dots ); ?> />
			<label for="<?php echo $section_name; ?>[hide-dots]">
				<?php _e( 'Hide navigation dots', 'make' ); ?>
			</label>
		</p>

		<p>
			<input id="<?php echo $section_name; ?>[autoplay]" type="checkbox" name="<?php echo $section_name; ?>[autoplay]" value="1"<?php checked( $autoplay ); ?> />
			<label for="<?php echo $section_name; ?>[autoplay]">
				<?php _e( 'Autoplay slideshow', 'make' ); ?>
			</label>
		</p>
	</div>

	<div class="ttf-one-banner-options-container">
		<h4 class="ttf-one-banner-options-title">
			<?php _e( 'Time between slides (in ms)', 'make' ); ?>
		</h4>
		<input id="<?php echo $section_name; ?>[delay]" class="code" type="text" name="<?php echo $section_name; ?>[delay]" value="<?php echo absint( $delay ); ?>" />

		<h4>
			<?php _e( 'Transition effect', 'make' ); ?>
		</h4>
		<select id="<?php echo $section_name; ?>[transition]" name="<?php echo $section_name; ?>[transition]">
			<option value="scrollHorz"<?php selected( 'scrollHorz', $transition ); ?>><?php _e( 'Slide horizontal', 'make' ); ?></option>
			<option value="fade"<?php selected( 'fade', $transition ); ?>><?php _e( 'Fade', 'make' ); ?></option>
			<option value="none"<?php selected( 'none', $transition ); ?>><?php echo _x( 'None', 'transition effect', 'make' ); ?></option>
		</select>
	</div>

	<div class="ttf-one-banner-options-container">
		<h4 class="ttf-one-banner-options-title">
			<?php _e( 'Section height', 'make' ); ?>
		</h4>
		<input id="<?php echo $section_name; ?>[height]" class="code" type="text" name="<?php echo $section_name; ?>[height]" value="<?php echo absint( $height ); ?>" />
	</div>

	<div class="clear"></div>
</div>

<input type="hidden" class="ttf-one-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $ttfmake_section_data['data']['state'] ) ) echo esc_attr( $ttfmake_section_data['data']['state'] ); else echo 'open'; ?>" />
<?php ttfmake_load_section_footer(); ?>