<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Builder_UI_Setup
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
	 * @param $post_type
	 *
	 * @return void
	 */
	public function add_builder_metabox( $post_type ) {
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
	 * @param $object
	 * @param $box
	 */
	public function render_builder( $object, $box ) {


		echo "<pre>";

		var_dump( $box );

		echo "</pre>";
	}


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