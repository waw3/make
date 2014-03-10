<?php
/**
 * @package ttf-one
 */

get_header();
?>

<main id="site-main" class="site-main" role="main">
<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'partials/content', 'archive' ); ?>

	<?php endwhile; ?>

	<?php ttf_one_paging_nav(); ?>

<?php else : ?>

	<?php get_template_part( 'partials/content', 'none' ); ?>

<?php endif; ?>
</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
