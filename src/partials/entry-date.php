<?php
/**
 * @package ttf-one
 */

$key = 'layout-' . ttf_one_get_view() . '-post-date';
$date_option = ttf_one_sanitize_choice( get_theme_mod( $key, ttf_one_get_default( $key ) ), $key );
?>

<?php if ( 'none' !== $date_option ) : ?>
<time class="entry-date" datetime="<?php the_time( 'c' ); ?>">
<?php if ( ! is_singular() ) : ?><a href="<?php the_permalink(); ?>" rel="bookmark"><?php endif; ?>
	<?php if ( 'absolute' === $date_option ) : ?>
		<?php echo get_the_date(); ?>
	<?php elseif ( 'relative' === $date_option ) : ?>
		<?php
		printf(
			__( '%s ago', 'ttf-one' ),
			human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) )
		)
		?>
	<?php endif; ?>
<?php if ( ! is_singular() ) : ?></a><?php endif; ?>
</time>
<?php endif; ?>