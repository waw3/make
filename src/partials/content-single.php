<?php
/**
 * @package ttf-one
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php get_template_part( 'partials/entry', 'title' ); ?>
		<?php get_template_part( 'partials/entry', 'date' ); ?>
		<?php get_template_part( 'partials/entry', 'sticky' ); ?>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php get_template_part( 'partials/entry', 'pagination' ); ?>
	</div>

	<footer class="entry-footer">
		<?php get_template_part( 'partials/entry', 'taxonomy' ); ?>
	</footer>
</article>
