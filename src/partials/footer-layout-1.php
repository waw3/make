<?php
/**
 * @package ttf-one
 */
?>

<footer id="site-footer" class="site-footer" role="contentinfo">
	<div class="container">
		<?php // Footer widget areas
		$sidebar_count = (int) get_theme_mod( 'footer-widget-areas', '3' );
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
		if ( $footer_text = get_theme_mod( 'footer-text' ) ) : ?>
		<div class="footer-text">
			<?php echo ttf_one_sanitize_text( $footer_text ); ?>
		</div>
		<?php endif; ?>

		<div class="site-info">
			<?php // Footer credit
			if ( 1 === (int) get_theme_mod( 'footer-show-credit', 1 ) ) :
				$footer_credit = sprintf(
					__( '%s theme', 'ttf-one' ),
					'TTF Start'
				); ?>
			<a title="<?php esc_attr_e( 'Theme info', 'oxford' ); ?>" href="https://thethemefoundry.com/wordpress-themes/ttf-one/"><?php echo $footer_credit; ?></a>
			<em class="by"><?php _ex( 'by', 'attribution', 'ttf-one' ); ?></em>
			<a title="<?php esc_attr_e( 'The Theme Foundry homepage', 'oxford' ); ?>" href="https://thethemefoundry.com/">
				The Theme Foundry
			</a>
			<?php endif; ?>
		</div>
	</div>
</footer>