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
		'scripts' => 'MAKE_Setup_ScriptsInterface',
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

		// The Builder metabox
		add_action( 'add_meta_boxes', array( $this, 'add_builder_metabox' ) );

		// Styles and scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'prep_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ), 20 );

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
	 * @hooked action add_meta_boxes
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
				'ttfmake-builder',
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


	public function prep_scripts() {
		// Initializer
		wp_register_script(
			'make-builder-ui-init',
			$this->scripts()->get_js_directory_uri() . '/builder/ui/init.js',
			array(
				'jquery',
				'backbone',
				'underscore',
				'utils',
				'wp-util',
			),
			TTFMAKE_VERSION,
			true
		);

		// Other Builder script handles (the initializer will load these)
		// Naming convention defines path to script file
		$script_handles = array(
			'make-builder-ui-view-menu',
			'make-builder-ui-view-menuitem',
			//'frappe',
		);

		// Register each script, based on the handle
		foreach ( $script_handles as $handle ) {
			// Check if the script is already registered (e.g. by a plugin)
			if ( $this->scripts()->is_registered( $handle, 'script' ) ) {
				continue;
			}

			// Get the URL for the script
			// Trim the prefix
			$str = $handle;
			$prefix = 'make-';
			if ( substr( $str, 0, strlen( $prefix ) ) == $prefix ) {
				$str = substr( $str , strlen( $prefix ) );
			}
			// Convert the name to the path
			$relative_url = str_replace( '-', '/', $str ) . '.js';
			// Check for a child theme version
			$absolute_url = $this->scripts()->get_located_file_url( array( $relative_url, 'js/' . $relative_url ) );

			// Register the script
			if ( $absolute_url ) {
				wp_register_script(
					$handle,
					$absolute_url,
					array(),
					TTFMAKE_VERSION,
					true
				);
			}
		}

		// Script URLs to pass to the initializer
		$script_urls = array();
		foreach ( $script_handles as $handle ) {
			if ( $this->scripts()->is_registered( $handle, 'script' ) ) {
				$script_urls[] = $this->scripts()->get_url( $handle, 'script' );
			} else {
				$script_urls[] = 'Invalid script';
			}
		}

		// Builder data
		$data = array(
			'menu' => array(
				'items' => $this->builder()->get_top_level_section_types(),
			),
		);

		// Add initial data
		wp_localize_script(
			'make-builder-ui-init',
			'MakeBuilder',
			array(
				'scripts' => $script_urls,
				'data' => $data,
				'l10n' => array(
					'loading' => __( 'Loading', 'make' ),
					'loadFailure' => __( 'The Builder failed to load.', 'make' ),
				),
			)
		);
	}

	/**
	 *
	 *
	 * @since 1.8.0.
	 *
	 * @return void
	 */
	public function enqueue() {
		// Styles
		wp_enqueue_style(
			'make-builder-ui',
			$this->scripts()->get_css_directory_uri() . '/builder/ui/builder.css',
			array(),
			TTFMAKE_VERSION,
			'screen'
		);

		// Scripts
		wp_enqueue_script( 'make-builder-ui-init' );
	}

	/**
	 *
	 */
	public function print_templates() {

		// Menu item
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