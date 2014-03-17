<?php
/**
 * @package One
 */

if ( ! function_exists( 'TTF_One_Builder_Base' ) ) :
/**
 * Defines the functionality for the HTML Builder.
 *
 * @since 1.0.
 */
class TTF_One_Builder_Base {
	/**
	 * The one instance of TTF_One_Builder_Base.
	 *
	 * @since 1.0.
	 *
	 * @var   TTF_One_Builder_Base
	 */
	private static $instance;

	/**
	 * Holds the menu item information
	 *
	 * @since 1.0.
	 *
	 * @var   array    Contains a multidimensional array with menu item information.
	 */
	private $_menu_items = array();

	/**
	 * Holds the iterator for managing sections
	 *
	 * @since 1.0.
	 *
	 * @var   int    Current section number.
	 */
	private $_iterator = 0;

	/**
	 * Instantiate or return the one TTF_One_Builder_Base instance.
	 *
	 * @since  1.0.
	 *
	 * @return TTF_One_Builder_Base
	 */
	public static function instance() {
		if ( is_null( self::$instance ) )
			self::$instance = new self();

		return self::$instance;
	}

	/**
	 * Initiate actions.
	 *
	 * @since  1.0.
	 *
	 * @return TTF_One_Builder_Base
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 1 ); // Bias toward top of stack
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'admin_print_styles-post.php', array( $this, 'admin_print_styles' ) );
		add_action( 'admin_print_styles-post-new.php', array( $this, 'admin_print_styles' ) );
		add_action( 'admin_footer', array( $this, 'print_templates' ) );
		add_action( 'admin_footer', array( $this, 'add_js_data' ) );
		add_action( 'tiny_mce_before_init', array( $this, 'tiny_mce_before_init' ), 15, 2 );
		add_action( 'after_wp_tiny_mce', array( $this, 'after_wp_tiny_mce' ) );

		// Filter the content displayed in templates
		global $wp_embed;
		add_filter( 'ttf_one_the_builder_content', array( $wp_embed, 'autoembed' ), 8 );
		add_filter( 'ttf_one_the_builder_content', 'wpautop' );

		// Setup config
		$this->_set_menu_items();
	}

	/**
	 * Set the menu items.
	 *
	 * @since  1.0.
	 *
	 * @return array    The menu items array.
	 */
	private function _set_menu_items() {
		// Setup the default menu items
		$menu_items = array(
			'banner'  => array(
				'id'          => 'banner',
				'label'       => __( 'Banner', 'ttf-one' ),
				'description' => __( 'A full-width background image with custom text and an optional button.', 'ttf-one' ),
			),
			'feature' => array(
				'id'          => 'feature',
				'label'       => __( 'Feature', 'ttf-one' ),
				'description' => __( 'A featured image accompanied on the left or right side by a narrow column of text.', 'ttf-one' ),
			),
			'profile' => array(
				'id'          => 'profile',
				'label'       => __( 'Profile', 'ttf-one' ),
				'description' => __( 'Three sortable columns, each featuring an image, title and text.', 'ttf-one' ),
			),
			'text'    => array(
				'id'          => 'text',
				'label'       => __( 'Text', 'ttf-one' ),
				'description' => __( 'A blank canvas for standard content or HTML code.', 'ttf-one' ),
			)
		);

		// Set the instance var
		$this->_menu_items = $menu_items;
		return $menu_items;
	}

	/**
	 * Add the meta box.
	 *
	 * @since  1.0.
	 *
	 * @return void
	 */
	public function add_meta_boxes() {
		add_meta_box(
			'ttf-one-builder',
			__( 'Page Builder', 'ttf-one' ),
			array( $this, 'display_builder' ),
			'page',
			'normal',
			'high'
		);
	}

