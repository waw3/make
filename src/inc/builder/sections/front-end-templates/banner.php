<?php
/**
 * @package ttf-one
 */

global $ttf_one_section_data;
$banner_slides = ttf_one_builder_get_banner_array( $ttf_one_section_data );
$is_slider = ( count( $banner_slides ) > 1 ) ? true : false;
$banner_id = ( isset( $ttf_one_section_data['id'] ) ) ? absint( $ttf_one_section_data['id'] ) : 1;

$slider_height = absint( $ttf_one_section_data['height'] );
if ( 0 === $slider_height ) {
	$slider_height = 600;
}
$slider_ratio = ( $slider_height / 960 ) * 100;
?>
<style type="text/css">
	.builder-section-banner-<?php echo $banner_id; ?> .builder-banner-slide {
		padding-bottom: <?php echo $slider_ratio; ?>%;
	}
	@media screen and (min-width: 960px) {
		.builder-section-banner-<?php echo $banner_id; ?> .builder-banner-slide {
			padding-bottom: <?php echo $slider_height; ?>px;
		}
	}
</style>
<section id="builder-section-<?php echo esc_attr( $ttf_one_section_data['id'] ); ?>" class="builder-section <?php echo esc_attr( ttf_one_builder_get_banner_class( $ttf_one_section_data ) ); ?>">
	<?php if ( '' !== $ttf_one_section_data['title'] ) : ?>
	<h3 class="builder-banner-section-title">
		<?php echo apply_filters( 'the_title', $ttf_one_section_data['title'] ); ?>
	</h3>
	<?php endif; ?>
	<div class="builder-section-content<?php echo ( $is_slider ) ? ' cycle-slideshow' : ''; ?>"<?php echo ( $is_slider ) ? ttf_one_builder_get_banner_slider_atts( $ttf_one_section_data ) : ''; ?>>
		<?php if ( ! empty( $banner_slides ) ) : foreach ( $banner_slides as $slide ) : ?>
		<div class="builder-banner-slide<?php echo ttf_one_builder_banner_slide_class( $slide ); ?>" style="<?php echo ttf_one_builder_banner_slide_style( $slide, $ttf_one_section_data ); ?>">
			<div class="builder-banner-content">
				<div class="builder-banner-inner-content">
					<?php ttf_one_get_builder_save()->the_builder_content( $slide['content'] ); ?>
				</div>
			</div>
			<?php if ( 0 !== absint( $slide['darken'] ) ) : ?>
			<div class="builder-banner-overlay"></div>
			<?php endif; ?>
		</div>
		<?php endforeach; endif; ?>
		<?php if ( $is_slider && false === (bool) $ttf_one_section_data['hide-arrows'] ) : ?>
		<div class="cycle-prev"></div>
		<div class="cycle-next"></div>
		<?php endif; ?>
		<?php if ( $is_slider && false === (bool) $ttf_one_section_data['hide-dots'] ) : ?>
		<div class="cycle-pager"></div>
		<?php endif; ?>
	</div>
</section>
