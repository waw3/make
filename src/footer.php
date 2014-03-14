<?php
/**
 * @package ttf-one
 */
?>

				</div>
			</div>

			<footer id="site-footer" class="site-footer" role="contentinfo">
				<div class="container">
					<section id="footer-1" class="widget-area <?php echo ( is_active_sidebar( 'footer-1' ) ) ? 'active' : 'inactive'; ?>" role="complementary">
						<?php dynamic_sidebar( 'footer-1' ) ?>
					</section>
					<section id="footer-2" class="widget-area <?php echo ( is_active_sidebar( 'footer-2' ) ) ? 'active' : 'inactive'; ?>" role="complementary">
						<?php dynamic_sidebar( 'footer-2' ) ?>
					</section>
					<section id="footer-3" class="widget-area <?php echo ( is_active_sidebar( 'footer-3' ) ) ? 'active' : 'inactive'; ?>" role="complementary">
						<?php dynamic_sidebar( 'footer-3' ) ?>
					</section>
					<section id="footer-4" class="widget-area <?php echo ( is_active_sidebar( 'footer-4' ) ) ? 'active' : 'inactive'; ?>" role="complementary">
						<?php dynamic_sidebar( 'footer-4' ) ?>
					</section>
					<div class="site-info">
						<?php $hide_credit = (int) get_theme_mod( 'footer-hide-credit', 1 ); ?>
						<?php if ( 1 === $hide_credit ) : ?>
						<a title="<?php esc_attr_e( 'Theme info', 'oxford' ); ?>" href="https://thethemefoundry.com/wordpress-themes/ttf-one/">
							<?php
							printf(
								__( '%s theme', 'ttf-one' ),
								'TTF Start'
							);
							?>
						</a>
						<em class="by"><?php _ex( 'by', 'attribution', 'ttf-one' ); ?></em>
						<a title="<?php esc_attr_e( 'The Theme Foundry homepage', 'oxford' ); ?>" href="https://thethemefoundry.com/">
							The Theme Foundry
						</a>
						<?php endif; ?>
					</div>
				</div>
			</footer>
		</div>

		<?php wp_footer(); ?>

	</body>
</html>