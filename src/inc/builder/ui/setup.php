<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Builder_UI_Setup
 *
 *
 *
 * @since 1.8.0.
 */
class MAKE_Builder_UI_Setup extends MAKE_Util_Modules implements MAKE_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.8.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'builder' => 'MAKE_Builder_SetupInterface',
	);

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since 1.8.0.
	 *
	 * @var bool
	 */
	private static $hooked = false;

	/**
	 * Hook into WordPress.
	 *
	 * @since 1.8.0.
	 *
	 * @return void
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		//
		add_action( 'add_meta_boxes', array( $this, 'add_builder_metabox' ) );

		// Hooking has occurred.
		self::$hooked = true;
	}

	/**
	 * Check if the hook routine has been run.
	 *
	 * @since 1.8.0.
	 *
	 * @return bool
	 */
	public function is_hooked() {
		return self::$hooked;
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param string $post_type
	 *
	 * @return void
	 */
	public function add_builder_metabox( $post_type ) {
		// Make sure the Builder has loaded data.
		$this->builder();

		// Check post type support
		if ( post_type_supports( $post_type, 'make-builder' ) ) {
			$data = get_all_post_type_supports( $post_type );

			add_meta_box(
				'make-builder',
				esc_html__( 'Page Builder', 'make' ),
				array( $this, 'render_builder' ),
				$post_type,
				'normal',
				'high',
				$data['make-builder']
			);
		}
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @param $object
	 * @param $box
	 *
	 * @return void
	 */
	public function render_builder( $object, $box ) {
		// The menu
		$menu_class = ( 'c' === get_user_setting( 'ttfmakemt' . get_the_ID() ) ) ? 'closed' : 'opened';
		?>
		<div class="ttfmake-menu ttfmake-menu-<?php echo $menu_class; ?>" id="ttfmake-menu">
			<div class="ttfmake-menu-pane">
				<ul class="ttfmake-menu-list"></ul>
			</div>
		</div>
	<?php
		// The stage
		?>
		<div class="ttfmake-stage ttfmake-stage-closed" id="ttfmake-stage"></div>
	<?php
		// Other inputs
		?>
		<input type="hidden" value="" name="ttfmake-section-order" id="ttfmake-section-order" />
		<?php wp_nonce_field( 'save', 'ttfmake-builder-nonce' ); ?>
	<?php
	}

	/**
	 *
	 */
	public function print_ui_templates() {

		?>

		<script type="text/html" id="tmpl-make-builder-menu-item">
			<a href="#" title="{{{{ data.description }}}}" class="ttfmake-menu-list-item-link" id="ttfmake-menu-list-item-link-{{{ data.id }}}" data-section="{{{ data.id }}}">
				<li class="ttfmake-menu-list-item">
					<div class="ttfmake-menu-list-item-link-icon-wrapper clear">
						<span class="ttfmake-menu-list-item-link-icon"></span>
						<div class="section-type-description">
							<h4>{{ data.label }}</h4>
						</div>
					</div>
				</li>
			</a>
		</script>

	<?php

	}
}