<?php
/**
 * @package ttf-one
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php get_template_part( 'partials/entry', 'title' ); ?>
		<?php get_template_part( 'partials/entry', 'content' ); ?>
		<p><?php _e( 'Download this file:', 'ttf-one' ); ?></p>
		<p><a href="<?php echo esc_url( wp_get_attachment_url() ); ?>" class="ttf-one-button ttf-one-download ttf-one-success"><?php echo esc_html( basename( $post->guid ) ); ?></a></p>
		<?php get_template_part( 'partials/entry', 'sharing' ); ?>
	</div>
</article>
