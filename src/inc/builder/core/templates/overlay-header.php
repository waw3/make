<?php global $ttfmake_overlay_id; ?>
<?php if ( 'ttfmake-tinymce-overlay' === $ttfmake_overlay_id ) : ?>
<div class="ttfmake-overlay" id="<?php echo $ttfmake_overlay_id; ?>">
<?php else : ?>
<div class="ttfmake-overlay <?php echo $ttfmake_overlay_id; ?>">
<?php endif; ?>
	<div class="ttfmake-overlay-wrapper">
		<div class="ttfmake-overlay-header">
			<div class="ttfmake-overlay-window-head">
				<div class="ttfmake-overlay-title">Configure Section</div>
				<span class="ttfmake-overlay-close" aria-hidden="true">&#215;</span>
			</div>
		</div>
		<div class="ttfmake-overlay-body">