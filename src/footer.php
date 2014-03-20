<?php
/**
 * @package ttf-one
 */
?>

				</div>
			</div>

			<?php // Footer partial
			get_template_part(
				'partials/footer-layout',
				get_theme_mod( 'footer-layout', ttf_one_get_default( 'footer-layout' ) )
			);
			?>
		</div>

		<?php wp_footer(); ?>

	</body>
</html>