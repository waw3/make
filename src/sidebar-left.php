<?php
/**
 * @package ttf-one
 */
?>
<section id="sidebar-left" class="widget-area <?php echo ( is_active_sidebar( 'sidebar-left' ) ) ? 'active' : 'inactive'; ?>" role="complementary">
	<?php if ( ! dynamic_sidebar( 'sidebar-left' ) ) : ?>
		&nbsp;
	<?php endif; ?>
</section>