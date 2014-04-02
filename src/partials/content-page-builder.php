<?php
/**
 * @package ttf-one
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php remove_filter( 'the_content', 'wpautop' ); ?>
		<?php the_content(); ?>
		<?php add_filter( 'the_content', 'wpautop' ); ?>
	</div>
</article>