	/**
	 * Display the meta box.
	 *
	 * @since  1.0.
	 *
	 * @param  WP_Post    $post_local    The current post object.
	 * @return void
	 */
	public function display_builder( $post_local ) {
		wp_nonce_field( 'save', 'ttf-one-builder-nonce' );

		// Get the current sections
		global $ttf_one_sections;
		$ttf_one_sections = get_post_meta( $post_local->ID, '_ttf-one-sections', true );
		$ttf_one_sections = ( is_array( $ttf_one_sections ) ) ? $ttf_one_sections : array();

		// Load the boilerplate templates
		get_template_part( 'inc/builder/templates/menu' );
		get_template_part( 'inc/builder/templates/stage-header' );

		$section_ids = array();

		// Print the current sections
		foreach ( $ttf_one_sections as $section ) {
			if ( isset( $section['section-type'] ) ) {
				$this->_load_section( $this->get_menu_item( $section['section-type'] ), $section );
				$section_ids[] = $this->get_iterator();
				$this->increment_iterator();
			}
		}

		get_template_part( 'inc/builder/templates/stage-footer' );

		// Generate initial section order input
		$section_order = '';
		foreach ( $section_ids as $number ) {
			$section_order .= 'ttf-one-section-' . $number . ',';
		}

		$section_order = substr( $section_order, 0, -1 );

		// Add the sort input
		echo '<input type="hidden" value="' . esc_attr( $section_order ) . '" name="ttf-one-section-order" id="ttf-one-section-order" />';
	}

