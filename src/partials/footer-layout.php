<?php
/**
 * @package ttf-one
 */

// Footer Options
$sidebar_count      = (int) get_theme_mod( 'footer-widget-areas', ttf_one_get_default( 'footer-widget-areas' ) );
$footer_text        = get_theme_mod( 'footer-text', ttf_one_get_default( 'footer-text' ) );
$show_footer_credit = (int) get_theme_mod( 'footer-show-credit', ttf_one_get_default( 'footer-show-credit' ) );
$social_links       = ttf_one_get_social_links();
$show_social        = (int) get_theme_mod( 'footer-show-social', ttf_one_get_default( 'footer-show-social' ) );
?>

<footer id="site-footer" class="site-footer footer-layout-<?php echo get_theme_mod( 'footer-layout', ttf_one_get_default( 'footer-layout' ) ) ?>" role="contentinfo">
	<div class="container">
		<?php // Footer widget areas
		if ( $sidebar_count > 0 ) : ?>
		<div class="footer-widget-container columns-<?php echo esc_attr( $sidebar_count ); ?>">
			<?php
			$current_sidebar = 1;
			while ( $current_sidebar <= $sidebar_count ) :
			?>
			<section id="footer-<?php echo $current_sidebar; ?>" class="widget-area <?php echo ( is_active_sidebar( 'footer-' . $current_sidebar ) ) ? 'active' : 'inactive'; ?>" role="complementary">
				<?php dynamic_sidebar( 'footer-' . $current_sidebar ); ?>
			</section>
			<?php
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
			<span class="theme-author"><a title="<?php esc_attr_e( 'The Theme Foundry homepage', 'ttf-one' ); ?>" href="https://thethemefoundry.com/">
				The Theme Foundry
			</a></span>
		</div>

		<?php // Social links
		if ( ! empty ( $social_links ) && 1 === $show_social ) : ?>
		<ul class="social-links footer-social-links">
			<?php foreach ( $social_links as $key => $link ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>">
					<a href="<?php echo esc_url( $link['url'] ); ?>" title="<?php echo esc_attr( $link['title'] ); ?>">
						<i class="fa fa-fw <?php echo esc_attr( $link['class'] ); ?>"></i>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	</div>
</footer>