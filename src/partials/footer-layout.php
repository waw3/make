<?php
/**
 * @package ttf-one
 */

// Footer Options
$footer_layout = (int) get_theme_mod( 'footer-layout', ttf_one_get_default( 'footer-layout' ) );
$sidebar_count = (int) get_theme_mod( 'footer-widget-areas', ttf_one_get_default( 'footer-widget-areas' ) );
$footer_text   = ttf_one_sanitize_text( get_theme_mod( 'footer-text', ttf_one_get_default( 'footer-text' ) ) );
$social_links  = ttf_one_get_social_links();
$show_social   = (int) get_theme_mod( 'footer-show-social', ttf_one_get_default( 'footer-show-social' ) );
?>

<footer id="site-footer" class="site-footer footer-layout-<?php echo $footer_layout; ?>" role="contentinfo">
	<div class="container">
		<?php // Footer widget areas
		if ( $sidebar_count > 0 ) : ?>
		<div class="footer-widget-container columns-<?php echo esc_attr( $sidebar_count ); ?>">
			<?php
			$current_sidebar = 1;
			while ( $current_sidebar <= $sidebar_count ) :
				get_sidebar( 'footer-' . $current_sidebar );
				$current_sidebar++;
			endwhile; ?>
		</div>
		<?php endif; ?>

		<?php // Footer text
		if ( $footer_text ) : ?>
		<div class="footer-text">
			<?php echo ttf_one_sanitize_text( $footer_text ); ?>
		</div>
		<?php endif; ?>

		<div class="site-info">
			<?php // Footer credit
			printf(
				__( '%s theme', 'ttf-one' ),
				'<span class="theme-name">One</span>'
			);
			?>
			<span class="theme-by"><?php _ex( 'by', 'attribution', 'ttf-one' ); ?></span>
			<span class="theme-author">
				<a title="The Theme Foundry <?php esc_attr_e( 'homepage', 'ttf-one' ); ?>" href="https://thethemefoundry.com/">
					The Theme Foundry
				</a>
			</span>
		</div>

		<?php // Social links
		ttf_one_maybe_show_social_links( 'footer' ); ?>
	</div>
</footer>