	/**
	 * Enqueue the JS and CSS for the admin.
	 *
	 * @param  string    $hook_suffix    The suffix for the screen.
	 * @return void
	 */
	public function admin_enqueue_scripts( $hook_suffix ) {
		// Only load resources if they are needed on the current page
		if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) || 'page' !== get_post_type() ) {
			return;
		}

		// Enqueue the CSS
		wp_enqueue_style(
			'ttf-one-builder',
			get_template_directory_uri() . '/inc/builder/css/builder.css',
			array(),
			TTF_ONE_VERSION
		);

		wp_enqueue_style( 'wp-color-picker' );

		// Dependencies regardless of min/full scripts
		$dependencies = array(
			'wplink',
			'utils',
			'wp-color-picker',
			'jquery-effects-core',
			'jquery-ui-sortable',
			'backbone',
		);

		// Only load full scripts for WordPress.com and those with SCRIPT_DEBUG set to true
		if ( ttf_one_is_wpcom() || ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ) {
			wp_register_script(
				'ttf-one-builder/js/tinymce.js',
				get_template_directory_uri() . '/inc/builder/js/tinymce.js',
				array(),
				TTF_ONE_VERSION,
				true
			);

			wp_register_script(
				'ttf-one-builder/js/models/section.js',
				get_template_directory_uri() . '/inc/builder/js/models/section.js',
				array(),
				TTF_ONE_VERSION,
				true
			);

			wp_register_script(
				'ttf-one-builder/js/collections/sections.js',
				get_template_directory_uri() . '/inc/builder/js/collections/sections.js',
				array(),
				TTF_ONE_VERSION,
				true
			);

			wp_register_script(
				'ttf-one-builder/js/views/menu.js',
				get_template_directory_uri() . '/inc/builder/js/views/menu.js',
				array(),
				TTF_ONE_VERSION,
				true
			);

			wp_register_script(
				'ttf-one-builder/js/views/section.js',
				get_template_directory_uri() . '/inc/builder/js/views/section.js',
				array(),
				TTF_ONE_VERSION,
				true
			);

			wp_enqueue_script(
				'ttf-one-builder',
				get_template_directory_uri() . '/inc/builder/js/app.js',
				array_merge(
					$dependencies,
					array(
						'ttf-one-builder/js/tinymce.js',
						'ttf-one-builder/js/models/section.js',
						'ttf-one-builder/js/collections/sections.js',
						'ttf-one-builder/js/views/menu.js',
						'ttf-one-builder/js/views/section.js',
					)
				),
				TTF_ONE_VERSION,
				true
			);
		} else {
			wp_enqueue_script(
				'ttf-one-builder',
				get_template_directory_uri() . '/inc/builder/js/builder.min.js',
				$dependencies,
				TTF_ONE_VERSION,
				true
			);
		}
	}

	/**
	 * Hide the builder metabox and main editor if necessary.
	 *
	 * @since  1.0.
	 *
	 * @return void
	 */
	public function admin_print_styles() {
		// Do not complete the function if the product template is in use (i.e., the builder needs to be shown)
		if ( 'page' !== get_post_type() ) {
			return;
		}

		$template = get_page_template_slug();
		?>
		<style type="text/css">
		</style>
	<?php
	}

	/**
	 * Add data for the HTML Builder.
	 *
	 * Data needs to be added late so that the iterator value is properly set.
	 *
	 * @since  1.0.
	 *
	 * @return void
	 */
	public function add_js_data() {
		global $hook_suffix;

		// Only load resources if they are needed on the current page
		if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) || 'page' !== get_post_type() ) {
			return;
		}

		// Add data needed for the JS
		$data = array(
			'iterator'          => $this->get_iterator(),
			'pageID'            => get_the_ID(),
			'hideHeaderChecked' => checked( get_post_meta( get_the_ID(), '_ttf-one-hide-header', true ), '1', false ),
			'hideHeaderLabel'   => __( 'Hide the site header on this page', 'ttf-one' ),
		);

		wp_localize_script(
			'ttf-one-builder',
			'ttfOneBuilderData',
			$data
		);
	}

	/**
	 * Reusable component for adding an image uploader.
	 *
	 * @since  1.0.
	 *
	 * @param  string    $section_name    Name of the current section.
	 * @param  int       $image_id        ID of the current image.
	 * @param  array     $messages        Message to show.
	 * @return void
	 */
	public function add_uploader( $section_name, $image_id = 0, $messages = array() ) {
		$image        = wp_get_attachment_image( $image_id, 'large' );
		$add_state    = ( '' === $image ) ? 'ttf-one-show' : 'ttf-one-hide';
		$remove_state = ( '' === $image ) ? 'ttf-one-hide' : 'ttf-one-show';

		// Set default messages. Note that 'one' is not used in some cases the strings are core i18ns
		$messages['add']    = ( empty( $messages['add'] ) )    ? __( 'Set featured image' )            : $messages['add'];
		$messages['remove'] = ( empty( $messages['remove'] ) ) ? __( 'Remove featured image' )         : $messages['remove'];
		$messages['title']  = ( empty( $messages['title'] ) )  ? __( 'Featured Image', 'ttf-one' )        : $messages['title'];
		$messages['button'] = ( empty( $messages['button'] ) ) ? __( 'Use as Featured Image', 'ttf-one' ) : $messages['button'];
		?>
		<div class="ttf-one-uploader">
			<div class="ttf-one-media-uploader-placeholder ttf-one-media-uploader-add">
				<?php if ( '' !== $image ) : ?>
					<?php echo $image; ?>
				<?php endif; ?>
			</div>
			<div class="ttf-one-media-link-wrap">
				<a href="#" class="ttf-one-media-uploader-add ttf-one-media-uploader-set-link <?php echo $add_state; ?>" data-title="<?php echo esc_attr( $messages['title'] ); ?>" data-button-text="<?php echo esc_attr( $messages['button'] ); ?>">
					<?php echo $messages['add']; ?>
				</a>
				<a href="#" class="ttf-one-media-uploader-remove <?php echo $remove_state; ?>">
					<?php echo $messages['remove']; ?>
				</a>
			</div>
			<input type="hidden" name="<?php echo $section_name; ?>[image-id]" value="<?php echo absint( $image_id ); ?>" class="ttf-one-media-uploader-value" />
		</div>
	<?php
	}

	/**
	 * Load a section template with an available data payload for use in the template.
	 *
	 * @since  1.0.
	 *
	 * @param  string    $section    The section data.
	 * @param  array     $data       The data payload to inject into the section.
	 * @return void
	 */
	private function _load_section( $section, $data = array() ) {
		if ( ! isset( $section['id'] ) ) {
			return;
		}

		// Globalize the data to provide access within the template
		global $ttf_one_section, $ttf_one_section_data, $ttf_one_section_id, $ttf_one_section_name, $ttf_one_is_js_template;
		$ttf_one_section      = $section;
		$ttf_one_section_data = $data;

		// Change the template depending on JS or PHP context
		if ( true === $ttf_one_is_js_template ) {
			$ttf_one_section_name = 'ttf-one-section[{{{ iterator }}}]';
			$ttf_one_section_id   = 'ttf-onesection{{{ iterator }}}';
		} else {
			$ttf_one_section_name = 'ttf-one-section[' . absint( ttf_one_get_builder()->get_iterator() ) . ']';
			$ttf_one_section_id   = 'ttf-onesection' . absint( ttf_one_get_builder()->get_iterator() );
		}

		// Include the template
		get_template_part( 'inc/builder/templates/' . $section['id'] );

		// Destroy the variable as a good citizen does
		unset( $GLOBALS['ttf_one_section'] );
		unset( $GLOBALS['ttf_one_builder'] );
		unset( $GLOBALS['ttf_one_section_data'] );
		unset( $GLOBALS['ttf_one_section_id'] );
		unset( $GLOBALS['ttf_one_section_name'] );
	}

	/**
	 * Print out the JS section templates
	 *
	 * @since  1.0.
	 *
	 * @return void
	 */
	public function print_templates() {
		global $hook_suffix, $typenow, $ttf_one_is_js_template;
		$ttf_one_is_js_template = true;

		// Only show when adding/editing pages
		if ( 'page' !== $typenow || ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) )) {
			return;
		}

		// Print the templates
		foreach ( $this->get_menu_items() as $key => $section ) : ?>
			<script type="text/html" id="tmpl-ttf-one-<?php echo esc_attr( $section['id'] ); ?>">
			<?php
			ob_start();
			$builder = ( 'slide' === $section['id'] ) ? 'slideshow' : 'product';
			$this->_load_section( $section, array(), $builder );
			$html = ob_get_clean();

			$html = str_replace(
				array(
					'name="ttfoneeditortemp' . $section['id'] . '"',
					'name="ttfoneeditortemp' . $section['id'] . 'left"',
					'name="ttfoneeditortemp' . $section['id'] . 'middle"',
					'name="ttfoneeditortemp' . $section['id'] . 'right"',
					'ttfoneeditortemp' . $section['id']
				),
				array(
					'name="ttf-one-section[{{{ iterator }}}][content]"',
					'name="ttf-one-section[{{{ iterator }}}][left][content]"',
					'name="ttf-one-section[{{{ iterator }}}][middle][content]"',
					'name="ttf-one-section[{{{ iterator }}}][right][content]"',
					'ttfoneeditor' . $section['id'] . '{{{ iterator }}}',
				),
				$html
			);

			echo $html;
			?>
		</script>
		<?php endforeach;

		unset( $GLOBALS['ttf_one_is_js_template'] );
	}

	/**
	 * Wrapper function to produce a WP Editor with special defaults.
	 *
	 * @since  1.0.
	 *
	 * @param  string    $content     The content to display in the editor.
	 * @param  string    $name        Name of the editor.
	 * @param  array     $settings    Setting to send to the editor.
	 * @return void
	 */
	public function wp_editor( $content, $name, $settings = array() ) {
		$settings = wp_parse_args( $settings, array(
			'tinymce'   => array(
				'toolbar1'                => 'bold,italic,link,unlink',
				'toolbar2'                => '',
				'toolbar3'                => '',
				'toolbar4'                => '',
			),
			'quicktags' => array(
				'buttons' => 'strong,em,link',
			),
			'editor_height' => 150,
		) );

		// Remove the default media buttons action and replace it with the custom one
		remove_action( 'media_buttons', 'media_buttons' );
		add_action( 'media_buttons', array( $this, 'media_buttons' ) );

		// Render the editor
		wp_editor( $content, $name, $settings );

		// Reinstate the original media buttons function
		remove_action( 'media_buttons', array( $this, 'media_buttons' ) );
		add_action( 'media_buttons', 'media_buttons' );
	}

	/**
	 * Add the media buttons to the text editor.
	 *
	 * This is a copy and modification of the core "media_buttons" function. In order to make the media editor work
	 * better for smaller width screens, we need to wrap the button text in a span tag. By doing so, we can hide the
	 * text in some situations.
	 *
	 * @since  1.0.
	 *
	 * @param  string    $editor_id    The value of the current editor ID.
	 * @return void
	 */
	public function media_buttons( $editor_id = 'content' ) {
		$post = get_post();
		if ( ! $post && ! empty( $GLOBALS['post_ID'] ) ) {
			$post = $GLOBALS['post_ID'];
		}

		wp_enqueue_media( array(
			'post' => $post
		) );

		$img = '<span class="wp-media-buttons-icon"></span>';

		echo '<a href="#" id="insert-media-button" class="button insert-media add_media" data-editor="' . esc_attr( $editor_id ) . '" title="' . esc_attr__( 'Add Media' ) . '">' . $img . ' <span class="ttf-one-media-button-text">' . __( 'Add Media' ) . '</span></a>';
	}

	/**
	 * Append the editor styles to the section editors.
	 *
	 * Unfortunately, the `wp_editor()` function does not support a "content_css" argument. As a result, the stylesheet
	 * for the "content_css" parameter needs to be added via a filter.
	 *
	 * @since  1.0.4.
	 *
	 * @param  array     $mce_init     The array of tinyMCE settings.
	 * @param  string    $editor_id    The ID for the current editor.
	 * @return array                   The modified settings.
	 */
	function tiny_mce_before_init( $mce_init, $editor_id ) {
		// Only add stylesheet to a section editor
		if ( false === strpos( $editor_id, 'ttf-one' ) ) {
			return $mce_init;
		}

		$content_css = get_template_directory_uri() . '/includes/stylesheets/editor-style.css';

		// If there is already a stylesheet being added, append and do not override
		if ( isset( $mce_init[ 'content_css' ] ) ) {
			$mce_init['content_css'] .= ',' . $content_css;
		} else {
			$mce_init['content_css'] = $content_css;
		}

		return $mce_init;
	}

	/**
	 * Denote the default editor for the user.
	 *
	 * Note that it would usually be ideal to expose this via a JS variable using wp_localize_script; however, it is
	 * being printed here in order to guarantee that nothing changes this value before it would otherwise be printed.
	 * The "after_wp_tiny_mce" action appears to be the most reliable place to print this variable.
	 *
	 * @since  1.0.
	 *
	 * @param  array    $settings   TinyMCE settings.
	 * @return void
	 */
	public function after_wp_tiny_mce( $settings ) {
		?>
		<script type="text/javascript">
			var ttfOneMCE = '<?php echo esc_js( wp_default_editor() ); ?>';
		</script>
	<?php
	}

	/**
	 * Duplicate of "the_content" with custom filter name for generating content in builder templates.
	 *
	 * @since  1.0.
	 *
	 * @param  string    $content    The original content.
	 * @return void
	 */
	public function the_builder_content( $content ) {
		$content = apply_filters( 'ttf_one_the_builder_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		echo $content;
	}

	/**
	 * Get the order for a feature section.
	 *
	 * @since  1.0.
	 *
	 * @param  array    $data    The section data.
	 * @return array             The desired order.
	 */
	public function get_featured_section_order( $data ) {
		$order = array(
			'image' => 'left',
			'text'  => 'right',
		);

		if ( isset( $data['order'] ) ) {
			if ( isset( $data['order'][0] ) && false !== strpos( $data['order'][0], 'text' ) ) {
				$order = array(
					'image' => 'right',
					'text'  => 'left',
				);
			}
		}

		return $order;
	}

	/**
	 * Retrieve the menu item information.
	 *
	 * @since  1.0.
	 *
	 * @return array    The menu item information.
	 */
	public function get_menu_items() {
		return $this->_menu_items;
	}

	/**
	 * Retrieve an individual menu item's information.
	 *
	 * @since  1.0.
	 *
	 * @param  string    $id    The section name to return.
	 * @return array            The menu item information.
	 */
	public function get_menu_item( $id ) {
		$items = $this->_menu_items;

		// Only return an item if it exists
		if ( array_key_exists( $id, $items ) ) {
			return $items[ $id ];
		} else {
			return array();
		}
	}

	/**
	 * Get the value of the iterator.
	 *
	 * @since  1.0.
	 *
	 * @return int    The value of the iterator.
	 */
	public function get_iterator() {
		return $this->_iterator;
	}

	/**
	 * Set the iterator value.
	 *
	 * @since  1.0.
	 *
	 * @param  int    $value    The new iterator value.
	 * @return int              The iterator value.
	 */
	public function set_iterator( $value ) {
		$this->_iterator = $value;
		return $this->get_iterator();
	}

	/**
	 * Increase the interator value by 1.
	 *
	 * @since  1.0.
	 *
	 * @return int    The iterator value.
	 */
	public function increment_iterator() {
		$value = $this->get_iterator();
		$value++;

		$this->set_iterator( $value );
		return $this->get_iterator();
	}
}
endif;

/**
 * Instantiate or return the one TTF_One_Builder_Base instance.
 *
 * @since  1.0.
 *
 * @return TTF_One_Builder_Base
 */
function ttf_one_get_builder_base() {
	return TTF_One_Builder_Base::instance();
}

add_action( 'admin_init', 'ttf_one_get_builder_base' );