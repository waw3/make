<?php
/**
 * @package ttf-one
 */

$thumb_key = 'layout-' . ttf_one_get_view() . '-featured-images';
$thumb_option = ttf_one_sanitize_choice( get_theme_mod( $thumb_key, ttf_one_get_default( $thumb_key ) ), $thumb_key );

// Header
ob_start();
get_template_part( 'partials/entry', 'date' );
get_template_part( 'partials/entry', 'sticky' );
if ( 'post-header' === $thumb_option ) :
	get_template_part( 'partials/entry', 'thumbnail' );
endif;
get_template_part( 'partials/entry', 'title' );
$entry_header = trim( ob_get_clean() );

// Footer
ob_start();
get_template_part( 'partials/entry', 'author' );
get_template_part( 'partials/entry', 'taxonomy' );
$entry_footer = trim( ob_get_clean() );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( $entry_header ) : ?>
	<header class="entry-header">
		<?php echo $entry_header; ?>
	</header>
	<?php endif; ?>

	<div class="entry-content">
		<?php if ( 'thumbnail' === $thumb_option ) : ?>
			<?php get_template_part( 'partials/entry', 'thumbnail' ); ?>
		<?php endif; ?>
		<?php get_template_part( 'partials/entry', 'content' ); ?>
	</div>

	<?php if ( $entry_footer ) : ?>
	<footer class="entry-footer">
		<?php echo $entry_footer; ?>
	</footer>
	<?php endif; ?>
</article>
