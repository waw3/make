<?php
/**
 * @package ttf-one
 */

$thumb_key = 'layout-' . ttf_one_get_view() . '-featured-images';
$thumb_option = ttf_one_sanitize_choice( get_theme_mod( $thumb_key, ttf_one_get_default( $thumb_key ) ), $thumb_key );

$thumbnail_id = get_post_thumbnail_id();
$thumbnail_size = 'thumbnail';

if ( is_attachment() ) :
	$thumbnail_id = get_post()->ID;
	$thumbnail_size = 'full';
elseif ( 'post-header' === $thumb_option ) :
	$thumbnail_size = 'large';
elseif ( 'thumbnail' === $thumb_option ) :
	$thumbnail_size = ( is_singular() ) ? 'medium' : 'thumbnail';
endif;
?>

<?php if ( 'none' !== $thumb_option && ! empty( $thumbnail_id ) ) : ?>
<figure class="entry-thumbnail <?php if ( ! is_attachment() ) echo esc_attr( $thumb_option ); ?>">
	<?php if ( ! is_singular() ) : ?><a href="<?php the_permalink(); ?>" rel="bookmark"><?php endif; ?>
		<?php echo wp_get_attachment_image( $thumbnail_id, $thumbnail_size ); ?>
	<?php if ( ! is_singular() ) : ?></a><?php endif; ?>
	<?php if ( is_singular() && has_excerpt( $thumbnail_id ) ) : ?>
	<figcaption class="entry-thumbnail-caption">
		<?php echo ttf_one_sanitize_text( get_post( $thumbnail_id )->post_excerpt ); ?>
	</figcaption>
	<?php endif; ?>
</figure>
<?php endif; ?>
