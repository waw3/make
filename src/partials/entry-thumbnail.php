<?php
/**
 * @package ttf-one
 */

$thumbnail_size = ( is_singular() ) ? 'large' : 'thumbnail';
?>

<?php if ( $thumbnail_id = get_post_thumbnail_id() ) : ?>
<figure class="entry-thumbnail">
	<?php the_post_thumbnail( $thumbnail_size ); ?>
	<?php if ( is_singular() && has_excerpt( $thumbnail_id ) ) : ?>
	<figcaption class="entry-thumbnail-caption">
		<?php echo ttf_one_sanitize_text( get_post( $thumbnail_id )->post_excerpt ); ?>
	</figcaption>
	<?php endif; ?>
</figure>
<?php endif; ?>
