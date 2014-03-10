<?php
/**
 * @package ttf-one
 */
?>

<?php if ( ! is_page() ) : ?>
<time class="entry-date" datetime="<?php the_time( 'c' ); ?>">
	<?php echo get_the_date(); ?>
</time>
<?php endif; ?>