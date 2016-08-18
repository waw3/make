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
		'attributes' => array(),
		'controls'   => array(),
		'content'    => '',
	);

	/**
	 * Holds an instance of MAKE_Builder_UI_Buttons
	 *
	 * @since 1.8.0.
	 *
	 * @var MAKE_Builder_UI_Buttons|null
	 */
	protected $buttons = null;

	/**
	 * Holds an instance of MAKE_Builder_UI_Controls
	 *
	 * @since 1.8.0.
	 *
	 * @var MAKE_Builder_UI_Controls|null
	 */
	protected $controls = null;

	/**
	 * Gets the instance of MAKE_Builder_UI_Buttons
	 *
	 * @since 1.8.0.
	 *
	 * @return MAKE_Builder_UI_Buttons
	 */
	protected function buttons() {
		if ( is_null( $this->buttons ) ) {
			$this->buttons = new MAKE_Builder_UI_Buttons();
		}

		return $this->buttons;
	}

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
	 * @return $this
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
				'element-type' => 'stage',
				'element-id'   => $element_id,
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
				<?php $this->controls()->render( $control_args['type'], $control_id, $control_args ); ?>
			<?php endforeach; ?>
			</div>
		<?php endif; ?>
		</div>
	<?php

		return $this;
	}

	/**
	 * Render an overlay window.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $element_id
	 * @param array  $args
	 *
	 * @return $this
	 */
	protected function render_overlay( $element_id, array $args ) {
		$overlay_atts = new MAKE_Util_HTMLAttributes( array(
			'class' => array(
				'make-overlay',
				'make-overlay-' . $element_id,
			),
			'data'  => array(
				'element-type' => 'overlay',
				'element-id'   => $element_id,
			),
		) );

		// Other attributes
		$overlay_atts->add( $args['attributes'] );

		// Begin output
		?>
		<div<?php echo $overlay_atts->render(); ?>>
			<div class="make-overlay-wrapper">
				<div class="make-overlay-header">
					<div class="make-overlay-header-inner">
						<div class="make-overlay-label"><?php echo esc_html( $args['label'] ); ?></div>
						<?php $this->buttons()->render( 'overlaybutton', 'close', array( 'action' => 'click:closeOverlay' ) ); ?>
					</div>
				</div>
			<?php if ( is_array( $args['controls'] ) ) : ?>
				<div class="make-overlay-controls">
					<?php foreach ( $args['controls'] as $control_id => $control_args ) : ?>
						<?php $this->controls()->render( $control_args['type'], $control_id, $control_args ); ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			</div>
		</div>
	<?php

		return $this;
	}

	/**
	 * Render a content preview frame.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $element_id
	 * @param array  $args
	 *
	 * @return $this
	 */
	protected function render_contentpreview( $element_id, array $args ) {
		$preview_atts = new MAKE_Util_HTMLAttributes( array(
			'class' => array(
				'make-contentpreview',
				'make-contentpreview-' . $element_id,
			),
			'data'  => array(
				'element-type' => 'contentpreview',
				'element-id'   => $element_id,
				'content'      => $args['content'],
			),
		) );

		// Other attributes
		$preview_atts->add( $args['attributes'] );

		// Begin output
		?>
		<div class="make-contentpreview-container">
			<div<?php echo $preview_atts->render(); ?>>
				<div class="make-iframe-overlay">
					<?php
					$this->buttons()->render( 'button', 'edit-content', array(
						'label'       => esc_html__( 'Edit content', 'make' ),
						'action'      => 'click:editContent',
						'label_class' => 'screen-reader-text',
					) );
					?>
				</div>
				<iframe width="100%" height="300" id="<?php echo esc_attr( $element_id ); ?>" scrolling="no"></iframe>
			</div>
		<?php if ( is_array( $args['controls'] ) ) : ?>
			<div class="make-contentpreview-controls">
				<?php  foreach ( $args['controls'] as $control_id => $control_args ) : ?>
					<?php $this->controls()->render( $control_args['type'], $control_id, $control_args ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		</div>
	<?php

		return $this;
	}

	/**
	 * Render a file uploader/previewer.
	 *
	 * @since 1.8.0.
	 *
	 * @param string $element_id
	 * @param array  $args
	 *
	 * @return $this
	 */
	protected function render_uploader( $element_id, array $args ) {
		$uploader_atts = new MAKE_Util_HTMLAttributes( array(
			'class' => array(
				'make-uploader',
				'make-uploader-' . $element_id,
			),
			'data'  => array(
				'element-type' => 'uploader',
				'element-id'   => $element_id,
			),
		) );

		// Other attributes
		$uploader_atts->add( $args['attributes'] );

		?>
		<div class="make-uploader-container">
			<div<?php echo $uploader_atts->render(); ?>>
				<div data-title="<?php echo esc_attr( $title ); ?>" class="ttfmake-media-uploader-placeholder ttfmake-media-uploader-add"<?php if ( ! empty( $image[0] ) ) : ?> style="background-image: url(<?php echo addcslashes( esc_url_raw( $image[0] ), '"' ); ?>);"<?php endif; ?>></div>
			</div>
		<?php if ( is_array( $args['controls'] ) ) : ?>
			<div class="make-uploader-controls">
				<?php  foreach ( $args['controls'] as $control_id => $control_args ) : ?>
					<?php $this->controls()->render( $control_args['type'], $control_id, $control_args ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		</div>
	<?php

		return $this;
	}
}