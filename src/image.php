<?php
/**
 * @package ttf-one
 */

get_header();
?>

<?php ttf_one_maybe_show_sidebar( 'left' ); ?>

<main id="site-main" class="site-main" role="main">
	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'partials/content', 'image' ); ?>

			<?php get_template_part( 'partials/content', 'comments' ); ?>

		<?php endwhile; ?>

	<?php endif; ?>
</main>

<?php ttf_one_maybe_show_sidebar( 'right' ); ?>

<?php get_footer(); ?>
