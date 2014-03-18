<?php
/**
 * @package ttf-one
 */
?>

<?php if ( is_sticky() && $sticky_label = get_theme_mod( 'general-sticky-label', ttf_one_get_default( 'general-sticky-label' ) ) ) : ?>
	<span class="sticky-post-label">
		<?php echo $sticky_label; ?>
	</span>
<?php endif; ?>