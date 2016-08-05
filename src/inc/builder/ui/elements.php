<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Builder_UI_Elements
 *
 * Methods for rendering section elements in the Builder UI.
 *
 * @since 1.8.0.
 */
class MAKE_Builder_UI_Elements extends MAKE_Builder_UI_Base {
	/**
	 * Default args that will be parsed into the $args parameter when a render method is called.
	 *
	 * @since 1.8.0.
	 *
	 * @var array
	 */
	protected $default_args = array(
		'label'      => '',
		'controls'   => array(),
		'attributes' => array(),
	);

	/**
	 * Holds an instance of MAKE_Builder_UI_Controls
	 *
	 * @since 1.8.0.
	 *
	 * @var MAKE_Builder_UI_Controls|null
	 */
	protected $controls = null;

	/**
	 * Gets the instance of MAKE_Builder_UI_Controls
	 *
	 * @since 1.8.0.
	 *
	 * @return MAKE_Builder_UI_Controls
	 */
	protected function controls() {
		if ( is_null( $this->controls ) ) {
			$this->controls = new MAKE_Builder_UI_Controls();
		}

		return $this->controls;
	}

	/**
	 * Render a stage to contain child section items.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $element_id
	 * @param array  $args
	 *
	 * @return void
	 */
	protected function render_stage( $element_id, array $args ) {
		// Stage attributes
		$stage_atts = new MAKE_Util_HTMLAttributes( array(
			'class' => array(
				'make-stage',
				'make-stage-' . $element_id,
				'make-columns-{{ data.columns }}',
			),
			'data'  => array(
				'type'       => 'stage',
				'element-id' => $element_id,
			),
		) );

		// Other attributes
		$stage_atts->add( $args['attributes'] );

		// Begin output
		?>
		<div class="make-stage-container">
			<div<?php echo $stage_atts->render(); ?>>
				<!-- Items -->
			</div>
		<?php if ( is_array( $args['controls'] ) ) : ?>
			<div class="make-stage-controls">
			<?php  foreach ( $args['controls'] as $control_id => $control_args ) : ?>
				<?php echo $this->controls()->render( $control_args['type'], $control_id, $control_args ); ?>
			<?php endforeach; ?>
			</div>
		<?php endif; ?>
		</div>
	<?php
	}

	/**
	 * Render an overlay window.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $element_id
	 * @param array  $args
	 *
	 * @return void
	 */
	protected function render_overlay( $element_id, array $args ) {
		$overlay_atts = new MAKE_Util_HTMLAttributes( array(
			'class' => array(
				'make-overlay',
				'make-overlay-' . $element_id,
			),
			'data'  => array(
				'type'       => 'overlay',
				'element-id' => $element_id,
			),
		) );

		// Other attributes
		$overlay_atts->add( $args['attributes'] );

		// Close button
		$button_atts = new MAKE_Util_HTMLAttributes( array(
			'class'       => array(
				'make-overlaybutton',
				'make-overlaybutton-header',
			),
			'data'        => array(
				'type'      => 'overlaybutton',
				'action'    => 'closeOverlay',
				'button-id' => 'overlay-close',
			),
			'type'        => 'button',
			'aria-hidden' => 'true',
		) );

		// Begin output
		?>
		<div<?php echo $overlay_atts->render(); ?>>
			<div class="make-overlay-wrapper">
				<div class="make-overlay-header">
					<div class="make-overlay-header-inner">
						<div class="make-overlay-label"><?php echo esc_html( $args['label'] ); ?></div>
						<button<?php echo $button_atts->render(); ?>><?php esc_html_e( 'Done', 'make' ); ?></button>
					</div>
				</div>
			<?php if ( is_array( $args['controls'] ) ) : ?>
				<div class="make-overlay-controls">
					<?php  foreach ( $args['controls'] as $control_id => $control_args ) : ?>
						<?php echo $this->controls()->render( $control_args['type'], $control_id, $control_args ); ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			</div>
		</div>
	<?php
	}


	protected function render_content( $element_id, $args ) {

	}


	protected function render_preview( $element_id, $args ) {
		$preview_atts = new MAKE_Util_HTMLAttributes( array(
			'class' => array(
				'make-preview',
				'make-preview-' . $element_id,
			),
		) );

		// Other attributes
		$preview_atts->add( $args['attributes'] );

		$editcontent_atts = new MAKE_Util_HTMLAttributes( array(
			'class' => array(
				'edit-content-link',
			),
			'data' => array(
				'textarea' => '',
				'iframe'   => '',
			),
			'href' => '#'
		) );


		?>
		<div class="make-preview-container">
			<div<?php echo $preview_atts->render(); ?>>
				<div class="make-iframe-overlay">
					<a<?php echo $editcontent_atts->render(); ?>>
						<span class="screen-reader-text">
							<?php esc_html_e( 'Edit content', 'make' ); ?>
						</span>
					</a>
				</div>
				<iframe width="100%" height="300" id="<?php echo esc_attr( $iframe_id ); ?>" scrolling="no"></iframe>
			</div>
		<?php if ( is_array( $args['controls'] ) ) : ?>
			<div class="make-preview-controls">
				<?php  foreach ( $args['controls'] as $control_id => $control_args ) : ?>
					<?php echo $this->controls()->render( $control_args['type'], $control_id, $control_args ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		</div>
	<?php
	}


	protected function render_uploader( $element_id, $args ) {
		$uploader_atts = new MAKE_Util_HTMLAttributes( array(

		) );

		// Other attributes
		$uploader_atts->add( $args['attributes'] );

		?>
		<div class="ttfmake-uploader<?php if ( ! empty( $image[0] ) ) : ?> ttfmake-has-image-set<?php endif; ?>">
			<div data-title="<?php echo esc_attr( $title ); ?>" class="ttfmake-media-uploader-placeholder ttfmake-media-uploader-add"<?php if ( ! empty( $image[0] ) ) : ?> style="background-image: url(<?php echo addcslashes( esc_url_raw( $image[0] ), '"' ); ?>);"<?php endif; ?>></div>
		<?php if ( is_array( $args['controls'] ) ) : ?>
			<div class="make-preview-controls">
				<?php  foreach ( $args['controls'] as $control_id => $control_args ) : ?>
					<?php echo $this->controls()->render( $control_args['type'], $control_id, $control_args ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		</div>
	<?php
	}
}