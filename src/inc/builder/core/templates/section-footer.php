<?php
/**
 * @package Make
 */

$links = apply_filters( 'ttfmake_builder_section_footer_links', array(
	100 => array(
		'href'  => '#',
		'class' => 'ttfmake-section-remove',
		'label' => __( 'Remove this section', 'make' )
	)
) );
?>
		<?php foreach ( $links as $link ) : ?>
		<?php
			$href  = ( isset( $link['href'] ) ) ? ' href="' . esc_url( $link['href'] ) . '"' : '';
			$id    = ( isset( $link['id'] ) ) ? ' id="' . esc_attr( $link['id'] ) . '"' : '';
			$class = ( isset( $link['class'] ) ) ? ' class="' . esc_attr( $link['class'] ) . '"' : '';
			$label = ( isset( $link['label'] ) ) ? esc_html( $link['label'] ) : '';
		?>
		<a<?php echo $href . $id . $class; ?>>
			<?php echo $label; ?>
		</a>
		<?php endforeach; ?>
	</div>
<?php if ( ! isset( $ttfmake_is_js_template ) || true !== $ttfmake_is_js_template ) : ?>
</div>
<?php endif; ?>