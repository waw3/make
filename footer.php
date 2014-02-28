<?php
/**
 * @package ttf-start
 */
?>

			</div>

			<footer id="site-footer" class="site-footer" role="contentinfo">
				<div class="site-info">
					<a title="<?php esc_attr_e( 'Theme info', 'oxford' ); ?>" href="https://thethemefoundry.com/wordpress-themes/ttf-start/">
						<?php
						printf(
							__( '%s theme', 'ttf-start' ),
							'TTF Start'
						);
						?>
					</a>
					<em class="by"><?php _ex( 'by', 'attribution', 'ttf-start' ); ?></em>
					<a title="<?php esc_attr_e( 'The Theme Foundry homepage', 'oxford' ); ?>" href="https://thethemefoundry.com/">
						The Theme Foundry
					</a>
				</div>
			</footer>
		</div>

		<?php wp_footer(); ?>

	</body>
</html>