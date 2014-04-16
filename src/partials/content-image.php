<?php
/**
 * @package ttf-one
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php get_template_part( 'partials/entry', 'thumbnail' ); ?>
	</header>

	<div class="entry-content">
		<?php get_template_part( 'partials/entry', 'title' ); ?>
		<?php get_template_part( 'partials/entry', 'content' ); ?>
		<?php if ( '' !== $exif_data = ttf_one_get_exif_data() ) : ?>
		<div class="entry-exif">
			<h4 class="entry-exif-label"><?php _e( 'Technical Details', 'ttf-one' ); ?></h4>
			<?php echo $exif_data; ?>
		</div>
		<?php endif; ?>
	</div>
</article>
