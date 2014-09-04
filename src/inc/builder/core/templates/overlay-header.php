<?php global $ttfmake_overlay_id; ?>
<?php if ( 'ttfmake-tinymce-overlay' === $ttfmake_overlay_id ) : ?>
<div class="ttfmake-overlay" id="<?php echo $ttfmake_overlay_id; ?>">
<?php else : ?>
<div class="ttfmake-overlay <?php echo $ttfmake_overlay_id; ?>">
<?php endif; ?>
	<div class="mce-container mce-window mce-in ttfmake-overlay-wrapper">
		<div class="mce-reset ttfmake-overlay-header">
			<div class="mce-window-head">
				<div class="mce-title">Configure Section</div>
				<button type="button" class="mce-close ttfmake-overlay-close" aria-hidden="true">&#215;</button>
			</div>
		</div>
		<div class="ttfmake-overlay-body">