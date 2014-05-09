<?php
/**
 * @package Make
 */
ttfmake_load_section_header();

global $ttfmake_section_data, $ttfmake_is_js_template;
$section_name  = ttfmake_get_section_name( $ttfmake_section_data, $ttfmake_is_js_template );

$keys = array(
	'title',
	'hide-arrows',
	'hide-dots',
	'autoplay',
	'transition',
	'delay',
	'height'
);
$data = ttfmake_parse_section_data( $ttfmake_section_data['data'], $keys, 'banner' );

$section_order = ( ! empty( $data['banner-slide-order'] ) ) ? $data['banner-slide-order'] : array();
?>

<div class="ttfmake-add-slide-wrapper">
	<a href="#" class="button button-primary ttfmake-button-large button-large ttfmake-add-slide"><?php _e( 'Add New Slide', 'make' ); ?></a>
</div>

<div class="ttfmake-banner-slides">
	<div class="ttfmake-banner-slides-stage">
		<?php foreach ( $section_order as $key => $section_id  ) : ?>
			<?php if ( isset( $data['banner-slides'][ $section_id ] ) ) : ?>
				<?php global $ttfmake_slide_id; $ttfmake_slide_id = $section_id; ?>
				<?php get_template_part( 'inc/builder/sections/builder-templates/banner', 'slide' ); ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<input type="hidden" value="<?php echo esc_attr( implode( ',', $section_order ) ); ?>" name="<?php echo $section_name; ?>[banner-slide-order]" class="ttfmake-banner-slide-order" />
</div>

<div class="ttfmake-banner-options">
	<h2 class="ttfmake-large-title">
		<?php _e( 'Options', 'make' ); ?>
	</h2>

	<div class="ttfmake-titlediv">
		<div class="ttfmake-titlewrap">
			<input placeholder="<?php esc_attr_e( 'Enter title here', 'make' ); ?>" type="text" name="<?php echo $section_name; ?>[title]" class="ttfmake-title ttfmake-section-header-title-input" value="<?php echo esc_attr( htmlspecialchars( $data['title'] ) ); ?>" autocomplete="off" />
		</div>
	</div>

	<div class="ttfmake-banner-options-container">
		<h4 class="ttfmake-banner-options-title">
			<?php _e( 'Slideshow display', 'make' ); ?>
		</h4>

		<p>
			<input id="<?php echo $section_name; ?>[hide-arrows]" type="checkbox" name="<?php echo $section_name; ?>[hide-arrows]" value="1"<?php checked( $data['hide-arrows'] ); ?> />
			<label for="<?php echo $section_name; ?>[hide-arrows]">
				<?php _e( 'Hide navigation arrows', 'make' ); ?>
			</label>
		</p>

		<p>
			<input id="<?php echo $section_name; ?>[hide-dots]" type="checkbox" name="<?php echo $section_name; ?>[hide-dots]" value="1"<?php checked( $data['hide-dots'] ); ?> />
			<label for="<?php echo $section_name; ?>[hide-dots]">
				<?php _e( 'Hide navigation dots', 'make' ); ?>
			</label>
		</p>

		<p>
			<input id="<?php echo $section_name; ?>[autoplay]" type="checkbox" name="<?php echo $section_name; ?>[autoplay]" value="1"<?php checked( $data['autoplay'] ); ?> />
			<label for="<?php echo $section_name; ?>[autoplay]">
				<?php _e( 'Autoplay slideshow', 'make' ); ?>
			</label>
		</p>
	</div>

	<div class="ttfmake-banner-options-container">
		<h4 class="ttfmake-banner-options-title">
			<?php _e( 'Time between slides (in ms)', 'make' ); ?>
		</h4>
		<input id="<?php echo $section_name; ?>[delay]" class="code" type="text" name="<?php echo $section_name; ?>[delay]" value="<?php echo absint( $data['delay'] ); ?>" />

		<h4>
			<?php _e( 'Transition effect', 'make' ); ?>
		</h4>
		<select id="<?php echo $section_name; ?>[transition]" name="<?php echo $section_name; ?>[transition]">
			<?php foreach ( ttfmake_get_section_choices( 'transition', 'banner' ) as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, ttfmake_sanitize_section_choice( $data['transition'], 'transition', 'banner' ) ); ?>>
					<?php echo esc_html( $label ); ?>
				</option>
			<?php endforeach; ?>
		</select>
	</div>

	<div class="ttfmake-banner-options-container">
		<h4 class="ttfmake-banner-options-title">
			<?php _e( 'Section height', 'make' ); ?>
		</h4>
		<input id="<?php echo $section_name; ?>[height]" class="code" type="text" name="<?php echo $section_name; ?>[height]" value="<?php echo absint( $data['height'] ); ?>" />
	</div>

	<div class="clear"></div>
</div>

<input type="hidden" class="ttfmake-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $data['state'] ) ) echo esc_attr( $data['state'] ); else echo 'open'; ?>" />
<?php ttfmake_load_section_footer(); ?>
