<?php
/**
 * @package ttf-one
 */
?>
<section id="sidebar-right" class="widget-area <?php echo ( is_active_sidebar( 'sidebar-right' ) ) ? 'active' : 'inactive'; ?>" role="complementary">
	<?php if ( ! dynamic_sidebar( 'sidebar-right' ) ) : ?>
		&nbsp;
	<?php endif; ?>
</section>