<?php
/**
 * @package ttf-one
 */
?>

				</div>
			</div>

			<footer id="site-footer" class="site-footer" role="contentinfo">
				<div class="container">
					<div class="site-info">
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
					</div>
				</div>
			</footer>
		</div>

		<?php wp_footer(); ?>

	</body>
</html>