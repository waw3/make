<?php
/**
 * @package ttf-one
 */
?>

<?php if ( ! is_page() ) : ?>
	<time class="entry-date" datetime="<?php the_time( 'c' ); ?>">
		<?php echo get_the_date(); ?>
	</time>
	<?php if ( is_sticky() ) : ?>
		<span class="sticky-post-label"><?php _e( 'Featured', 'ttf-one' ); ?></span>
	<?php endif; ?>
<?php endif; ?>