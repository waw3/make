<?php
/**
 * @package ttf-one
 */

get_header();
?>

<main id="site-main" class="site-main" role="main">
<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'partials/content', 'single' ); ?>

		<?php get_template_part( 'partials/nav', 'post' ); ?>

		<?php
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || '0' != get_comments_number() ) :
			comments_template();
		endif;
		?>

	<?php endwhile; ?>

<?php endif; ?>
</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
