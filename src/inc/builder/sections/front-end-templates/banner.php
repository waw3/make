<?php
/**
 * @package ttf-one
 */

global $ttf_one_section_data;
$banner = ttf_one_builder_get_banner_array( $ttf_one_section_data );
$is_slider = ( count( $banner ) > 1 ) ? true : false;
?>

<section class="builder-section <?php echo esc_attr( ttf_one_get_builder_save()->section_classes( $ttf_one_section_data ) ); ?>">
	<div class="builder-section-content<?php echo ( $is_slider ) ? ' cycle-slideshow' : ''; ?>"<?php echo ( $is_slider ) ? ttf_one_builder_get_banner_slider_atts( $ttf_one_section_data ) : ''; ?>>
		<?php if ( ! empty( $banner ) ) : foreach ( $banner as $slide ) : ?>
		<div class="builder-banner-slide<?php echo ttf_one_builder_banner_slide_class( $slide ); ?>" style="<?php echo ttf_one_builder_banner_slide_style( $slide, $ttf_one_section_data ); ?>">
			<div class="builder-banner-content" style="position:absolute;top:0;">
				<?php ttf_one_get_builder_save()->the_builder_content( $slide['content'] ); ?>
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
