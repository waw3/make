<?php
/**
 * @package Make
 */
?>
<div id="ttfmake-notice-<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $classes ); ?>" data-nonce="<?php echo esc_attr( $nonce ); ?>">
	<?php if ( true === $dismiss && false === $this->support['dismissible'] ) : ?>
		<a class="ttfmake-dismiss" href="#"><?php esc_html_e( 'Hide', 'make' ); ?></a>
	<?php endif; ?>
	<?php echo wpautop( $message ); ?>
</div>