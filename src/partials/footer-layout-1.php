<?php
/**
 * @package ttf-one
 */
?>

<footer id="site-footer" class="site-footer" role="contentinfo">
	<div class="container">
		<?php // Footer widget areas
		$sidebar_count = (int) get_theme_mod( 'footer-widget-areas', ttf_one_get_default( 'footer-widget-areas' ) );
		if ( $sidebar_count > 0 ) :
			$current_sidebar = 1;
			while ( $current_sidebar <= $sidebar_count ) :
			?>
			<section id="footer-<?php echo $current_sidebar; ?>" class="widget-area <?php echo ( is_active_sidebar( 'footer-' . $current_sidebar ) ) ? 'active' : 'inactive'; ?>" role="complementary">
				<?php dynamic_sidebar( 'footer-' . $current_sidebar ); ?>
			</section>
			<?php
				$current_sidebar++;
			endwhile;
		endif; ?>

		<?php // Footer text
		if ( $footer_text = get_theme_mod( 'footer-text', ttf_one_get_default( 'footer-text' ) ) ) : ?>
		<div class="footer-text">
			<?php echo ttf_one_sanitize_text( $footer_text ); ?>
		</div>
		<?php endif; ?>

		<div class="site-info">
			<?php // Footer credit
			if ( 1 === (int) get_theme_mod( 'footer-show-credit', ttf_one_get_default( 'footer-show-credit' ) ) ) :
				$footer_credit = sprintf(
					__( '%s theme', 'ttf-one' ),
					'<span class="theme-name">One</span>'
				); ?>
			<?php echo $footer_credit; ?>
			<span class="theme-by"><?php _ex( 'by', 'attribution', 'ttf-one' ); ?></span>
			<span class="theme-author"><a title="<?php esc_attr_e( 'The Theme Foundry homepage', 'ttf-one' ); ?>" href="https://thethemefoundry.com/">
				The Theme Foundry
			</a></span>
			<?php endif; ?>
		</div>
	</div>
</footer>