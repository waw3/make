<?php
/**
 * @package ttf-one
 */
?>

<?php if ( ! is_page() ) : ?>
	<time class="entry-date" datetime="<?php the_time( 'c' ); ?>">
	<?php if ( ! is_singular() ) : ?><a href="<?php the_permalink(); ?>" rel="bookmark"><?php endif; ?>
		<?php echo get_the_date(); ?>
	<?php if ( ! is_singular() ) : ?></a><?php endif; ?>
	</time>
<?php endif; ?>