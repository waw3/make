<?php
/**
 * @package ttf-one
 */

$thumb_key = 'layout-' . ttf_one_get_view() . '-featured-images';
$thumb_option = ttf_one_sanitize_choice( get_theme_mod( $thumb_key, ttf_one_get_default( $thumb_key ) ), $thumb_key );
if ( 'post-header' === $thumb_option ) :
	$thumbnail_size = 'large';
elseif ( 'thumbnail' === $thumb_option ) :
	$thumbnail_size = ( is_singular() ) ? 'medium' : 'thumbnail';
endif;
?>

<?php if ( 'none' !== $thumb_option && $thumbnail_id = get_post_thumbnail_id() ) : ?>
<figure class="entry-thumbnail">
	<?php the_post_thumbnail( $thumbnail_size ); ?>
	<?php if ( is_singular() && has_excerpt( $thumbnail_id ) ) : ?>
	<figcaption class="entry-thumbnail-caption">
		<?php echo ttf_one_sanitize_text( get_post( $thumbnail_id )->post_excerpt ); ?>
	</figcaption>
	<?php endif; ?>
</figure>
<?php endif; ?>
