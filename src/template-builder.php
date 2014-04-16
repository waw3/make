<?php
/**
 * Template Name: Builder Template
 *
 * @package ttf-one
 */

get_header();
?>

<main id="site-main" class="site-main" role="main">
<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'partials/content', 'page-builder' ); ?>

		<div class="builder-comment-container">
			<?php get_template_part( 'partials/content', 'comments' ); ?>
		</div>

	<?php endwhile; ?>

<?php endif; ?>
</main>

<?php get_footer(); ?>
