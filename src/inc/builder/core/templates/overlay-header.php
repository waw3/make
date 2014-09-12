<?php
global $ttfmake_overlay_id;
$type = ( 'ttfmake-tinymce-overlay' === $ttfmake_overlay_id ) ? 'mce' : 'config';
?>
<?php if ( 'mce' === $type ) : ?>
<div class="ttfmake-overlay" id="<?php echo $ttfmake_overlay_id; ?>">
<?php else : ?>
<div class="ttfmake-overlay <?php echo $ttfmake_overlay_id; ?>">
<?php endif; ?>
	<div class="ttfmake-overlay-wrapper">
		<div class="ttfmake-overlay-header">
			<div class="ttfmake-overlay-window-head">
				<div class="ttfmake-overlay-title"><?php ( 'config' === $type ) ? _e( 'Configure Section', 'make' ) : _e( 'Edit Content', 'make' ); ?></div>
				<span class="ttfmake-overlay-close ttfmake-overlay-close-action" aria-hidden="true"><?php _e( 'Done', 'make' ); ?></span>
			</div>
		</div>
		<div class="ttfmake-overlay-body">