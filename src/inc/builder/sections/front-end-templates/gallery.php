<?php
/**
 * @package ttf-one
 */

global $ttf_one_section_data;
$gallery = ttf_one_builder_get_gallery_array( $ttf_one_section_data );
?>

<section class="builder-section<?php echo esc_attr( ttf_one_builder_get_gallery_class( $ttf_one_section_data ) ); ?>" style="<?php echo esc_attr( ttf_one_builder_get_gallery_style( $ttf_one_section_data ) ); ?>">
	<div class="builder-section-content">
		<?php if ( ! empty( $gallery ) ) : $i = 0; foreach ( $gallery as $item ) :
			$link_front = '';
			$link_back = '';
			if ( '' !== $item['link'] ) :
				$link_front = '<a href="' . esc_url( $item['link'] ) . '">';
				$link_back = '</a>';
			endif;
			$i++;
			?>
		<div class="builder-gallery-item<?php echo esc_attr( ttf_one_builder_get_gallery_item_class( $ttf_one_section_data, $i ) ); ?>">
			<?php if ( 0 !== absint( $item['image-id'] ) ) : ?>
			<figure class="builder-gallery-image">
				<?php echo $link_front . wp_get_attachment_image( $item['image-id'], 'large' ) . $link_back; ?>
				<?php if ( has_excerpt( $item['image-id'] ) ) : ?>
				<figcaption class="builder-gallery-image-caption">
					<?php echo ttf_one_allowed_tags( get_post( $item['image-id'] )->post_excerpt ); ?>
				</figcaption>
				<?php endif; ?>
			</figure>
			<?php endif; ?>
			<div class="builder-gallery-content">
				<?php if ( '' !== $item['title'] ) : ?>
				<h4 class="builder-gallery-title">
					<?php echo $link_front . apply_filters( 'the_title', $item['title'] ) . $link_back; ?>
				</h4>
				<?php endif; ?>
				<?php if ( '' !== $item['description'] ) : ?>
				<div class="builder-gallery-description">
					<?php ttf_one_get_builder_save()->the_builder_content( $item['description'] ); ?>
				</div>
				<?php endif; ?>
			</div>
			<?php if ( 'fancy' === $ttf_one_section_data['captions'] ) : ?>
			<div class="builder-gallery-overlay"></div>
			<?php endif; ?>
		</div>
		<?php endforeach; endif; ?>
	</div>
	<?php if ( 0 !== absint( $ttf_one_section_data['darken'] ) ) : ?>
	<div class="builder-section-overlay"></div>
	<?php endif; ?>
</section>
