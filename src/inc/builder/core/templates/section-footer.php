<?php
/**
 * @package Make
 */

global $ttfmake_section_data;
?>
	<?php if ( ! empty( $ttfmake_section_data['section']['config'] ) ) : ?>
		<?php get_template_part( '/inc/builder/core/templates/overlay', 'configuration' ); ?>
	<?php endif; ?>
	</div>
<?php if ( ! isset( $ttfmake_is_js_template ) || true !== $ttfmake_is_js_template ) : ?>
</div>
<?php endif; ?>