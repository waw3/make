<?php
/**
 * @package ttf-one
 */

global $ttf_one_section_data;
$gallery = ttf_one_builder_get_gallery_array( $ttf_one_section_data );

$darken = ( isset( $ttf_one_section_data[ 'darken' ] ) ) ? absint( $ttf_one_section_data[ 'darken' ] ) : 0;
$captions = ( isset( $ttf_one_section_data[ 'captions' ] ) ) ? esc_attr( $ttf_one_section_data[ 'captions' ] ) : 'reveal';
$aspect = ( isset( $ttf_one_section_data[ 'aspect' ] ) ) ? esc_attr( $ttf_one_section_data[ 'aspect' ] ) : 'square';
?>

<section id="builder-section-<?php echo esc_attr( $ttf_one_section_data['id'] ); ?>" class="builder-section<?php echo esc_attr( ttf_one_builder_get_gallery_class( $ttf_one_section_data ) ); ?>" style="<?php echo esc_attr( ttf_one_builder_get_gallery_style( $ttf_one_section_data ) ); ?>">
	<?php if ( '' !== $ttf_one_section_data['title'] ) : ?>
	<h3 class="builder-gallery-section-title">
		<?php echo apply_filters( 'the_title', $ttf_one_section_data['title'] ); ?>
	</h3>
	<?php endif; ?>
	<div class="builder-section-content">
		<?php if ( ! empty( $gallery ) ) : $i = 0; foreach ( $gallery as $item ) :
			$onclick = '';
			if ( '' !== $item['link'] ) :
				$onclick = ' onclick="window.location.href = \'' . esc_js( esc_url( $item['link'] ) ) . '\';"';
			endif;
			$i++;
		?>
		<div class="builder-gallery-item<?php echo esc_attr( ttf_one_builder_get_gallery_item_class( $ttf_one_section_data, $i ) ); ?>"<?php echo $onclick; ?>>
			<?php if ( 0 !== absint( $item['image-id'] ) ) : ?>
				<?php echo ttf_one_builder_get_gallery_item_image( $item, $aspect ); ?>
			<?php endif; ?>
			<?php if ( 'none' !== $captions && ( '' !== $item['title'] || '' !== $item['description'] || has_excerpt( $item['image-id'] ) ) ) : ?>
			<div class="builder-gallery-content">
				<?php if ( '' !== $item['title'] ) : ?>
				<h4 class="builder-gallery-title">
					<?php echo apply_filters( 'the_title', $item['title'] ); ?>
				</h4>
				<?php endif; ?>
				<?php if ( '' !== $item['description'] ) : ?>
				<div class="builder-gallery-description">
					<?php ttf_one_get_builder_save()->the_builder_content( $item['description'] ); ?>
				</div>
				<?php elseif ( has_excerpt( $item['image-id'] ) ) : ?>
				<div class="builder-gallery-description">
					<?php echo ttf_one_allowed_tags( get_post( $item['image-id'] )->post_excerpt ); ?>
				</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
		<?php endforeach; endif; ?>
	</div>
	<?php if ( 0 !== $darken ) : ?>
	<div class="builder-section-overlay"></div>
	<?php endif; ?>
</section>
