<?php
/**
 * @package ttf-one
 */
?>

<?php if ( is_sticky() && $sticky_label = get_theme_mod( 'general-sticky-label', __( 'Featured', 'ttf-one' ) ) ) : ?>
	<span class="sticky-post-label">
		<?php echo $sticky_label; ?>
	</span>
<?php endif; ?>