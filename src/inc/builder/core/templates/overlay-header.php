<?php global $ttfmake_overlay_id; ?>
<?php if ( 'ttfmake-tinymce-overlay' === $ttfmake_overlay_id ) : ?>
<div class="ttfmake-overlay" id="<?php echo $ttfmake_overlay_id; ?>">
<?php else : ?>
<div class="ttfmake-overlay <?php echo $ttfmake_overlay_id; ?>">
<?php endif; ?>
	<div class="ttfmake-overlay-wrapper">
		<div class="ttfmake-overlay-header">
			<h2>Testing</h2>
			<a href="#" class="ttfmake-overlay-close"><?php _e( 'Close', 'make' ); ?></a>
		</div>
		<div class="ttfmake-overlay-body">