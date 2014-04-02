<?php
/**
 * @package ttf-one
 */

$gallery = ttf_one_builder_get_gallery_array();
?>

<section class="builder-section <?php echo esc_attr( ttf_one_get_builder_save()->section_classes() ); ?>"<?php echo ttf_one_builder_get_gallery_style(); ?>>
	<?php if ( ! empty( $gallery ) ) : foreach ( $gallery as $item ) :
		$link_front = '';
		$link_back = '';
		if ( '' !== $item['link'] ) :
			$link_front = '<a href="' . esc_url( $item['link'] ) . '">';
			$link_back = '</a>';
		endif;
		?>
	<div class="builder-gallery-item">
		<?php if ( 0 !== absint( $item['image-id'] ) ) : ?>
		<figure class="builder-gallery-image">
			<?php echo $link_front . wp_get_attachment_image( $item['image-id'], 'large' ) . $link_back; ?>
		</figure>
		<?php endif; ?>
		<?php if ( '' !== $item['title'] ) : ?>
		<h4 class="builder-gallery-title">
			<?php echo $link_front . ttf_one_sanitize_text( $item['title'] ) . $link_back; ?>
		</h4>
		<?php endif; ?>
	</div>
	<?php endforeach; endif; ?>
</section>
