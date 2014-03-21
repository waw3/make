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

		<?php get_template_part( 'partials/content', 'attachment' ); ?>

		<?php
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || '0' != get_comments_number() ) :
			comments_template();
		endif;
		?>

	<?php endwhile; ?>

<?php endif; ?>
</main>

<?php ttf_one_maybe_show_sidebar( 'right' ); ?>

<?php get_footer(); ?>
