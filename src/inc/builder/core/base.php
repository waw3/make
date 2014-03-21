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
		// Include the API
		require get_template_directory() . '/inc/builder/core/api.php';

		// Add the core sections
		require get_template_directory() . '/inc/builder/sections/section-definitions.php';

		// Include the save routines
		require get_template_directory() . '/inc/builder/core/save.php';

		// Set up actions
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
		get_template_part( 'inc/builder/core/templates/menu' );
		get_template_part( 'inc/builder/core/templates/stage', 'header' );

		$section_data        = $this->get_section_data( $post_local->ID );
		$registered_sections = ttf_one_get_sections();

		// Print the current sections
		foreach ( $section_data as $section ) {
			if ( isset( $registered_sections[ $section['section-type'] ]['display_template'] ) ) {
				// Print the saved section
				$this->_load_section( $registered_sections[ $section['section-type'] ], $section );
			}
		}

		get_template_part( 'inc/builder/core/templates/stage', 'footer' );

		// Add the sort input
		$section_order = get_post_meta( $post_local->ID, '_ttf-one-section-ids', true );
		$section_order = ( ! empty( $section_order ) ) ? implode( ',', $section_order ) : '';
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
			get_template_directory_uri() . '/inc/builder/core/css/builder.css',
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
				get_template_directory_uri() . '/inc/builder/core/js/tinymce.js',
				array(),
				TTF_ONE_VERSION,
				true
			);

			wp_register_script(
				'ttf-one-builder/js/models/section.js',
				get_template_directory_uri() . '/inc/builder/core/js/models/section.js',
				array(),
				TTF_ONE_VERSION,
				true
			);

			wp_register_script(
				'ttf-one-builder/js/collections/sections.js',
				get_template_directory_uri() . '/inc/builder/core/js/collections/sections.js',
				array(),
				TTF_ONE_VERSION,
				true
			);

			wp_register_script(
				'ttf-one-builder/js/views/menu.js',
				get_template_directory_uri() . '/inc/builder/core/js/views/menu.js',
				array(),
				TTF_ONE_VERSION,
				true
			);

			wp_register_script(
				'ttf-one-builder/js/views/section.js',
				get_template_directory_uri() . '/inc/builder/core/js/views/section.js',
				array(),
				TTF_ONE_VERSION,
				true
			);

			wp_enqueue_script(
				'ttf-one-builder',
				get_template_directory_uri() . '/inc/builder/core/js/app.js',
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
				get_template_directory_uri() . '/inc/builder/core/js/builder.min.js',
				$dependencies,
				TTF_ONE_VERSION,
				true
			);
		}
	}

	/**
	 * Print additional, dynamic CSS for the builder interface.
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	public function admin_print_styles() {
		// Do not complete the function if the product template is in use (i.e., the builder needs to be shown)
		if ( 'page' !== get_post_type() ) {
			return;
		}

		?>
		<style type="text/css">
			<?php foreach ( ttf_one_get_sections() as $key => $section ) : ?>
			#ttf-one-menu-list-item-link-<?php echo esc_attr( $section['id'] ); ?> .ttf-one-menu-list-item-link-icon-wrapper {
				background-image: url(<?php echo addcslashes( esc_url_raw( $section['icon'] ), '"' ); ?>);
			}
			<?php endforeach; ?>
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
	 * @param  string    $section     The section data.
	 * @param  array     $data        The data payload to inject into the section.
	 * @return void
	 */
	private function _load_section( $section, $data = array() ) {
		if ( ! isset( $section['id'] ) ) {
			return;
		}

		// Globalize the data to provide access within the template
		global $ttf_one_section_data;
		$ttf_one_section_data = array(
			'data'    => $data,
			'section' => $section,
		);

		// Include the template
		get_template_part( $section['builder_template'] );

		// Destroy the variable as a good citizen does
		unset( $GLOBALS['ttf_one_section_data'] );
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
		foreach ( ttf_one_get_sections() as $key => $section ) : ?>
			<script type="text/html" id="tmpl-ttf-one-<?php echo esc_attr( $section['id'] ); ?>">
			<?php
			ob_start();
			$this->_load_section( $section, array() );
			$html = ob_get_clean();

			$html = str_replace(
				array(
					'ttfoneeditor' . $section['id'] . 'temp',
				),
				array(
					'ttfoneeditor' . $section['id'] . '{{{ id }}}',
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
	 * Retrieve all of the data for the sections.
	 *
	 * @since  1.0.0.
	 *
	 * @param  string    $post_id    The post to retrieve the data from.
	 * @return mixed                 The combined data.
	 */
	public function get_section_data( $post_id ) {
		$data      = array();
		$ids       = get_post_meta( $post_id, '_ttf-one-section-ids', true );
		$post_meta = get_post_meta( $post_id );

		// Any meta containing the old keys should be deleted
		if ( is_array( $post_meta ) ) {
			foreach ( $post_meta as $key => $value ) {
				// Only consider builder values
				if ( 0 === strpos( $key, '_ttf-one-builder-' ) ) {
					// Get the ID from the key
					$pattern = '/_ttf-one-builder-(\d+)-(.*)/';
					$key_id  = preg_replace( $pattern, '$1', $key );
					$name    = str_replace( '_ttf-one-builder-' . $key_id . '-', '', $key );

					// If the ID in the key is not one of the whitelisted IDs, delete it
					if ( in_array( $key_id, $ids ) ) {
						$data[ $key_id ][ $name ] = $value[0];
					}
				}
			}
		}

		return $data;
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

add_action( 'admin_init', 'ttf_one_get_builder_base', 1 );

if ( ! function_exists( 'ttf_one_load_section_header' ) ) :
/**
 * Load a consistent header for sections.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttf_one_load_section_header() {
	get_template_part( '/inc/builder/core/templates/section', 'header' );
}
endif;

if ( ! function_exists( 'ttf_one_load_section_footer' ) ) :
/**
 * Load a consistent footer for sections.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttf_one_load_section_footer() {
	get_template_part( '/inc/builder/core/templates/section', 'footer' );
}
endif;

if ( ! function_exists( 'ttf_one_get_wp_editor_id' ) ) :
/**
 * Generate the ID for a WP editor based on an existing or future section number.
 *
 * @since  1.0.0.
 *
 * @param  array     $data              The data for the section.
 * @param  array     $is_js_template    Whether a JS template is being printed or not.
 * @return string                       The editor ID.
 */
function ttf_one_get_wp_editor_id( $data, $is_js_template ) {
	$id_base = 'ttfoneeditor' . $data['section']['id'];

	if ( $is_js_template ) {
		$id = $id_base . 'temp';
	} else {
		$id = $id_base . $data['data']['id'];
	}

	return $id;
}
endif;

if ( ! function_exists( 'ttf_one_get_section_name' ) ) :
/**
 * Generate the name of a section.
 *
 * @since  1.0.0.
 *
 * @param  array     $data              The data for the section.
 * @param  array     $is_js_template    Whether a JS template is being printed or not.
 * @return string                       The name of the section.
 */
function ttf_one_get_section_name( $data, $is_js_template ) {
	$name = 'ttf-one-section';

	if ( $is_js_template ) {
		$name .= '[{{{ id }}}]';
	} else {
		$name .= '[' . $data['data']['id'] . ']';
	}

	return $name;
}
endif;