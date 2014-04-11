<?php
/**
 * @package ttf-one
 */

$title_key = 'layout-' . ttf_one_get_view() . '-hide-title';
$title_option = (bool) get_theme_mod( $title_key, ttf_one_get_default( $title_key ) );
?>

<?php if ( ! is_page() || ! $title_option ) : ?>
<h1 class="entry-title">
	<?php if ( ! is_singular() ) : ?><a href="<?php the_permalink(); ?>" rel="bookmark"><?php endif; ?>
		<?php the_title(); ?>
	<?php if ( ! is_singular() ) : ?></a><?php endif; ?>
</h1>
<?php endif; ?>